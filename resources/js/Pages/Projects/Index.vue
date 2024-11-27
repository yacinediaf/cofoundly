<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import ProjectBanner from './Partials/ProjectBanner.vue';
defineOptions({
    layout: AppLayout
})
let props = defineProps(['projects']);
</script>

<template>
    <div class="h-full">
        <div class="h-full px-6 lg:p-8 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-medium text-gray-900">
                My projects
            </h1>

            <div class="flex items-start flex-wrap gap-2 mt-6">
                <ProjectBanner v-for="project in projects.data" :key="project.code" :project />
            </div>
        </div>
    </div>
</template>
