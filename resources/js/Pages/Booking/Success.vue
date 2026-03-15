<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import Navbar from "../../Components/Navbar.vue";
import { ref } from "vue";
import { Booking } from "../../types/booking";

const props = defineProps<{
    booking: Booking;
    configs?: Record<string, any>;
}>();

const formatCurrency = (value: number | string) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(Number(value));
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString("id-ID", {
        weekday: "long",
        day: "numeric",
        month: "long",
        year: "numeric",
    });
};

const whatsappMessage = `Halo Admin, saya ingin konfirmasi pembayaran booking dengan kode: ${props.booking.booking_code}. Berikut bukti pembayarannya:`;
const whatsappUrl = `https://wa.me/${props.configs?.admin_whatsapp || "628123456789"}?text=${encodeURIComponent(whatsappMessage)}`;

const copied = ref(false);
const copyToClipboard = (text: string) => {
    navigator.clipboard.writeText(text).then(() => {
        copied.value = true;
        setTimeout(() => {
            copied.value = false;
        }, 2000);
    });
};
</script>

<template>
    <Head title="Booking Berhasil" />

    <div class="min-h-screen bg-gray-50 text-dark pb-20 font-sans">
        <Navbar />

        <main class="max-w-2xl mx-auto px-4 mt-12 text-center">
            <div class="mb-10">
                <div
                    class="w-20 h-20 bg-success/10 text-success rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm border border-success/20 relative"
                >
                    <span class="material-symbols-outlined text-4xl"
                        >check_circle</span
                    >
                </div>
                <h1 class="text-3xl font-bold mb-2 tracking-tight text-dark">
                    Booking Berhasil!
                </h1>
                <p class="text-secondary font-medium text-sm">
                    Selesaikan pembayaran untuk mengamankan jadwal Anda.
                </p>
            </div>

            <div
                class="bg-white rounded-xl p-6 md:p-10 text-left space-y-8 shadow-sm border border-gray-200 relative overflow-hidden"
            >
                <!-- Order Summary Header -->
                <div class="flex justify-between items-start">
                    <div>
                        <p
                            class="text-[10px] font-bold text-secondary uppercase tracking-wider mb-1"
                        >
                            Kode Booking
                        </p>
                        <p
                            class="text-xl font-bold text-primary tracking-tight"
                        >
                            {{ booking.booking_code }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span
                            class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-warning/10 text-warning border border-warning/20 capitalize"
                        >
                            <span
                                class="w-2 h-2 bg-warning rounded-full mr-2"
                            ></span>
                            {{ booking.status }}
                        </span>
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6 border-y border-gray-100"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="p-2.5 bg-gray-50 rounded-xl border border-gray-100"
                        >
                            <span
                                class="material-symbols-outlined text-secondary/60 text-xl"
                                >stadium</span
                            >
                        </div>
                        <div>
                            <p
                                class="text-[10px] font-bold text-secondary uppercase"
                            >
                                Lapangan
                            </p>
                            <p class="font-bold text-dark text-sm">
                                {{ booking.field?.name }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div
                            class="p-2.5 bg-gray-50 rounded-xl border border-gray-100"
                        >
                            <span
                                class="material-symbols-outlined text-secondary/60 text-xl"
                                >calendar_month</span
                            >
                        </div>
                        <div>
                            <p
                                class="text-[10px] font-bold text-secondary uppercase"
                            >
                                Tanggal
                            </p>
                            <p class="font-bold text-dark text-sm">
                                {{ formatDate(booking.play_date) }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div
                            class="p-2.5 bg-gray-50 rounded-xl border border-gray-100"
                        >
                            <span
                                class="material-symbols-outlined text-secondary/60 text-xl"
                                >schedule</span
                            >
                        </div>
                        <div>
                            <p
                                class="text-[10px] font-bold text-secondary uppercase"
                            >
                                Waktu
                            </p>
                            <p class="font-bold text-dark text-sm">
                                {{ booking.start_time.substring(0, 5) }} -
                                {{ booking.end_time.substring(0, 5) }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div
                            class="p-2.5 bg-gray-50 rounded-xl border border-gray-100"
                        >
                            <span
                                class="material-symbols-outlined text-secondary/60 text-xl"
                                >payments</span
                            >
                        </div>
                        <div>
                            <p
                                class="text-[10px] font-bold text-secondary uppercase"
                            >
                                Metode
                            </p>
                            <p class="font-bold text-dark text-sm">
                                {{
                                    booking.payment_method === "transfer"
                                        ? "Transfer Bank"
                                        : "Bayar di Tempat"
                                }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-secondary font-medium"
                            >Total Harga</span
                        >
                        <span class="text-lg font-bold text-dark">{{
                            formatCurrency(booking.total_price)
                        }}</span>
                    </div>
                    <div
                        class="flex justify-between items-center p-4 bg-primary/5 rounded-xl border border-primary/10"
                    >
                        <span
                            class="text-primary font-bold uppercase text-[10px] tracking-wider"
                            >Wajib Bayar DP ({{
                                booking.dp_percentage_snapshot
                            }}%)</span
                        >
                        <span class="text-xl font-bold text-primary">{{
                            formatCurrency(booking.dp_amount)
                        }}</span>
                    </div>
                </div>

                <!-- Payment Info (Only for Transfer) -->
                <div
                    v-if="booking.payment_method === 'transfer'"
                    class="bg-gray-50 rounded-xl p-6 md:p-8 space-y-6 border border-gray-200"
                >
                    <h3
                        class="font-bold text-dark text-base flex items-center gap-3"
                    >
                        <span class="material-symbols-outlined text-primary"
                            >account_balance</span
                        >
                        Instruksi Transfer
                    </h3>

                    <div class="space-y-4">
                        <div
                            class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm"
                        >
                            <div class="flex justify-between items-start mb-4">
                                <p
                                    class="text-[10px] text-secondary font-bold uppercase tracking-wider"
                                >
                                    {{ configs?.bank_name || "BANK BCA" }}
                                </p>
                                <span
                                    class="material-symbols-outlined text-gray-300"
                                    >contactless</span
                                >
                            </div>
                            <div
                                class="flex items-center justify-between gap-4 mb-2"
                            >
                                <p
                                    class="text-2xl font-bold text-dark tracking-tight"
                                >
                                    {{
                                        configs?.bank_account_number ||
                                        "1234 5678 90"
                                    }}
                                </p>
                                <button
                                    @click="
                                        copyToClipboard(
                                            configs?.bank_account_number ||
                                                '1234 5678 90',
                                        )
                                    "
                                    class="text-primary text-[10px] font-bold hover:underline uppercase tracking-wider flex items-center gap-1"
                                >
                                    <span
                                        v-if="copied"
                                        class="material-symbols-outlined text-xs"
                                        >done</span
                                    >
                                    {{ copied ? "Berhasil" : "Salin" }}
                                </button>
                            </div>
                            <div class="pt-3 border-t border-gray-100 mt-3">
                                <p
                                    class="text-[9px] text-secondary font-bold uppercase mb-0.5 tracking-wider"
                                >
                                    Atas Nama
                                </p>
                                <p class="text-sm font-bold text-dark">
                                    {{
                                        configs?.bank_account_name ||
                                        "Admin Futsal"
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <p
                        class="text-[10px] text-secondary leading-relaxed italic"
                    >
                        *Mohon lampirkan bukti transfer saat melakukan
                        konfirmasi melalui WhatsApp agar pesanan segera
                        diproses.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col gap-3">
                    <a
                        :href="whatsappUrl"
                        target="_blank"
                        class="w-full bg-[#25D366] hover:opacity-90 text-white font-bold py-4 rounded-lg transition-all active:scale-[0.98] flex items-center justify-center gap-3 text-base"
                    >
                        <span class="material-symbols-outlined text-xl"
                            >chat</span
                        >
                        Konfirmasi WhatsApp
                    </a>
                    <Link
                        href="/"
                        class="w-full bg-white hover:bg-gray-50 text-secondary font-semibold py-4 rounded-lg border border-gray-200 transition-all flex items-center justify-center gap-3 text-sm"
                    >
                        <span class="material-symbols-outlined text-lg"
                            >home</span
                        >
                        Kembali ke Beranda
                    </Link>
                </div>
            </div>
        </main>
    </div>
</template>
