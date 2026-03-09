<script setup lang="ts">
import { computed } from 'vue';

type Option = {
    value: string | number;
    label: string;
};

const props = defineProps<{
    modelValue: string | number | null;
    options: Option[];
    label?: string;
    id?: string;
    placeholder?: string;
    error?: string;
    required?: boolean;
    disabled?: boolean;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | number | null): void;
}>();

const inputId = computed(() => props.id || `select-${Math.random().toString(36).substring(2, 9)}`);

const handleChange = (event: Event) => {
    const target = event.target as HTMLSelectElement;
    emit('update:modelValue', target.value);
};
</script>

<template>
    <div class="mb-5">
        <label v-if="label" :for="inputId" class="block text-sm font-semibold text-gray-700 mb-1.5">
            {{ label }} <span v-if="required" class="text-indigo-600">*</span>
        </label>
        <div class="relative">
            <select
                :id="inputId"
                :value="modelValue"
                @change="handleChange"
                :required="required"
                :disabled="disabled"
                class="block w-full rounded-lg border-0 py-2.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-indigo-600 hover:ring-gray-300 sm:text-sm sm:leading-6 transition-all duration-200 ease-in-out bg-white disabled:cursor-not-allowed disabled:bg-gray-100 disabled:text-gray-500 disabled:ring-gray-200"
                :class="{ 'ring-red-300 text-red-900 focus:ring-red-500 hover:ring-red-400': error }"
            >
                <option v-if="placeholder" value="" disabled selected>{{ placeholder }}</option>
                <option v-for="option in options" :key="option.value" :value="option.value">
                    {{ option.label }}
                </option>
            </select>
        </div>
        <p v-if="error" class="mt-2 text-sm text-red-600 flex items-center animate-in fade-in slide-in-from-top-1 duration-200">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ error }}
        </p>
    </div>
</template>
