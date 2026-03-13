<template>
  <AdminLayout title="Dashboard">
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
  </AdminLayout>
</template>

<script setup lang="ts">
import { h } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Table/DataTable.vue'
import { createColumnHelper } from '@tanstack/vue-table'

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
