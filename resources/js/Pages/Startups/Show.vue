<script setup>
import IndustryTag from '@/Components/IndustryTag.vue';
import LocationTag from '@/Components/LocationTag.vue';
import Startuplogo from '@/Components/Startuplogo.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Motion } from "motion-v"
import TrendyStartups from './Partials/TrendyStartups.vue';

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
                    <div class="bg-white pt-6 px-4 pb-4 rounded-b-lg">
                        <h1 class="text-2xl font-semibold flex items-center gap-2">
                            <span>{{ startup.name }}</span>
                            <LocationTag :location="startup.location" />
                            <IndustryTag :industry="startup.industry" />
                        </h1>
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
                                    class="text-xs text-gray-400 font-semibold">(Founder)</span></p>
                        </div>
                        <!-- Members -->
                        <div v-for="member in members" :key="member.id" class="flex items-center gap-1">
                            <div
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" :src="member.profile_photo_url"
                                    :alt="member.name">
                            </div>
                            <p class="text-sm text-gray-500">{{ member.name }}</p>
                        </div>
                    </div>

                </Motion>

                <TrendyStartups :startup="startup" />
            </div>
        </div>

    </GuestLayout>
</template>
