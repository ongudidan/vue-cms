<script setup>
import { router } from '@inertiajs/vue3';
import { Check, Power } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    theme: {
        type: Object,
        required: true,
    },
});

const showConfirmModal = ref(false);
const processing = ref(false);

const activateTheme = () => {
    showConfirmModal.value = true;
};

const confirmActivation = () => {
    processing.value = true;
    router.post(`/admin/themes/${props.theme.id}/activate`, {}, {
        preserveScroll: true,
        onFinish: () => {
            processing.value = false;
            showConfirmModal.value = false;
        },
    });
};
</script>

<template>
    <div
        class="group relative overflow-hidden rounded-xl border border-sidebar-border bg-card shadow-sm transition-all hover:shadow-lg">
        <!-- Active Badge -->
        <div v-if="theme.is_active"
            class="absolute right-4 top-4 z-10 flex items-center gap-1.5 rounded-full bg-green-500 px-3 py-1 text-xs font-semibold text-white shadow-md">
            <Check class="h-3 w-3" />
            Active
        </div>

        <!-- Card Content -->
        <div class="p-6">
            <!-- Theme Icon/Preview -->
            <div
                class="mb-4 flex h-24 items-center justify-center rounded-lg bg-gradient-to-br from-primary/20 to-primary/5">
                <div class="text-5xl">🎨</div>
            </div>

            <!-- Theme Info -->
            <div class="mb-4">
                <h3 class="mb-1 text-xl font-bold text-foreground">{{ theme.name }}</h3>
                <p class="mb-2 text-sm text-muted-foreground line-clamp-2">
                    {{ theme.description || 'No description available' }}
                </p>
                <div class="flex flex-wrap gap-2 text-xs text-muted-foreground">
                    <span v-if="theme.version" class="rounded-full bg-muted px-2 py-1">
                        v{{ theme.version }}
                    </span>
                    <span v-if="theme.author" class="rounded-full bg-muted px-2 py-1">
                        {{ theme.author }}
                    </span>
                    <span class="rounded-full bg-muted px-2 py-1">
                        {{ theme.sections_count }} sections
                    </span>
                </div>
            </div>

            <!-- Actions -->
            <div v-if="!theme.is_active" class="flex gap-2">
                <button @click="activateTheme" :disabled="processing"
                    class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-all hover:bg-primary/90 hover:shadow-md disabled:cursor-not-allowed disabled:opacity-50">
                    <Power class="h-4 w-4" />
                    Activate
                </button>
            </div>
            <div v-else class="flex items-center justify-center py-2 text-sm text-muted-foreground">
                Currently active theme
            </div>
        </div>

        <!-- Activation Confirmation Modal -->
        <div v-if="showConfirmModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            @click.self="showConfirmModal = false">
            <div class="w-full max-w-md rounded-xl border border-sidebar-border bg-card p-6 shadow-xl">
                <div class="mb-4 flex items-start gap-3">
                    <div class="rounded-lg bg-yellow-500/10 p-2">
                        <div class="text-2xl">⚠️</div>
                    </div>
                    <div class="flex-1">
                        <h3 class="mb-2 text-lg font-semibold text-foreground">Activate Theme?</h3>
                        <p class="text-sm text-muted-foreground">
                            Activating <strong>{{ theme.name }}</strong> will deactivate the current theme.
                            Pages built with the previous theme's sections may need to be rebuilt.
                        </p>
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <button @click="showConfirmModal = false" :disabled="processing"
                        class="rounded-lg border border-sidebar-border px-4 py-2 text-sm font-medium text-foreground transition-colors hover:bg-muted disabled:cursor-not-allowed disabled:opacity-50">
                        Cancel
                    </button>
                    <button @click="confirmActivation" :disabled="processing"
                        class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-all hover:bg-primary/90 hover:shadow-md disabled:cursor-not-allowed disabled:opacity-50">
                        {{ processing ? 'Activating...' : 'Activate Theme' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
