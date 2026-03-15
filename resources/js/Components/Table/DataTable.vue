<script setup lang="ts" generic="TData">
import {
    FlexRender,
    getCoreRowModel,
    useVueTable,
    type ColumnDef,
    getFilteredRowModel,
    getPaginationRowModel,
    getFacetedRowModel,
    getFacetedUniqueValues,
    type ColumnFiltersState,
} from "@tanstack/vue-table";
import { ref, computed } from "vue";
import Table from "./Table.vue";
import Thead from "./Thead.vue";
import Tbody from "./Tbody.vue";
import Tr from "./Tr.vue";
import Th from "./Th.vue";
import Td from "./Td.vue";
import TextInput from "@/Components/Admin/TextInput.vue";
import SelectInput from "@/Components/Admin/SelectInput.vue";

const props = withDefaults(
    defineProps<{
        columns: ColumnDef<TData, any>[];
        data: TData[];
        enableSearch?: boolean;
        enablePagination?: boolean;
        initialPageSize?: number;
    }>(),
    {
        enableSearch: true,
        enablePagination: false,
        initialPageSize: 10,
    },
);

const globalFilter = ref("");
const columnFilters = ref<ColumnFiltersState>([]);
const pagination = ref({
    pageIndex: 0,
    pageSize: props.initialPageSize,
});

const table = useVueTable({
    get data() {
        return props.data;
    },
    get columns() {
        return props.columns;
    },
    getCoreRowModel: getCoreRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getPaginationRowModel: props.enablePagination
        ? getPaginationRowModel()
        : undefined,
    getFacetedRowModel: getFacetedRowModel(),
    getFacetedUniqueValues: getFacetedUniqueValues(),
    state: {
        get globalFilter() {
            return globalFilter.value;
        },
        get columnFilters() {
            return columnFilters.value;
        },
        get pagination() {
            return pagination.value;
        },
    },
    onGlobalFilterChange: (updaterOrValue) => {
        globalFilter.value =
            typeof updaterOrValue === "function"
                ? updaterOrValue(globalFilter.value)
                : updaterOrValue;
    },
    onColumnFiltersChange: (updaterOrValue) => {
        columnFilters.value =
            typeof updaterOrValue === "function"
                ? updaterOrValue(columnFilters.value)
                : updaterOrValue;
    },
    onPaginationChange: (updaterOrValue) => {
        pagination.value =
            typeof updaterOrValue === "function"
                ? updaterOrValue(pagination.value)
                : updaterOrValue;
    },
});

// Add this to expose table instance to parent
defineExpose({
    table,
});

const pageSizeOptions = [
    { value: 10, label: "10 per halaman" },
    { value: 100, label: "100 per halaman" },
    { value: 200, label: "200 per halaman" },
];
</script>

<template>
    <div
        v-if="enableSearch"
        class="p-4 bg-white border-b border-secondary/20 flex flex-col md:flex-row md:items-center justify-between gap-4"
    >
        <div class="relative max-w-sm w-full">
            <TextInput
                v-model="globalFilter"
                placeholder="Cari..."
                class="mb-0"
            >
                <template #prefix>
                    <svg
                        class="w-4 h-4 text-secondary"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 20"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                        />
                    </svg>
                </template>
            </TextInput>
        </div>

        <div v-if="enablePagination" class="w-full md:w-48">
            <SelectInput
                :model-value="table.getState().pagination.pageSize"
                @update:model-value="table.setPageSize(Number($event))"
                :options="pageSizeOptions"
            />
        </div>
    </div>

    <div class="overflow-x-auto">
        <Table>
            <Thead>
                <Tr
                    v-for="headerGroup in table.getHeaderGroups()"
                    :key="headerGroup.id"
                >
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
                    <Td
                        :colspan="columns.length"
                        class="text-center text-secondary py-8 italic"
                    >
                        Data tidak ditemukan.
                    </Td>
                </Tr>
            </Tbody>
        </Table>
    </div>

    <!-- Pagination Controls -->
    <div
        v-if="enablePagination"
        class="px-6 py-4 border-t border-secondary/10 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-4"
    >
        <div class="text-sm text-secondary order-2 sm:order-1">
            Menampilkan
            <span class="font-medium">{{
                table.getState().pagination.pageIndex *
                    table.getState().pagination.pageSize +
                1
            }}</span>
            sampai
            <span class="font-medium">{{
                Math.min(
                    (table.getState().pagination.pageIndex + 1) *
                        table.getState().pagination.pageSize,
                    table.getFilteredRowModel().rows.length,
                )
            }}</span>
            dari
            <span class="font-medium">{{
                table.getFilteredRowModel().rows.length
            }}</span>
            data
        </div>

        <div class="flex items-center gap-1 order-1 sm:order-2">
            <button
                @click="table.previousPage()"
                :disabled="!table.getCanPreviousPage()"
                class="px-3 py-1.5 text-sm rounded-lg bg-white text-secondary hover:bg-primary/10 hover:text-primary border border-secondary/20 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center min-w-[40px]"
            >
                <span class="text-lg leading-none">&laquo;</span>
                <span class="hidden sm:inline ml-1">Prev</span>
            </button>

            <div class="flex items-center gap-1">
                <button
                    v-for="page in table.getPageCount()"
                    :key="page"
                    @click="table.setPageIndex(page - 1)"
                    class="px-3 py-1.5 text-sm rounded-lg transition-all duration-200"
                    :class="[
                        table.getState().pagination.pageIndex === page - 1
                            ? 'bg-primary text-white font-bold'
                            : 'bg-white text-secondary hover:bg-primary/10 hover:text-primary border border-secondary/20',
                        // Simple logic for ellipsis - only show first, last, and current surroundings
                        Math.abs(
                            table.getState().pagination.pageIndex - (page - 1),
                        ) <= 1 ||
                        page === 1 ||
                        page === table.getPageCount()
                            ? 'block'
                            : 'hidden',
                    ]"
                >
                    {{ page }}
                </button>
            </div>

            <button
                @click="table.nextPage()"
                :disabled="!table.getCanNextPage()"
                class="px-3 py-1.5 text-sm rounded-lg bg-white text-secondary hover:bg-primary/10 hover:text-primary border border-secondary/20 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center min-w-[40px]"
            >
                <span class="hidden sm:inline mr-1">Next</span>
                <span class="text-lg leading-none">&raquo;</span>
            </button>
        </div>
    </div>
</template>
