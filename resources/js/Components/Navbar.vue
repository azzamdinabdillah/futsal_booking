<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineProps<{
    transparent?: boolean;
}>();
</script>

<template>
    <nav 
        class="relative z-50 transition-all duration-300"
        :class="[
            transparent 
                ? 'bg-transparent border-b border-white/10' 
                : 'bg-white border-b border-gray-200 shadow-sm'
        ]"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <Link href="/" class="h-10 w-auto">
                         <img class="h-full w-auto rounded-lg" :src="'/assets/images/logo.jpg'" alt="Logo">
                    </Link>
                </div>

                <div class="flex items-center space-x-4">
                    <Link
                        v-if="$page.props.auth?.user"
                        href="/dashboard"
                        class="text-sm font-medium transition-colors"
                        :class="transparent ? 'text-gray-200 hover:text-white' : 'text-secondary hover:text-primary'"
                    >
                        Dashboard
                    </Link>

                    <template v-else>
                        <Link
                            href="/login"
                            class="text-sm font-medium transition-colors"
                            :class="transparent ? 'text-gray-200 hover:text-white' : 'text-secondary hover:text-primary'"
                        >
                            Masuk
                        </Link>

                        <Link
                            href="/register"
                            class="text-sm font-medium px-4 py-2 rounded-lg transition-all"
                            :class="transparent 
                                ? 'text-white bg-primary hover:opacity-90' 
                                : 'text-white bg-primary hover:opacity-90 shadow-sm shadow-primary/20'"
                        >
                            Daftar
                        </Link>
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>
