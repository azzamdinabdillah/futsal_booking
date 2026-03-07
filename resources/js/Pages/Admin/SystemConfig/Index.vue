<script setup lang="ts">
import { ref } from 'vue'
import Sidebar from '@/Components/Admin/Sidebar.vue'
import { Head } from '@inertiajs/vue3'
import Table from '@/Components/Table/Table.vue'
import Thead from '@/Components/Table/Thead.vue'
import Tbody from '@/Components/Table/Tbody.vue'
import Tr from '@/Components/Table/Tr.vue'
import Th from '@/Components/Table/Th.vue'
import Td from '@/Components/Table/Td.vue'

defineProps<{
  configs: Array<{
    id: number
    key: string
    value: string
    description: string
  }>
}>()

const isSidebarOpen = ref(false)
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
          
          <Table>
            <Thead>
              <Tr>
                <Th>Key</Th>
                <Th>Value</Th>
                <Th>Description</Th>
                <Th>Action</Th>
              </Tr>
            </Thead>
            <Tbody>
              <Tr v-for="config in configs" :key="config.id">
                <Td class="font-medium text-gray-900">{{ config.key }}</Td>
                <Td>{{ config.value }}</Td>
                <Td>{{ config.description }}</Td>
                <Td>
                  <button class="text-blue-600 hover:text-blue-800 font-medium">Edit</button>
                </Td>
              </Tr>
              <Tr v-if="configs.length === 0">
                <Td colspan="4" class="text-center text-gray-500">No configurations found.</Td>
              </Tr>
            </Tbody>
          </Table>
        </div>
      </div>
    </main>
  </div>
</template>
