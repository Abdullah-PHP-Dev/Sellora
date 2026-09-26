<script setup>
defineProps({
  title: {
    type: String,
    required: true
  },
  value: {
    type: [String, Number],
    required: true
  },
  change: {
    type: String,
    default: ''
  },
  isPositive: {
    type: Boolean,
    default: true
  }
})
</script>

<template>
  <div class="rounded-lg border border-gray-200 bg-white px-6 py-6 shadow-sm dark:border-gray-800 dark:bg-gray-800">
    
    <!-- Circular Icon Placeholder -->
    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-50 dark:bg-gray-700">
      <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
      </svg>
    </div>

    <!-- Data & Change Indicator -->
    <div class="mt-4 flex items-end justify-between">
      <div>
        <h4 class="text-2xl font-bold text-gray-900 dark:text-white">
          {{ value }}
        </h4>
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">
          {{ title }}
        </span>
      </div>

      <span
        v-if="change"
        :class="[
          'flex items-center gap-1 text-sm font-medium',
          isPositive ? 'text-green-500' : 'text-red-500'
        ]"
      >
        {{ change }}
        
        <!-- Up Arrow -->
        <svg v-if="isPositive" class="w-3 h-3 fill-current" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
          <path d="M4.35716 2.3925L0.908974 5.745L5.0443e-07 4.86125L5 -5.1656e-07L10 4.86125L9.09103 5.745L5.64284 2.3925L5.64284 10L4.35716 10L4.35716 2.3925Z" />
        </svg>
        
        <!-- Down Arrow -->
        <svg v-else class="w-3 h-3 fill-current" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
          <path d="M5.64284 7.6075L9.09102 4.255L10 5.13875L5 10L-8.98488e-07 5.13875L0.908973 4.255L4.35716 7.6075L4.35716 -5.1656e-07L5.64284 -4.59604e-07L5.64284 7.6075Z" />
        </svg>
      </span>
    </div>
  </div>
</template>