<template>
  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-2">Futsal Booking — Blocked Slots</h1>
    <p class="text-gray-600 mb-6">Halaman dummy daftar slot waktu yang diblokir (Vue + Inertia).</p>
    
    <div class="bg-white shadow rounded-lg overflow-hidden border">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Field</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Blocked By</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="slot in blockedSlots" :key="slot.id">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ slot.field?.name }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ slot.blocked_date }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ slot.start_time }} - {{ slot.end_time }}</td>
            <td class="px-6 py-4 text-sm text-gray-500">{{ slot.reason }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ slot.creator?.full_name }}</td>
          </tr>
          <tr v-if="blockedSlots.length === 0">
            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 italic">Belum ada slot yang diblokir. Jalankan seeder.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-6 space-x-3 text-sm">
      <Link href="/admin" class="text-blue-600 hover:underline">Ke halaman admin</Link>
      <Link href="/fields" class="text-blue-600 hover:underline">Ke daftar fields</Link>
      <Link href="/system-configs" class="text-blue-600 hover:underline">Ke system configs</Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  blockedSlots: {
    type: Array,
    default: () => []
  }
})
</script>
