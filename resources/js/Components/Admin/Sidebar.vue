<script setup>
import { Link, usePage } from '@inertiajs/vue3'

defineProps({
  sidebarOpen: Boolean
})

defineEmits(['close-sidebar'])

const page = usePage()

const isUrl = (url) => {
  return page.url.startsWith(url)
}
</script>

<template>
  <aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="absolute left-0 top-0 z-50 flex h-screen w-72.5 flex-col overflow-y-hidden bg-gray-900 duration-300 ease-linear dark:bg-gray-800 lg:static lg:translate-x-0"
  >
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5 border-b border-gray-800">
      <Link href="/dashboard" class="text-2xl font-bold text-white tracking-wide">
        Sellora <span class="text-xs text-indigo-400 font-normal">Admin</span>
      </Link>
      <button @click="$emit('close-sidebar')" class="block lg:hidden text-gray-400 hover:text-white">
        &times;
      </button>
    </div>

    <!-- Sidebar Navigation -->
    <div class="no-scrollbar flex flex-col overflow-y-auto duration-300 ease-linear">
      <nav class="mt-5 px-4 py-4 lg:mt-9 lg:px-6">
        <div>
          <h3 class="mb-4 ml-4 text-sm font-semibold text-gray-400">MENU</h3>
          <ul class="mb-6 flex flex-col gap-1.5">
            <li>
              <Link
                href="/dashboard"
                :class="[
                  'group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium duration-300 ease-in-out hover:bg-gray-800 dark:hover:bg-gray-700',
                  isUrl('/dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-300'
                ]"
              >
                <span>Dashboard</span>
              </Link>
            </li>
            <!-- Add future admin Inertia routes here -->
          </ul>
        </div>
      </nav>
    </div>
  </aside>
</template>