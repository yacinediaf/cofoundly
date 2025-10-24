<script setup>
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog"
import { Label } from "@/Components/ui/label"
import IndustryTag from '@/Components/IndustryTag.vue';
import LocationTag from '@/Components/LocationTag.vue';
import Startuplogo from '@/Components/Startuplogo.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { Motion } from "motion-v"
import TrendyStartups from './Partials/TrendyStartups.vue';
import StartupStage from '@/Components/StartupStage.vue';
import Button from "@/Components/ui/button/Button.vue";
import Textarea from "@/Components/ui/textarea/Textarea.vue";
import { ref } from "vue";

let props = defineProps({
    startup: Object,
    members: Object,
    canRequest: Boolean,
    alreadyRequested: Boolean,
    isGuest: Boolean,
})

let form = useForm({
    message: '',
})

let dialogIsOpen = ref(false)

function openDialog() {

    if (props.isGuest) {
        router.visit(route('login'))
        return
    }
    dialogIsOpen.value = true
}

function requestToJoin() {
    form.post(route('startup.requests', props.startup), {
        onSuccess: () => {
            form.reset('message')
            dialogIsOpen.value = false
        },
    })
}
</script>

<template>

    <GuestLayout>

        <Head :title="startup.name" />

        <div class="bg-gray-100 h-auto">
            <div class="lg:w-[1024px] grid grid-cols-12 gap-4 mx-auto py-4 md:py-10 px-2 relative h-full">
                <Motion :initial="{ opacity: 0, y: 100 }" :whileInView="{ opacity: 1, y: 0 }"
                    class="col-span-12 md:col-span-8 rounded-b-lg">
                    <div class="relative border">
                        <!-- Startup Banner -->
                        <div v-if="!startup.banner_url" class="w-full bg-gray-300 h-48 rounded-t-lg"></div>
                        <div v-else class="w-full h-48 bg-cover bg-no-repeat bg-center rounded-t-lg cursor-pointer"
                            :style="'background-image: url(\'' + startup.banner_url + '\');'">
                        </div>
                        <div class="absolute -bottom-10 left-0 mx-3 my-6">
                            <Startuplogo :logoPath="startup.logo_url" />
                        </div>
                    </div>
                    <div>
                        <div class="bg-white pt-6 px-4 pb-4 rounded-b-lg flex gap-2 items-center justify-between">
                            <div class="flex flex-col gap-2 flex-wrap">
                                <h1 class="text-2xl font-semibold flex items-center gap-2">
                                    {{ startup.name }}
                                </h1>
                                <div class="flex flex-col md:flex-row items-start gap-2">
                                    <LocationTag :location="startup.location" />
                                    <IndustryTag :industry="startup.industry" />
                                </div>
                                <div>
                                    <StartupStage :startup="startup" />
                                </div>
                            </div>
                            <Button v-if="canRequest && !alreadyRequested || isGuest" class="flex gap-2"
                                @click="openDialog">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="#8f8f8f" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-circle-plus-icon lucide-circle-plus">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M8 12h8" />
                                    <path d="M12 8v8" />
                                </svg>
                                Join
                            </Button>
                            <Dialog v-model:open="dialogIsOpen">
                                <DialogContent class="sm:max-w-[600px]">
                                    <DialogHeader>
                                        <DialogTitle>Ask To join Startup</DialogTitle>
                                        <DialogDescription class="text-xs bg-blue-300 p-2 rounded-md text-black">
                                            Nice Step 🎉!
                                            <br>
                                            What <b>motivates</b> you to join this startup?
                                            <br>
                                            and How can you <b>contribute</b>?

                                        </DialogDescription>
                                    </DialogHeader>
                                    <div class="gap-4 py-4 h-full">
                                        <div class="flex flex-col gap-2">
                                            <Label for="message">
                                                Motivation Message
                                            </Label>
                                            <Textarea id="message" v-model="form.message" class="h-full" autofocus />
                                        </div>
                                    </div>
                                    <DialogFooter>
                                        <Button @click="requestToJoin" class="text-xs" :disabled="form.processing"
                                            :loading="form.processing">
                                            Send Request
                                        </Button>
                                    </DialogFooter>
                                </DialogContent>
                            </Dialog>
                            <Button variant="outline" class="flex gap-2 text-xs" disabled v-if="alreadyRequested">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="#8f8f8f" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-send-icon lucide-send">
                                    <path
                                        d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z" />
                                    <path d="m21.854 2.147-10.94 10.939" />
                                </svg>
                                Request Sent
                            </Button>
                        </div>
                        <!-- ABOUT  -->
                        <div class="bg-white mt-4 p-4 rounded-lg">
                            <h1 class="font-semibold text-lg mb-2">About</h1>
                            <p class="text-xs text-gray-500 mt-1 " v-html="startup.description"></p>
                        </div>

                        <div>
                            <!-- Open Positions -->
                            <div class="bg-white mt-4 p-4 rounded-lg">
                                <h1 class="font-semibold text-lg mb-2">Open Positions</h1>
                                <p v-if="startup.looking_for"
                                    class="text-xs text-gray-500 mt-1 code prose prose-sm min-w-full"
                                    v-html="startup.looking_for">
                                </p>
                                <p v-else class="text-xs text-gray-500 mt-1">
                                    Currently, there are no
                                    open positions.
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Team -->
                    <div class="bg-white mt-4 p-4 rounded-lg">
                        <h1 class="font-semibold text-lg mb-2">Team</h1>
                        <!-- Founder -->
                        <div class="flex items-center gap-1">
                            <div
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" :src="startup.owner.profile_photo_url"
                                    :alt="startup.owner.name">
                            </div>
                            <p class="text-sm text-gray-500">{{ startup.owner.name }} <span
                                    class="text-xs text-gray-400 font-semibold">(founder)</span></p>
                        </div>
                        <!-- Members -->
                        <div v-for="member in members.data" :key="member.id" class="flex items-center gap-1">
                            <div
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" :src="member.profile_photo_url"
                                    :alt="member.name">
                            </div>
                            <p class="text-sm text-gray-500">{{ member.name }} <span
                                    class="text-xs text-gray-400 font-semibold">({{ member.role }})</span></p>
                        </div>
                    </div>

                </Motion>

                <TrendyStartups :startup="startup" />
            </div>
        </div>

    </GuestLayout>
</template>
