<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { computed } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { RocketIcon } from '@radix-icons/vue';

const page = usePage()
const currentStartup = computed(() => page.props.auth.user.current_startup)

const switchToStartup = (startup) => {
    router.put(route('current-startup.update'), {
        startup_id: startup.id,
    }, {
        preserveState: false,
    });
};
</script>
<template>
    <Dropdown align="left" width="60">
        <template #trigger>
            <span class="inline-flex rounded-md items-center">
                <button type="button"
                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                    <RocketIcon v-if="!currentStartup.logo_path"
                        class="h-8 w-8 text-gray-500 border rounded-lg p-2 mr-2" />
                    <span v-else class="h-8 w-8 block border rounded-lg bg-cover bg-no-repeat bg-center"
                        :style="'background-image: url(\'' + currentStartup.logo_path + '\');'" />

                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                    </svg>
                </button>
            </span>
        </template>

        <template #content>
            <div class="w-60">
                <!-- Startup Management -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                    Manage Startup
                </div>

                <!-- Startup Settings -->
                <DropdownLink :href="route('user-startups.show', $page.props.auth.user.current_startup)">
                    Startup Settings
                </DropdownLink>

                <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('user-startups.create')">
                    Create New Startup
                </DropdownLink>

                <!-- <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                    Create New Team
                </DropdownLink> -->

                <!-- Startup Switcher -->
                <template v-if="$page.props.auth.user.all_startups.length > 1">
                    <div class="border-t border-gray-200" />

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        Switch Startups
                    </div>

                    <template v-for="startup in $page.props.auth.user.all_startups" :key="startup.id">
                        <form @submit.prevent="switchToStartup(startup)">
                            <DropdownLink as="button">
                                <div class="flex items-center">
                                    <svg v-if="startup.id == currentStartup.id" class="me-2 h-5 w-5 text-green-400"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>

                                    <div>{{ startup.name }}</div>
                                </div>
                            </DropdownLink>
                        </form>
                    </template>
                </template>
            </div>
        </template>
    </Dropdown>
</template>