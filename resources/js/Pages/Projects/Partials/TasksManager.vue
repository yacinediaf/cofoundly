<script setup>
import draggable from 'vuedraggable';
import { router, usePage } from '@inertiajs/vue3';
import { inject, computed } from 'vue';
import TaskCard from '@/Pages/Tasks/Partials/TaskCard.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table';

let props = defineProps(['tasks']);
let project = inject('project');

let todos = computed(() => props.tasks['Todo'] ?? [])
let inProgress = computed(() => props.tasks['In Progress'] ?? [])
let done = computed(() => props.tasks['Done'] ?? [])

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

Echo.private('projects.' + project.project_code).listen('TaskStatusUpdated', (event) => {
    removeFromPreviousStatusList(event.task);
    InsertInNewStatusList(event.task);
}).listen('TaskDeleted', (event) => {
    removeFromPreviousStatusList(event.task);
}).listen('TaskCreated', (event) => {
    InsertInNewStatusList(event.task);
})

function removeFromPreviousStatusList(updatedTask) {
    const allTasks = [todos.value, inProgress.value, done.value];

    allTasks.forEach((array) => {
        const index = array.findIndex((task) => task.id === updatedTask.id);
        if (index !== -1) {
            array.splice(index, 1); // Remove the task from the array
        }
    });
}

function InsertInNewStatusList(updatedTask) {
    if (updatedTask.status === "Todo") {
        todos.value.push(updatedTask);
    } else if (updatedTask.status === "In Progress") {
        inProgress.value.push(updatedTask);
    } else if (updatedTask.status === "Done") {
        done.value.push(updatedTask);
    }
}
</script>
<template>
    <div class="mt-8 h-full">
        <div class="hidden lg:grid grid-cols-12 gap-3 h-full">
            <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3 h-full bg-blue-200">
                <h1 class="font-bold text-white">
                    <span class="bg-blue-500 py-1 px-3 rounded-md">Todo</span>
                </h1>
                <draggable v-model="todos" group="test" :move="canDrag" class="w-full space-y-2 h-full cursor-move"
                    item-key="id" @change="e => update(e, 'Todo')">
                    <template #item="{ element }">
                        <TaskCard :task="element"></TaskCard>
                    </template>
                </draggable>
            </div>
            <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3 h-full bg-orange-200">
                <h1 class="font-bold text-white">
                    <span class="bg-orange-500 py-1 px-3 rounded-md">In Progress</span>
                </h1>
                <draggable v-model="inProgress" group="test" :move="canDrag" class="w-full space-y-2 h-full cursor-move"
                    item-key="id" @change="e => update(e, 'In Progress')">
                    <template #item="{ element }">
                        <TaskCard :task="element"></TaskCard>
                    </template>
                </draggable>
            </div>
            <div class="col-span-4 border rounded-lg px-3 py-4 flex flex-col items-center gap-3 h-full bg-green-200">
                <h1 class="font-bold text-white">
                    <span class="bg-green-500 py-1 px-3 rounded-md">Done</span>
                </h1>
                <draggable v-model="done" group="test" :move="canDrag" class="w-full space-y-2 h-full cursor-move"
                    item-key="id" @change="e => update(e, 'Done')">
                    <template #item="{ element }">
                        <TaskCard :task="element"></TaskCard>
                    </template>
                </draggable>
            </div>
        </div>
        <div class="lg:hidden h-full">
            <Table class="w-full rounded border mb-4">
                <TableHeader>
                    <TableRow>
                        <TableHead>ID</TableHead>
                        <TableHead>Task</TableHead>
                        <TableHead>Assigned To</TableHead>
                        <TableHead>Due Date</TableHead>
                        <TableHead>Status</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="task in todos.concat(inProgress).concat(done)" :key="task.id">
                        <TableCell>
                            <h1 class="font-semibold">{{ '#' + task.id }}</h1>
                        </TableCell>
                        <TableCell>
                            <span class="truncate">{{ task.title }}</span>
                        </TableCell>
                        <TableCell>
                            {{ task.assigned_to.name }}
                        </TableCell>
                        <TableCell>
                            {{ task.delivery_date }}
                        </TableCell>
                        <TableCell>
                            <span class="py-1 px-3 rounded-full text-xs" :class="{
                                'bg-green-500 text-white': task.status == 'Done',
                                'bg-orange-500 text-white': task.status == 'In Progress',
                                'bg-gray-800 text-white': task.status == 'Todo'
                            }">{{ task.status }}</span>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </div>
</template>