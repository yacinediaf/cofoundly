<script setup>
let props = defineProps(['project', 'selectedTags'])
let emit = defineEmits(['update:selectedTags'])

const assignTag = (tag) => {
    if (props.selectedTags.includes(tag)) {
        return removeTag(tag);
    }
    props.selectedTags.push(tag);

    emit('update:selectedTags', props.selectedTags);
}

const removeTag = (tag) => {
    const index = props.selectedTags.indexOf(tag);
    if (index > -1) {
        props.selectedTags.splice(index, 1);
    }
}
</script>
<template>
    <div class="flex flex-wrap gap-3 items-center">
        <div class="w-full">
            <ul class="flex flex-wrap items-center gap-2">
                <li v-if="project.tags.length" v-for="tag in project.tags"
                    class="bg-gray-300 py-1 px-2 text-xs rounded-full text-white cursor-pointer"
                    :style="{ 'background-color': selectedTags.includes(tag.id) ? tag.color : 'gray' }"
                    @click="assignTag(tag.id)">
                    {{ tag.name }}
                </li>
            </ul>
        </div>
    </div>
</template>