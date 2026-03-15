<script setup lang="ts">
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import Navbar from "../../Components/Navbar.vue";
import { ref, computed, watch } from "vue";
import { Field } from "../../types/field";

const props = defineProps<{
    fields: Field[];
    selectedFieldId?: number;
    selectedDate?: string;
    bookings?: any[];
    configs?: Record<string, any>;
}>();

const form = useForm({
    field_id:
        props.selectedFieldId ||
        (props.fields.length > 0 ? props.fields[0].id : null),
    customer_name: "",
    customer_whatsapp: "",
    customer_email: "",
    play_date: props.selectedDate || new Date().toISOString().split("T")[0],
    start_time: "08:00",
    end_time: "09:00",
    payment_method: "transfer",
    policy_agreed: false,
});

const selectedField = computed(() =>
    props.fields.find((f) => f.id === form.field_id),
);

const durationHours = computed(() => {
    if (!form.start_time || !form.end_time) return 0;
    const start = new Date(`2000-01-01T${form.start_time}`);
    const end = new Date(`2000-01-01T${form.end_time}`);
    const diff = (end.getTime() - start.getTime()) / (1000 * 60 * 60);
    return diff > 0 ? diff : 0;
});

const totalPrice = computed(() => {
    if (!selectedField.value) return 0;
    return durationHours.value * selectedField.value.price_per_hour;
});

const dpPercentage = computed(() =>
    parseFloat(props.configs?.dp_percentage || "30"),
);

const dpAmount = computed(() => (dpPercentage.value / 100) * totalPrice.value);

const remainingAmount = computed(() => totalPrice.value - dpAmount.value);

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(value);
};

const submit = () => {
    form.post("/booking", {
        onSuccess: () => {
            // Success logic handled by controller redirect
        },
    });
};

// Generate time slots (08:00 to 23:00)
const timeSlots = Array.from({ length: 16 }, (_, i) => {
    const hour = (i + 8).toString().padStart(2, "0");
    return `${hour}:00`;
});

// Watch for date/field changes to update availability if needed
watch([() => form.play_date, () => form.field_id], () => {
    router.get(
        "/booking/create",
        {
            field_id: form.field_id,
            date: form.play_date,
        },
        {
            preserveState: true,
            preserveScroll: true,
            only: ["bookings"],
        },
    );
});

const isSlotBooked = (time: string) => {
    if (!props.bookings) return false;
    return props.bookings.some((b) => {
        const start = b.start_time.substring(0, 5);
        const end = b.end_time.substring(0, 5);
        return time >= start && time < end;
    });
};
</script>

