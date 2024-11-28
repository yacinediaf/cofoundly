<script setup>
import StarterKit from '@tiptap/starter-kit';
import { EditorContent, useEditor } from '@tiptap/vue-3';
import { Markdown } from 'tiptap-markdown';
import { watch } from 'vue';

const props = defineProps({
    modelValue: '',
})

let emit = defineEmits(['update:modelValue']);

const editor = useEditor({
    extensions: [
        StarterKit,
        Markdown
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm sm:prose lg:prose-lg xl:prose-2xl mx-auto focus:outline-none',
        },
    },
    onUpdate: () => emit('update:modelValue', editor.value?.storage.markdown.getMarkdown())
});

watch(() => props.modelValue, (value) => {
    if (value === editor.value?.storage.markdown.getMarkdown()) {
        return;
    }
    editor.value?.commands.setContent(value);
}, { immediate: true })
</script>
<template>
    <div class="border py-1.5 px-2 rounded-md">
        <menu class="flex gap-2">
            <li><button type="button"
                    class="px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold">Bold</button>
            </li>
            <li><button type="button"
                    class="px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold">Italic</button></li>
        </menu>
        <EditorContent :editor="editor"></EditorContent>
    </div>
</template>