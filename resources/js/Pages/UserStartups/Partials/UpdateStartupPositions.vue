<script setup>
import { ref } from 'vue';
import { Link, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';

const props = defineProps({
    startup: Object,
});

const form = useForm({
    _method: 'PUT',
    looking_for: props.startup.looking_for,
});

const verificationLinkSent = ref(null);

const updateStartupPositions = () => {

    form.post(route('user-startups.update', props.startup), {
        preserveScroll: true,
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};
</script>

<template>
    <FormSection @submitted="updateStartupPositions">
        <template #title>
            Startup Positions
        </template>

        <template #description>
            Are you looking for new positions to help your startup grow?
        </template>

        <template #form>
            <!-- looking_for -->
            <div class="col-span-6">
                <InputLabel for="looking_for" value="Looking For" class="mb-2" />
                <div class="text-xs text-blue-500 bg-gray-100 p-2 rounded font-semibold py-1">
                    You can mention the roles with skills that you are looking for in order to grow and fulfill your
                    startup.
                    <br>
                    Example:
                    <br>
                    - Co-founder with marketing skills,
                    <br>
                    - Developer with Laravel and Vue.js skills
                </div>
                <MarkdownEditor v-model="form.looking_for" class="mt-1" />
                <InputError :message="form.errors.looking_for" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <ActionMessage :on="form.recentlySuccessful" class="me-3">
                Saved.
            </ActionMessage>

            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </PrimaryButton>
        </template>
    </FormSection>
</template>
