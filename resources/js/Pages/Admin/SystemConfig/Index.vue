<script setup lang="ts">
import { ref, h } from 'vue'
import Sidebar from '@/Components/Admin/Sidebar.vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import DataTable from '@/Components/Table/DataTable.vue'
import { createColumnHelper } from '@tanstack/vue-table'
import Modal from '@/Components/Modal.vue'
import Button from '@/Components/Admin/Button.vue'
import TextInput from '@/Components/Admin/TextInput.vue'
import TextArea from '@/Components/Admin/TextArea.vue'
import RadioGroup from '@/Components/Admin/RadioGroup.vue'

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
const inputType = ref<'text' | 'color'>('text')

const form = useForm({
  value: '',
  description: '',
})

const openEditModal = (config: Config) => {
  editingConfig.value = config
  form.value = config.value
  form.description = config.description
  
  // Check if value is a valid hex color
  const isColor = /^#[0-9A-F]{6}$/i.test(config.value)
  inputType.value = isColor ? 'color' : 'text'
  
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
    cell: ({ row }) => h(Button, {
      variant: 'primary',
      size: 'sm',
      onClick: () => openEditModal(row.original)
    }, () => 'Edit'),
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
          <!-- Input Type Selector -->
          <RadioGroup 
            v-model="inputType" 
            label="Input Type" 
            :options="[
              { label: 'Text', value: 'text' },
              { label: 'Color Picker', value: 'color' }
            ]" 
            :inline="true"
          />

          <TextInput
            v-if="inputType === 'text'"
            id="value"
            v-model="form.value"
            label="Value"
            :error="form.errors.value"
            required
          />

          <div v-else class="mb-5">
            <label for="color-value" class="block text-sm font-semibold text-gray-700 mb-1.5">Value</label>
            <div class="flex items-center space-x-3">
              <input 
                type="color" 
                id="color-value" 
                v-model="form.value"
                class="h-10 w-20 p-1 border border-gray-300 rounded-md cursor-pointer"
              >
              <span class="text-gray-700 font-mono bg-gray-100 px-2 py-1 rounded border border-gray-200">{{ form.value }}</span>
            </div>
            <p v-if="form.errors.value" class="mt-2 text-sm text-red-600 flex items-center animate-in fade-in slide-in-from-top-1 duration-200">
                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ form.errors.value }}
            </p>
          </div>

          <TextArea
            id="description"
            v-model="form.description"
            label="Description"
            :rows="3"
            :error="form.errors.description"
          />

          <div class="flex justify-end space-x-3">
            <Button 
              type="button" 
              variant="secondary"
              @click="closeEditModal"
            >
              Cancel
            </Button>
            <Button 
              type="submit" 
              variant="primary"
              :disabled="form.processing"
              :loading="form.processing"
            >
              Save Changes
            </Button>
          </div>
        </form>
      </div>
    </Modal>
  </div>
</template>
