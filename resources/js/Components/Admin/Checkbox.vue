<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    modelValue: boolean | any[];
    value?: any;
    label?: string;
    id?: string;
    disabled?: boolean;
    error?: string;
}>();

const emit = defineEmits<{
    (e: 'update:modelValue', value: boolean | any[]): void;
}>();

const inputId = computed(() => props.id || `checkbox-${Math.random().toString(36).substring(2, 9)}`);

const isChecked = computed(() => {
    if (Array.isArray(props.modelValue)) {
        return props.modelValue.includes(props.value);
    }
    return props.modelValue;
});

const handleChange = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const checked = target.checked;

    if (Array.isArray(props.modelValue)) {
        const newValue = [...props.modelValue];
        if (checked) {
            newValue.push(props.value);
        } else {
            const index = newValue.indexOf(props.value);
            if (index > -1) {
                newValue.splice(index, 1);
            }
        }
        emit('update:modelValue', newValue);
    } else {
        emit('update:modelValue', checked);
    }
};
</script>

<template>
    <div class="mb-5">
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input
                    :id="inputId"
                    type="checkbox"
                    :checked="isChecked"
                    :value="value"
                    @change="handleChange"
                    :disabled="disabled"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 transition duration-150 ease-in-out cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed hover:border-gray-400"
                    :class="{ 'border-red-300 text-red-600 focus:ring-red-500': error }"
                />
            </div>
            <div class="ml-3 text-sm leading-5">
                <label v-if="label" :for="inputId" class="font-medium text-gray-700 cursor-pointer select-none">
                    {{ label }}
                </label>
            </div>
        </div>
        <p v-if="error" class="mt-2 text-sm text-red-600 flex items-center animate-in fade-in slide-in-from-top-1 duration-200">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ error }}
        </p>
    </div>
</template>
