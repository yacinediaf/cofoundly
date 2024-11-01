<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineOptions({
    layout: AppLayout
})
defineProps(['project']);
</script>
<template>
    <div class="h-full">
        <div class="h-full px-6 lg:p-8 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-medium text-gray-900">
                {{ 'Project Title : ' + project.title }}
            </h1>
        </div>
    </div>
</template>