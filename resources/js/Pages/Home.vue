<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Navbar from '../Components/Navbar.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>
    <Head title="Beranda" />

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
</template>
