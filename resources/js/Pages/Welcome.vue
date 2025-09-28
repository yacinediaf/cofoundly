<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import StartupCard from '@/Pages/Startups/Partials/StartupCard.vue';

defineProps({
    startups: Array
})
</script>

<template>

    <GuestLayout>

        <Head title="Welcome" />

        <div class="bg-gray-100 container mx-auto">
            <header class="py-6 md:py-20 px-4 md:w-[600px] mx-auto">
                <h2 class="text-4xl/relaxed text-black text-center font-bold">
                    Explore <br>
                    <span class="bg-orange-500 text-white py-1 px-3 rounded">Innovative Startup Ideas 🚀</span><br>
                    and Join the Revolution.
                </h2>
                <p class="font-semibold text-center mt-4">
                    Here you find startup in starter phase and ideas where you can join and co-found, teams, investors
                    and mentors, from Algeria.
                </p>
            </header>

            <section class="w-full lg:w-[900px] mx-auto py-10 md:py-20">
                <h1 class="font-semibold text-2xl">Startups</h1>

                <div>
                    <div>
                        <div class="grid grid-cols-6 gap-4 mt-4">
                            <StartupCard :startup="startup" v-for="startup in startups" :key="startup.id" />
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </GuestLayout>
</template>
