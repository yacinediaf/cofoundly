<script setup>
import { router } from '@inertiajs/vue3';
import { ref, reactive } from 'vue';
import LoadedButton from '@/Components/LoadedButton.vue';
import { PlusIcon } from '@radix-icons/vue';
import Button from '@/Components/ui/button/Button.vue';
import Label from '@/Components/ui/label/Label.vue';
import Input from '@/Components/ui/input/Input.vue';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'

let props = defineProps({
    project: {
        type: Object,
        required: true
    }
})
const isDialogOpen = ref(false);
const isLoading = ref(false);
const tagData = reactive({
    name: '',
    color: '#4B5563'
})
const createTag = () => {
    isLoading.value = true;
    router.post(route('tags.store', props.project.project_code), tagData, {
        onError: () => console.log(usePage().props.errors),
        onFinish: () => {
            isLoading.value = false
            isDialogOpen.value = false
        }
    });
}
</script>
<template>
    <div>
        <div class="flex items-center justify-between">
            <h1 class="font-semibold text-2xl mb-2">Tags</h1>
            <Dialog v-model:open="isDialogOpen">
                <DialogTrigger as-child>
                    <Button variant="outline" class="gap-2">
                        <PlusIcon class="w-4 h-4" />
                    </Button>
                </DialogTrigger>
                <DialogContent class="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>New tag</DialogTitle>
                        <DialogDescription class="text-xs">
                            Create your new tag here. Click save when you're done.
                        </DialogDescription>
                    </DialogHeader>
                    <div class="grid gap-4 py-4 space-y-4">
                        <div class="flex flex-col grid-cols-12 gap-2">
                            <Label for="title">
                                Tag Title.
                            </Label>
                            <div class="flex items-center gap-1 w-full">
                                <Input v-model="tagData.name" id="title" placeholder="Marketing" class="text-xs" />
                                <Input type="color" v-model="tagData.color"
                                    class="p-0 w-10 h-10 border-none cursor-pointer" />
                            </div>
                            <div>
                                <span v-if="$page.props.errors['name']" class='text-xs text-red-500'>
                                    {{ $page.props.errors['name'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <DialogFooter>
                        <Button variant="secondary" @click="isDialogOpen = false">
                            Close
                        </Button>
                        <LoadedButton title="Create" :isLoading="isLoading" @click="createTag">
                        </LoadedButton>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </div>
        <p class="text-xs text-gray-500">Create or Use existing tags to categorize this task.</p>
    </div>
</template>