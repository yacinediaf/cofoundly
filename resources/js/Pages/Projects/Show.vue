<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/ui/button/Button.vue';
import TasksManager from '@/Pages/Projects/Partials/TasksManager.vue';
import { PlusIcon } from '@radix-icons/vue';

defineOptions({
    layout: AppLayout
})

defineProps(['project', 'tasks', 'currentDate'])

</script>
<template>
    <div class="h-full">
        <div class="h-full px-6 lg:p-8 bg-white border-b border-gray-200">
            <div>
                <div>
                    <h1 class="text-2xl font-medium text-gray-900">
                        {{ 'Project Title : ' + project.title }}
                    </h1>
                </div>
                <div class="mt-5 w-full flex items-center justify-between">
                    <div class="text-gray-500 text-sm">{{ currentDate }}</div>
                    <div>
                        <Button class="flex gap-1">
                            <span>New Task</span>
                            <PlusIcon class="w-4 h-4" />
                        </Button>
                    </div>
                </div>
            </div>

            <TasksManager :tasks="tasks"></TasksManager>

        </div>
    </div>
</template>