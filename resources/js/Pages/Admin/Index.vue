<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex flex-col w-full">
      <!-- Header -->
      <header class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-10">
        <div class="flex items-center">
          <!-- Hamburger Button -->
          <button 
            @click="isSidebarOpen = !isSidebarOpen" 
            class="mr-4 text-gray-600 hover:text-gray-900 focus:outline-none md:hidden"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
        </div>
        <div class="flex items-center space-x-4">
          <span class="text-gray-600 hidden sm:inline">Admin User</span>
          <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
        </div>
      </header>

      <!-- Content -->
      <div class="p-4 md:p-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6">
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
          
          <Table>
            <Thead>
              <Tr>
                <Th>User</Th>
                <Th>Action</Th>
                <Th>Date</Th>
                <Th>Status</Th>
              </Tr>
            </Thead>
            <Tbody>
              <Tr>
                <Td>John Doe</Td>
                <Td>Booked Field A</Td>
                <Td>2024-03-01</Td>
                <Td><span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Completed</span></Td>
              </Tr>
              <Tr>
                <Td>Jane Smith</Td>
                <Td>Cancelled Booking</Td>
                <Td>2024-02-28</Td>
                <Td><span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Cancelled</span></Td>
              </Tr>
              <Tr>
                <Td>Mike Johnson</Td>
                <Td>New Registration</Td>
                <Td>2024-02-27</Td>
                <Td><span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">New</span></Td>
              </Tr>
            </Tbody>
          </Table>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import Sidebar from '@/Components/Admin/Sidebar.vue'
import Table from '@/Components/Table/Table.vue'
import Thead from '@/Components/Table/Thead.vue'
import Tbody from '@/Components/Table/Tbody.vue'
import Tr from '@/Components/Table/Tr.vue'
import Th from '@/Components/Table/Th.vue'
import Td from '@/Components/Table/Td.vue'

const isSidebarOpen = ref(false)
</script>
