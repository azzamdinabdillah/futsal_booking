<template>
  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-2">Futsal Booking — Bookings</h1>
    <p class="text-gray-600 mb-6">Halaman dummy daftar pemesanan lapangan (Vue + Inertia).</p>
    
    <div class="bg-white shadow rounded-lg overflow-hidden border">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Field</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Schedule</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="booking in bookings" :key="booking.id">
              <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ booking.booking_code }}</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ booking.customer_name }}<br>
                <span class="text-xs">{{ booking.customer_whatsapp }}</span>
              </td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ booking.field?.name }}</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ booking.play_date }}<br>
                <span class="text-xs">{{ booking.start_time }} - {{ booking.end_time }}</span>
              </td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ Number(booking.total_price).toLocaleString() }}</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm">
                <span :class="{
                  'px-2 py-1 rounded-full text-xs font-semibold': true,
                  'bg-yellow-100 text-yellow-800': booking.status === 'waiting_payment',
                  'bg-green-100 text-green-800': booking.status === 'confirmed',
                  'bg-blue-100 text-blue-800': booking.status === 'completed',
                  'bg-red-100 text-red-800': booking.status === 'cancelled',
                }">
                  {{ booking.status }}
                </span>
              </td>
            </tr>
            <tr v-if="bookings.length === 0">
              <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500 italic">Belum ada pemesanan. Jalankan seeder.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3 text-sm">
      <Link href="/admin" class="text-blue-600 hover:underline">Ke halaman admin</Link>
      <Link href="/fields" class="text-blue-600 hover:underline">Ke daftar fields</Link>
      <Link href="/blocked-slots" class="text-blue-600 hover:underline">Ke blocked slots</Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  bookings: {
    type: Array,
    default: () => []
  }
})
</script>
