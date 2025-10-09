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
            <h1 class="font-semibold py-4">Trendy Startups (Most Viewed)</h1>
            <ul class="space-y-1 divide-y-2 divide-gray-100">
                <li class="flex gap-2 hover:bg-gray-100 p-1 rounded-lg cursor-pointer truncate">
                    <Startuplogo :logoPath="startup.logo_path" />
                    <div class="flex flex-col">
                        <h1 class="font-medium text-lg">{{ startup.name }}</h1>
                        <p class="text-sm text-gray-500 truncate w-full">{{ startup.description }}</p>
                    </div>
                </li>
                <li class="flex gap-2 hover:bg-gray-100 p-1 rounded-lg cursor-pointer truncate">
                    <Startuplogo :logoPath="startup.logo_path" />
                    <div class="flex flex-col">
                        <h1 class="font-medium text-lg">{{ startup.name }}</h1>
                        <p class="text-xs text-gray-500 mt-1 ">{{ startup.description }}</p>
                    </div>
                </li>
                <li class="flex gap-2 hover:bg-gray-100 p-1 rounded-lg cursor-pointer truncate">
                    <Startuplogo :logoPath="startup.logo_path" />
                    <div class="flex flex-col">
                        <h1 class="font-medium text-lg">{{ startup.name }}</h1>
                        <p class="text-xs text-gray-500 mt-1">{{ startup.description }}</p>
                    </div>
                </li>
            </ul>
        </div>
    </Motion>
</template>
