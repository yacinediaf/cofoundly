<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import StartupCard from '@/Pages/Startups/Partials/StartupCard.vue';
import { Motion } from "motion-v"


defineProps({
    startups: Array
})
</script>

<template>

    <GuestLayout>

        <Head title="Startups" />

        <div class="bg-gray-100">
            <header class="py-6 md:py-20 px-4 md:w-[600px] mx-auto">
                <div class="text-3xl/relaxed md:text-4xl/relaxed text-black text-center font-bold">
                    Explore
                    <br>
                    <div
                        class="bg-orange-500 text-white rounded flex items-center justify-center text-2xl/relaxed md:text-3xl/relaxed">
                        <h1>Innovative Startup Ideas</h1>
                        <Motion as="span" :initial="{ x: -100, y: 100, opacity: 0 }"
                            :animate="{ x: 0, y: 0, opacity: 1, transition: { duration: 0.5 } }">
                            🚀
                        </Motion>
                    </div>
                    and Join the Revolution.
                </div>
                <p class="font-semibold text-center mt-4">
                    Here you find startup in starter phase and ideas where you can join and co-found, teams, investors
                    and mentors, from Algeria.
                </p>
            </Header>

            <section class="w-full h-full lg:w-[900px] mx-auto py-10 md:py-20 px-2">
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
        </div>

    </GuestLayout>
</template>
