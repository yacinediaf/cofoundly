<script setup>
import draggable from 'vuedraggable';
import { router, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import TaskCard from '@/Pages/Tasks/Partials/TaskCard.vue';

let props = defineProps(['tasks']);

let todos = ref(props.tasks['Todo'] ?? [])
let inProgress = ref(props.tasks['In Progress'] ?? [])
let done = ref(props.tasks['Done'] ?? [])

const update = (e, status) => {
    if (e.added) {
        let task = e.added?.element;
        if (usePage().props.auth.user.id === task.assigned_to.id) {
            router.post(route('tasks.update', [task.id]), {
                _method: 'PATCH',
                status: status
            });
        }
        return false;
    }
}

function canDrag(evt) {
    return (usePage().props.auth.user.id === evt.draggedContext.element.assigned_to.id)
}
</script>
<template>
    <div class="grid grid-cols-12 gap-3 mt-8 h-full">
        <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3 h-full bg-blue-200">
            <h1 class="font-bold text-white">
                <span class="bg-blue-500 py-1 px-3 rounded-md">Done</span>
            </h1>
            <draggable v-model="todos" group="test" :move="canDrag" class="w-full space-y-2 h-full" item-key="id"
                @change="e => update(e, 'Todo')">
                <template #item="{ element }">
                    <TaskCard :task="element"></TaskCard>
                </template>
            </draggable>
        </div>
        <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3 h-full bg-orange-200">
            <h1 class="font-bold text-white">
                <span class="bg-orange-500 py-1 px-3 rounded-md">In Progress</span>
            </h1>
            <draggable v-model="inProgress" group="test" :move="canDrag" class="w-full space-y-2 h-full" item-key="id"
                @change="e => update(e, 'In Progress')">
                <template #item="{ element }">
                    <TaskCard :task="element"></TaskCard>
                </template>
            </draggable>
        </div>
        <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3 h-full bg-green-200">
            <h1 class="font-bold text-white">
                <span class="bg-green-500 py-1 px-3 rounded-md">Done</span>
            </h1>
            <draggable v-model="done" group="test" :move="canDrag" class="w-full space-y-2 h-full" item-key="id"
                @change="e => update(e, 'Done')">
                <template #item="{ element }">
                    <TaskCard :task="element"></TaskCard>
                </template>
            </draggable>
        </div>
    </div>
</template>