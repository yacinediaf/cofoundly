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
        <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3">
            <h1 class="font-bold text-xl flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-black mt-2"></div>
                <span>Todo</span>
            </h1>
            <draggable v-model="todos" group="test" class="w-full space-y-2 h-full cursor-move" item-key="id"
                @change="e => update(e, 'Todo')">
                <template #item="{ element }">
                    <TaskCard :task="element"></TaskCard>
                </template>
            </draggable>
        </div>
        <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3">
            <h1 class="font-bold text-xl flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-orange-500 mt-2"></div>
                <span>In Progress</span>
            </h1>
            <draggable v-model="inProgress" group="test" class="w-full space-y-2 h-full cursor-move" item-key="id"
                @change="e => update(e, 'In Progress')">
                <template #item="{ element }">
                    <TaskCard :task="element"></TaskCard>
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
                    <TaskCard :task="element"></TaskCard>
                </template>
            </draggable>
        </div>
    </div>
</template>