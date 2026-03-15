<script setup lang="ts">
import { h, ref, watch } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import DataTable from "@/Components/Table/DataTable.vue";
import { createColumnHelper } from "@tanstack/vue-table";
import { Booking } from "@/types/booking";
import SelectInput from "@/Components/Admin/SelectInput.vue";

const props = defineProps<{
    bookings: Booking[];
}>();

const dataTableRef = ref<{ table: any } | null>(null);
const statusFilter = ref<string>("");

const statusOptions = [
    { value: "", label: "Semua Status" },
    { value: "pending", label: "Menunggu" },
    { value: "confirmed", label: "Dikonfirmasi" },
    { value: "completed", label: "Selesai" },
    { value: "cancelled", label: "Dibatalkan" },
];

watch(statusFilter, (newValue) => {
    if (dataTableRef.value) {
        dataTableRef.value.table.getColumn("status")?.setFilterValue(newValue);
    }
});

const columnHelper = createColumnHelper<Booking>();

const columns = [
    columnHelper.accessor("booking_code", {
        header: "Kode",
        cell: (info) =>
            h(
                "span",
                { class: "font-mono font-bold text-primary" },
                info.getValue(),
            ),
    }),
    columnHelper.accessor("customer_name", {
        header: "Customer",
        cell: (info) =>
            h("div", { class: "flex flex-col" }, [
                h("span", { class: "font-medium" }, info.getValue()),
                h(
                    "span",
                    { class: "text-xs text-secondary" },
                    info.row.original.customer_whatsapp,
                ),
            ]),
    }),
    columnHelper.accessor("field.name", {
        header: "Lapangan",
        cell: (info) => info.getValue() ?? "-",
    }),
    columnHelper.display({
        id: "schedule",
        header: "Jadwal",
        cell: (info) => {
            const date = new Date(info.row.original.play_date);
            const formattedDate = date.toLocaleDateString("id-ID", {
                weekday: "short",
                day: "numeric",
                month: "short",
                year: "numeric",
            });
            return h("div", { class: "flex flex-col" }, [
                h("span", { class: "text-sm" }, formattedDate),
                h(
                    "span",
                    { class: "text-xs font-medium text-secondary" },
                    `${info.row.original.start_time.substring(0, 5)} - ${info.row.original.end_time.substring(0, 5)}`,
                ),
            ]);
        },
    }),
    columnHelper.accessor("total_price", {
        header: "Total",
        cell: (info) =>
            new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR",
                maximumFractionDigits: 0,
            }).format(Number(info.getValue())),
    }),
    columnHelper.accessor("status", {
        header: "Status",
        cell: (info) => {
            const status = info.getValue();
            let colorClass = "bg-gray-100 text-gray-800";
            let label: string = status;

            switch (status) {
                case "pending":
                    colorClass = "bg-yellow-100 text-yellow-800";
                    label = "Menunggu";
                    break;
                case "confirmed":
                    colorClass = "bg-blue-100 text-blue-800";
                    label = "Dikonfirmasi";
                    break;
                case "completed":
                    colorClass = "bg-green-100 text-green-800";
                    label = "Selesai";
                    break;
                case "cancelled":
                    colorClass = "bg-red-100 text-red-800";
                    label = "Dibatalkan";
                    break;
            }

            return h(
                "span",
                {
                    class: `px-2.5 py-1 rounded-full text-xs font-semibold ${colorClass}`,
                },
                label,
            );
        },
    }),
    columnHelper.display({
        id: "actions",
        header: "Aksi",
        cell: ({ row }) =>
            h("div", { class: "flex space-x-3" }, [
                h(
                    "button",
                    {
                        class: "text-primary hover:text-primary/80 font-medium text-sm transition-colors",
                        onClick: () => {
                            // Logic for viewing details (can be a modal or separate page)
                            // For now, let's just log or implement a simple status toggle if needed
                            alert(
                                `Detail booking: ${row.original.booking_code}`,
                            );
                        },
                    },
                    "Detail",
                ),
                row.original.status === "pending"
                    ? h(
                          "button",
                          {
                              class: "text-green-600 hover:text-green-800 font-medium text-sm transition-colors",
                              onClick: () => {
                                  if (confirm("Konfirmasi booking ini?")) {
                                      router.patch(
                                          `/admin/bookings/${row.original.id}/status`,
                                          { status: "confirmed" },
                                      );
                                  }
                              },
                          },
                          "Konfirmasi",
                      )
                    : null,
            ]),
    }),
];
</script>

<template>
    <Head title="Manajemen Booking" />

    <AdminLayout title="Manajemen Booking">
        <div class="p-4 md:p-6">
            <div
                class="bg-white rounded-2xl shadow-sm border border-secondary/10 overflow-hidden"
            >
                <div
                    class="px-6 py-5 border-b border-secondary/10 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white"
                >
                    <div>
                        <h3 class="text-lg font-bold text-dark">
                            Semua Booking
                        </h3>
                        <p class="text-sm text-secondary">
                            Kelola semua pesanan lapangan futsal
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <div class="w-full md:w-48">
                            <SelectInput
                                v-model="statusFilter"
                                :options="statusOptions"
                                placeholder="Filter Status"
                            />
                        </div>
                    </div>
                </div>

                <DataTable
                    ref="dataTableRef"
                    :columns="columns"
                    :data="bookings"
                    :enable-pagination="true"
                    :initial-page-size="10"
                />
            </div>
        </div>
    </AdminLayout>
</template>
