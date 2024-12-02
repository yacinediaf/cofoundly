<script setup>
import draggable from 'vuedraggable';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';
import TaskCard from '@/Pages/Tasks/Partials/TaskCard.vue';

let props = defineProps(['tasks']);

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
    <div class="grid grid-cols-12 gap-3 mt-8">
        <div
            class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3 md:min-h-screen bg-blue-200">
            <h1 class="font-bold text-white">
                <span class="bg-blue-500 py-1 px-3 rounded-md">Done</span>
            </h1>
            <draggable v-model="todos" group="test" class="w-full space-y-2 h-full cursor-move" item-key="id"
                @change="e => update(e, 'Todo')">
                <template #item="{ element }">
                    <TaskCard :task="element"></TaskCard>
                </template>
            </draggable>
        </div>
        <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3 max-h-screen bg-orange-200">
            <h1 class="font-bold text-white">
                <span class="bg-orange-500 py-1 px-3 rounded-md">In Progress</span>
            </h1>
            <draggable v-model="inProgress" group="test" class="w-full space-y-2 h-full cursor-move" item-key="id"
                @change="e => update(e, 'In Progress')">
                <template #item="{ element }">
                    <TaskCard :task="element"></TaskCard>
                </template>
            </draggable>
        </div>
        <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3 max-h-screen bg-green-200">
            <h1 class="font-bold text-white">
                <span class="bg-green-500 py-1 px-3 rounded-md">Done</span>
            </h1>
            <draggable v-model="done" group="test" class="w-full space-y-2 h-full cursor-move" item-key="id"
                @change="e => update(e, 'Done')">
                <template #item="{ element }">
                    <TaskCard :task="element"></TaskCard>
                </template>
            </draggable>
        </div>
    </div>
</template>