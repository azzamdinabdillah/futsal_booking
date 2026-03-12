<template>
  <div class="flex h-screen bg-light">
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
            class="mr-4 text-secondary hover:text-dark focus:outline-none md:hidden"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h2 class="text-xl font-semibold text-dark">Dashboard</h2>
        </div>
        <div class="flex items-center space-x-4">
          <span class="text-secondary hidden sm:inline">Admin User</span>
          <div class="w-8 h-8 bg-secondary/20 rounded-full"></div>
        </div>
      </header>

      <!-- Content -->
      <div class="p-4 md:p-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-6">
          <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-secondary text-sm font-medium">Total Users</h3>
            <p class="text-3xl font-bold text-dark mt-2">1,234</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-secondary text-sm font-medium">Active Bookings</h3>
            <p class="text-3xl font-bold text-dark mt-2">56</p>
          </div>
          <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-secondary text-sm font-medium">Revenue</h3>
            <p class="text-3xl font-bold text-dark mt-2">$12,345</p>
          </div>
        </div>

        <!-- Recent Activity Table (Dummy) -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <div class="px-6 py-4 border-b border-secondary/20">
            <h3 class="text-lg font-semibold text-dark">Recent Activity</h3>
          </div>
          
          <DataTable :columns="columns" :data="activities" />
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, h } from 'vue'
import Sidebar from '@/Components/Admin/Sidebar.vue'
import DataTable from '@/Components/Table/DataTable.vue'
import { createColumnHelper } from '@tanstack/vue-table'

const isSidebarOpen = ref(false)

type Activity = {
  user: string
  action: string
  date: string
  status: string
}

const activities: Activity[] = [
  { user: 'John Doe', action: 'Booked Field A', date: '2024-03-01', status: 'Completed' },
  { user: 'Jane Smith', action: 'Cancelled Booking', date: '2024-02-28', status: 'Cancelled' },
  { user: 'Mike Johnson', action: 'New Registration', date: '2024-02-27', status: 'New' },
]

const columnHelper = createColumnHelper<Activity>()

const columns = [
  columnHelper.accessor('user', { header: 'User' }),
  columnHelper.accessor('action', { header: 'Action' }),
  columnHelper.accessor('date', { header: 'Date' }),
  columnHelper.accessor('status', {
    header: 'Status',
    cell: info => {
      const status = info.getValue()
      let className = 'px-2 py-1 rounded-full text-xs '
      if (status === 'Completed') className += 'bg-success/20 text-success'
      else if (status === 'Cancelled') className += 'bg-danger/20 text-danger'
      else className += 'bg-info/20 text-info'
      
      return h('span', { class: className }, status)
    }
  }),
]
</script>
