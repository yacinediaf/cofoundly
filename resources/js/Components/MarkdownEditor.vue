<script setup>
import StarterKit from '@tiptap/starter-kit';
import { EditorContent, useEditor } from '@tiptap/vue-3';
import { Markdown } from 'tiptap-markdown';
import { ref, watch } from 'vue';
import 'remixicon/fonts/remixicon.css';
import Link from '@tiptap/extension-link';
import { Input } from '@/Components/ui/input'
import { Button } from '@/Components/ui/button'
import { Label } from '@/Components/ui/label'
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/Components/ui/popover'

const props = defineProps({
    modelValue: '',
})

let emit = defineEmits(['update:modelValue']);

const editor = useEditor({
    extensions: [
        StarterKit.configure({
            heading: {
                levels: [2, 3, 4]
            }
        }),
        Link,
        Markdown
    ],
    editorProps: {
        attributes: {
            class: 'h-[512px] overflow-y-scroll prose prose-sm sm:prose lg:prose-lg xl:prose-2xl mx-auto focus:outline-none px-3 py-3',
        },
    },
    onUpdate: () => emit('update:modelValue', editor.value?.storage.markdown.getMarkdown())
});

let promptedHref = ref(null);

const createLink = () => {
    if (!promptedHref.value) {
        return editor.value?.chain().focus().run();
    }

    return editor.value?.chain().focus().setLink({ href: promptedHref.value }).run();
}

const unsetLink = () => {
    if (editor.value?.isActive('link') && promptedHref.value) {
        promptedHref.value = null;
        return editor.value?.chain().unsetLink().run();
    }
}

watch(() => props.modelValue, (value) => {
    if (value === editor.value?.storage.markdown.getMarkdown()) {
        return;
    }
    editor.value?.commands.setContent(value);
}, { immediate: true })
</script>
<template>
    <div>
        <span class="text-xs text-gray-500">This text editor supports Markdonw too.</span>
        <div class="border py-1.5 px-2 rounded-md">
            <menu v-if="editor" class="flex gap-2 border-b pb-1">
                <li>
                    <button @click="() => editor.chain().focus().toggleBold().run()" type="button"
                        class="px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-100': editor.isActive('bold') }" title="Bold">
                        <i class="ri-bold"></i>
                    </button>
                </li>
                <li>
                    <button @click="() => editor.chain().focus().toggleItalic().run()" type="button"
                        class="px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-100': editor.isActive('italic') }" title="Italic">
                        <i class="ri-italic"></i>
                    </button>
                </li>
                <li>
                    <button @click="() => editor.chain().focus().toggleStrike().run()" type="button"
                        class="px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-100': editor.isActive('strike') }" title="Strike Through">
                        <i class="ri-strikethrough"></i>
                    </button>
                </li>
                <li>
                    <button @click="() => editor.chain().focus().toggleBlockquote().run()" type="button"
                        class="px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-100': editor.isActive('blockquote') }" title="Block Quote">
                        <i class="ri-double-quotes-r"></i>
                    </button>
                </li>
                <li>
                    <button @click="() => editor.chain().focus().toggleBulletList().run()" type="button"
                        class="px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-100': editor.isActive('bulletList') }" title="Unordered List">
                        <i class="ri-list-unordered"></i>
                    </button>
                </li>
                <li>
                    <button @click="() => editor.chain().focus().toggleOrderedList().run()" type="button"
                        class="px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-100': editor.isActive('orderedList') }" title="Ordered List">
                        <i class="ri-list-ordered"></i>
                    </button>
                </li>
                <li>
                    <Popover>
                        <PopoverTrigger as-child>
                            <button type="button"
                                class="relative px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold"
                                :class="{ 'bg-gray-100': editor.isActive('link') }" title="Set a Link">
                                <i class="ri-link"></i>
                            </button>
                        </PopoverTrigger>
                        <PopoverContent v-if="!editor.isActive('link')" class="w-80">
                            <div class="grid gap-4">
                                <div class="flex flex-col gap-4">
                                    <Label for="url">Url Destination.</Label>
                                    <Input v-model="promptedHref" id="url" type="text" />
                                </div>
                                <Button @click="createLink">Create Link</Button>
                            </div>
                        </PopoverContent>
                        <PopoverContent v-if="editor.isActive('link')">
                            <div class="flex flex-col gap-4">
                                <Button @click="unsetLink">Unset Link</Button>
                            </div>
                        </PopoverContent>
                    </Popover>
                </li>
                <li>
                    <button @click="() => editor.chain().focus().toggleHeading({ level: 2 }).run()" type="button"
                        class="px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-100': editor.isActive('heading', { level: 2 }) }" title="Heading 1">
                        <i class="ri-h-1"></i>
                    </button>
                </li>
                <li>
                    <button @click="() => editor.chain().focus().toggleHeading({ level: 3 }).run()" type="button"
                        class="px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-100': editor.isActive('heading', { level: 3 }) }" title="Heading 2">
                        <i class="ri-h-2"></i>
                    </button>
                </li>
                <li>
                    <button @click="() => editor.chain().focus().toggleHeading({ level: 4 }).run()" type="button"
                        class="px-1.5 py-1 hover:bg-gray-100 rounded-md text-sm font-semibold"
                        :class="{ 'bg-gray-100': editor.isActive('heading', { level: 4 }) }" title="Heading 3">
                        <i class="ri-h-3"></i>
                    </button>
                </li>
            </menu>
            <div>
                <EditorContent :editor="editor"></EditorContent>
            </div>
        </div>
    </div>
</template>