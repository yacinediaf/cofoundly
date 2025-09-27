<script setup>
import { useForm } from '@inertiajs/vue3';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    description: '',
    website: '',
    location: '',
});

const createStartup = () => {
    form.post(route('user-startups.store'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <FormSection @submitted="createStartup">
        <template #title>
            Startup Details
        </template>

        <template #description>
            Create a new startup to lunch new idea.
        </template>

        <template #form>
            <div class="col-span-6">
                <InputLabel value="Startup Owner" />

                <div class="flex items-center mt-2">
                    <img class="object-cover w-12 h-12 rounded-full" :src="$page.props.auth.user.profile_photo_url"
                        :alt="$page.props.auth.user.name">

                    <div class="ms-4 leading-tight">
                        <div class="text-gray-900">{{ $page.props.auth.user.name }}</div>
                        <div class="text-sm text-gray-700">
                            {{ $page.props.auth.user.email }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="name" value="Startup Name" />
                <TextInput id="name" v-model="form.name" type="text" class="block w-full mt-1" autofocus />
                <InputError :message="form.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="description" value="Description" />
                <TextInput id="description" v-model="form.description" type="text" class="block w-full mt-1"
                    autofocus />
                <InputError :message="form.errors.description" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="website" value="Website (optional)" />
                <TextInput id="website" v-model="form.website" type="text" class="block w-full mt-1"
                    placeholder="https://" autofocus />
                <InputError :message="form.errors.website" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <InputLabel for="location" value="Location" />
                <select id="location" v-model="form.location"
                    class="block mt-1 py-2 border border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm px-2 w-full font-medium text-sm text-gray-700">
                    <option selected disabled value="">Select Wilaya</option>
                    <option class="text-gray-900" v-for="wilaya in $page.props.wilayas" :value="wilaya.id">
                        {{ wilaya.name }}
                    </option>
                </select>
                <InputError :message="form.errors.location" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Create
            </PrimaryButton>
        </template>
    </FormSection>
</template>
