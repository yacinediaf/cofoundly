<script setup>
import { RocketIcon } from '@radix-icons/vue';

defineProps(['logoPath'])
</script>
<template>
    <div>
        <!-- Startup Logo -->
        <div v-if="logoPath">
            <span
                class="h-16 w-16 block shadow-xl border-2 bg-white border-gray-300 rounded-lg bg-cover bg-no-repeat bg-center cursor-pointer"
                :style="'background-image: url(\'' + logoPath + '\');'" />
        </div>
        <div v-else>
            <RocketIcon
                class="h-16 w-16 text-gray-500 text-sm bg-white border-2 border-gray-300 rounded-lg p-4 mr-2 cursor-pointer" />
        </div>
    </div>
</template>
