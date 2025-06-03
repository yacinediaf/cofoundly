<script setup>
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/Components/ui/sheet'
import {
    DropdownMenuItem,
} from '@/Components/ui/dropdown-menu';
import { MixerHorizontalIcon, ChevronDownIcon, ChevronUpIcon } from '@radix-icons/vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import LoadedButton from '@/Components/LoadedButton.vue';
import { reactive, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

let props = defineProps(['task'])
let newComment = reactive({
    content: '',
    user_id: usePage().props.auth.user.id,
})
let showComments = ref(false);
let isLoading = ref(false);
let makeComment = () => {
    isLoading.value = true;
    if (newComment.content == '') {
        return;
    }
    router.post(route('task.comment.store', props.task.id), newComment, {
        onFinish: () => isLoading.value = false
    });
}
</script>

<template>
    <div class="mt-4">
        <Sheet>
            <DropdownMenuItem>
                <SheetTrigger @click.stop>
                    Show
                </SheetTrigger>
            </DropdownMenuItem>
            <SheetContent class="min-w-full min-h-full overflow-y-scroll">
                <SheetHeader>
                    <SheetTitle>
                        <div class="space-y-4 mb-2">
                            <div class="flex gap-2 text-2xl font-semibold">
                                <div class="flex gap-2 items-center px-3 rounded-full text-white" :class="{
                                    'bg-green-500 text-white': task.status == 'Done',
                                    'bg-orange-500 text-white': task.status == 'In Progress',
                                    'bg-gray-800 text-white': task.status == 'Todo'
                                }">
                                    <MixerHorizontalIcon class="w-4 h-4">
                                    </MixerHorizontalIcon>
                                    <h1>{{ 'Task #' + task.id }}</h1>
                                </div>
                                <div>
                                    {{ task.title }}
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <div class="flex items-center gap-2 py-1 px-4 rounded-md bg-gray-50">
                                    <div class="text-sm">Assigned to</div>

                                    <div class="flex items-center gap-1">
                                        <img class="h-7 w-7 rounded-full border-2 border-white"
                                            :src="task.assignedTo.profile_photo_url" />
                                        <span class="text-xs">
                                            {{ task.assignedTo.name }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 py-1 px-4 rounded-md bg-gray-50">
                                    <div class="text-sm">Deliver on</div>

                                    <div class="flex items-center gap-1">
                                        <span class="text-xs">
                                            {{ task.deliveryDate }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-xl">
                                Task Description
                            </div>
                        </div>
                    </SheetTitle>
                    <SheetDescription class="code prose prose-sm lg:prose-lg min-w-full" v-html="task.description">
                    </SheetDescription>
                </SheetHeader>
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
                        <div v-if="showComments" class="w-3/4 mt-10">
                            <div>
                                <ul class="flex flex-col gap-2">
                                    <div v-for="comment in task.comments" class="flex items-center">
                                        <img class="h-8 w-8 rounded-full" :src="comment.user.profilePicture"
                                            :alt="comment.user.name" />
                                        <div :class="{
                                            'bg-blue-400 text-white': comment.user.id == $page.props.auth.user.id,
                                            'bg-gray-300 text-white': comment.user.id != $page.props.auth.user.id
                                        }" class="py-1 px-3 mx-2 rounded-lg w-full text-sm">
                                            <div class="flex items-center justify-between gap-2 py-2">
                                                <div class="font-semibold">
                                                    {{ comment.user.name }}
                                                </div>
                                                <div class="text-xs">
                                                    {{ comment.createdAt }}
                                                </div>
                                            </div>
                                            <div class="code prose prose-sm px-4 py-2 " v-html="comment.content" />
                                        </div>
                                    </div>
                                </ul>
                            </div>
                            <div class="h-32 mt-8">
                                <MarkdownEditor v-model="newComment.content" attrs="h-32 min-w-full" />
                                <LoadedButton title="Comment" class="mt-2 mb-10" :isLoading="isLoading"
                                    @click="makeComment">
                                </LoadedButton>
                            </div>
                        </div>
                    </transition>
                </div>
            </SheetContent>
        </Sheet>
    </div>
</template>
<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>