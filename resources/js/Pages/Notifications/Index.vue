<template>
  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-2">Futsal Booking — Notifications</h1>
    <p class="text-gray-600 mb-6">Halaman dummy log notifikasi (Vue + Inertia).</p>
    
    <div class="bg-white shadow rounded-lg overflow-hidden border">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Code</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Channel</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Recipient</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sent At</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="notification in notifications" :key="notification.id">
              <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ notification.booking?.booking_code }}</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ notification.type }}</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                <span :class="{
                  'px-2 py-0.5 rounded text-xs font-medium': true,
                  'bg-green-100 text-green-800': notification.channel === 'whatsapp',
                  'bg-blue-100 text-blue-800': notification.channel === 'email',
                }">
                  {{ notification.channel }}
                </span>
              </td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ notification.recipient }}</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm">
                <span :class="{
                  'px-2 py-1 rounded-full text-xs font-semibold': true,
                  'bg-yellow-100 text-yellow-800': notification.status === 'pending',
                  'bg-green-100 text-green-800': notification.status === 'sent',
                  'bg-red-100 text-red-800': notification.status === 'failed',
                }">
                  {{ notification.status }}
                </span>
              </td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ notification.sent_at || '-' }}</td>
            </tr>
            <tr v-if="notifications.length === 0">
              <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500 italic">Belum ada notifikasi. Jalankan seeder.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3 text-sm">
      <Link href="/admin" class="text-blue-600 hover:underline">Ke halaman admin</Link>
      <Link href="/bookings" class="text-blue-600 hover:underline">Ke daftar bookings</Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  notifications: {
    type: Array,
    default: () => []
  }
})
</script>
