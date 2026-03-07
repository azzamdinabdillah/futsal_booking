<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import { ref, computed, watch } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, Pagination } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/pagination';

interface Field {
    id: number;
    name: string;
    price: string | number;
    location: string;
    type: string;
    size: string;
    photos: string[];
    [key: string]: any;
}

interface Booking {
    field_id: number;
    start: string;
    end: string;
    [key: string]: any;
}

const props = withDefaults(defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    fields?: Field[];
    initialBookings?: Booking[];
    initialDate?: string;
}>(), {
    fields: () => [],
    initialBookings: () => [],
});

const modules = [Autoplay, Pagination];

// State for Schedule Section
const selectedDate = ref<string>(props.initialDate || new Date().toISOString().split('T')[0]);
const selectedField = ref<Field | null>(props.fields.length > 0 ? props.fields[0] : null);
const isLoading = ref<boolean>(false);

// Watch for date changes to fetch new bookings
watch(selectedDate, (newDate) => {
    isLoading.value = true;
    router.get('/', { date: newDate }, {
        preserveState: true,
        preserveScroll: true,
        only: ['initialBookings', 'initialDate'],
        onFinish: () => {
            isLoading.value = false;
        }
    });
});

const formattedDate = computed<string>(() => {
    if (!selectedDate.value) return 'Pilih Tanggal';
    const date = new Date(selectedDate.value);
    return date.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
});

// Get booked slots for the selected field
const bookedSlots = computed<string[]>(() => {
    if (!selectedField.value || !props.initialBookings) return [];
    
    // Filter bookings for current field
    return props.initialBookings
        .filter(booking => booking.field_id === selectedField.value!.id)
        .map(booking => `${booking.start} - ${booking.end}`)
        .sort();
});

</script>

