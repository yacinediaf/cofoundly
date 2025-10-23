<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import Label from '@/Components/ui/label/Label.vue';
import Input from '@/Components/ui/input/Input.vue';
import { Button } from '@/Components/ui/button';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>

    <Head title="Register" />

    <AuthenticationCard>
        <form @submit.prevent="submit">
            <div>
                <Label for="email">Name</Label>
                <Input v-model="form.name" id="name" type="text" required />
                <InputError :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <Label for="email">Email</Label>
                <Input v-model="form.email" id="email" type="email" placeholder="m@example.com" required />
                <InputError :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <Label for="password" value="Password">Password</Label>
                <Input id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
                    autocomplete="new-password" />
                <InputError :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <Label for="password_confirmation" value="Confirm Password">Confirm Password</Label>
                <Input id="password_confirmation" v-model="form.password_confirmation" type="password"
                    class="mt-1 block w-full" required autocomplete="new-password" />
                <InputError :message="form.errors.password_confirmation" />
            </div>

            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                <Label for="terms">
                    <div class="flex items-center">
                        <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                        <div class="ms-2">
                            I agree to the <a target="_blank" :href="route('terms.show')"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terms
                                of Service</a> and <a target="_blank" :href="route('policy.show')"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Privacy
                                Policy</a>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </Label>
            </div>

            <div class="flex flex-col gap-2 items-center justify-end mt-4">
                <Button type="submit" class="w-full" :disabled="form.processing">
                    <span v-show="form.processing" class="flex items-center justify-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Processing...
                    </span>
                    <span v-show="!form.processing">
                        Register
                    </span>
                </Button>
                <Link :href="route('login')"
                    class="underline text-xs text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Already registered?
                </Link>
            </div>
        </form>
    </AuthenticationCard>
</template>
