<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';

let props = defineProps({
    requests: Array,
    availableRoles: Object,
});

let currentRequest = ref(props.requests.length > 0 ? props.requests[0] : null);
let accepted = ref(false);
let form = useForm({
    email: currentRequest.value ? currentRequest.value.user.email : '',
    role: null,
});

const addTeamMember = () => {
    form.post(route('startup.members.store', usePage().props.auth.user.current_startup.id), {
        preserveScroll: true,

        onSuccess: () => {
            accepted.value = false;
            form.reset()
            currentRequest.value = null;
        },
    });
};

const rejectRequest = () => {
    form.delete(route('startup.requests.delete', currentRequest.value.code), {
        preserveScroll: true,

        onSuccess: () => {
            accepted.value = false;
            form.reset()
        },
    });
};
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Startup Requests
            </h2>
        </template>

        <div class="h-screen">
            <div class="h-[512px] grid grid-cols-12 py-2 border bg-white w-full mt-2">
                <div class="col-span-4 border-r overflow-y-scroll h-full">
                    <h1 class="py-2 font-bold text-center text-xl border-b sticky top-0 bg-white">Inbox</h1>
                    <ul class="p-4 h-full">
                        <li v-for="request in requests" :key="request.id" @click="currentRequest = request"
                            :class="currentRequest && currentRequest.id === request.id ? 'bg-gray-50' : ''"
                            class="border rounded-lg mb-2 hover:bg-gray-50 cursor-pointer">
                            <div href="#" class="block px-4 py-2 hover:bg-gray-50">
                                <div class="flex-1 flex items-center gap-4">
                                    <img class="h-8 w-8 rounded-full object-cover" :src="request.user.profile_photo_url"
                                        :alt="request.user.name">
                                    <div class="">
                                        <p class="font-semibold">{{ request.user.name }}</p>
                                        <p class="text-gray-600 w-64 truncate text-xs">
                                            {{ request.message }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-span-6 w-full relative">
                    <div v-if="currentRequest" class="w-full px-4">
                        <div class="text-lg font-semibold mb-4 border-b py-2">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        :src="currentRequest.user.profile_photo_url" :alt="currentRequest.user.name">
                                    <span class="mx-2">{{ currentRequest.user.name }}</span>
                                    <span class="text-sm text-gray-600 bg-gray-100 py-1 px-2">
                                        {{ currentRequest.status }}
                                    </span>
                                </div>
                                <div class="flex gap-2">
                                    <div>
                                        <button @click="rejectRequest" class="text-red-500 text-sm">Decline</button>
                                    </div>
                                    <div v-if="!accepted">
                                        <button class="text-green-500 text-sm" @click="accepted = true">Accept</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p>
                            {{ currentRequest ? currentRequest.message : '' }}
                        </p>
                    </div>
                    <div v-else class="w-full h-full flex flex-col gap-3 items-center justify-center">
                        <span class="text-gray-500">No requests Found</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none"
                            stroke="#545454" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-package-open-icon lucide-package-open">
                            <path d="M12 22v-9" />
                            <path
                                d="M15.17 2.21a1.67 1.67 0 0 1 1.63 0L21 4.57a1.93 1.93 0 0 1 0 3.36L8.82 14.79a1.655 1.655 0 0 1-1.64 0L3 12.43a1.93 1.93 0 0 1 0-3.36z" />
                            <path
                                d="M20 13v3.87a2.06 2.06 0 0 1-1.11 1.83l-6 3.08a1.93 1.93 0 0 1-1.78 0l-6-3.08A2.06 2.06 0 0 1 4 16.87V13" />
                            <path
                                d="M21 12.43a1.93 1.93 0 0 0 0-3.36L8.83 2.2a1.64 1.64 0 0 0-1.63 0L3 4.57a1.93 1.93 0 0 0 0 3.36l12.18 6.86a1.636 1.636 0 0 0 1.63 0z" />
                        </svg>
                    </div>
                    <!-- Role Management Modal -->
                    <DialogModal :show="accepted" @close="accepted = false">
                        <template #title>
                            Assign Role
                        </template>

                        <template #content>
                            <div>
                                <div class="relative z-0 mt-1 border border-gray-200 rounded-lg cursor-pointer">
                                    <button v-for="(role, i) in availableRoles" :key="role.key" type="button"
                                        class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                                        :class="{ 'border-t border-gray-200 focus:border-none rounded-t-none': i > 0, 'rounded-b-none': i !== Object.keys(availableRoles).length - 1 }"
                                        @click="form.role = role.key">
                                        <div>
                                            <!-- Role Name -->
                                            <div class="flex items-center">
                                                <div class="text-sm text-gray-600">
                                                    {{ role.name }}
                                                </div>
                                            </div>

                                            <!-- Role Description -->
                                            <div class="mt-2 text-xs text-gray-600">
                                                {{ role.description }}
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <template #footer>
                            <SecondaryButton @click="accepted = false">
                                Cancel
                            </SecondaryButton>

                            <PrimaryButton class="ms-3" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing" @click="addTeamMember">
                                Save
                            </PrimaryButton>
                        </template>
                    </DialogModal>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
