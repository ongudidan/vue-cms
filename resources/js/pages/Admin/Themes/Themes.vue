<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { RefreshCw, Palette } from 'lucide-vue-next';
import { ref } from 'vue';
import ThemeCard from '@/pages/Admin/Themes/ThemeCard.vue';

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Themes', href: '/admin/themes' },
];

const syncing = ref(false);

const syncThemes = () => {
    syncing.value = true;
    router.post('/admin/themes/sync', {}, {
        preserveScroll: true,
        onFinish: () => {
            syncing.value = false;
        },
    });
};
</script>

<template>

    <Head title="Themes" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-primary/10 p-3">
                        <Palette class="h-6 w-6 text-primary" />
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-foreground">Themes</h1>
                        <p class="text-sm text-muted-foreground">
                            Manage and activate themes for your website
                        </p>
                    </div>
                </div>

                <!-- Sync Button -->
                <button @click="syncThemes" :disabled="syncing"
                    class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-all hover:bg-primary/90 hover:shadow-md disabled:cursor-not-allowed disabled:opacity-50">
                    <RefreshCw class="h-4 w-4" :class="{ 'animate-spin': syncing }" />
                    {{ syncing ? 'Syncing...' : 'Sync Themes' }}
                </button>
            </div>

            <!-- Info Alert -->
            <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-950/30">
                <div class="flex gap-3">
                    <div class="text-blue-600 dark:text-blue-400">ℹ️</div>
                    <div class="flex-1">
                        <h3 class="mb-1 text-sm font-semibold text-blue-900 dark:text-blue-100">
                            How Themes Work
                        </h3>
                        <p class="text-sm text-blue-800 dark:text-blue-200">
                            Themes are automatically discovered from the <code
                                class="rounded bg-blue-100 px-1 py-0.5 dark:bg-blue-900">themes/</code>
                            directory. Only one theme can be active at a time. When you activate a new theme, the
                            previous one will be automatically deactivated.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Themes Grid -->
            <div v-if="data.themes.length > 0" class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <ThemeCard v-for="theme in data.themes" :key="theme.id" :theme="theme" />
            </div>

            <!-- Empty State -->
            <div v-else class="rounded-lg border-2 border-dashed border-sidebar-border bg-muted/30 p-12 text-center">
                <Palette class="mx-auto mb-4 h-12 w-12 text-muted-foreground" />
                <h3 class="mb-2 text-lg font-semibold text-foreground">No Themes Found</h3>
                <p class="mb-4 text-sm text-muted-foreground">
                    Create a theme folder in the <code class="rounded bg-muted px-1 py-0.5">themes/</code> directory
                    with a
                    <code class="rounded bg-muted px-1 py-0.5">theme.json</code> file.
                </p>
                <button @click="syncThemes" :disabled="syncing"
                    class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-all hover:bg-primary/90 hover:shadow-md disabled:cursor-not-allowed disabled:opacity-50">
                    <RefreshCw class="mr-2 inline-block h-4 w-4" :class="{ 'animate-spin': syncing }" />
                    {{ syncing ? 'Syncing...' : 'Sync Themes' }}
                </button>
            </div>
        </div>
    </AppLayout>
</template>