<template>
    <Head title="Booking Lapangan" />

    <div class="min-h-screen bg-gray-50 text-dark pb-20 font-sans">
        <!-- Header / Navbar -->
        <Navbar />

        <main class="max-w-5xl mx-auto px-4 mt-8">
            <div class="flex items-center gap-4 mb-8">
                <Link
                    href="/"
                    class="p-2 bg-white hover:bg-gray-100 rounded-lg transition-all shadow-sm border border-gray-200"
                >
                    <span
                        class="material-symbols-outlined text-secondary text-xl"
                        >arrow_back</span
                    >
                </Link>
                <h1 class="text-2xl font-bold tracking-tight text-dark">
                    Form Booking Lapangan
                </h1>
            </div>

            <form
                @submit.prevent="submit"
                class="grid grid-cols-1 lg:grid-cols-12 gap-6"
            >
                <!-- Left: Booking Form -->
                <div class="lg:col-span-8 space-y-6">
                    <section
                        class="bg-white rounded-xl p-6 md:p-8 shadow-sm border border-gray-200"
                    >
                        <h2
                            class="text-lg font-bold flex items-center gap-3 text-dark mb-6 border-b border-gray-100 pb-4"
                        >
                            <span class="material-symbols-outlined text-primary"
                                >sports_soccer</span
                            >
                            Informasi Lapangan
                        </h2>

                        <div class="space-y-6">
                            <div>
                                <label
                                    class="block text-sm font-semibold text-secondary mb-2"
                                    >Pilih Lapangan</label
                                >
                                <select
                                    v-model="form.field_id"
                                    class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium text-dark"
                                >
                                    <option
                                        v-for="field in fields"
                                        :key="field.id"
                                        :value="field.id"
                                    >
                                        {{ field.name }} —
                                        {{
                                            formatCurrency(field.price_per_hour)
                                        }}
                                        / Jam
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.field_id"
                                    class="text-danger text-xs mt-1.5 font-medium"
                                >
                                    {{ form.errors.field_id }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="md:col-span-1">
                                    <label
                                        class="block text-sm font-semibold text-secondary mb-2"
                                        >Tanggal Main</label
                                    >
                                    <input
                                        type="date"
                                        v-model="form.play_date"
                                        class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium text-dark"
                                    />
                                    <div
                                        v-if="form.errors.play_date"
                                        class="text-danger text-xs mt-1.5 font-medium"
                                    >
                                        {{ form.errors.play_date }}
                                    </div>
                                </div>

                                <div
                                    class="md:col-span-2 grid grid-cols-2 gap-4"
                                >
                                    <div>
                                        <label
                                            class="block text-sm font-semibold text-secondary mb-2"
                                            >Jam Mulai</label
                                        >
                                        <select
                                            v-model="form.start_time"
                                            class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium text-dark"
                                        >
                                            <option
                                                v-for="slot in timeSlots"
                                                :key="slot"
                                                :value="slot"
                                                :disabled="isSlotBooked(slot)"
                                            >
                                                {{ slot }}
                                                {{
                                                    isSlotBooked(slot)
                                                        ? "(Penuh)"
                                                        : ""
                                                }}
                                            </option>
                                        </select>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-semibold text-secondary mb-2"
                                            >Jam Selesai</label
                                        >
                                        <select
                                            v-model="form.end_time"
                                            class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium text-dark"
                                        >
                                            <option
                                                v-for="slot in timeSlots"
                                                :key="slot"
                                                :value="slot"
                                            >
                                                {{ slot }}
                                            </option>
                                        </select>
                                    </div>
                                    <div
                                        v-if="
                                            form.errors.start_time ||
                                            form.errors.end_time
                                        "
                                        class="col-span-2 text-danger text-xs font-medium"
                                    >
                                        {{
                                            form.errors.start_time ||
                                            form.errors.end_time
                                        }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section
                        class="bg-white rounded-xl p-6 md:p-8 shadow-sm border border-gray-200"
                    >
                        <h2
                            class="text-lg font-bold flex items-center gap-3 text-dark mb-6 border-b border-gray-100 pb-4"
                        >
                            <span class="material-symbols-outlined text-primary"
                                >person</span
                            >
                            Data Pemesan
                        </h2>

                        <div class="space-y-6">
                            <div>
                                <label
                                    class="block text-sm font-semibold text-secondary mb-2"
                                    >Nama Lengkap</label
                                >
                                <input
                                    type="text"
                                    v-model="form.customer_name"
                                    placeholder="Masukkan nama lengkap"
                                    class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium text-dark placeholder:text-gray-400"
                                />
                                <div
                                    v-if="form.errors.customer_name"
                                    class="text-danger text-xs mt-1.5 font-medium"
                                >
                                    {{ form.errors.customer_name }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-secondary mb-2"
                                        >Nomor WhatsApp</label
                                    >
                                    <input
                                        type="tel"
                                        v-model="form.customer_whatsapp"
                                        placeholder="0812xxxx"
                                        class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium text-dark placeholder:text-gray-400"
                                    />
                                    <div
                                        v-if="form.errors.customer_whatsapp"
                                        class="text-danger text-xs mt-1.5 font-medium"
                                    >
                                        {{ form.errors.customer_whatsapp }}
                                    </div>
                                </div>
                                <div>
                                    <label
                                        class="block text-sm font-semibold text-secondary mb-2"
                                        >Alamat Email</label
                                    >
                                    <input
                                        type="email"
                                        v-model="form.customer_email"
                                        placeholder="email@contoh.com"
                                        class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all font-medium text-dark placeholder:text-gray-400"
                                    />
                                    <div
                                        v-if="form.errors.customer_email"
                                        class="text-danger text-xs mt-1.5 font-medium"
                                    >
                                        {{ form.errors.customer_email }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section
                        class="bg-white rounded-xl p-6 md:p-8 shadow-sm border border-gray-200"
                    >
                        <h2
                            class="text-lg font-bold flex items-center gap-3 text-dark mb-6 border-b border-gray-100 pb-4"
                        >
                            <span class="material-symbols-outlined text-primary"
                                >payments</span
                            >
                            Metode Pembayaran
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label
                                class="relative flex items-center gap-4 p-4 rounded-lg border cursor-pointer transition-all"
                                :class="
                                    form.payment_method === 'transfer'
                                        ? 'bg-primary/5 border-primary ring-1 ring-primary'
                                        : 'bg-white border-gray-300 hover:border-gray-400'
                                "
                            >
                                <input
                                    type="radio"
                                    v-model="form.payment_method"
                                    value="transfer"
                                    class="w-4 h-4 text-primary focus:ring-primary"
                                />
                                <div class="flex items-center gap-3">
                                    <span
                                        class="material-symbols-outlined text-secondary"
                                        >account_balance</span
                                    >
                                    <span class="font-bold text-dark"
                                        >Transfer Bank</span
                                    >
                                </div>
                            </label>
                            <label
                                class="relative flex items-center gap-4 p-4 rounded-lg border cursor-pointer transition-all"
                                :class="
                                    form.payment_method === 'cash'
                                        ? 'bg-primary/5 border-primary ring-1 ring-primary'
                                        : 'bg-white border-gray-300 hover:border-gray-400'
                                "
                            >
                                <input
                                    type="radio"
                                    v-model="form.payment_method"
                                    value="cash"
                                    class="w-4 h-4 text-primary focus:ring-primary"
                                />
                                <div class="flex items-center gap-3">
                                    <span
                                        class="material-symbols-outlined text-secondary"
                                        >payments</span
                                    >
                                    <span class="font-bold text-dark"
                                        >Bayar di Tempat</span
                                    >
                                </div>
                            </label>
                        </div>
                        <div
                            v-if="form.errors.payment_method"
                            class="text-danger text-xs mt-3 font-medium"
                        >
                            {{ form.errors.payment_method }}
                        </div>
                    </section>
                </div>

                <!-- Right: Summary -->
                <div class="lg:col-span-4">
                    <div
                        class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 sticky top-24 space-y-6"
                    >
                        <h2
                            class="text-lg font-bold flex items-center gap-3 text-dark border-b border-gray-100 pb-4"
                        >
                            <span class="material-symbols-outlined text-primary"
                                >receipt_long</span
                            >
                            Ringkasan Booking
                        </h2>

                        <div class="space-y-4">
                            <div
                                class="flex justify-between items-center text-sm"
                            >
                                <span class="text-secondary font-medium"
                                    >Durasi Bermain</span
                                >
                                <span class="text-dark font-bold"
                                    >{{ durationHours }} Jam</span
                                >
                            </div>
                            <div
                                class="flex justify-between items-center text-sm"
                            >
                                <span class="text-secondary font-medium"
                                    >Harga / Jam</span
                                >
                                <span class="text-dark font-bold">{{
                                    formatCurrency(
                                        selectedField?.price_per_hour || 0,
                                    )
                                }}</span>
                            </div>

                            <div class="pt-4 border-t border-gray-100">
                                <div
                                    class="flex justify-between items-center mb-1"
                                >
                                    <span class="text-dark font-bold"
                                        >Total Harga</span
                                    >
                                    <span
                                        class="text-xl font-bold text-primary"
                                        >{{ formatCurrency(totalPrice) }}</span
                                    >
                                </div>
                            </div>

                            <div
                                class="bg-gray-50 rounded-lg p-4 space-y-2 border border-gray-200"
                            >
                                <div
                                    class="flex justify-between items-center text-sm"
                                >
                                    <span class="text-secondary font-bold"
                                        >Wajib DP ({{ dpPercentage }}%)</span
                                    >
                                    <span class="text-warning font-bold">{{
                                        formatCurrency(dpAmount)
                                    }}</span>
                                </div>
                                <div
                                    class="flex justify-between items-center text-xs text-secondary border-t border-gray-200 pt-2"
                                >
                                    <span>Sisa Pembayaran</span>
                                    <span>{{
                                        formatCurrency(remainingAmount)
                                    }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4 pt-2">
                            <label
                                class="flex items-start gap-3 cursor-pointer group"
                            >
                                <input
                                    type="checkbox"
                                    v-model="form.policy_agreed"
                                    class="mt-1 w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary"
                                />
                                <span
                                    class="text-xs text-secondary leading-normal group-hover:text-dark transition-colors"
                                >
                                    Saya menyetujui kebijakan dan peraturan
                                    booking yang berlaku.
                                </span>
                            </label>
                            <div
                                v-if="form.errors.policy_agreed"
                                class="text-danger text-xs font-medium"
                            >
                                {{ form.errors.policy_agreed }}
                            </div>

                            <button
                                type="submit"
                                :disabled="
                                    form.processing || !form.policy_agreed
                                "
                                class="w-full bg-primary hover:opacity-90 disabled:opacity-50 disabled:cursor-not-allowed text-white font-bold py-4 rounded-lg shadow-sm transition-all active:scale-[0.98] flex items-center justify-center gap-2 text-base"
                            >
                                <span
                                    v-if="form.processing"
                                    class="animate-spin material-symbols-outlined text-xl"
                                    >sync</span
                                >
                                <span
                                    v-else
                                    class="material-symbols-outlined text-xl"
                                    >shopping_cart</span
                                >
                                {{
                                    form.processing
                                        ? "Memproses..."
                                        : "Konfirmasi Booking"
                                }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</template>

<style scoped>
/* Custom styles if needed */
input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1);
}
</style>
