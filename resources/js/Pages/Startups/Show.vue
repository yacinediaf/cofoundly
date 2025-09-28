<script setup>
import LocationTag from '@/Components/LocationTag.vue';
import Startuplogo from '@/Components/Startuplogo.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    startup: Object
})
</script>

<template>

    <GuestLayout>

        <Head :title="startup.name" />

        <div class="bg-gray-100 h-auto">
            <div class="lg:w-[1024px] grid grid-cols-12 gap-4 mx-auto py-4 md:py-10 px-2 relative h-full">
                <div class="col-span-12 md:col-span-8 rounded-b-lg">
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
                        </h1>
                        <p class="text-xs text-gray-500 mt-1 ">{{ startup.description }}</p>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-4 h-auto">
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
                </div>
            </div>
        </div>

    </GuestLayout>
</template>
