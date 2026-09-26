<script setup>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { onClickOutside } from '@vueuse/core'

defineProps({
  user: Object
})

const dropdownOpen = ref(false)
const target = ref(null)

onClickOutside(target, () => {
  dropdownOpen.value = false
})
</script>

<template>
  <div class="relative" ref="target">
    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center gap-4">
      <span class="hidden text-right lg:block">
        <span class="block text-sm font-medium text-gray-800 dark:text-white">{{ user?.name || 'Admin User' }}</span>
        <span class="block text-xs font-medium text-gray-500 dark:text-gray-400">{{ user?.email || 'admin@sellora.com' }}</span>
      </span>
      <div class="h-11 w-11 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
        {{ user?.name ? user.name.charAt(0).toUpperCase() : 'A' }}
      </div>
    </button>

    <div
      v-show="dropdownOpen"
      class="absolute right-0 mt-4 w-62.5 rounded-sm border border-stroke bg-white p-3 shadow-default dark:border-strokedark dark:bg-boxdark z-50"
    >
      <ul class="flex flex-col gap-1 border-b border-stroke pb-3 dark:border-strokedark">
        <li>
          <Link href="/user/profile" class="flex items-center gap-3.5 text-sm font-medium duration-300 ease-in-out hover:text-indigo-600 p-2 rounded">
            My Profile
          </Link>
        </li>
      </ul>
      <Link
        href="/logout"
        method="post"
        as="button"
        class="flex w-full items-center gap-3.5 py-2 px-2 text-sm font-medium duration-300 ease-in-out hover:text-red-600"
      >
        Log Out
      </Link>
    </div>
  </div>
</template>