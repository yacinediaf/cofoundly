<script setup>
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import LoadedButton from '@/Components/LoadedButton.vue';
import Button from '@/Components/ui/button/Button.vue';
import { computed, reactive, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';
import { ChevronDownIcon, ChevronUpIcon, PaperPlaneIcon } from '@radix-icons/vue';

let props = defineProps(['task'])
let comments = computed(() => props.task.comments);
let newComment = reactive({
    content: '',
    user_id: usePage().props.auth.user.id,
    isEdited: false
})
let oldComment = ref(null);
let showComments = ref(false);
let isLoading = ref(false);
let makeComment = () => {
    isLoading.value = true;
    if (newComment.content == '') {
        return;
    }
    router.post(route('task.comment.store', props.task.id), newComment, {
        onFinish: () => {
            isLoading.value = false
            resetComment()
        }
    });
}
let editComment = (comment) => {
    newComment.content = comment.content;
    newComment.isEdited = true;
    oldComment.value = comment;
}
let resetComment = () => {
    newComment.content = '';
    newComment.isEdited = false;
}
let saveEditedComment = (comment) => {
    isLoading.value = true;
    if (oldComment.value.id == null) {
        return;
    }
    router.put(route('task.comment.update', comment.id), newComment, {
        onFinish: () => isLoading.value = false
    });
}
let deleteComment = (comment) => {
    router.delete(route('task.comment.delete', comment.id), {
        onFinish: () => isLoading.value = false
    });
}
</script>
<template>
    <div class="mt-10">
        <div>
            <span v-if="!showComments"
                class="text-gray-500 cursor-pointer text-sm hover:text-gray-600 flex items-center gap-1"
                @click="showComments = true">
                Show Comments
                <ChevronDownIcon class="w-4 h-4" />
            </span>
            <span v-if="showComments"
                class="text-gray-500 cursor-pointer text-sm hover:text-gray-600 flex items-center gap-1"
                @click="showComments = false">
                Hide Comments
                <ChevronUpIcon class="w-4 h-4" />
            </span>
        </div>
        <transition name="fade">
            <div v-if="showComments" class="w-3/4">
                <div>
                    <ul class="flex flex-col gap-2">
                        <div v-for="comment in comments" class="relative flex items-center space-y-4">
                            <img class="h-8 w-8 rounded-full" :src="comment.user.profilePicture"
                                :alt="comment.user.name" />
                            <div class="w-full flex flex-col gap-1">
                                <div :class="{
                                    'bg-blue-300 text-white': comment.user.id == $page.props.auth.user.id,
                                    'bg-gray-200 text-black': comment.user.id != $page.props.auth.user.id
                                }" class="py-1 px-3 mx-2 rounded-xl w-full text-sm">
                                    <div class="flex items-center justify-between gap-2 py-2">
                                        <div class="font-semibold">
                                            {{ comment.user.name }}
                                        </div>
                                    </div>
                                    <div :class="{ 'text-white': comment.user.id == $page.props.auth.user.id }"
                                        class="code prose prose-sm px-4 py-2 " v-html="comment.content" />
                                </div>
                                <div class="flex items-center gap-2 text-xs px-2 ml-2">
                                    <div>
                                        {{ comment.createdAt }}
                                    </div>
                                    <div v-if="comment.user.id == $page.props.auth.user.id"
                                        @click="editComment(comment)" class="cursor-pointer">
                                        Edit
                                    </div>
                                    <div v-if="comment.user.id == $page.props.auth.user.id"
                                        @click="deleteComment(comment)"
                                        class="cursor-pointer text-red-500 hover:text-red-600">
                                        Delete
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
                <div class="h-32 mt-8">
                    <MarkdownEditor v-model="newComment.content" attrs="h-32 min-w-full" />
                    <div v-if="!newComment.isEdited" class="min-w-full flex justify-end">
                        <LoadedButton title="Comment" class="mt-2 mb-10" :isLoading="isLoading" @click="makeComment">
                        </LoadedButton>
                    </div>
                    <div v-else class="min-w-full flex justify-end gap-2 text-white">
                        <Button variant="outline" class="mt-2 mb-10 bg-red-500 hover:bg-red-600 hover:text-white"
                            @click="resetComment">
                            Cancel
                        </Button>
                        <LoadedButton title="Update" class="mt-2 mb-10" :isLoading="isLoading"
                            @click="saveEditedComment(oldComment)">
                        </LoadedButton>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>