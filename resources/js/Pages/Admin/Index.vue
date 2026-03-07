<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
      <div class="p-4 text-2xl font-bold border-b border-gray-700">
        Admin Panel
      </div>
      <nav class="flex-1 p-4 space-y-2">
        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700 bg-gray-700">
          Dashboard
        </a>
        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">
          Users
        </a>
        <a href="#" class="block px-4 py-2 rounded hover:bg-gray-700">
          Settings
        </a>
        <Link href="/" class="block px-4 py-2 rounded hover:bg-gray-700 text-red-300">
          Logout / Home
        </Link>
      </nav>
      <div class="p-4 border-t border-gray-700 text-sm text-gray-400">
        &copy; 2024 Futsal Booking
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
      <!-- Header -->
      <header class="bg-white shadow p-4 flex justify-between items-center">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
        <div class="flex items-center space-x-4">
          <span class="text-gray-600">Admin User</span>
          <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
        </div>
      </header>

      <!-- Content -->
      <div class="p-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
          <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">1,234</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm font-medium">Active Bookings</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">56</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500 text-sm font-medium">Revenue</h3>
            <p class="text-3xl font-bold text-gray-800 mt-2">$12,345</p>
          </div>
        </div>

        <!-- Recent Activity Table (Dummy) -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase">
                  <th class="px-6 py-3 border-b">User</th>
                  <th class="px-6 py-3 border-b">Action</th>
                  <th class="px-6 py-3 border-b">Date</th>
                  <th class="px-6 py-3 border-b">Status</th>
                </tr>
              </thead>
              <tbody class="text-gray-700 text-sm">
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 border-b">John Doe</td>
                  <td class="px-6 py-4 border-b">Booked Field A</td>
                  <td class="px-6 py-4 border-b">2024-03-01</td>
                  <td class="px-6 py-4 border-b"><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span></td>
                </tr>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 border-b">Jane Smith</td>
                  <td class="px-6 py-4 border-b">Cancelled Booking</td>
                  <td class="px-6 py-4 border-b">2024-02-28</td>
                  <td class="px-6 py-4 border-b"><span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Cancelled</span></td>
                </tr>
                <tr class="hover:bg-gray-50">
                  <td class="px-6 py-4 border-b">Mike Johnson</td>
                  <td class="px-6 py-4 border-b">New Registration</td>
                  <td class="px-6 py-4 border-b">2024-02-27</td>
                  <td class="px-6 py-4 border-b"><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">New</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
</script>
