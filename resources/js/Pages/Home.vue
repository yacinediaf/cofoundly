<script setup>
import PageHeader from '@/Components/PageHeader.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Motion } from "motion-v"

defineProps({
    startups: Array
})
</script>

<template>

    <GuestLayout>

        <Head title="Startups" />
        <PageHeader></PageHeader>

        <!-- Features Section -->
        <section id="features" class="py-20 md:py-40 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="flex flex-col gap-2 text-center md:text-start mb-20 md-40 w-full md:w-1/2">
                    <h2 class="text-3xl font-bold">Simple, Useful, and Powerful Features
                    </h2>
                    <p class="text-sm text-gray-600">We have a range of features that make you familiar with
                        startup management experience easy
                        and efficient.
                    </p>
                </div>
                <div class="md:flex gap-4 flex-col space-y-15">
                    <div
                        class="w-full h-[400px] mt-10 bg-white rounded-2xl shadow-smborder text-center flex flex-col gap-6 md:flex-row items-start relative">
                        <Motion as="div" :initial="{ x: -100, opacity: 0 }"
                            :whileInView="{ x: 0, opacity: 1, transition: { duration: 0.5 } }"
                            class="flex flex-col gap-2 md:w-1/3 text-start">
                            <h3 class="text-xl font-semibold">Team Management</h3>
                            <p class="text-gray-600 text-sm">
                                Invite Co-founders and Members to your startup and give them access to your startup
                                projects.
                            </p>
                        </Motion>
                        <Motion as="div" :initial="{ opacity: 0 }" :inViewOptions="{ once: true }"
                            :whileInView="{ opacity: 1, transition: { duration: 0.5 } }"
                            class="w-full h-[250px] md:h-full">
                            <img src="/images/team_management_capture.png" alt="Collaboration"
                                class="mx-auto w-full md:w-2/3 h-full mb-4 md:-skew-x-[10deg] border-2 rounded-lg shadow-md block md:absolute top-0 right-0"
                                style="--mask-bottom: linear-gradient(to bottom, #000 50%, transparent 100%);
                                    --mask-right: linear-gradient(to right, #000 80%, transparent 100%);
                                    mask-image: var(--mask-bottom), var(--mask-right);
                                    mask-composite: intersect;">
                        </Motion>
                    </div>

                    <div
                        class="w-full h-[400px] mt-10 bg-white rounded-2xl shadow-smborder text-center flex flex-col gap-6 md:flex-row items-start relative">
                        <Motion as="div" :initial="{ x: -100, opacity: 0 }"
                            :whileInView="{ x: 0, opacity: 1, transition: { duration: 0.5 } }"
                            class="flex flex-col gap-2 md:w-1/3 text-start">
                            <h3 class="text-xl font-semibold">Task Handling</h3>
                            <p class="text-gray-600 text-sm">
                                Simple, easy interactive task management system to manage your startup projects in
                                <b>realtime</b>.
                            </p>
                        </Motion>
                        <Motion as="div" :initial="{ opacity: 0 }" :inViewOptions="{ once: true }"
                            :whileInView="{ opacity: 1, transition: { duration: 0.5 } }" class="w-full h-1/2 md:h-full">
                            <img src="/images/task_management.png" alt="task_management"
                                class="mx-auto md:w-2/3 h-full mb-4 md:-skew-x-[10deg] border-2 rounded-lg shadow-md block md:absolute top-0 right-0"
                                style="--mask-bottom: linear-gradient(to bottom, #000 50%, transparent 100%);
                                    --mask-right: linear-gradient(to right, #000 80%, transparent 100%);
                                    mask-image: var(--mask-bottom), var(--mask-right);
                                    mask-composite: intersect;">
                        </Motion>
                    </div>

                    <div
                        class="w-full h-[400px] mt-10 bg-white rounded-2xl shadow-smborder text-center flex flex-col gap-6 md:flex-row items-start relative">
                        <Motion as="div" :initial="{ x: -100, opacity: 0 }"
                            :whileInView="{ x: 0, opacity: 1, transition: { duration: 0.5 } }"
                            class="flex flex-col gap-2 md:w-1/3 text-start">
                            <h3 class="text-xl font-semibold">Request Management</h3>
                            <p class="text-gray-600 text-sm">
                                Manage and choose your startup requests and give them access to your startup
                                environment.
                            </p>
                        </Motion>
                        <Motion as="div" :initial="{ opacity: 0 }" :inViewOptions="{ once: true }"
                            :whileInView="{ opacity: 1, transition: { duration: 0.5 } }" class="w-full h-1/2 md:h-full">
                            <img src="/images/notification_management.png" alt="notification_management"
                                class="mx-auto md:w-2/3 h-full mb-4 md:-skew-x-[10deg] border-2 rounded-lg shadow-md block md:absolute top-0 right-0"
                                style="--mask-bottom: linear-gradient(to bottom, #000 50%, transparent 100%);
                                    --mask-right: linear-gradient(to right, #000 80%, transparent 100%);
                                    mask-image: var(--mask-bottom), var(--mask-right);
                                    mask-composite: intersect;">
                        </Motion>
                    </div>

                    <Motion as="div" :initial="{ y: 100, opacity: 0 }"
                        :whileInView="{ y: 0, opacity: 1, transition: { duration: 0.5 } }"
                        class="w-full flex items-center justify-center mt-10">
                        <h1 class="text-3xl font-semibold">And much more... </h1>
                    </Motion>
                </div>
            </div>
        </section>
    </GuestLayout>
</template>
