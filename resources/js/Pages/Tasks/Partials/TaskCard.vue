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
import { Link } from '@inertiajs/vue3';

defineProps(['task'])

</script>
<template>
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
                <h1 class="font-semibold truncate">{{ task.title }}</h1>
            </div>
            <div class="flex items-center justify-between pt-2">
                <div>
                    <img class="h-7 w-7 rounded-full border-2 border-white" :src="task.assigned_to.profile_photo_url" />
                </div>
                <div class="text-xs flex items-center gap-3 text-gray-600">
                    <div class="flex items-center gap-1">
                        <StopwatchIcon></StopwatchIcon>
                        <span>{{ task.delivery_date }}</span>
                    </div>
                    <div>
                        <ChatBubbleIcon></ChatBubbleIcon>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>