<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Components/ui/button/Button.vue';
import { ChatBubbleIcon, DotsHorizontalIcon, StopwatchIcon, PlusIcon } from '@radix-icons/vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';
import draggable from 'vuedraggable';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineOptions({
    layout: AppLayout
})

let props = defineProps(['project', 'tasks', 'currentDate'])
let todos = ref(props.tasks['Todo'] ?? [])
let inProgress = ref(props.tasks['In Progress'] ?? [])
let done = ref(props.tasks['Done'] ?? [])

const update = (e, status) => {
    if (e.added) {
        let task = e.added?.element.id;
        router.post(route('tasks.update', [task]), {
            _method: 'PATCH',
            status: status
        });
    }
}

</script>
<template>
    <div class="h-full">
        <div class="h-full px-6 lg:p-8 bg-white border-b border-gray-200">
            <div>
                <div>
                    <h1 class="text-2xl font-medium text-gray-900">
                        {{ 'Project Title : ' + project.title }}
                    </h1>
                </div>
                <div class="mt-5 w-full flex items-center justify-between">
                    <div class="text-gray-500 text-sm">{{ currentDate }}</div>
                    <div>
                        <Button class="flex gap-1">
                            <span>New Task</span>
                            <PlusIcon class="w-4 h-4" />
                        </Button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-3 mt-8">
                <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3">
                    <h1 class="font-bold text-xl flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-black mt-2"></div>
                        <span>Todo</span>
                    </h1>
                    <draggable v-model="todos" group="test" class="w-full space-y-2 h-full cursor-move" item-key="id"
                        @change="e => update(e, 'Todo')">
                        <template #item="{ element }">
                            <div class="my-2 w-full border p-4 rounded-lg shadow-lg bg-gray-50/50 hover:bg-gray-100/55">
                                <div class="space-y-2">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="bg-purple-500 py-1 px-2 rounded-full text-white text-xs ">
                                                    web design
                                                </span>
                                                <span class="bg-red-500 py-1 px-2 rounded-full text-white text-xs ">
                                                    Tooling
                                                </span>
                                            </div>
                                            <div>
                                                <DropdownMenu>
                                                    <DropdownMenuTrigger>
                                                        <DotsHorizontalIcon class="cursor-pointer">
                                                        </DotsHorizontalIcon>
                                                        <DropdownMenuContent class="w-32">
                                                            <DropdownMenuLabel>
                                                                Options
                                                            </DropdownMenuLabel>
                                                            <DropdownMenuSeparator />
                                                            <DropdownMenuGroup>
                                                                <DropdownMenuItem>
                                                                    <Link href="#" class="w-full">
                                                                    Edit
                                                                    </Link>
                                                                </DropdownMenuItem>
                                                                <DropdownMenuItem>
                                                                    <Link href="#" class="w-full">
                                                                    Delete
                                                                    </Link>
                                                                </DropdownMenuItem>
                                                            </DropdownMenuGroup>
                                                        </DropdownMenuContent>
                                                    </DropdownMenuTrigger>
                                                </DropdownMenu>
                                            </div>
                                        </div>
                                        <h1 class="font-semibold">{{ element.title }}</h1>
                                    </div>
                                    <div class="text-gray-500 text-sm">
                                        {{ element.description }}
                                    </div>
                                    <div class="flex items-center justify-between border-t pt-2">
                                        <div>
                                            <img class="h-7 w-7 rounded-full border-2 border-white"
                                                :src="$page.props.auth.user.profile_photo_url" />
                                        </div>
                                        <div class="text-xs flex items-center gap-3 text-gray-600">
                                            <div class="flex items-center gap-1">
                                                <StopwatchIcon></StopwatchIcon>
                                                <span>{{ element.created_at }}</span>
                                            </div>
                                            <div>
                                                <ChatBubbleIcon></ChatBubbleIcon>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </draggable>
                </div>
                <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3">
                    <h1 class="font-bold text-xl flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-orange-500 mt-2"></div>
                        <span>In Progress</span>
                    </h1>
                    <draggable v-model="inProgress" group="test" class="w-full space-y-2 h-full cursor-move"
                        item-key="id" @change="e => update(e, 'In Progress')">
                        <template #item="{ element }">
                            <div class="my-2 w-full border p-4 rounded-lg shadow-lg bg-gray-50/50 hover:bg-gray-100/55">
                                <div class="space-y-2">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="bg-purple-500 py-1 px-2 rounded-full text-white text-xs ">
                                                    web design
                                                </span>
                                                <span class="bg-red-500 py-1 px-2 rounded-full text-white text-xs ">
                                                    Tooling
                                                </span>
                                            </div>
                                            <div>
                                                <DropdownMenu>
                                                    <DropdownMenuTrigger>
                                                        <DotsHorizontalIcon class="cursor-pointer">
                                                        </DotsHorizontalIcon>
                                                        <DropdownMenuContent class="w-32">
                                                            <DropdownMenuLabel>
                                                                Options
                                                            </DropdownMenuLabel>
                                                            <DropdownMenuSeparator />
                                                            <DropdownMenuGroup>
                                                                <DropdownMenuItem>
                                                                    <Link href="#" class="w-full">
                                                                    Edit
                                                                    </Link>
                                                                </DropdownMenuItem>
                                                                <!-- <DropdownMenuItem>
                                                                <Link href="#" class="w-full">
                                                                Hide
                                                                </Link>
                                                            </DropdownMenuItem> -->
                                                                <DropdownMenuItem>
                                                                    <Link href="#" class="w-full">
                                                                    Delete
                                                                    </Link>
                                                                </DropdownMenuItem>
                                                            </DropdownMenuGroup>
                                                        </DropdownMenuContent>
                                                    </DropdownMenuTrigger>
                                                </DropdownMenu>
                                            </div>
                                        </div>
                                        <h1 class="font-semibold">{{ element.title }}</h1>
                                    </div>
                                    <div class="text-gray-500 text-sm">
                                        {{ element.description }}
                                    </div>
                                    <div class="flex items-center justify-between border-t pt-2">
                                        <div>
                                            <img class="h-7 w-7 rounded-full border-2 border-white"
                                                :src="$page.props.auth.user.profile_photo_url" />
                                        </div>
                                        <div class="text-xs flex items-center gap-3 text-gray-600">
                                            <div class="flex items-center gap-1">
                                                <StopwatchIcon></StopwatchIcon>
                                                <span>{{ element.created_at }}</span>
                                            </div>
                                            <div>
                                                <ChatBubbleIcon></ChatBubbleIcon>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </draggable>
                </div>
                <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3">
                    <h1 class="font-bold text-xl flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-500 mt-2"></div>
                        <span>Done</span>
                    </h1>
                    <draggable v-model="done" group="test" class="w-full space-y-2 h-full cursor-move" item-key="id"
                        @change="e => update(e, 'Done')">
                        <template #item="{ element }">
                            <div class="my-2 w-full border p-4 rounded-lg shadow-lg bg-gray-50/50 hover:bg-gray-100/55">
                                <div class="space-y-2">
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="bg-purple-500 py-1 px-2 rounded-full text-white text-xs ">
                                                    web design
                                                </span>
                                                <span class="bg-red-500 py-1 px-2 rounded-full text-white text-xs ">
                                                    Tooling
                                                </span>
                                            </div>
                                            <div>
                                                <DropdownMenu>
                                                    <DropdownMenuTrigger>
                                                        <DotsHorizontalIcon class="cursor-pointer">
                                                        </DotsHorizontalIcon>
                                                        <DropdownMenuContent class="w-32">
                                                            <DropdownMenuLabel>
                                                                Options
                                                            </DropdownMenuLabel>
                                                            <DropdownMenuSeparator />
                                                            <DropdownMenuGroup>
                                                                <DropdownMenuItem>
                                                                    <Link href="#" class="w-full">
                                                                    Edit
                                                                    </Link>
                                                                </DropdownMenuItem>
                                                                <!-- <DropdownMenuItem>
                                                                <Link href="#" class="w-full">
                                                                Hide
                                                                </Link>
                                                            </DropdownMenuItem> -->
                                                                <DropdownMenuItem>
                                                                    <Link href="#" class="w-full">
                                                                    Delete
                                                                    </Link>
                                                                </DropdownMenuItem>
                                                            </DropdownMenuGroup>
                                                        </DropdownMenuContent>
                                                    </DropdownMenuTrigger>
                                                </DropdownMenu>
                                            </div>
                                        </div>
                                        <h1 class="font-semibold">{{ element.title }}</h1>
                                    </div>
                                    <div class="text-gray-500 text-sm">
                                        {{ element.description }}
                                    </div>
                                    <div class="flex items-center justify-between border-t pt-2">
                                        <div>
                                            <img class="h-7 w-7 rounded-full border-2 border-white"
                                                :src="$page.props.auth.user.profile_photo_url" />
                                        </div>
                                        <div class="text-xs flex items-center gap-3 text-gray-600">
                                            <div class="flex items-center gap-1">
                                                <StopwatchIcon></StopwatchIcon>
                                                <span>{{ element.created_at }}</span>
                                            </div>
                                            <div>
                                                <ChatBubbleIcon></ChatBubbleIcon>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </draggable>
                </div>
            </div>
        </div>
    </div>
</template>