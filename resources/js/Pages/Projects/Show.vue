<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/ui/button/Button.vue';
import TasksManager from '@/Pages/Projects/Partials/TasksManager.vue';
import { PlusIcon } from '@radix-icons/vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, computed, provide, watch } from 'vue';

defineOptions({
    layout: AppLayout
})
let props = defineProps(['project', 'tasks', 'currentDate'])
provide('project', props.project)
let tasks = ref(props.tasks)
let selectedTags = ref([])

const assignTag = (tag) => {
    if (selectedTags.value.includes(tag)) {
        const index = selectedTags.value.indexOf(tag);
        if (index > -1) {
            selectedTags.value.splice(index, 1);
        }
    } else {
        selectedTags.value.push(tag);
    }
    router.visit(route('projects.show', props.project.project_code), {
        only: ['tasks'],
        data: {
            selectedTags: [... new Set(selectedTags.value)]
        },
        preserveState: true,
        preserveScroll: true
    })

}

const removeTag = (tag) => {
    const index = selectedTags.value.indexOf(tag);
    if (index > -1) {
        selectedTags.value.splice(index, 1);
    }
}

watch(() => props.tasks, (newTasks) => {
    tasks.value = newTasks
})
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
                        <Link :href="route('tasks.create', [project.project_code])">
                        <Button class="flex gap-1">
                            <span>New Task</span>
                            <PlusIcon class="w-4 h-4" />
                        </Button>
                        </Link>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 items-center">
                    <div class="w-full">
                        <ul class="flex flex-wrap items-center gap-2">
                            <li v-if="project.tags.length" v-for="tag in project.tags"
                                class="bg-gray-300 py-1 px-2 text-xs rounded-full text-white cursor-pointer"
                                :style="{ 'background-color': selectedTags.includes(tag.id) ? tag.color : 'gray' }"
                                @click="assignTag(tag.id)">
                                {{ tag.name }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <TasksManager v-model="tasks" :project="project"></TasksManager>

        </div>
    </div>
</template>