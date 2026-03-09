<script setup lang="ts">
import { ref, h } from 'vue'
import Sidebar from '@/Components/Admin/Sidebar.vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import DataTable from '@/Components/Table/DataTable.vue'
import { createColumnHelper } from '@tanstack/vue-table'
import Modal from '@/Components/Modal.vue'

type Config = {
  id: number
  key: string
  value: string
  description: string
}

const props = defineProps<{
  configs: Config[]
}>()

const isSidebarOpen = ref(false)
const isEditModalOpen = ref(false)
const editingConfig = ref<Config | null>(null)

const form = useForm({
  value: '',
  description: '',
})

const openEditModal = (config: Config) => {
  editingConfig.value = config
  form.value = config.value
  form.description = config.description
  isEditModalOpen.value = true
}

const closeEditModal = () => {
  isEditModalOpen.value = false
  editingConfig.value = null
  form.reset()
  form.clearErrors()
}

const submitEdit = () => {
  if (!editingConfig.value) return
  
  form.post(`/admin/system-config/${editingConfig.value.id}`, {
    onSuccess: () => {
      closeEditModal()
    },
  })
}

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
      onClick: () => openEditModal(row.original)
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

    <!-- Edit Modal -->
    <Modal :show="isEditModalOpen" @close="closeEditModal">
      <div class="p-6 bg-white rounded-lg">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
          Edit Configuration: <span class="font-bold">{{ editingConfig?.key }}</span>
        </h2>
        
        <form @submit.prevent="submitEdit">
          <div class="mb-4">
            <label for="value" class="block text-sm font-medium text-gray-700 mb-1">Value</label>
            <input 
              id="value" 
              v-model="form.value" 
              type="text" 
              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
              required
            />
            <div v-if="form.errors.value" class="text-red-500 text-sm mt-1">{{ form.errors.value }}</div>
          </div>

          <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea 
              id="description" 
              v-model="form.description" 
              rows="3"
              class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
            ></textarea>
            <div v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</div>
          </div>

          <div class="flex justify-end space-x-3">
            <button 
              type="button" 
              @click="closeEditModal"
              class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50"
            >
              Cancel
            </button>
            <button 
              type="submit" 
              class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
              :disabled="form.processing"
            >
              Save Changes
            </button>
          </div>
        </form>
      </div>
    </Modal>
  </div>
</template>
