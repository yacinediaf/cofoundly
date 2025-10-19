<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import UpdateStartupInformationForm from '@/Pages/UserStartups/Partials/UpdateStartupInformationForm.vue';
import UpdateStartupDetailsForm from '@/Pages/UserStartups/Partials/UpdateStartupDetailsForm.vue';
import UpdateStartupPositions from '@/Pages/UserStartups/Partials/UpdateStartupPositions.vue';

defineProps({
    startup: Object,
});
</script>

<template>
    <AppLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Startup
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <UpdateStartupInformationForm :startup="$page.props.startup" />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <UpdateStartupDetailsForm :startup="$page.props.startup" class="mt-10 sm:mt-0" />

                    <SectionBorder />
                </div>

                <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                    <UpdateStartupPositions :startup="$page.props.startup" class="mt-10 sm:mt-0" />

                    <SectionBorder />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
