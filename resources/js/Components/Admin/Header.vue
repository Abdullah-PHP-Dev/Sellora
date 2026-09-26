<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import DarkModeSwitcher from '@/Components/Admin/DarkModeSwitcher.vue'
import UserDropdown from '@/Components/Admin/UserDropdown.vue'

defineProps({
  sidebarOpen: Boolean
})

defineEmits(['toggle-sidebar'])

const page = usePage()
const user = page.props.auth?.user
</script>

<template>
  <header class="sticky top-0 z-40 flex w-full bg-white drop-shadow-1 dark:bg-gray-800 dark:drop-shadow-none border-b border-gray-200 dark:border-gray-700">
    <div class="flex flex-grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">
      <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
        <!-- Hamburger Toggle Button -->
        <button
          @click="$emit('toggle-sidebar')"
          class="z-50 block rounded-sm border border-stroke bg-white p-1.5 shadow-sm dark:border-strokedark dark:bg-boxdark lg:hidden"
        >
          <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <Link href="/dashboard" class="flex items-center gap-2 font-bold text-xl text-indigo-600 dark:text-indigo-400">
          Sellora
        </Link>
      </div>

      <div class="hidden sm:block">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">Admin Dashboard</h2>
      </div>

      <div class="flex items-center gap-3 2xl:gap-7">
        <ul class="flex items-center gap-2 2xl:gap-4">
          <DarkModeSwitcher />
        </ul>
        <UserDropdown :user="user" />
      </div>
    </div>
  </header>
</template>