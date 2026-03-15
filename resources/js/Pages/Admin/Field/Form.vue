<script setup lang="ts">
import { ref, onMounted, computed } from "vue";
import { Head, useForm, Link } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import TextInput from "@/Components/Admin/TextInput.vue";
import TextArea from "@/Components/Admin/TextArea.vue";
import SelectInput from "@/Components/Admin/SelectInput.vue";
import Button from "@/Components/Admin/Button.vue";
import { Field } from "@/types/field";

const props = defineProps<{
    field?: Field;
}>();

const isEdit = computed(() => !!props.field);
const title = computed(() =>
    isEdit.value ? "Edit Lapangan" : "Tambah Lapangan",
);
const submitLabel = computed(() =>
    isEdit.value ? "Simpan Perubahan" : "Simpan Lapangan",
);

const form = useForm({
    _method: isEdit.value ? "PUT" : undefined,
    name: "",
    price_per_hour: 0,
    length_m: 0,
    width_m: 0,
    description: "",
    status: "active",
    inactive_reason: "",
    photos: [] as File[],
    deleted_photos: [] as number[],
});

// Initialize form data if in edit mode
onMounted(() => {
    if (props.field) {
        form.name = props.field.name;
        form.price_per_hour = props.field.price_per_hour;
        form.length_m = props.field.length_m;
        form.width_m = props.field.width_m;
        form.description = props.field.description;
        form.status = props.field.status;
        form.inactive_reason = props.field.inactive_reason || "";
    }
});

const photoPreviews = ref<string[]>([]);
const existingPhotos = ref(props.field?.photos || []);

const handleFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement;
    if (target.files) {
        const files = Array.from(target.files);
        form.photos = [...form.photos, ...files];

        files.forEach((file) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                if (e.target?.result) {
                    photoPreviews.value.push(e.target.result as string);
                }
            };
            reader.readAsDataURL(file);
        });

        target.value = "";
    }
};

const removeNewPhoto = (index: number) => {
    form.photos.splice(index, 1);
    photoPreviews.value.splice(index, 1);
};

const removeExistingPhoto = (index: number, photoId: number) => {
    existingPhotos.value.splice(index, 1);
    form.deleted_photos.push(photoId);
};

const submit = () => {
    if (isEdit.value && props.field) {
        form.put(`/admin/fields/${props.field.id}`, {
            forceFormData: true,
        });
    } else {
        form.post("/admin/fields", {
            forceFormData: true,
        });
    }
};

const statusOptions = [
    { value: "active", label: "Aktif" },
    { value: "maintenance", label: "Perbaikan" },
    { value: "inactive", label: "Tidak Aktif" },
];
</script>

<template>
    <Head :title="title" />

    <AdminLayout :title="title">
        <div class="p-4 md:p-6">
            <div
                class="bg-white rounded-lg shadow overflow-hidden max-w-4xl mx-auto"
            >
                <div
                    class="px-6 py-4 border-b border-secondary/20 flex justify-between items-center"
                >
                    <h3 class="text-lg font-semibold text-dark">
                        {{
                            isEdit
                                ? "Form Edit Lapangan"
                                : "Form Tambah Lapangan"
                        }}
                    </h3>
                    <Link
                        href="/admin/fields"
                        class="text-sm text-secondary hover:text-primary"
                    >
                        &larr; Kembali
                    </Link>
                </div>

                <form @submit.prevent="submit" class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <TextInput
                            v-model="form.name"
                            label="Nama Lapangan"
                            placeholder="Contoh: Lapangan A"
                            :error="form.errors.name"
                            required
                        />

                        <TextInput
                            v-model="form.price_per_hour"
                            type="number"
                            label="Harga per Jam (Rp)"
                            placeholder="0"
                            :error="form.errors.price_per_hour"
                            required
                        >
                            <template #prefix>Rp</template>
                        </TextInput>

                        <TextInput
                            v-model="form.length_m"
                            type="number"
                            label="Panjang (Meter)"
                            placeholder="0"
                            step="0.1"
                            :error="form.errors.length_m"
                            required
                        />

                        <TextInput
                            v-model="form.width_m"
                            type="number"
                            label="Lebar (Meter)"
                            placeholder="0"
                            step="0.1"
                            :error="form.errors.width_m"
                            required
                        />

                        <SelectInput
                            v-model="form.status"
                            :options="statusOptions"
                            label="Status"
                            :error="form.errors.status"
                            required
                        />

                        <div
                            v-if="form.status !== 'active'"
                            class="md:col-span-2"
                        >
                            <TextInput
                                v-model="form.inactive_reason"
                                label="Alasan Tidak Aktif"
                                placeholder="Contoh: Sedang dalam perbaikan atap"
                                :error="form.errors.inactive_reason"
                                required
                            />
                        </div>
                    </div>

                    <TextArea
                        v-model="form.description"
                        label="Deskripsi"
                        placeholder="Deskripsi tambahan mengenai lapangan..."
                        :error="form.errors.description"
                        :rows="4"
                    />

                    <div>
                        <label
                            class="block text-sm font-semibold text-dark mb-1.5"
                            >Foto Lapangan</label
                        >

                        <!-- Existing Photos -->
                        <div v-if="existingPhotos.length > 0" class="mb-4">
                            <h4
                                class="text-xs font-medium text-gray-500 mb-2 uppercase tracking-wider"
                            >
                                Foto Saat Ini
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div
                                    v-for="(photo, index) in existingPhotos"
                                    :key="photo.id"
                                    class="relative group"
                                >
                                    <img
                                        :src="'/' + photo.photo_url"
                                        class="h-24 w-full object-cover rounded-lg border border-gray-200"
                                    />
                                    <button
                                        type="button"
                                        @click="
                                            removeExistingPhoto(index, photo.id)
                                        "
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600 transition-colors"
                                        title="Hapus foto"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"
                                            ></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary transition-colors cursor-pointer relative"
                        >
                            <div class="space-y-1 text-center">
                                <svg
                                    class="mx-auto h-12 w-12 text-gray-400"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 48 48"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>
                                <div
                                    class="flex text-sm text-gray-600 justify-center"
                                >
                                    <label
                                        for="file-upload"
                                        class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-primary-dark focus-within:outline-none"
                                    >
                                        <span>Upload file baru</span>
                                        <input
                                            id="file-upload"
                                            name="file-upload"
                                            type="file"
                                            class="sr-only"
                                            multiple
                                            accept="image/*"
                                            @change="handleFileChange"
                                        />
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF up to 2MB
                                </p>
                            </div>
                            <input
                                type="file"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                multiple
                                accept="image/*"
                                @change="handleFileChange"
                            />
                        </div>
                        <p
                            v-if="form.errors.photos"
                            class="mt-2 text-sm text-danger"
                        >
                            {{ form.errors.photos }}
                        </p>

                        <!-- New Photos Preview -->
                        <div v-if="photoPreviews.length > 0" class="mt-4">
                            <h4
                                class="text-xs font-medium text-gray-500 mb-2 uppercase tracking-wider"
                            >
                                Foto Baru
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div
                                    v-for="(preview, index) in photoPreviews"
                                    :key="index"
                                    class="relative group"
                                >
                                    <img
                                        :src="preview"
                                        class="h-24 w-full object-cover rounded-lg border border-gray-200"
                                    />
                                    <button
                                        type="button"
                                        @click="removeNewPhoto(index)"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 shadow hover:bg-red-600 transition-colors"
                                    >
                                        <svg
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"
                                            ></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <Button type="submit" :loading="form.processing">
                            {{ submitLabel }}
                        </Button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
