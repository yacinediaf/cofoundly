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
import { MixerHorizontalIcon } from '@radix-icons/vue';

defineProps(['task'])
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
            </SheetContent>
        </Sheet>
    </div>
</template>