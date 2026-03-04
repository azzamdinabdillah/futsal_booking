<template>
  <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-2">Futsal Booking — System Configs</h1>
    <p class="text-gray-600 mb-6">Halaman dummy pengaturan sistem (Vue + Inertia).</p>
    
    <div class="bg-white shadow rounded-lg overflow-hidden border">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Key</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="config in configs" :key="config.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ config.key }}</td>
            <td class="px-6 py-4 text-sm text-gray-500">{{ config.value }}</td>
            <td class="px-6 py-4 text-sm text-gray-500">{{ config.description }}</td>
          </tr>
          <tr v-if="configs.length === 0">
            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 italic">Belum ada konfigurasi. Jalankan seeder.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-6 space-x-3 text-sm">
      <Link href="/admin" class="text-blue-600 hover:underline">Ke halaman admin</Link>
      <Link href="/fields" class="text-blue-600 hover:underline">Ke daftar fields</Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  configs: {
    type: Array,
    default: () => []
  }
})
</script>
