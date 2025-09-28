<script setup>
let props = defineProps({
    location: Object
})

</script>
<template>
    <div>
        <span class="text-gray-500 bg-gray-200 px-2 py-1 rounded-full text-xs flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-map-pin-icon lucide-map-pin">
                <path
                    d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                <circle cx="12" cy="10" r="3" />
            </svg>
            <span>
                {{ location.name }}
            </span>
        </span>
    </div>
</template>
