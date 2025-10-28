<script setup>
import { Button } from "@/Components/ui/button"
import { Motion } from "motion-v"
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import StartupCard from '@/Pages/Startups/Partials/StartupCard.vue';

defineProps({
    startups: Array
})
</script>

<template>

    <GuestLayout>

        <Head title="Startups" />

        <header class="px-4 md:w-[600px] h-screen mx-auto flex flex-col items-center justify-center gap-4">
            <div class="text-3xl/relaxed text-black text-center">
                <div class="rounded flex flex-col gap-6 items-center italic justify-center text-2xl/relaxed">
                    <div>
                        <svg class="w-8 h-8 text-orange-500 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 18 14">
                            <path
                                d="M6 0H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3H2a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Zm10 0h-4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h4v1a3 3 0 0 1-3 3h-1a1 1 0 0 0 0 2h1a5.006 5.006 0 0 0 5-5V2a2 2 0 0 0-2-2Z" />
                        </svg>
                        <div class="text-gray-700">
                            <h1>You Really don't have to worry about your idea.</h1>
                            <h1>
                                Ideas are cheap what counts is the ability
                                to
                                translate an idea into a reality.
                            </h1>
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center gap-3">
                        <div class="w-16 h-16">
                            <img class="w-full h-full rounded-full opacity-80"
                                src="https://files.joshkaufman.net/joshkaufman-square.jpg" alt="Josh kaufman">
                        </div>
                        <span class="text-sm">Josh Kaufman.</span>
                    </div>
                </div>
            </div>
        </Header>

        <section id="startups_section" class="w-full h-full lg:w-[900px] mx-auto py-10 md:py-20 px-2">
            <h1 v-if="startups.length > 0" class="font-semibold text-2xl">Startups</h1>

            <div>
                <div>
                    <div v-if="startups.length > 0" class="grid grid-cols-6 gap-4 mt-4">
                        <StartupCard :startup="startup" v-for="startup in startups" :key="startup.id" />
                    </div>
                    <div v-else class="flex flex-col items-center mt-4">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                                fill="none" stroke="#424242" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="lucide lucide-tree-palm-icon lucide-tree-palm">
                                <path d="M13 8c0-2.76-2.46-5-5.5-5S2 5.24 2 8h2l1-1 1 1h4" />
                                <path d="M13 7.14A5.82 5.82 0 0 1 16.5 6c3.04 0 5.5 2.24 5.5 5h-3l-1-1-1 1h-3" />
                                <path
                                    d="M5.89 9.71c-2.15 2.15-2.3 5.47-.35 7.43l4.24-4.25.7-.7.71-.71 2.12-2.12c-1.95-1.96-5.27-1.8-7.42.35" />
                                <path d="M11 15.5c.5 2.5-.17 4.5-1 6.5h4c2-5.5-.5-12-1-14" />
                            </svg>
                        </div>
                        <p class="w-full flex items-center justify-center text-gray-500 text-center mt-4">
                            No startups found yet be the first.
                            <Link class="mx-2 text-orange-500 font-semibold" :href="route('user-startups.create')">
                            Create
                            one </Link>
                            or
                            <Link class="mx-2 text-orange-500 font-semibold" :href="route('login')">Join one
                            </Link>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
