<script setup>
import { Link, useForm } from '@inertiajs/vue3'
import { PlusIcon } from '@radix-icons/vue';
import Button from '@/Components/ui/button/Button.vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import Textarea from './ui/textarea/Textarea.vue';
import { ref } from 'vue';

const form = useForm({
    title: null,
    description: null
})

const isDialogOpen = ref(false);
const createProject = () => {
    form.post('/projects', {
        onSuccess: () => {
            form.reset();
            closeDialog()
        }
    })
};

const closeDialog = () => {
    isDialogOpen.value = false;
}

</script>
<template>
    <section class="bg-white px-4 py-6 text-gray-500">
        <div>
            <aside class="font-bold mb-2">Projects 📚</aside>
            <template v-if="$page.props.auth.user.team_projects.length">
                <div class="block text-xs text-gray-400">
                    Switch Projects
                </div>
                <ul class="py-2 w-full">
                    <li v-for="project in $page.props.auth.user.team_projects" :key="project.projectCode"
                        class="text-gray-500 py-1 px-4 rounded-lg cursor-pointer font-medium text-sm"
                        :class="{ 'bg-gray-50': $page.url.includes(project.project_code) }">
                        <Link :href="route('projects.show', { project })">
                        {{ project.title }}
                        </Link>
                    </li>
                </ul>
            </template>
        </div>
        <Dialog v-model:open="isDialogOpen">
            <DialogTrigger as-child>
                <Button variant="outline" class="gap-2">
                    New Project
                    <PlusIcon class="w-4 h-4" />
                </Button>
            </DialogTrigger>
            <DialogContent class="sm:max-w-[425px]">
                <DialogHeader>
                    <DialogTitle>New Project</DialogTitle>
                    <DialogDescription>
                        Create your new project here. Click save when you're done.
                    </DialogDescription>
                </DialogHeader>
                <div class="grid gap-4 py-4 space-y-4">
                    <div class="flex flex-col grid-cols-12 gap-4">
                        <Label for="title">
                            Project Title
                        </Label>
                        <Input v-model="form.title" id="title" placeholder="Planora" class="col-span-12" />
                    </div>
                    <div class="grid w-full gap-4">
                        <Label for="description">Project Description <span
                                class="text-gray-500 text-sm font-normal">(Optional)</span></Label>
                        <Textarea v-model="form.description" id="description" class="w-full h-32" />
                    </div>
                </div>
                <DialogFooter>
                    <Button variant="secondary" type="submit" @click="isDialogOpen = false">
                        Close
                    </Button>
                    <Button type="submit" @click="createProject">
                        Create
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </section>
</template>