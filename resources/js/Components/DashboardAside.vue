<script setup>
import { PlusIcon } from '@radix-icons/vue';
import Button from './ui/button/Button.vue';

</script>
<template>
    <section class="bg-white w-96 px-4 py-6 text-gray-500">
        <div>
            <aside class="font-bold">Projects</aside>
            <template v-if="$page.props.auth.user.team_projects.length">
                <div class="block text-xs text-gray-400">
                    Switch Projects
                </div>
                <ul class="py-2 w-full">
                    <li class="text-gray-500 py-1 hover:bg-gray-50 px-4 rounded-lg cursor-pointer"
                        v-for="project in $page.props.auth.user.team_projects" :key="project.id">
                        {{ project.title }}
                    </li>
                </ul>
            </template>
            <div class="mt-4">
                <Button variant="secondary" class="flex items-center justify-between gap-4">
                    New project
                    <PlusIcon class="w-4 h-4" />
                </Button>
            </div>
        </div>
    </section>
</template>