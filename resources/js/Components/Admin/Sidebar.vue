<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

defineProps<{
  isOpen: boolean
}>()

const emit = defineEmits(['close'])

const page = usePage()
const currentPath = computed(() => page.url.split('?')[0])

const isActive = (path: string) => {
  if (path === '#') return false
  // Strict match for dashboard root to avoid highlighting on sub-pages unless desired
  if (path === '/admin') return currentPath.value === '/admin'
  return currentPath.value.startsWith(path)
}
</script>

<template>
  <!-- Mobile Overlay -->
  <div 
    v-if="isOpen" 
    class="fixed inset-0 bg-black/50 z-30 md:hidden"
    @click="emit('close')"
  ></div>

  <!-- Sidebar -->
  <aside 
    class="fixed inset-y-0 left-0 z-40 w-64 bg-primary text-white transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col"
    :class="isOpen ? 'translate-x-0' : '-translate-x-full'"
  >
    <div class="p-4 text-2xl font-bold border-b border-white/10 flex justify-between items-center">
      <span>Admin Panel</span>
      <!-- Mobile Close Button -->
      <button @click="emit('close')" class="md:hidden text-gray-400 hover:text-white focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
      <Link 
        href="/admin" 
        class="block px-4 py-2 rounded hover:bg-white/10" 
        :class="{ 'bg-white/20': isActive('/admin') }"
        @click="emit('close')"
      >
        Dashboard
      </Link>
      <Link 
        href="/admin/fields" 
        class="block px-4 py-2 rounded hover:bg-white/10" 
        :class="{ 'bg-white/20': isActive('/admin/fields') }"
        @click="emit('close')"
      >
        Manajemen Lapangan
      </Link>
      <a 
        href="#" 
        class="block px-4 py-2 rounded hover:bg-white/10" 
        :class="{ 'bg-white/20': isActive('#') }"
        @click="emit('close')"
      >
        Users
      </a>
      <Link 
        href="/admin/system-config" 
        class="block px-4 py-2 rounded hover:bg-white/10" 
        :class="{ 'bg-white/20': isActive('/admin/system-config') }"
        @click="emit('close')"
      >
        System Config
      </Link>
      <Link href="/admin/logout" method="post" as="button" class="block w-full text-left px-4 py-2 rounded hover:bg-white/10 text-red-300">
        Logout / Home
      </Link>
    </nav>
    
    <div class="p-4 border-t border-white/10 text-sm text-gray-400">
      &copy; 2024 Futsal Booking
    </div>
  </aside>
</template>
