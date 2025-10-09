<script setup>
import { ref } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Pencil1Icon, RocketIcon, TrashIcon } from '@radix-icons/vue';

const props = defineProps({
    startup: Object,
});

const form = useForm({
    _method: 'PUT',
    name: props.startup.name,
    description: props.startup.description,
    location: props.startup.location.id,
    logo: props.startup.logo_path ?? null,
    banner: props.startup.banner_path ?? null,
    industry: props.startup.industry_id ?? null,
});

const verificationLinkSent = ref(null);
const logoPreview = ref(form.logo);
const bannerPreview = ref(form.banner);
const logoInput = ref(null);
const bannerInput = ref(null);

const updateStartupInformation = () => {
    if (logoInput.value) {
        form.logo = logoInput.value.files[0];
    }

    if (bannerInput.value) {
        form.banner = bannerInput.value.files[0];
    }

    form.post(route('user-startups.update', props.startup), {
        preserveScroll: true,
        onSuccess: () => {
            clearlogoFileInput()
            clearbannerFileInput()
        },
    });
};

const sendEmailVerification = () => {
    verificationLinkSent.value = true;
};

const selectNewlogo = () => {
    logoInput.value.click();
};

const selectNewBanner = () => {
    bannerInput.value.click();
};

const updateLogoPreview = () => {
    const logo = logoInput.value.files[0];

    if (!logo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        logoPreview.value = e.target.result;
    };

    reader.readAsDataURL(logo);
};

const updateBannerPreview = () => {
    const banner = bannerInput.value.files[0];

    if (!banner) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        bannerPreview.value = e.target.result;
    };

    reader.readAsDataURL(banner);
};

const deletelogo = () => {
    router.delete(route('current-startup-logo.destroy', props.startup), {
        preserveScroll: true,
        onSuccess: () => {
            logoPreview.value = null;
            clearlogoFileInput();
        },
    });
};

const deleteBanner = () => {
    router.delete(route('current-startup-banner.destroy', props.startup), {
        preserveScroll: true,
        onSuccess: () => {
            bannerPreview.value = null;
            clearbannerFileInput();
        },
    });
};

const clearlogoFileInput = () => {
    if (logoInput.value?.value) {
        logoInput.value.value = null;
    }
};

const clearbannerFileInput = () => {
    if (bannerInput.value?.value) {
        bannerInput.value.value = null;
    }
};
</script>

<template>
    <FormSection @submitted="updateStartupInformation">
        <template #title>
            Startup Information
        </template>

        <template #description>
            Update your startup's information and media.
        </template>

        <template #form>

            <!-- Startup Banner -->
            <div class="col-span-6 block w-full relative">
                <div class="w-full bg-gray-300 h-48 rounded-lg relative" v-show="!bannerPreview">
                    <!-- Startup Banner File Input -->
                    <input id="banner" ref="bannerInput" type="file" class="hidden" @change="updateBannerPreview">
                    <Pencil1Icon @click.prevent="selectNewBanner"
                        class="absolute top-1 right-1 h-6 w-6 p-0.5 rounded-full text-white bg-gray-500 cursor-pointer" />
                </div>
                <!-- New Banner Preview -->
                <div v-show="bannerPreview" class="mt-2 relative">
                    <div @click.prevent="selectNewBanner"
                        class="w-full h-48 bg-cover bg-no-repeat bg-center rounded-lg relative cursor-pointer"
                        :style="'background-image: url(\'' + bannerPreview + '\');'">
                    </div>
                    <TrashIcon v-if="startup.banner_path" @click.prevent="deleteBanner"
                        class="absolute -top-2 -right-1 h-6 w-6 p-0.5 rounded-full text-white bg-red-500 cursor-pointer">
                    </TrashIcon>
                </div>
                <!-- Startup Logo -->
                <div class="absolute bottom-0 left-0 mx-3 my-3">
                    <!-- Startup Logo File Input -->
                    <input id="logo" ref="logoInput" type="file" class="hidden" @change="updateLogoPreview">

                    <!-- Current Logo -->
                    <div v-show="!logoPreview" class="mt-2 relative">
                        <RocketIcon @click.prevent="selectNewlogo"
                            class="h-16 w-16 text-gray-500 text-sm bg-white border border-gray-100 rounded-lg p-4 mr-2 cursor-pointer" />
                    </div>

                    <!-- New Profile logo Preview -->
                    <div v-show="logoPreview" class="mt-2 relative">
                        <span @click.prevent="selectNewlogo"
                            class="h-16 w-16 block shadow-xl border-2 bg-white border-gray-500 rounded-lg bg-cover bg-no-repeat bg-center cursor-pointer"
                            :style="'background-image: url(\'' + logoPreview + '\');'" />
                        <TrashIcon v-if="startup.logo_path" @click.prevent="deletelogo"
                            class="absolute -top-2 -right-1 h-6 w-6 p-0.5 rounded-full text-white bg-red-500 cursor-pointer">
                        </TrashIcon>
                    </div>

                    <InputError :message="form.errors.logo" class="mt-2" />
                </div>
            </div>

            <!-- Name -->
            <div class="col-span-6">
                <InputLabel for="name" value="Name" />
                <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required
                    autocomplete="name" />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <!-- description -->
            <div class="col-span-6">
                <InputLabel for="description" value="Description" />
                <TextInput id="description" v-model="form.description" type="text" class="mt-1 block w-full" required
                    autocomplete="username" />
                <InputError :message="form.errors.description" class="mt-2" />

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
            <!-- Location -->
            <div class="col-span-6">
                <InputLabel for="location" value="Location" />
                <select id="location" v-model="form.location"
                    class="block mt-1 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-2 w-full font-medium text-sm text-gray-700">
                    <option :selected="form.location == null" value="" class="text-gray-900">Select a location</option>
                    <option :selected="wilaya.id == form.location" class="text-gray-900"
                        v-for="wilaya in $page.props.wilayas" :value="wilaya.id">
                        {{ wilaya.name }}
                    </option>
                </select>
                <InputError :message="form.errors.location" class="mt-2" />
            </div>

            <!-- Industry -->
            <div class="col-span-6">
                <InputLabel for="industry" value="Industry" />
                <select id="industry" v-model="form.industry"
                    class="block mt-1 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-2 w-full font-medium text-sm text-gray-700">
                    <option value="" class="text-gray-900">Select an industry</option>
                    <option :selected="industry.id == form.industry_id" class="text-gray-900"
                        v-for="industry in $page.props.industries" :value="industry.id">
                        {{ industry.name }}
                    </option>
                </select>
                <InputError :message="form.errors.industry" class="mt-2" />
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
