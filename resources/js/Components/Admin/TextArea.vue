<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    modelValue: string | null;
    label?: string;
    id?: string;
    placeholder?: string;
    error?: string;
    required?: boolean;
    disabled?: boolean;
    rows?: number;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void;
}>();

const inputId = computed(() => props.id || `textarea-${Math.random().toString(36).substring(2, 9)}`);

const handleInput = (event: Event) => {
    const target = event.target as HTMLTextAreaElement;
    emit('update:modelValue', target.value);
};
</script>

<template>
    <div class="mb-5">
        <label v-if="label" :for="inputId" class="block text-sm font-semibold text-dark mb-1.5">
            {{ label }} <span v-if="required" class="text-danger">*</span>
        </label>
        <div class="relative">
            <textarea
                :id="inputId"
                :value="modelValue"
                @input="handleInput"
                :placeholder="placeholder"
                :required="required"
                :disabled="disabled"
                :rows="rows || 3"
                class="block w-full rounded-lg border-0 px-3.5 py-2.5 outline-0 text-dark ring-1 ring-inset ring-secondary/30 placeholder:text-secondary/50 focus:ring-2 focus:ring-inset focus:ring-primary hover:ring-secondary/50 sm:text-sm sm:leading-6 transition-all duration-200 ease-in-out bg-white disabled:cursor-not-allowed disabled:bg-light disabled:text-secondary disabled:ring-secondary/20"
                :class="{ 'ring-danger/50 text-danger placeholder:text-danger/50 focus:ring-danger hover:ring-danger/70': error }"
            ></textarea>
        </div>
        <p v-if="error" class="mt-2 text-sm text-danger flex items-center animate-in fade-in slide-in-from-top-1 duration-200">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ error }}
        </p>
    </div>
</template>
