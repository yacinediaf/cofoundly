<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Calendar } from '@/Components/ui/calendar'
import { getLocalTimeZone, today } from '@internationalized/date'
import Label from '@/Components/ui/label/Label.vue';
import Input from '@/Components/ui/input/Input.vue';

defineOptions({
    layout: AppLayout
})

defineProps(['members']);

let userName = ($member) => computed(() => usePage().props.auth.user.id == $member.id ? 'Me' : $member.name)
let selectedMember = ref(null);
const value = ref(today(getLocalTimeZone()))

const assignTo = ($member) => {
    selectedMember.value = $member.id
}
</script>
<template>
    <div class="h-full">
        <div class="h-full p-6 lg:p-8 bg-white border-b border-gray-200">
            <div class="w-full flex gap-10">
                <div class="w-64 flex flex-col gap-8">
                    <div class="space-y-4">
                        <div>
                            <h1 class="font-semibold text-2xl mb-2">Team Members</h1>
                            <p class="text-xs text-gray-500">Assign the task to one of the following users.</p>
                        </div>
                        <div class="flex flex-wrap gap-3 items-center">
                            <div v-for="member in members" :key="member.id" @click="assignTo(member)"
                                class="flex flex-col gap-1 items-center cursor-pointer">
                                <img class="h-14 w-14 shadow-md rounded-full transition-all ease-in-out"
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
                            <h1 class="font-semibold text-2xl mb-2">Date</h1>
                            <p class="text-xs text-gray-500">Pick the date that you're willing to finish this task on.
                            </p>
                        </div>

                        <Calendar v-model="value" :weekday-format="'short'" class="rounded-md border" />
                    </div>
                </div>
                <section>
                    <h1 class="font-semibold text-2xl mb-2">What's Up, New Task ? Let's go 🤩💻</h1>

                    <div class="mt-5">
                        <form>
                            <div>
                                <Label>Task Title</Label>
                                <Input class="mt-2" />
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>