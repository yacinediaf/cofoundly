<script setup>
defineProps(['project'])
</script>
<template>
    <div class="bg-white shadow-md w-64 border p-4 rounded">
        <a :href="'/@' + project.projectCode">
            <div>
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
            <p class="text-sm mt-2 text-gray-700" v-if="project.description">
                {{ project.description }}
            </p>

            <div class="flex gap-1">
                <div class="pt-2 items-center" v-if="project.team.members.length" v-for="user in project.team.members">
                    <img class="h-8 w-8 rounded-full border border-gray-300" :src="user.profilePicture" />
                </div>
            </div>
        </div>
    </div>
</template>