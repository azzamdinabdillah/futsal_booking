<script setup lang="ts" generic="TData">
import {
  FlexRender,
  getCoreRowModel,
  useVueTable,
  type ColumnDef,
} from '@tanstack/vue-table'
import Table from './Table.vue'
import Thead from './Thead.vue'
import Tbody from './Tbody.vue'
import Tr from './Tr.vue'
import Th from './Th.vue'
import Td from './Td.vue'

const props = defineProps<{
  columns: ColumnDef<TData, any>[]
  data: TData[]
}>()

const table = useVueTable({
  get data() {
    return props.data
  },
  get columns() {
    return props.columns
  },
  getCoreRowModel: getCoreRowModel(),
})
</script>

<template>
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
