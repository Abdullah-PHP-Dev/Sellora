<script setup>
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <div class="min-h-screen bg-gray-100">
        <header class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-gray-900">
                    Sellora
                </h1>

                <form method="POST" action="/logout">
                    <input
                        type="hidden"
                        name="_token"
                        :value="$page.props.csrf_token"
                    />

                    <button
                        type="submit"
                        class="text-sm font-medium text-red-600 hover:text-red-700"
                    >
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-10">
            <h2 class="text-3xl font-bold text-gray-900">
                Dashboard
            </h2>

            <p class="mt-2 text-gray-600">
                Welcome to your Sellora dashboard.
            </p>
        </main>
    </div>
</template>