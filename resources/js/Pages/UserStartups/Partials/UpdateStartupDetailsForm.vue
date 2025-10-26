<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    startup: Object,
});

const form = useForm({
    _method: 'PUT',
    stage: props.startup.stage,
    website: props.startup.website,
});

const verificationLinkSent = ref(null);

const updateStartupDetails = () => {

    form.post(route('user-startups.update', props.startup), {
        preserveScroll: true,
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};
</script>

<template>
    <FormSection @submitted="updateStartupDetails">
        <template #title>
            Startup Details
        </template>

        <template #description>
            Update your startup's details.
        </template>

        <template #form>
            <!-- stage -->
            <div class="col-span-6">
                <InputLabel for="stage" value="Stage (Current Stage of your startup)" />
                <span class="bg-red-500 text-white py-1 px-2 rounded-lg text-xs mt-2">
                    You have to select one of these stages in order
                    to be visible to others
                </span>
                <div class="space-y-2 space-x-2 mt-1">
                    <label v-for="option in $page.props.startupStages" :key="option"
                        class="inline-flex items-center border py-1 px-2 rounded-md cursor-pointer">
                        <input type="radio" class="form-radio" :value="option" v-model="form.stage" />
                        <span class="ml-2 text-gray-700">{{ option }}</span>
                    </label>
                </div>
                <InputError :message="form.errors.stage" class="mt-2" />
            </div>

            <!-- website -->
            <div class="col-span-6">
                <InputLabel for="website" value="Website" />
                <TextInput id="website" v-model="form.website" type="text" placeholder="https://"
                    class="mt-1 block w-full" required autocomplete="website" />
                <InputError :message="form.errors.website" class="mt-2" />

                <div v-if="$page.props.jetstream.hasEmailVerification && user.email_verified_at === null">
                    <p class="text-sm mt-2">
                        Your email address is unverified.

                        <Link :href="route('verification.send')" method="post" as="button"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click.prevent="sendEmailVerification">
                        Click here to re-send the verification email.
                        </Link>
                    </p>

                    <div v-show="verificationLinkSent" class="mt-2 font-medium text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </div>
                </div>
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
