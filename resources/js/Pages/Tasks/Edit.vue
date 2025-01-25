<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router, usePage } from '@inertiajs/vue3';
import { computed, reactive, ref, watch } from 'vue';
import { Calendar } from '@/Components/ui/calendar'
import { getLocalTimeZone, today } from '@internationalized/date'
import Label from '@/Components/ui/label/Label.vue';
import Input from '@/Components/ui/input/Input.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import { calendarDateFormatter } from '@/Composables/UseCalendarDateFormatter';
import LoadedButton from '@/Components/LoadedButton.vue';
import EditTag from './Partials/EditTag.vue';
import Tags from './Partials/Tags.vue';

defineOptions({
    layout: AppLayout
})

let props = defineProps(['members', 'task', 'project']);

let userName = ($member) => computed(() => usePage().props.auth.user.id == $member.id ? 'Me' : $member.name)

let selectedMember = ref(props.task.assigned_to);
let deliveryDate = ref(calendarDateFormatter(props.task.delivery_date))
const isLoading = ref(false);
const selectedTags = ref(props.task.tags ? props.task.tags.map((tag) => tag.id) : []);

const updateTask = () => {
    isLoading.value = true;
    if (selectedTags.value.length) {
        taskData.tags = selectedTags.value;
    }
    router.put(route('tasks.replace', [props.project.project_code, props.task.id]), taskData, {
        onFinish: () => isLoading.value = false
    });
}

const assignTo = (member) => {
    selectedMember.value = member.id
}

const convertDate = (date) => {

    return date.year + '-' + String(date.month).padStart(2, '0') + '-' + String(date.day).padStart(2, '0');
}

const taskData = reactive({
    title: props.task.title,
    description: props.task.description,
    assignedTo: selectedMember,
    deliveryDate: convertDate(deliveryDate.value)
});

watch(() => deliveryDate.value, (newDate) => {
    if (!newDate) {
        deliveryDate.value = today(getLocalTimeZone());
        return;
    }
    taskData.deliveryDate = convertDate(newDate);
})
</script>
<template>
    <div class="h-full">
        <div class="h-full p-6 lg:p-8 bg-white border-b border-gray-200">
            <div class="w-full flex gap-10">
                <section class="w-full px-6">
                    <div class="flex justify-between">
                        <h1 class="font-semibold text-2xl mb-2">What's Up, New Task ? Let's go 🤩💻</h1>
                        <LoadedButton title="Update" :isLoading="isLoading" @click="updateTask"></LoadedButton>
                    </div>

                    <div class="mt-5">
                        <form class="space-y-4">
                            <div>
                                <Label class="text-md">Task Title</Label>
                                <Input id="title" autofocus v-model="taskData.title" class="mt-2" />
                                <span v-if="$page.props.errors['title']" class='text-xs text-red-500'>{{
                                    $page.props.errors['title'] }}</span>
                            </div>
                            <div>
                                <div class="flex flex-col">
                                    <Label class="text-md">Task Detail</Label>
                                    <span v-if="$page.props.errors['description']" class='text-xs text-red-500'>
                                        {{ $page.props.errors['description'] }}
                                    </span>
                                </div>
                                <MarkdownEditor v-model="taskData.description" />
                            </div>
                        </form>
                    </div>
                </section>

                <div class="w-64 flex flex-col gap-8">
                    <div class="space-y-4">
                        <EditTag :project></EditTag>
                        <Tags :project v-model:selectedTags="selectedTags"></Tags>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h1 class="font-semibold text-2xl mb-2">Team Members</h1>
                            <p class="text-xs text-gray-500">Assign the task to one of the following users, it is
                                assigned to you by default.</p>
                        </div>
                        <div class="flex flex-wrap gap-3 items-center">
                            <div v-for="member in members" :key="member.id" @click="assignTo(member)"
                                class="flex flex-col gap-1 items-center cursor-pointer">
                                <img class="h-10 w-10 shadow-md rounded-full transition-all ease-in-out"
                                    :class="{ 'border-2 border-blue-500': selectedMember == member.id }"
                                    :src="member.profile_photo_url" />

                                <span class="text-xs font-semibold text-gray-600"
                                    :class="{ 'text-blue-600': selectedMember == member.id }">
                                    {{ userName(member) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <h1 class="font-semibold text-2xl mb-2">Delivery Date</h1>
                            <p class="text-xs text-gray-500">Pick the date that you're willing to finish this task on.
                            </p>
                        </div>

                        <Calendar v-model="deliveryDate" :weekday-format="'short'"
                            :min-value="today(getLocalTimeZone())" :default-value="today(getLocalTimeZone())"
                            class="rounded-md border" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>