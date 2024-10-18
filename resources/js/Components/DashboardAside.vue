<script setup>
import { PlusIcon } from '@radix-icons/vue';
import Button from './ui/button/Button.vue';
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
import { reactive } from 'vue';

const form = reactive({
    title: null,
    description: null
})

const createProject = () => router.post('/projects', form);

</script>
<template>
    <section class="bg-white w-96 px-4 py-6 text-gray-500">
        <div>
            <aside class="font-bold">Projects</aside>
            <template v-if="$page.props.auth.user.team_projects.length">
                <div class="block text-xs text-gray-400">
                    Switch Projects
                </div>
                <ul class="py-2 w-full">
                    <li class="text-gray-500 py-1 hover:bg-gray-50 px-4 rounded-lg cursor-pointer"
                        v-for="project in $page.props.auth.user.team_projects" :key="project.id">
                        {{ project.title }}
                    </li>
                </ul>
            </template>
        </div>
        <Dialog>
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
                        <Input v-model="form.title" id="title" value="Planora" class="col-span-12" />
                    </div>
                    <div class="grid w-full gap-4">
                        <Label for="description">Project Description</Label>
                        <Textarea v-model="form.description" id="description" class="w-full h-32" />
                    </div>
                </div>
                <DialogFooter>
                    <Button type="submit" @click="createProject">
                        Create
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </section>
</template>