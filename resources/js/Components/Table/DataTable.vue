<script setup lang="ts" generic="TData">
import {
  FlexRender,
  getCoreRowModel,
  useVueTable,
  type ColumnDef,
  getFilteredRowModel,
} from '@tanstack/vue-table'
import { ref } from 'vue'
import Table from './Table.vue'
import Thead from './Thead.vue'
import Tbody from './Tbody.vue'
import Tr from './Tr.vue'
import Th from './Th.vue'
import Td from './Td.vue'
import TextInput from '@/Components/Admin/TextInput.vue'

const props = withDefaults(defineProps<{
  columns: ColumnDef<TData, any>[]
  data: TData[]
  enableSearch?: boolean
}>(), {
  enableSearch: true
})

const globalFilter = ref('')

const table = useVueTable({
  get data() {
    return props.data
  },
  get columns() {
    return props.columns
  },
  getCoreRowModel: getCoreRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  state: {
    get globalFilter() {
      return globalFilter.value
    },
  },
  onGlobalFilterChange: (updaterOrValue) => {
    globalFilter.value = typeof updaterOrValue === 'function' 
      ? updaterOrValue(globalFilter.value) 
      : updaterOrValue
  },
})
</script>

<template>
  <div v-if="enableSearch" class="p-4 bg-white border-b border-gray-200">
    <div class="relative max-w-sm">
      <TextInput
        v-model="globalFilter"
        placeholder="Search..."
        class="mb-0"
      >
        <template #prefix>
          <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
          </svg>
        </template>
      </TextInput>
    </div>
  </div>
  <Table>
    <Thead>
      <Tr v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
        <Th v-for="header in headerGroup.headers" :key="header.id">
          <FlexRender
            v-if="!header.isPlaceholder"
            :render="header.column.columnDef.header"
            :props="header.getContext()"
          />
        </Th>
      </Tr>
    </Thead>
    <Tbody>
      <Tr v-for="row in table.getRowModel().rows" :key="row.id">
        <Td v-for="cell in row.getVisibleCells()" :key="cell.id">
          <FlexRender
            :render="cell.column.columnDef.cell"
            :props="cell.getContext()"
          />
        </Td>
      </Tr>
      <Tr v-if="table.getRowModel().rows.length === 0">
        <Td :colspan="columns.length" class="text-center text-gray-500">
          No results.
        </Td>
      </Tr>
    </Tbody>
  </Table>
</template>
