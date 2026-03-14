<script setup lang="ts">
import { onMounted, onUnmounted, watch } from 'vue';
import Button from '@/Components/Admin/Button.vue';

const props = withDefaults(
    defineProps<{
        show?: boolean;
        closeable?: boolean;
        maxWidth?: 'sm' | 'md' | 'lg' | 'xl' | '2xl';
        // Form props
        title?: string;
        subtitle?: string;
        submitText?: string;
        cancelText?: string;
        loading?: boolean;
        showFooter?: boolean;
    }>(),
    {
        show: false,
        closeable: true,
        maxWidth: '2xl',
        title: '',
        subtitle: '',
        submitText: 'Save Changes',
        cancelText: 'Cancel',
        loading: false,
        showFooter: false,
    }
);

const emit = defineEmits(['close', 'submit']);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }
);

const close = () => {
    if (props.closeable) {
        emit('close');
    }
};

const submit = () => {
    emit('submit');
};

const closeOnEscape = (e: KeyboardEvent) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

const maxWidthClass = {
    sm: 'sm:max-w-sm',
    md: 'sm:max-w-md',
    lg: 'sm:max-w-lg',
    xl: 'sm:max-w-xl',
    '2xl': 'sm:max-w-2xl',
}[props.maxWidth];

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = '';
});
</script>

<template>
    <Teleport to="body">
        <div v-show="show" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <transition
                enter-active-class="ease-out duration-300"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="ease-in duration-200"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div v-show="show" class="fixed inset-0 bg-dark/50 backdrop-blur-sm transition-opacity" @click="close" />
            </transition>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full justify-center p-4 text-center items-center sm:p-0">
                    <transition
                        enter-active-class="ease-out duration-300"
                        enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-active-class="ease-in duration-200"
                        leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <div
                            v-show="show"
                            class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 w-full border border-secondary/20"
                            :class="maxWidthClass"
                        >
                            <form v-if="title || showFooter" @submit.prevent="submit" class="flex flex-col h-full">
                                <!-- Header -->
                                <div v-if="title" class="px-6 py-4 border-b border-secondary/20 flex items-center justify-between bg-light/50">
                                    <h2 class="text-lg font-semibold text-dark">
                                        {{ title }}
                                    </h2>
                                    <div v-if="subtitle" class="text-xs font-mono text-secondary bg-white px-2 py-1 rounded border border-secondary/20 shadow-sm">
                                        {{ subtitle }}
                                    </div>
                                </div>
                                
                                <!-- Body -->
                                <div class="p-6 space-y-5">
                                    <slot />
                                </div>

                                <!-- Footer -->
                                <div v-if="showFooter" class="px-6 py-4 bg-light border-t border-secondary/20 flex justify-end space-x-3">
                                    <Button 
                                        type="button" 
                                        variant="secondary"
                                        @click="close"
                                    >
                                        {{ cancelText }}
                                    </Button>
                                    <Button 
                                        type="submit" 
                                        variant="primary"
                                        :disabled="loading"
                                        :loading="loading"
                                    >
                                        {{ submitText }}
                                    </Button>
                                </div>
                            </form>
                            
                            <slot v-else />
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </Teleport>
</template>
