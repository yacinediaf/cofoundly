<script setup>
import IndustryTag from '@/Components/IndustryTag.vue';
import LocationTag from '@/Components/LocationTag.vue';
import Startuplogo from '@/Components/Startuplogo.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Motion } from "motion-v"
import TrendyStartups from './Partials/TrendyStartups.vue';
import StartupStage from '@/Components/StartupStage.vue';

defineProps({
    startup: Object,
    members: Array
})
</script>

<template>

    <GuestLayout>

        <Head :title="startup.name" />

        <div class="bg-gray-100 h-auto">
            <div class="lg:w-[1024px] grid grid-cols-12 gap-4 mx-auto py-4 md:py-10 px-2 relative h-full">
                <Motion :initial="{ opacity: 0, y: 100 }" :whileInView="{ opacity: 1, y: 0 }"
                    class="col-span-12 md:col-span-8 rounded-b-lg">
                    <div class="relative border">
                        <!-- Startup Banner -->
                        <div v-if="!startup.banner_path" class="w-full bg-gray-300 h-48 rounded-t-lg"></div>
                        <div v-else class="w-full h-48 bg-cover bg-no-repeat bg-center rounded-t-lg cursor-pointer"
                            :style="'background-image: url(\'' + startup.banner_path + '\');'">
                        </div>
                        <div class="absolute -bottom-10 left-0 mx-3 my-6">
                            <Startuplogo :logoPath="startup.logo_path" />
                        </div>
                    </div>
                    <div>
                        <div class="bg-white pt-6 px-4 pb-4 rounded-b-lg flex items-center justify-between">
                            <div class="flex flex-col gap-2">
                                <h1 class="text-2xl font-semibold flex flex-wrap items-center gap-2">
                                    {{ startup.name }}
                                </h1>
                                <div class="flex items-center gap-2">
                                    <LocationTag :location="startup.location" />
                                    <IndustryTag :industry="startup.industry" />
                                </div>
                                <div>
                                    <StartupStage :startup="startup" />
                                </div>
                            </div>
                            <button
                                class="bg-orange-300 px-3 py-1 text-gray-600 rounded-md text-xs flex items-center gap-1 hover:shadow-md transition-all ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="#8f8f8f" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-circle-plus-icon lucide-circle-plus">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M8 12h8" />
                                    <path d="M12 8v8" />
                                </svg>
                                Join
                            </button>

                        </div>
                        <div>
                            <!-- Open Positions -->
                            <div class="bg-white mt-4 p-4 rounded-lg">
                                <h1 class="font-semibold text-lg mb-2">Open Positions</h1>
                                <p class="text-xs text-gray-500 mt-1 ">Currently, there are no open positions.</p>
                            </div>
                        </div>
                    </div>
                    <!-- ABOUT  -->
                    <div class="bg-white mt-4 p-4 rounded-lg">
                        <h1 class="font-semibold text-lg mb-2">About</h1>
                        <p class="text-xs text-gray-500 mt-1 ">{{ startup.description }}</p>
                    </div>
                    <!-- Team -->
                    <div class="bg-white mt-4 p-4 rounded-lg">
                        <h1 class="font-semibold text-lg mb-2">Team</h1>
                        <!-- Founder -->
                        <div class="flex items-center gap-1">
                            <div
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" :src="startup.owner.profile_photo_url"
                                    :alt="startup.owner.name">
                            </div>
                            <p class="text-sm text-gray-500">{{ startup.owner.name }} <span
                                    class="text-xs text-gray-400 font-semibold">(founder)</span></p>
                        </div>
                        <!-- Members -->
                        <div v-for="member in members.data" :key="member.id" class="flex items-center gap-1">
                            <div
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" :src="member.profile_photo_url"
                                    :alt="member.name">
                            </div>
                            <p class="text-sm text-gray-500">{{ member.name }} <span
                                    class="text-xs text-gray-400 font-semibold">({{ member.role }})</span></p>
                        </div>
                    </div>

                </Motion>

                <TrendyStartups :startup="startup" />
            </div>
        </div>

    </GuestLayout>
</template>
