<script setup lang="ts">
import { ref, h } from 'vue'
import Sidebar from '@/Components/Admin/Sidebar.vue'
import { Head } from '@inertiajs/vue3'
import DataTable from '@/Components/Table/DataTable.vue'
import { createColumnHelper } from '@tanstack/vue-table'

type Config = {
  id: number
  key: string
  value: string
  description: string
}

defineProps<{
  configs: Config[]
}>()

const isSidebarOpen = ref(false)

const columnHelper = createColumnHelper<Config>()

const columns = [
  columnHelper.accessor('key', {
    header: 'Key',
    cell: info => h('span', { class: 'font-medium text-gray-900' }, info.getValue()),
  }),
  columnHelper.accessor('value', {
    header: 'Value',
    cell: info => info.getValue(),
  }),
  columnHelper.accessor('description', {
    header: 'Description',
    cell: info => info.getValue(),
  }),
  columnHelper.display({
    id: 'actions',
    header: 'Action',
    cell: ({ row }) => h('button', {
      class: 'text-blue-600 hover:text-blue-800 font-medium',
      onClick: () => {
        // Edit logic will be implemented later
        console.log('Edit', row.original)
      }
    }, 'Edit'),
  }),
]
</script>

<template>
  <Head title="System Configuration" />
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
          <h2 class="text-xl font-semibold text-gray-800">System Configuration</h2>
        </div>
        <div class="flex items-center space-x-4">
          <span class="text-gray-600 hidden sm:inline">Admin User</span>
          <div class="w-8 h-8 bg-gray-300 rounded-full"></div>
        </div>
      </header>

      <!-- Content -->
      <div class="p-4 md:p-6">
        <div class="bg-white rounded-lg shadow overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-800">Configuration List</h3>
            <!-- Add button could go here if needed -->
          </div>
          
          <DataTable :columns="columns" :data="configs" />
        </div>
      </div>
    </main>
  </div>
</template>
