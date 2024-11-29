<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router, usePage } from '@inertiajs/vue3';
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { Calendar } from '@/Components/ui/calendar'
import { getLocalTimeZone, today } from '@internationalized/date'
import Label from '@/Components/ui/label/Label.vue';
import Button from '@/Components/ui/button/Button.vue';
import Input from '@/Components/ui/input/Input.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';


defineOptions({
    layout: AppLayout
})

let props = defineProps(['members', 'project']);

let userName = ($member) => computed(() => usePage().props.auth.user.id == $member.id ? 'Me' : $member.name)

let selectedMember = ref(usePage().props.auth.user.id);
let deliveryDate = ref(today(getLocalTimeZone()))

const createTask = () => {
    router.post(route('tasks.store', props.project.project_code), taskData, {
        onError: () => console.log(usePage().props.errors)
    });
}

const assignTo = ($member) => {
    selectedMember.value = $member.id
}

const convertDate = (date) => {

    return date.year + '-' + String(date.month).padStart(2, '0') + '-' + String(date.day).padStart(2, '0');
}

const taskData = reactive({
    title: '',
    description: '',
    assignedTo: selectedMember.value,
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
                        <Button @click.prevent="createTask">Create Task</Button>
                    </div>

                    <div class="mt-5">
                        <form class="space-y-4">
                            <div>
                                <Label class="text-md">Task Title</Label>
                                <Input autofocus v-model="taskData.title" class="mt-2" />
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