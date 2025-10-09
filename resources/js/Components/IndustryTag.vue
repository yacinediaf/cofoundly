<script setup>
let props = defineProps({
    industry: Object
})
console.log(props.industry);
</script>
<template>
    <div>
        <span class="text-gray-500 bg-gray-200 px-2 py-1 rounded-full text-xs flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                stroke="#828282" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-tag-icon lucide-tag">
                <path
                    d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z" />
                <circle cx="7.5" cy="7.5" r=".5" fill="currentColor" />
            </svg>
            <span>
                {{ industry.name }}
            </span>
        </span>
    </div>
</template>
