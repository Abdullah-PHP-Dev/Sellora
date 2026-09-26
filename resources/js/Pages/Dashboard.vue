<script setup>
import { Head } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import MetricCard from '@/Components/Dashboard/MetricCard.vue'

defineProps({
  stats: {
    type: Object,
    default: () => ({
      totalRevenue: '$45,231.89',
      totalOrders: 1240,
      totalCustomers: 850,
      activeProducts: 320
    })
  },
  recentOrders: {
    type: Array,
    default: () => []
  }
})
</script>

<template>
  <Head title="Admin Dashboard" />

  <AdminLayout>
    <!-- KPI Metric Cards Grid -->
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-4 2xl:gap-7.5">
      <MetricCard title="Total Revenue" :value="stats.totalRevenue" change="+12.5%" is-positive />
      <MetricCard title="Total Orders" :value="stats.totalOrders" change="+8.2%" is-positive />
      <MetricCard title="Total Customers" :value="stats.totalCustomers" change="+5.1%" is-positive />
      <MetricCard title="Active Products" :value="stats.activeProducts" change="-1.4%" :is-positive="false" />
    </div>

    <!-- Data Tables & Charts Section -->
    <div class="mt-4 md:mt-6 2xl:mt-7.5 grid grid-cols-12 gap-4 md:gap-6 2xl:gap-7.5">
      <div class="col-span-12 rounded-sm border border-stroke bg-white p-6 shadow-default dark:border-gray-800 dark:bg-gray-800">
        <h4 class="mb-4 text-xl font-bold text-gray-800 dark:text-white">Recent Store Orders</h4>
        <div v-if="recentOrders.length === 0" class="text-sm text-gray-500 py-4">
          No live orders found in the database. Connected to Sellora Order API.
        </div>
        <div v-else class="overflow-x-auto">
          <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase text-gray-700 dark:text-gray-300">
              <tr>
                <th class="px-4 py-3">Order ID</th>
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in recentOrders" :key="order.id" class="border-b dark:border-gray-700">
                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">#{{ order.id }}</td>
                <td class="px-4 py-3">{{ order.customer_name }}</td>
                <td class="px-4 py-3">{{ order.status }}</td>
                <td class="px-4 py-3">${{ order.total_amount }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>