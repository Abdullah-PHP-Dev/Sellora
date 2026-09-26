<script setup>
import { ref } from 'vue'
import Sidebar from '@/Components/Admin/Sidebar.vue'
import Header from '@/Components/Admin/Header.vue'

const sidebarOpen = ref(false)
</script>

<template>
  <div class="flex h-screen overflow-hidden bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <!-- Sidebar -->
    <Sidebar :sidebar-open="sidebarOpen" @close-sidebar="sidebarOpen = false" />

    <!-- Content Area -->
    <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
      <!-- Header -->
      <Header :sidebar-open="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen" />

      <!-- Main Content -->
      <main class="w-full flex-grow p-4 md:p-6 2xl:p-10">
        <slot />
      </main>
    </div>
  </div>
</template>