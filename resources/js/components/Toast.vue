<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { CheckCircle2, X, XCircle } from 'lucide-vue-next';
import { computed, onMounted, ref, watch } from 'vue';

const page = usePage();
const show = ref(false);
const message = ref('');
const type = ref<'success' | 'error'>('success');

const flashMessage = computed(() => page.props.flash as { success?: string; error?: string });

watch(
    flashMessage,
    (newFlash) => {
        if (newFlash?.success) {
            message.value = newFlash.success;
            type.value = 'success';
            show.value = true;
            autoHide();
        } else if (newFlash?.error) {
            message.value = newFlash.error;
            type.value = 'error';
            show.value = true;
            autoHide();
        }
    },
    { deep: true }
);

const autoHide = () => {
    setTimeout(() => {
        show.value = false;
    }, 5000);
};

const close = () => {
    show.value = false;
};
</script>

<template>
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="translate-y-2 opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="translate-y-0 opacity-100"
        leave-to-class="translate-y-2 opacity-0"
    >
        <div
            v-if="show"
            class="fixed right-4 top-4 z-50 flex min-w-[300px] max-w-md items-center gap-3 rounded-lg border bg-card p-4 shadow-lg"
            :class="{
                'border-green-500/20 bg-green-500/10': type === 'success',
                'border-red-500/20 bg-red-500/10': type === 'error',
            }"
        >
            <CheckCircle2
                v-if="type === 'success'"
                class="h-5 w-5 flex-shrink-0 text-green-600 dark:text-green-400"
            />
            <XCircle
                v-if="type === 'error'"
                class="h-5 w-5 flex-shrink-0 text-red-600 dark:text-red-400"
            />
            <p
                class="flex-1 text-sm font-medium"
                :class="{
                    'text-green-600 dark:text-green-400': type === 'success',
                    'text-red-600 dark:text-red-400': type === 'error',
                }"
            >
                {{ message }}
            </p>
            <button
                @click="close"
                class="flex-shrink-0 rounded-lg p-1 transition-colors hover:bg-muted"
                :class="{
                    'text-green-600 dark:text-green-400': type === 'success',
                    'text-red-600 dark:text-red-400': type === 'error',
                }"
            >
                <X class="h-4 w-4" />
            </button>
        </div>
    </Transition>
</template>