<template>
    <Head>
        <title>Beranda</title>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    </Head>

    <div class="min-h-screen relative font-sans">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img 
                :src="'/assets/images/futsal-1.jpg'" 
                alt="Lapangan Futsal" 
                class="w-full h-full object-cover"
            />
            <div class="absolute inset-0 bg-black/60"></div>
        </div>

        <!-- Navigation -->
        <Navbar />

        <!-- Hero Content -->
        <div class="relative z-10 flex flex-col items-center justify-center min-h-[calc(100vh-64px)] px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-3xl w-full">
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white tracking-tight mb-6 drop-shadow-lg">
                    Selamat Datang di <span class="text-indigo-400">Premier Futsal Arena</span>
                </h1>
                
                <p class="mt-4 text-xl text-gray-200 max-w-2xl mx-auto drop-shadow-md">
                    Lapangan berkualitas, fasilitas lengkap, dan harga bersahabat. Booking jadwal main futsal Anda sekarang juga!
                </p>

                <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                    <Link
                        href="/bookings/create"
                        class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:text-lg transition-all transform hover:scale-105 shadow-lg"
                    >
                        Booking Sekarang
                    </Link>
                    <Link
                        href="#lokasi"
                        class="inline-flex items-center justify-center px-8 py-3 border border-white/30 backdrop-blur-sm text-base font-medium rounded-md text-white hover:bg-white/10 md:text-lg transition-all shadow-lg"
                    >
                        Lihat Lokasi
                    </Link>
                </div>
            </div>

            <!-- Simple Location Info -->
            <div id="lokasi" class="mt-16 text-white/90">
                <p class="text-sm uppercase tracking-widest text-indigo-400 font-semibold mb-2">Lokasi Kami</p>
                <p class="text-lg font-medium">Jl. Panglima Sudirman Pandean Gg. II No. 7-9 Kel, Setono Pande, Kec. Kota, Kota Kediri, Jawa Timur 64126</p>
            </div>
        </div>
    </div>
    
    <!-- Schedule Section -->
    <div id="jadwal" class="bg-[#f6f8f7] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-[#1a472a]">Jadwal Lapangan</h2>
            </div>

            <!-- Field Tabs -->
            <div class="mb-6 overflow-x-auto pb-2 no-scrollbar">
                <div class="flex gap-4 min-w-max">
                    <button 
                        v-for="field in fields" 
                        :key="field.id"
                        @click="selectedField = field"
                        class="flex items-center cursor-pointer gap-2 px-6 py-2.5 rounded-full transition-all whitespace-nowrap border"
                        :class="selectedField?.id === field.id 
                            ? 'bg-[#1a472a] text-white border-[#1a472a]' 
                            : 'bg-white text-slate-500 border-slate-200 hover:border-[#1a472a]/50'"
                    >
                        <span class="material-symbols-outlined text-lg">sports_soccer</span>
                        <span class="text-sm font-bold uppercase tracking-wider">{{ field.name }}</span>
                    </button>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden" v-if="selectedField">
                <div class="flex flex-col md:flex-row">
                    <!-- Image Section -->
                    <div class="w-full md:w-1/3 h-64 md:h-auto relative group">
                        <swiper
                            :modules="modules"
                            :slides-per-view="1"
                            :space-between="0"
                            :autoplay="{ delay: 3000, disableOnInteraction: false }"
                            :pagination="{ clickable: true }"
                            :loop="true"
                            class="w-full h-full"
                        >
                            <swiper-slide v-for="(photo, index) in selectedField.photos" :key="index">
                                <img 
                                    :src="photo"
                                    :alt="`${selectedField.name} - Foto ${index + 1}`"
                                    class="w-full h-full object-cover"
                                />
                            </swiper-slide>
                        </swiper>
                        <div class="absolute top-4 left-4 bg-[#bef264] text-[#1a472a] px-3 py-1 rounded-lg text-xs font-bold shadow-sm flex items-center gap-1 z-10">
                            <span class="material-symbols-outlined text-sm">star</span> 4.8
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="flex-1 p-6 flex flex-col gap-6">
                        <!-- Top Info -->
                        <div class="flex flex-col gap-6">
                            <div class="flex justify-between items-start">
                                <h3 class="text-2xl sm:text-3xl font-bold text-[#1a472a] leading-tight">{{ selectedField.name }}</h3>
                                <div class="text-right shrink-0 flex items-center gap-1">
                                    <p class="text-2xl sm:text-3xl font-black text-[#050505]">{{ selectedField.price }}</p>
                                    <p class="text-sm font-medium text-slate-500">/ Jam</p>
                                </div>
                            </div>

                            <div class="flex gap-3 flex-wrap">
                                <div class="flex items-center gap-1.5 px-2 py-1.5 sm:gap-2 sm:px-3 sm:py-2 bg-slate-50 rounded-lg border border-slate-100 w-fit">
                                    <span class="material-symbols-outlined text-[#1a472a] text-sm sm:text-base">location_on</span> 
                                    <span class="font-semibold text-[#1a472a] capitalize text-xs sm:text-sm">{{ selectedField.location }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 px-2 py-1.5 sm:gap-2 sm:px-3 sm:py-2 bg-slate-50 rounded-lg border border-slate-100 w-fit">
                                    <span class="material-symbols-outlined text-[#1a472a] text-sm sm:text-base">grass</span> 
                                    <span class="font-semibold text-[#1a472a] capitalize text-xs sm:text-sm">{{ selectedField.type }}</span>
                                </div>
                                <div class="flex items-center gap-1.5 px-2 py-1.5 sm:gap-2 sm:px-3 sm:py-2 bg-slate-50 rounded-lg border border-slate-100 w-fit">
                                    <span class="material-symbols-outlined text-[#1a472a] text-sm sm:text-base">aspect_ratio</span> 
                                    <span class="font-semibold text-[#1a472a] text-xs sm:text-sm">{{ selectedField.size }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="border-t border-slate-100"></div> -->

                        <!-- Date Picker -->
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-[#1a472a]">Pilih Tanggal Main</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-[#1a472a]">
                                    <span v-if="!isLoading" class="material-symbols-outlined">calendar_month</span>
                                    <div v-else class="w-5 h-5 border-2 border-[#1a472a] border-t-transparent rounded-full animate-spin"></div>
                                </div>
                                <input 
                                    type="date" 
                                    v-model="selectedDate" 
                                    :disabled="isLoading"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-[#1a472a]/20 focus:border-[#1a472a] text-[#1a472a] font-bold transition-all hover:border-[#1a472a]/50 cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed"
                                />
                            </div>
                        </div>

                        <!-- Slots -->
                            <div class="relative min-h-[100px]">
                                <!-- Loading Overlay -->
                                <div v-if="isLoading" class="absolute inset-0 z-20 bg-white/60 backdrop-blur-[1px] flex items-center justify-center rounded-xl transition-all duration-300">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-8 h-8 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin text-indigo-600"></div>
                                        <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest animate-pulse">Memuat Jadwal...</span>
                                    </div>
                                </div>

                                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3 flex items-center flex-wrap gap-2">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                        Slot Terisi (Booked) {{ selectedDate }} 
                                    </div>

                                    <span v-if="selectedDate === new Date().toISOString().split('T')[0]" class="md:ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-indigo-100 text-indigo-800">Hari Ini</span>
                                </h4>
                                <div v-if="bookedSlots.length > 0" class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                    <div 
                                        v-for="slot in bookedSlots" 
                                        :key="slot"
                                        class="px-2 py-2 rounded border text-center text-xs font-bold transition-all bg-red-50 border-red-100 text-red-500 cursor-not-allowed opacity-60 decoration-red-500 line-through"
                                    >
                                        {{ slot }}
                                    </div>
                                </div>
                                <div v-else class="text-slate-500 text-sm italic bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    Belum ada booking pada tanggal ini. Semua slot tersedia.
                                </div>
                                <p class="text-[10px] text-slate-400 mt-2">* Slot selain di atas tersedia untuk dibooking.</p>
                            </div>

                        <!-- Action Button -->
                        <button class="w-full bg-[#bef264] hover:bg-[#a8e063] text-[#1a472a] font-bold py-3.5 rounded-xl shadow-lg shadow-[#bef264]/20 transition-transform active:scale-[0.98] flex items-center justify-center gap-2 text-lg">
                            <span class="material-symbols-outlined">shopping_cart</span>
                            Booking Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
:deep(.swiper-pagination-bullet) {
    background-color: rgba(255, 255, 255, 0.5);
    width: 8px;
    height: 8px;
    transition: all 0.3s ease;
}

:deep(.swiper-pagination-bullet-active) {
    background-color: #bef264;
    width: 24px;
    border-radius: 9999px;
}

/* Custom Scrollbar for Schedule List */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #c7c7c7;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
