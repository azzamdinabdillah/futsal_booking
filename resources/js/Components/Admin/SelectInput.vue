<script setup lang="ts">
import { computed } from 'vue';
import { ChevronDown } from 'lucide-vue-next';

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
    <div class="">
        <label v-if="label" :for="inputId" class="block text-sm font-semibold text-dark mb-1.5">
            {{ label }} <span v-if="required" class="text-danger">*</span>
        </label>
        <div class="relative">
            <select
                :id="inputId"
                :value="modelValue"
                @change="handleChange"
                :required="required"
                :disabled="disabled"
                class="block w-full appearance-none rounded-lg border-0 py-2.5 pl-3.5 pr-10 text-dark ring-1 ring-inset ring-secondary/30 focus:ring-2 focus:ring-inset focus:ring-primary hover:ring-secondary/50 sm:text-sm sm:leading-6 transition-all duration-200 ease-in-out bg-white disabled:cursor-not-allowed disabled:bg-light disabled:text-secondary disabled:ring-secondary/20 outline-0"
                :class="{ 'ring-danger/50 text-danger focus:ring-danger hover:ring-danger/70': error }"
            >
                <option v-if="placeholder" value="" disabled selected>{{ placeholder }}</option>
                <option v-for="option in options" :key="option.value" :value="option.value">
                    {{ option.label }}
                </option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-secondary">
                <ChevronDown class="h-4 w-4" aria-hidden="true" />
            </div>
        </div>
        <p v-if="error" class="mt-2 text-sm text-danger flex items-center animate-in fade-in slide-in-from-top-1 duration-200">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ error }}
        </p>
    </div>
</template>
