<script setup lang="ts">
import { computed, useSlots } from 'vue';

const props = defineProps<{
    modelValue: string | number | null;
    label?: string;
    id?: string;
    type?: string;
    placeholder?: string;
    error?: string;
    required?: boolean;
    disabled?: boolean;
    autofocus?: boolean;
    autocomplete?: string;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string | number | null): void;
}>();

const slots = useSlots();
const hasPrefix = computed(() => !!slots.prefix);

const inputId = computed(() => props.id || `input-${Math.random().toString(36).substring(2, 9)}`);

const handleInput = (event: Event) => {
    const target = event.target as HTMLInputElement;
    emit('update:modelValue', target.value);
};
</script>

<template>
    <div class="">
        <label v-if="label" :for="inputId" class="block text-sm font-semibold text-gray-700 mb-1.5">
            {{ label }} <span v-if="required" class="text-indigo-600">*</span>
        </label>
        <div class="relative group">
            <div v-if="hasPrefix" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500 group-focus-within:text-indigo-600 transition-colors duration-200">
                <slot name="prefix" />
            </div>
            <input
                :id="inputId"
                :type="type || 'text'"
                :value="modelValue"
                @input="handleInput"
                :placeholder="placeholder"
                :required="required"
                :disabled="disabled"
                :autofocus="autofocus"
                :autocomplete="autocomplete"
                class="block w-full rounded-lg border-0 outline-0 py-2.5 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 hover:ring-gray-300 sm:text-sm sm:leading-6 transition-all duration-200 ease-in-out bg-white disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500 disabled:ring-gray-200"
                :class="[
                    { 'pl-10': hasPrefix },
                    { 'pl-3.5': !hasPrefix },
                    { 'ring-red-300 text-red-900 placeholder:text-red-300 focus:ring-red-500 hover:ring-red-400': error }
                ]"
            />
        </div>
        <p v-if="error" class="mt-2 text-sm text-red-600 flex items-center animate-in fade-in slide-in-from-top-1 duration-200">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ error }}
        </p>
    </div>
</template>
