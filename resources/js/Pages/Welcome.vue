<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';

const page = usePage();

const isAuthenticated = () => {
    return !!page.props.auth?.user;
};
</script>

<template>
    <Head title="Welcome" />

    <div class="min-h-screen bg-gray-50">

        <!-- Navigation -->
        <header class="border-b border-gray-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

                <!-- Logo -->
                <Link
                    href="/"
                    class="text-2xl font-bold text-gray-900"
                >
                    Sellora
                </Link>

                <!-- Guest Navigation -->
                <div
                    v-if="!isAuthenticated()"
                    class="flex items-center gap-3"
                >
                    <Link
                        href="/login"
                        class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                    >
                        Login
                    </Link>

                    <Link
                        href="/register"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700"
                    >
                        Register
                    </Link>
                </div>

                <!-- Authenticated Navigation -->
                <div
                    v-else
                    class="flex items-center gap-3"
                >
                    <Link
                        href="/dashboard"
                        class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                    >
                        Dashboard
                    </Link>

                    <form method="POST" action="/logout">
                        <input
                            type="hidden"
                            name="_token"
                            :value="page.props.csrf_token"
                        />

                        <button
                            type="submit"
                            class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700"
                        >
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </header>

        <!-- Hero -->
        <main>
            <section class="mx-auto max-w-7xl px-6 py-24">

                <div class="mx-auto max-w-3xl text-center">

                    <div
                        class="mb-6 inline-flex rounded-full bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-700"
                    >
                        Welcome to Sellora
                    </div>

                    <h1 class="text-5xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                        Build and manage your
                        <span class="text-indigo-600">
                            online business
                        </span>
                    </h1>

                    <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-gray-600">
                        Sellora provides a modern platform to manage your
                        business, products, customers, orders and more from
                        one powerful dashboard.
                    </p>

                    <!-- Hero Actions -->
                    <div
                        v-if="!isAuthenticated()"
                        class="mt-10 flex items-center justify-center gap-4"
                    >
                        <Link
                            href="/register"
                            class="rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
                        >
                            Get Started
                        </Link>

                        <Link
                            href="/login"
                            class="rounded-xl border border-gray-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50"
                        >
                            Sign In
                        </Link>
                    </div>

                    <div
                        v-else
                        class="mt-10"
                    >
                        <Link
                            href="/dashboard"
                            class="inline-flex rounded-xl bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700"
                        >
                            Go to Dashboard
                        </Link>
                    </div>

                </div>

            </section>
        </main>

        <!-- Footer -->
        <footer class="border-t border-gray-200 bg-white">
            <div class="mx-auto max-w-7xl px-6 py-6 text-center text-sm text-gray-500">
                © {{ new Date().getFullYear() }} Sellora. All rights reserved.
            </div>
        </footer>

    </div>
</template>