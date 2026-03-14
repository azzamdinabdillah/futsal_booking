<script setup lang="ts">
import { ref, computed } from 'vue'
import { Head, usePage, Link } from '@inertiajs/vue3'
import Sidebar from '@/Components/Admin/Sidebar.vue'
import { 
  Menu, 
  LogOut
} from 'lucide-vue-next'

defineProps<{
  title?: string
}>()

const isSidebarOpen = ref(false)
const page = usePage()

const userInitials = computed(() => {
  const name = page.props.auth.user?.full_name || 'Admin'
  return name.split(' ').map((n: string) => n[0]).join('').substring(0, 2).toUpperCase()
})
const flashSuccess = computed(() => page.props.flash.success)
const flashError = computed(() => page.props.flash.error)
</script>

<template>
  <div class="flex h-screen bg-gray-50/50">
    <!-- Sidebar -->
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex flex-col w-full">
      <!-- Header -->
      <header class="bg-primary border-b border-white/10 py-3 flex justify-between items-center sticky top-0 z-20 px-4 sm:px-8 transition-all duration-200 shadow-md">
        <div class="flex items-center gap-4">
          <!-- Hamburger Button -->
          <button 
            @click="isSidebarOpen = !isSidebarOpen" 
            class="p-2 -ml-2 text-white/70 hover:text-white focus:outline-none md:hidden rounded-lg hover:bg-white/10 transition-all duration-200"
          >
            <Menu class="w-6 h-6" />
          </button>
          
          <h2 v-if="title" class="text-2xl font-bold text-white tracking-tight">{{ title }}</h2>
        </div>

        <div class="flex items-center gap-4">
          <!-- User Info -->
          <div class="flex items-center gap-3 px-3 py-1.5 rounded-xl bg-white/5 border border-white/10">
            <div class="h-9 w-9 rounded-lg bg-white/20 text-white flex items-center justify-center font-bold text-sm shadow-sm ring-1 ring-white/20 backdrop-blur-sm">
              {{ userInitials }}
            </div>
            <div class="hidden sm:block">
              <div class="text-sm font-bold text-white leading-none mb-0.5">{{ $page.props.auth.user?.full_name }}</div>
              <div class="text-[10px] text-white/60 font-medium uppercase tracking-wider">Administrator</div>
            </div>
          </div>

          <!-- Logout Button -->
          <Link 
            href="/admin/logout" 
            method="post" 
            as="button" 
            class="p-2.5 text-white/70 hover:text-red-200 hover:bg-red-500/20 rounded-xl transition-all duration-200 border border-transparent hover:border-red-500/30 focus:outline-none group"
            title="Sign Out"
          >
            <LogOut class="w-5 h-5 group-hover:scale-110 transition-transform" />
          </Link>
        </div>
      </header>

      <!-- Flash Messages -->
      <div v-if="flashSuccess" class="mx-4 mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ flashSuccess }}</span>
      </div>
      <div v-if="flashError" class="mx-4 mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ flashError }}</span>
      </div>

      <!-- Content -->
      <slot />
    </main>
  </div>
</template>
