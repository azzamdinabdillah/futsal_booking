<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';
import { ref, computed } from 'vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});

// State for Schedule Section
const selectedDate = ref(new Date().toISOString().split('T')[0]);

// Dummy data for fields
const fields = ref([
    {
        id: 1,
        name: 'Lapangan A',
        type: 'Rumput Sintetis',
        location: 'Indoor',
        size: '5v5',
        price: 'Rp 100.000 / jam',
        image: '/assets/images/futsal-1.jpg',
        bookings: [
            { start: '09:00', end: '11:00' },
            { start: '13:00', end: '14:00' },
            { start: '17:00', end: '20:00' },
        ]
    },
    {
        id: 2,
        name: 'Lapangan B',
        type: 'Matras Interlock',
        location: 'Indoor',
        size: '5v5',
        price: 'Rp 120.000 / jam',
        image: '/assets/images/futsal-1.jpg',
        bookings: [
            { start: '10:00', end: '12:00' },
            { start: '15:00', end: '16:00' },
        ]
    },
    {
        id: 3,
        name: 'Lapangan C',
        type: 'Rumput Sintetis',
        location: 'Outdoor',
        size: '7v7',
        price: 'Rp 150.000 / jam',
        image: '/assets/images/futsal-1.jpg',
        bookings: []
    },
    {
        id: 4,
        name: 'Lapangan D',
        type: 'Vinyl',
        location: 'Indoor',
        size: '5v5',
        price: 'Rp 110.000 / jam',
        image: '/assets/images/futsal-1.jpg',
        bookings: [
            { start: '19:00', end: '21:00' }
        ]
    },
    {
        id: 5,
        name: 'Lapangan E',
        type: 'Rumput Sintetis',
        location: 'Indoor',
        size: '5v5',
        price: 'Rp 100.000 / jam',
        image: '/assets/images/futsal-1.jpg',
        bookings: [
            { start: '16:00', end: '18:00' }
        ]
    }
]);

const formattedDate = computed(() => {
    if (!selectedDate.value) return 'Pilih Tanggal';
    const date = new Date(selectedDate.value);
    return date.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
});

const selectedField = ref(fields.value[0]);

const generateSlots = () => {
    const slots = [];
    for (let i = 8; i < 23; i++) {
        const start = i < 10 ? `0${i}:00` : `${i}:00`;
        const end = (i + 1) < 10 ? `0${i + 1}:00` : `${i + 1}:00`;
        slots.push(`${start} - ${end}`);
    }
    return slots;
};

const isBooked = (slotLabel) => {
    if (!selectedField.value || !selectedField.value.bookings) return false;
    const [slotStart, slotEnd] = slotLabel.split(' - ');
    return selectedField.value.bookings.some(b => {
        return (slotStart >= b.start && slotStart < b.end);
    });
};
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
                        class="flex items-center gap-2 px-6 py-2.5 rounded-full transition-all whitespace-nowrap shadow-sm border"
                        :class="selectedField.id === field.id 
                            ? 'bg-[#1a472a] text-white border-[#1a472a]' 
                            : 'bg-white text-slate-500 border-slate-200 hover:border-[#1a472a]/50'"
                    >
                        <span class="material-symbols-outlined text-lg">sports_soccer</span>
                        <span class="text-sm font-bold uppercase tracking-wider">{{ field.name }}</span>
                    </button>
                </div>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <!-- Image Section -->
                    <div class="w-full md:w-1/3 h-64 md:h-auto relative">
                        <img 
                            :src="selectedField.image" 
                            :alt="selectedField.name"
                            class="w-full h-full object-cover"
                        />
                        <div class="absolute top-4 left-4 bg-[#bef264] text-[#1a472a] px-3 py-1 rounded-lg text-xs font-bold shadow-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">star</span> 4.8
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="flex-1 p-6 flex flex-col gap-6">
                        <!-- Top Info -->
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold text-[#1a472a] mb-2">{{ selectedField.name }}</h3>
                                <div class="flex flex-wrap gap-2 text-sm text-slate-600">
                                    <span class="flex items-center gap-1 bg-slate-100 px-2 py-1 rounded text-xs font-medium">
                                        <span class="material-symbols-outlined text-sm">location_on</span> {{ selectedField.location }}
                                    </span>
                                    <span class="flex items-center gap-1 bg-slate-100 px-2 py-1 rounded text-xs font-medium">
                                        <span class="material-symbols-outlined text-sm">grass</span> {{ selectedField.type }}
                                    </span>
                                    <span class="flex items-center gap-1 bg-slate-100 px-2 py-1 rounded text-xs font-medium">
                                        <span class="material-symbols-outlined text-sm">aspect_ratio</span> {{ selectedField.size }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-extrabold text-[#1a472a]">{{ selectedField.price }}</p>
                            </div>
                        </div>

                        <div class="border-t border-slate-100"></div>

                        <!-- Date Picker -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <div class="flex items-center gap-2 text-[#1a472a]">
                                <span class="material-symbols-outlined">calendar_month</span>
                                <label class="font-bold whitespace-nowrap">Pilih Tanggal</label>
                            </div>
                            <input 
                                type="date" 
                                v-model="selectedDate" 
                                class="w-full rounded-lg border-slate-200 focus:ring-[#1a472a] focus:border-[#1a472a] text-[#1a472a] font-medium"
                            />
                        </div>

                        <!-- Slots -->
                        <div>
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-[#1a472a]"></span>
                                Slot Tersedia
                            </h4>
                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                <div 
                                    v-for="slot in generateSlots()" 
                                    :key="slot"
                                    class="px-2 py-2 rounded border text-center text-xs font-bold transition-all"
                                    :class="isBooked(slot)
                                        ? 'bg-red-50 border-red-100 text-red-500 cursor-not-allowed opacity-60 decoration-red-500 line-through'
                                        : 'bg-white border-slate-200 text-slate-600 hover:border-[#1a472a] hover:text-[#1a472a] cursor-pointer'"
                                >
                                    {{ slot }}
                                </div>
                            </div>
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
