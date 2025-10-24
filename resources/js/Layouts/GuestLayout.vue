<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<template>
    <div class="bg-gray-50 h-full">
        <div class="relative">
            <div class="w-full relative">
                <header class="py-4 lg:grid-cols-3 bg-white/70 sticky top-0 z-50 shadow-lg text-black">
                    <nav class="px-2 text-sm md:container mx-auto flex items-center justify-between font-semibold">
                        <div>
                            <Link :href="'/'">Home</Link>
                        </div>
                        <div>
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Dashboard
                            </Link>
                            <template v-else>
                                <Link :href="route('login')"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                Log in
                                </Link>
                                <Link :href="route('register')"
                                    class="bg-orange-500 text-white hover:bg-orange-400 rounded-md px-3 py-2 ring-1 ring-transparent transition focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                Register
                                </Link>
                            </template>
                        </div>
                    </nav>
                </header>

                <main class="h-screen">
                    <slot></slot>
                </main>
            </div>
        </div>
    </div>
</template>
