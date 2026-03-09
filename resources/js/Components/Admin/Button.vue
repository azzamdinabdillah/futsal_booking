<script setup lang="ts">
import { computed } from 'vue';

type ButtonVariant = 'primary' | 'secondary' | 'danger' | 'warning' | 'info' | 'success';
type ButtonSize = 'sm' | 'md' | 'lg';

const props = withDefaults(defineProps<{
    type?: 'button' | 'submit' | 'reset';
    variant?: ButtonVariant;
    size?: ButtonSize;
    disabled?: boolean;
    block?: boolean;
    loading?: boolean;
}>(), {
    type: 'button',
    variant: 'primary',
    size: 'md',
    disabled: false,
    block: false,
    loading: false,
});

const baseClasses = computed(() => {
    return 'inline-flex cursor-pointer items-center justify-center font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150';
});

const variantClasses = computed(() => {
    switch (props.variant) {
        case 'secondary':
            return 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-gray-500';
        case 'danger':
            return 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 border border-transparent';
        case 'warning':
            return 'bg-yellow-500 text-white hover:bg-yellow-600 focus:ring-yellow-500 border border-transparent';
        case 'info':
            return 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-500 border border-transparent';
        case 'success':
            return 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500 border border-transparent';
        case 'primary':
        default:
            return 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500 border border-transparent';
    }
});

const sizeClasses = computed(() => {
    switch (props.size) {
        case 'sm':
            return 'px-3 py-1.5 text-sm';
        case 'lg':
            return 'px-6 py-3 text-lg';
        case 'md':
        default:
            return 'px-4 py-2 text-sm';
    }
});

const widthClass = computed(() => props.block ? 'w-full' : '');
const opacityClass = computed(() => props.disabled || props.loading ? 'opacity-50 cursor-not-allowed' : '');
</script>

<template>
    <button
        :type="type"
        :class="[baseClasses, variantClasses, sizeClasses, widthClass, opacityClass]"
        :disabled="disabled || loading"
    >
        <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <slot />
    </button>
</template>
