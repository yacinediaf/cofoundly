<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

let props = defineProps(['projects']);
console.log(props.projects);

</script>

<template>
    <AppLayout title="Projects">
        <div>
            <div class="px-6 lg:p-8 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-medium text-gray-900">
                    My projects
                </h1>

                <div class="flex items-start justify-between flex-wrap gap-6 mt-6">
                    <div class="bg-white shadow-md px-2 w-64 border" v-for="project in projects.data"
                        :key="project.code">
                        <a :href="'/@' + project.projectCode">
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-700">
                                    {{ project.title }}
                                    <span class="text-xs text-gray-500">
                                        {{ '(' + project.team.name + ')' }}
                                    </span>

                                </h2>
                                <span class="text-xs text-gray-500">Last updated at {{ project.createdAt }}.</span>
                            </div>
                        </a>
                        <div class="flex flex-col">
                            <p v-if="project.description">{{ project.description }}</p>

                            <div class="p-4" v-if="project.team.members.length" v-for="user in project.team.members">
                                <img class="h-9 w-9 rounded-full" :src="user.profilePicture" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
