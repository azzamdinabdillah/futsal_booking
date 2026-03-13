<script setup lang="ts">
import { ref } from 'vue'
import { Head } from '@inertiajs/vue3'
import Sidebar from '@/Components/Admin/Sidebar.vue'

defineProps<{
  title?: string
}>()

const isSidebarOpen = ref(false)
</script>

<template>
  <div class="flex h-screen bg-light">
    <!-- Sidebar -->
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto flex flex-col w-full">
      <!-- Header -->
      <header class="bg-white shadow p-4 flex justify-between items-center sticky top-0 z-10">
        <div class="flex items-center">
          <!-- Hamburger Button -->
          <button 
            @click="isSidebarOpen = !isSidebarOpen" 
            class="mr-4 text-secondary hover:text-dark focus:outline-none md:hidden"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <h2 v-if="title" class="text-xl font-semibold text-dark">{{ title }}</h2>
        </div>
        <div class="flex items-center space-x-4">
          <span class="text-secondary hidden sm:inline">{{ $page.props.auth.user?.full_name }}</span>
          <div class="w-8 h-8 bg-secondary/20 rounded-full"></div>
        </div>
      </header>

      <!-- Content -->
      <slot />
    </main>
  </div>
</template>
