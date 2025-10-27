<script setup>
import { Button } from "@/Components/ui/button"
import { Link } from "@inertiajs/vue3";
import { Motion } from "motion-v"
</script>
<template>
    <div class="bg-gray-100 min-h-screen">
        <header class="px-4 md:w-[600px] h-screen mx-auto flex flex-col items-center justify-center gap-4">
            <div class="text-3xl/relaxed md:text-5xl/relaxed text-black text-center font-bold">
                Explore
                <br>
                <div
                    class="bg-orange-500 text-white rounded flex items-center justify-center text-2xl/relaxed md:text-4xl/relaxed">
                    <h1>Innovative Startup Ideas</h1>
                    <Motion as="span" :initial="{ x: -100, y: 100, opacity: 0 }"
                        :animate="{ x: 0, y: 0, opacity: 1, transition: { duration: 0.5 } }">
                        🚀
                    </Motion>
                </div>
                and Join the Revolution.
            </div>
            <p class="font-semibold text-center mt-4">
                Here you find startup in starter phase and ideas where you can join and co-found, teams,
                investors
                and mentors, from Algeria.
            </p>

            <div class="flex items-center gap-3 w-full justify-center mt-10">
                <Button class="py-5 px-6">
                    <Link :href="route('dashboard')" class="text-white">
                    Create Startup
                    </Link>
                </Button>
                <Button class="py-5 px-6 bg-orange-500 hover:bg-orange-400">
                    <Link href="/startups#startups_section" class="text-white">
                    Join Startup
                    </Link>
                </Button>
            </div>
        </Header>
    </div>
</template>