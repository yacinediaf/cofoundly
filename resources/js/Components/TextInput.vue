<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input ref="input"
        class="border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-2 py-1.5"
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" />
</template>
