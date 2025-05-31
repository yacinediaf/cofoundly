<script setup>
import { ChatBubbleIcon, DotsHorizontalIcon, StopwatchIcon } from '@radix-icons/vue';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuGroup,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu';
import {
    Sheet,
    SheetContent,
    SheetDescription,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/Components/ui/sheet'
import { MixerHorizontalIcon } from '@radix-icons/vue';
import { router, Link } from '@inertiajs/vue3';
import { inject } from 'vue';

let props = defineProps(['task'])

let project = inject('project');

function deleteTask() {
    router.delete(route('tasks.delete', [project.project_code, props.task.id]));
}

</script>
<template>
    <div class="my-2 w-full border p-4 rounded-lg shadow-lg bg-gray-50/50 hover:bg-gray-100/55">
        <div class="space-y-2">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <div v-if="task.tags?.length" class="flex items-center gap-2">
                        <span v-for="tag in task.tags" class="py-1 px-2 rounded-full text-white text-xs"
                            :style="{ 'background-color': tag.color }">
                            {{ tag.name }}
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
                                                                <div class="flex gap-2 items-center px-3 rounded-full text-white"
                                                                    :class="{
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
                                                                <div
                                                                    class="flex items-center gap-2 py-1 px-4 rounded-md bg-gray-50">
                                                                    <div class="text-sm">Assigned to</div>

                                                                    <div class="flex items-center gap-1">
                                                                        <img class="h-7 w-7 rounded-full border-2 border-white"
                                                                            :src="task.assignedTo.profile_photo_url" />
                                                                        <span class="text-xs">
                                                                            {{ task.assignedTo.name }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="flex items-center gap-2 py-1 px-4 rounded-md bg-gray-50">
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
                                                    <SheetDescription class="code prose prose-sm lg:prose-lg min-w-full"
                                                        v-html="task.description">
                                                    </SheetDescription>
                                                </SheetHeader>
                                            </SheetContent>
                                        </Sheet>
                                        <DropdownMenuItem v-if="task.can.editTask">
                                            <Link :href="route('tasks.edit', [project.project_code, task.id])">
                                            Edit
                                            </Link>
                                        </DropdownMenuItem>

                                        <DropdownMenuItem v-if="task.can.deleteTask" class="text-red-500"
                                            @click.prevent="deleteTask">
                                            Delete
                                        </DropdownMenuItem>
                                    </DropdownMenuGroup>
                                </DropdownMenuContent>
                            </DropdownMenuTrigger>
                        </DropdownMenu>
                    </div>
                </div>
                <h1 class="font-semibold truncate">{{ task.title }}</h1>
            </div>
            <div class="flex items-center justify-between pt-1">
                <div>
                    <img class="h-7 w-7 rounded-full border-2 border-white" :src="task.assignedTo.profile_photo_url" />
                </div>
                <div class="text-xs flex items-center font-semibold gap-3 text-gray-600">
                    <div class="flex items-center gap-1">
                        <StopwatchIcon></StopwatchIcon>
                        <span>{{ task.deliveryDate }}</span>
                    </div>
                    <div>
                        <ChatBubbleIcon></ChatBubbleIcon>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>