<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="grid min-h-svh lg:grid-cols-2">
        <div class="flex flex-col gap-4 p-6 md:p-10">
            <div class="flex justify-center gap-2 md:justify-start">
                <Link href="/" class="flex items-center gap-2 font-medium">
                <div class="flex h-6 w-6 items-center justify-center rounded-md bg-primary text-primary-foreground">
                    <img src="/images/cofoundly.png" class="w-full h-full rounded-lg" />
                </div>
                Cofoundly.
                </Link>
            </div>
            <div class="flex flex-1 items-center justify-center">
                <div class="w-full max-w-xs">
                    <slot></slot>
                </div>
            </div>
        </div>
        <div class="relative hidden bg-muted lg:block">
            <img src="/images/aside_image.jpg" alt="Image" loading="lazy"
                class="absolute inset-0 h-full w-full object-cover dark:brightness-[0.2] dark:grayscale">
        </div>
    </div>
</template>
