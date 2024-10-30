<script setup>
import { Link } from '@inertiajs/vue3';

defineProps(['project'])
</script>
<template>
    <div class="bg-white w-64 border p-4 rounded hover:bg-gray-50">
        <Link :href="'/projects/@' + project.projectCode">
            <div>
                <h2 class="text-lg font-semibold text-gray-700">
                    {{ project.title }}
                    <span class="text-xs text-gray-500">
                        {{ '(' + project.team.name + ')' }}
                    </span>

                </h2>
                <span class="text-xs text-gray-500">Last updated at {{ project.createdAt }}.</span>
            </div>
        </Link>
        <div class="flex flex-col">
            <p class="text-sm mt-2 text-gray-700" v-if="project.description">
                {{ project.description }}
            </p>

            <div class="flex items-center -space-x-2">
                <div class="pt-2 items-center" v-if="project.team.owner">
                    <img class="h-7 w-7 rounded-full border-2 border-white" :src="project.team.owner.profilePicture" />
                </div>
                <div class="pt-2 items-center" v-if="project.team.members.length" v-for="user in project.team.members">
                    <img class="h-7 w-7 rounded-full border-2 border-white" :src="user.profilePicture" />
                </div>
            </div>
        </div>
    </div>
</template>