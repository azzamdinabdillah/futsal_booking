<script setup lang="ts">
import { computed } from 'vue';

type Option = {
  label: string;
  value: string | number | boolean;
  description?: string;
};

const props = defineProps<{
  modelValue: string | number | boolean | null;
  options: Option[];
  name?: string;
  label?: string;
  inline?: boolean;
}>();

const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number | boolean | null): void;
}>();

const groupName = computed(() => props.name || `radio-group-${Math.random().toString(36).substring(2, 9)}`);
</script>

<template>
  <div class="mb-4">
    <label v-if="label" class="block text-sm font-medium text-gray-700 mb-2">
      {{ label }}
    </label>
    <div :class="[inline ? 'flex flex-wrap gap-3' : 'space-y-2']">
      <label 
        v-for="(option, index) in options" 
        :key="index" 
        class="relative flex items-center cursor-pointer p-3 rounded-lg border transition-all duration-200 ease-in-out"
        :class="[
          modelValue === option.value 
            ? 'bg-indigo-50 border-indigo-200 ring-1 ring-indigo-200 shadow-sm' 
            : 'bg-white border-gray-200 hover:border-gray-300 hover:bg-gray-50'
        ]"
      >
        <input 
          type="radio" 
          :name="groupName"
          :value="option.value"
          :checked="modelValue === option.value"
          @change="$emit('update:modelValue', option.value)"
          class="h-4 w-4 text-indigo-600 border-gray-300"
        >
        <div class="ml-3">
          <span 
            class="block text-sm font-medium"
            :class="[modelValue === option.value ? 'text-indigo-900' : 'text-gray-900']"
          >
            {{ option.label }}
          </span>
          <span 
            v-if="option.description" 
            class="block text-xs mt-0.5"
            :class="[modelValue === option.value ? 'text-indigo-700' : 'text-gray-500']"
          >
            {{ option.description }}
          </span>
        </div>
      </label>
    </div>
  </div>
</template>
