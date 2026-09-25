<script setup>
import { Head, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post('/register');
};
</script>

<template>
    <Head title="Create Account" />

    <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-lg p-8">

                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Create your Sellora account
                    </h1>

                    <p class="mt-2 text-gray-600">
                        Get started with Sellora
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-5">

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Name
                        </label>

                        <input
                            v-model="form.name"
                            type="text"
                            autocomplete="name"
                            required
                            class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3"
                        />

                        <p
                            v-if="form.errors.name"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Email
                        </label>

                        <input
                            v-model="form.email"
                            type="email"
                            autocomplete="email"
                            required
                            class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3"
                        />

                        <p
                            v-if="form.errors.email"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Password
                        </label>

                        <input
                            v-model="form.password"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3"
                        />

                        <p
                            v-if="form.errors.password"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">
                            Confirm Password
                        </label>

                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3"
                        />
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full rounded-lg bg-indigo-600 px-4 py-3 font-semibold text-white hover:bg-indigo-700 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Creating Account...' : 'Create Account' }}
                    </button>

                    <div class="text-center text-sm text-gray-600">
                        Already have an account?

                        <a
                            href="/login"
                            class="font-semibold text-indigo-600"
                        >
                            Sign in
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>