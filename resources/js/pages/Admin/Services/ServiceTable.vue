<script setup>
import { ChevronLeft, ChevronRight, Edit, Trash2 } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

defineProps({
    services: {
        type: Object,
        required: true,
    },
});

defineEmits(['edit', 'delete']);

const goToPage = (url) => {
    if (!url) return;
    router.get(url, {}, { preserveState: true, preserveScroll: true });
};
</script>

<template>
    <div class="overflow-hidden rounded-xl border border-sidebar-border bg-card shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-sidebar-border bg-muted/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Slug
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Status
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sidebar-border">
                    <tr
                        v-for="service in services.data"
                        :key="service.id"
                        class="transition-colors hover:bg-muted/30"
                    >
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg border border-sidebar-border bg-muted">
                                    <img
                                        v-if="service.media && service.media.length > 0"
                                        :src="service.media[0].url"
                                        :alt="service.title"
                                        class="h-full w-full object-cover"
                                    />
                                    <div v-else class="flex h-full w-full items-center justify-center text-muted-foreground">
                                        <span class="text-xs">No img</span>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-medium text-foreground">{{ service.title }}</span>
                                    <span v-if="service.details" class="mt-1 line-clamp-1 text-sm text-muted-foreground">
                                        {{ service.details }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <code class="rounded bg-muted px-2 py-1 text-xs text-foreground">
                                {{ service.slug }}
                            </code>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                :class="service.active 
                                    ? 'bg-green-500/10 text-green-600 dark:text-green-400' 
                                    : 'bg-red-500/10 text-red-600 dark:text-red-400'"
                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium"
                            >
                                {{ service.active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    @click="$emit('edit', service)"
                                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground"
                                    title="Edit"
                                >
                                    <Edit class="h-4 w-4" />
                                </button>
                                <button
                                    @click="$emit('delete', service)"
                                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400"
                                    title="Delete"
                                >
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="services.data.length === 0">
                        <td colspan="4" class="px-6 py-12 text-center">
                            <p class="text-muted-foreground">No services found</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div
            v-if="services.last_page > 1"
            class="flex items-center justify-between border-t border-sidebar-border px-6 py-4"
        >
            <div class="text-sm text-muted-foreground">
                Showing {{ (services.current_page - 1) * services.per_page + 1 }}
                to {{ Math.min(services.current_page * services.per_page, services.total) }}
                of {{ services.total }} results
            </div>
            <div class="flex items-center gap-2">
                <button
                    @click="goToPage(services.links[0]?.url)"
                    :disabled="services.current_page === 1"
                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <ChevronLeft class="h-4 w-4" />
                </button>
                <div class="flex gap-1">
                    <button
                        v-for="(link, index) in services.links.slice(1, -1)"
                        :key="index"
                        @click="goToPage(link.url)"
                        :class="[
                            'min-w-[2rem] rounded-lg px-3 py-1 text-sm transition-colors',
                            link.active
                                ? 'bg-primary text-primary-foreground'
                                : 'text-muted-foreground hover:bg-muted hover:text-foreground',
                        ]"
                        v-html="link.label"
                    ></button>
                </div>
                <button
                    @click="goToPage(services.links[services.links.length - 1]?.url)"
                    :disabled="services.current_page === services.last_page"
                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground disabled:cursor-not-allowed disabled:opacity-50"
                >
                    <ChevronRight class="h-4 w-4" />
                </button>
            </div>
        </div>
    </div>
</template>
