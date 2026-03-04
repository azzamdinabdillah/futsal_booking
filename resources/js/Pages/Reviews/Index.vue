<template>
  <div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-2">Futsal Booking — Reviews</h1>
    <p class="text-gray-600 mb-6">Halaman dummy daftar ulasan pelanggan (Vue + Inertia).</p>
    
    <div class="bg-white shadow rounded-lg overflow-hidden border">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking Code</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Field</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Field Rating</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service Rating</th>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="review in reviews" :key="review.id">
              <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ review.booking?.booking_code }}</td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ review.field?.name }}</td>
              <td class="px-4 py-4 text-sm text-gray-500">
                <span class="font-bold text-yellow-500">{{ review.field_rating_score }}/5</span><br>
                <span class="text-xs italic">"{{ review.field_rating_comment }}"</span>
              </td>
              <td class="px-4 py-4 text-sm text-gray-500">
                <span class="font-bold text-yellow-500">{{ review.service_rating_score }}/5</span><br>
                <span class="text-xs italic">"{{ review.service_rating_comment }}"</span>
              </td>
              <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ new Date(review.created_at).toLocaleDateString() }}</td>
            </tr>
            <tr v-if="reviews.length === 0">
              <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-500 italic">Belum ada ulasan. Jalankan seeder atau buat baru.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-6 flex flex-wrap gap-3 text-sm">
      <Link href="/admin" class="text-blue-600 hover:underline">Ke halaman admin</Link>
      <Link href="/bookings" class="text-blue-600 hover:underline">Ke daftar bookings</Link>
      <Link href="/fields" class="text-blue-600 hover:underline">Ke daftar fields</Link>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
  reviews: {
    type: Array,
    default: () => []
  }
})
</script>
