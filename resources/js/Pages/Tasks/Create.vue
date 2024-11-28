<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Calendar } from '@/Components/ui/calendar'
import { getLocalTimeZone, today } from '@internationalized/date'
import Label from '@/Components/ui/label/Label.vue';
import Input from '@/Components/ui/input/Input.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';

defineOptions({
    layout: AppLayout
})

defineProps(['members']);

let userName = ($member) => computed(() => usePage().props.auth.user.id == $member.id ? 'Me' : $member.name)
let selectedMember = ref(usePage().props.auth.user.id);
const value = ref(today(getLocalTimeZone()))
const form = useForm({
    title: '',
    description: ''
});
const assignTo = ($member) => {
    selectedMember.value = $member.id
}
</script>
<template>
    <div class="h-full">
        <div class="h-full p-6 lg:p-8 bg-white border-b border-gray-200">
            <div class="w-full flex gap-10">
                <section class="w-full px-6">
                    <h1 class="font-semibold text-2xl mb-2">What's Up, New Task ? Let's go 🤩💻</h1>

                    <div class="mt-5">
                        <form class="space-y-4">
                            <div>
                                <Label class="text-md">Task Title</Label>
                                <Input v-model="form.title" class="mt-2" />
                            </div>
                            <div>
                                <Label class="text-md">Task Detail</Label>
                                <MarkdownEditor v-model="form.description" />
                            </div>
                            <div>
                                <textarea v-model="form.description" class="w-full" rows="25"></textarea>
                            </div>
                        </form>
                    </div>
                </section>

                <div class="w-64 flex flex-col gap-8">
                    <div class="space-y-4">
                        <div>
                            <h1 class="font-semibold text-2xl mb-2">Team Members</h1>
                            <p class="text-xs text-gray-500">Assign the task to one of the following users.</p>
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

                        <Calendar v-model="value" :weekday-format="'short'" class="rounded-md border" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>