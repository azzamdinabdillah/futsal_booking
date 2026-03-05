<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <nav class="relative z-10 border-b border-white/10 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <div class="h-10 w-auto">
                         <img class="h-full w-auto" :src="'/assets/images/logo.jpg'" alt="Logo">
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <Link
                        v-if="$page.props.auth?.user"
                        href="/dashboard"
                        class="text-sm font-medium text-gray-200 hover:text-white transition-colors"
                    >
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            href="/login"
                            class="text-sm font-medium text-gray-200 hover:text-white transition-colors"
                        >
                            Masuk
                        </Link>

                        <Link
                            href="/register"
                            class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md transition-colors"
                        >
                            Daftar
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>
