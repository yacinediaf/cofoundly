<script setup>
import IndustryTag from '@/Components/IndustryTag.vue';
import LocationTag from '@/Components/LocationTag.vue';
import StartupStage from '@/Components/StartupStage.vue';
import { Link } from '@inertiajs/vue3';
import { RocketIcon } from '@radix-icons/vue';
import { delay, Motion } from "motion-v"

defineProps(['startup'])
</script>
<template>
    <Motion :initial="{ opacity: 0, y: 100 }" :whileInView="{ opacity: 1, y: 0, delay: 100 }"
        :inViewOptions="{ once: true }" class="bg-white p-4 rounded-lg shadow-sm col-span-6 md:col-span-3 border">
        <div class="flex items-start gap-6">
            <div v-if="startup.logo_url">
                <span
                    class="h-16 w-16 block shadow-xl border-2 bg-white border-gray-300 rounded-lg bg-cover bg-no-repeat bg-center cursor-pointer"
                    :style="'background-image: url(\'' + startup.logo_url + '\');'" />
            </div>
            <div v-else>
                <RocketIcon
                    class="h-16 w-16 text-gray-500 text-sm bg-white border-2 border-gray-300 rounded-lg p-4 mr-2 cursor-pointer" />
            </div>
            <div class="flex flex-col items-start gap-2">
                <div class="flex items-center gap-2">
                    <h2 class="text-lg font-semibold">{{ startup.name }}</h2>
                </div>
                <div class="flex items-center gap-2">
                    <LocationTag :location="startup.location" />
                    <IndustryTag :industry="startup.industry" />
                </div>
            </div>
        </div>
        <div class="my-4 space-y-1">
            <StartupStage :startup="startup" />
            <div class="flex items-center gap-1 text-xs">

                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-briefcase-business-icon lucide-briefcase-business">
                    <path d="M12 12h.01" />
                    <path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                    <path d="M22 13a18.15 18.15 0 0 1-20 0" />
                    <rect width="20" height="14" x="2" y="6" rx="2" />
                </svg>
                <span>Open Positions</span>
            </div>
        </div>
        <div class="mt-4">
            <Link :href="route('startups.show', startup.id)" :prefetch="true"
                class="text-sm text-gray-500 border rounded-full px-2 py-1 hover:text-orange-500 hover:border-orange-500 transition-all ease-in-out delay-75">
            Read more
            </Link>
        </div>
    </Motion>
</template>
