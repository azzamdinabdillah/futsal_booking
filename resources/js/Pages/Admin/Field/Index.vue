<script setup lang="ts">
import { h } from 'vue'
import { Head } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Table/DataTable.vue'
import { createColumnHelper } from '@tanstack/vue-table'

// Define the Field type based on the model
type FieldPhoto = {
    id: number
    field_id: number
    photo_url: string
    sort_order: number
}

type Field = {
    id: number
    name: string
    price_per_hour: number
    length_m: number
    width_m: number
    surface_type: string
    roof_type: string
    player_capacity: string
    description: string
    status: string
    inactive_reason: string | null
    photos: FieldPhoto[]
}

const props = defineProps<{
    fields: Field[]
}>()

const columnHelper = createColumnHelper<Field>()

const columns = [
    columnHelper.accessor('name', {
        header: 'Nama Lapangan',
        cell: info => h('span', { class: 'font-medium' }, info.getValue()),
    }),
    columnHelper.accessor('price_per_hour', {
        header: 'Harga / Jam',
        cell: info => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(info.getValue()),
    }),
    columnHelper.accessor('surface_type', {
        header: 'Jenis Lantai',
        cell: info => info.getValue(),
    }),
    columnHelper.accessor('roof_type', {
        header: 'Jenis Atap',
        cell: info => info.getValue(),
    }),
    columnHelper.accessor('status', {
        header: 'Status',
        cell: info => h('span', {
            class: `px-2 py-1 rounded-full text-xs font-semibold ${
                info.getValue() === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
            }`
        }, info.getValue() === 'active' ? 'Aktif' : 'Tidak Aktif'),
    }),
    columnHelper.display({
        id: 'dimensions',
        header: 'Dimensi',
        cell: info => `${info.row.original.length_m}m x ${info.row.original.width_m}m`
    }),
    columnHelper.accessor('player_capacity', {
        header: 'Kapasitas',
        cell: info => info.getValue(),
    }),
    columnHelper.accessor('photos', {
        header: 'Foto',
        cell: info => {
            const photos = info.getValue()
            if (photos && photos.length > 0) {
                return h('div', { class: 'flex space-x-1' }, 
                    photos.map(photo => h('img', { 
                        src: '/' + photo.photo_url, 
                        alt: 'Field Photo',
                        class: 'w-10 h-10 object-cover rounded border border-gray-200'
                    }))
                )
            }
            return h('span', { class: 'text-gray-400 italic' }, 'Tidak ada foto')
        }
    }),
]
</script>

<template>
    <Head title="Manajemen Lapangan" />

    <AdminLayout title="Manajemen Lapangan">
        <div class="p-4 md:p-6">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-secondary/20 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-dark">Daftar Lapangan</h3>
                </div>
                
                <DataTable :columns="columns" :data="fields" />
            </div>
        </div>
    </AdminLayout>
</template>
