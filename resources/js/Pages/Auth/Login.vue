<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post('/login', {
        replace: true,
    });
};
</script>

<template>
    <Head title="Login" />

    <div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-lg p-8">

                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Sellora
                    </h1>

                    <p class="mt-2 text-gray-600">
                        Sign in to your account
                    </p>
                </div>

                <form @submit.prevent="submit" class="space-y-6">

                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Email
                        </label>

                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            autocomplete="email"
                            required
                            class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500"
                        />

                        <p
                            v-if="form.errors.email"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ form.errors.email }}
                        </p>
                    </div>

                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Password
                        </label>

                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            autocomplete="current-password"
                            required
                            class="mt-2 w-full rounded-lg border border-gray-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500"
                        />

                        <p
                            v-if="form.errors.password"
                            class="mt-2 text-sm text-red-600"
                        >
                            {{ form.errors.password }}
                        </p>
                    </div>

                    <div class="flex items-center">
                        <input
                            id="remember"
                            v-model="form.remember"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300"
                        />

                        <label
                            for="remember"
                            class="ml-2 text-sm text-gray-600"
                        >
                            Remember me
                        </label>
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full rounded-lg bg-indigo-600 px-4 py-3 font-semibold text-white hover:bg-indigo-700 disabled:opacity-50"
                    >
                        {{ form.processing ? 'Signing in...' : 'Sign In' }}
                    </button>

                    <div class="text-center">
                        <a
                            href="/forgot-password"
                            class="text-sm text-indigo-600 hover:text-indigo-700"
                        >
                            Forgot your password?
                        </a>
                    </div>

                    <div class="text-center text-sm text-gray-600">
                        Don't have an account?

                        <a
                            href="/register"
                            class="font-semibold text-indigo-600 hover:text-indigo-700"
                        >
                            Create account
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>