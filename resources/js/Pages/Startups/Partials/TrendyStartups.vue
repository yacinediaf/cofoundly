<script setup>
import Startuplogo from "@/Components/Startuplogo.vue";
import { Motion } from "motion-v"

defineProps({
    startup: Object
})
</script>
<template>
    <Motion :intial="{ opacity: 0 }" :whileInView="{ opacity: 1 }" class="col-span-12 md:col-span-4 h-auto">
        <div class="sticky top-16 bg-white px-3 pb-4 rounded-lg border h-auto">
            <h1 class="font-semibold py-4 text-center text-xl">Trendy Startups</h1>
            <ul class="space-y-1 divide-y-2 divide-gray-100">
                <li class="flex gap-2 hover:bg-gray-100 p-1 rounded-lg cursor-pointer truncate h-32">
                    <!-- <Startuplogo :logoPath="startup.logo_path" />
                    <div class="flex flex-col">
                        <h1 class="font-medium text-lg">{{ startup.name }}</h1>
                    </div> -->
                    <div class="bg-gray-100 h-32 p-2 w-full rounded animate-pulse flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="#7d7d7d" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-rocket-icon lucide-rocket">
                            <path
                                d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z" />
                            <path
                                d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z" />
                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0" />
                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5" />
                        </svg>
                    </div>
                </li>
            </ul>
        </div>
    </Motion>
</template>
