<script setup lang="ts">
import { h, ref } from 'vue'
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import DataTable from '@/Components/Table/DataTable.vue'
import { createColumnHelper } from '@tanstack/vue-table'
import { Field, FieldPhoto } from '@/types/field'
import VueEasyLightbox from 'vue-easy-lightbox'

const props = defineProps<{
    fields: Field[]
}>()

const visibleRef = ref(false)
const indexRef = ref(0)
const imgsRef = ref<string[]>([])

const showImg = (index: number, photos: FieldPhoto[]) => {
    imgsRef.value = photos.map(photo => '/' + photo.photo_url)
    indexRef.value = index
    visibleRef.value = true
}

const onHide = () => visibleRef.value = false

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
        cell: info => {
            const status = info.getValue()
            let colorClass = 'bg-gray-100 text-gray-800'
            let label = status

            if (status === 'active') {
                colorClass = 'bg-green-100 text-green-800'
                label = 'Aktif'
            } else if (status === 'maintenance') {
                colorClass = 'bg-yellow-100 text-yellow-800'
                label = 'Perbaikan'
            } else if (status === 'inactive') {
                colorClass = 'bg-red-100 text-red-800'
                label = 'Tidak Aktif'
            }

            return h('span', {
                class: `px-2 py-1 rounded-full text-xs font-semibold ${colorClass}`
            }, label)
        },
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
                    photos.map((photo, index) => h('img', { 
                        src: '/' + photo.photo_url, 
                        alt: 'Field Photo',
                        class: 'w-10 h-10 object-cover rounded border border-gray-200 cursor-pointer hover:opacity-80 transition',
                        onClick: () => showImg(index, photos)
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
                    <Link href="/admin/fields/create" class="bg-primary text-white hover:opacity-90 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        + Tambah Lapangan
                    </Link>
                </div>
                
                <DataTable :columns="columns" :data="fields" />
            </div>
        </div>

        <VueEasyLightbox
            :visible="visibleRef"
            :imgs="imgsRef"
            :index="indexRef"
            @hide="onHide"
            :loop="true"
        />
    </AdminLayout>
</template>

<style scoped>
:deep(.vel-modal) {
    background-color: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
}
</style>
