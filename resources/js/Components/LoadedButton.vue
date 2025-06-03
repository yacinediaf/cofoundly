<script setup>
import Button from '@/Components/ui/button/Button.vue';
import { ReloadIcon } from '@radix-icons/vue';

defineProps({
    title: {
        type: String
    },
    isLoading: {
        type: Boolean,
        default: false,
    },
    callback: {
        type: Function,
    }
});
</script>

<template>
    <Button v-if="!isLoading" @click="callback">
        
        {{ title }}
    </Button>
    <Button v-else disabled>
        <ReloadIcon class="w-4 h-4 mr-2 animate-spin" />
        Loading
    </Button>
</template>