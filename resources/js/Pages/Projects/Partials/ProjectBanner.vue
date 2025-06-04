<script setup>
import { Link } from '@inertiajs/vue3';
import { Progress } from '@/Components/ui/progress';
import { computed } from 'vue';
import { calculatePercentage } from '@/Composables/UsePercentage';
import { Share1Icon } from '@radix-icons/vue';

let props = defineProps(['project'])

let todoProgress = computed(() => calculatePercentage(props.project.tasks.todo, props.project.tasks.total))
let inProgressProgress = computed(() => calculatePercentage(props.project.tasks.inProgress, props.project.tasks.total))
let doneProgress = computed(() => calculatePercentage(props.project.tasks.done, props.project.tasks.total))

</script>
<template>
    <div class="bg-white w-64 border p-4 rounded hover:bg-gray-50">
        <Link :href="route('projects.show', project.projectCode)" prefetch>
        <div>
            <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-1">
                <Share1Icon></Share1Icon>
                <div>
                    {{ project.title }}

                    <span class="text-xs text-gray-500">
                        {{ '(' + project.team.name + ')' }}
                    </span>
                </div>


            </h2>
            <span class="text-xs text-gray-500">Last updated at {{ project.createdAt }}.</span>
        </div>
        </Link>

        <div class="py-2 space-y-1">
            <div class="space-y-1">
                <h2 class="text-sm font-semibold text-gray-500">Todo</h2>
                <Progress :model-value="todoProgress" progress-class="bg-black" />
            </div>
            <div class="space-y-1">
                <h2 class="text-sm font-semibold text-gray-500">In Progress</h2>
                <Progress :model-value="inProgressProgress" progress-class="bg-orange-500" />
            </div>
            <div class="space-y-1">
                <h2 class="text-sm font-semibold text-gray-500">Done</h2>
                <Progress :model-value="doneProgress" progress-class="bg-green-500" />
            </div>
        </div>

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