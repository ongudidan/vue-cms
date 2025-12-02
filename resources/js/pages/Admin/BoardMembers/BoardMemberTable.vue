<script setup>
import { ChevronLeft, ChevronRight, Edit, Trash2 } from 'lucide-vue-next';
import { router } from '@inertiajs/vue3';

defineProps({
    boardMembers: {
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
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Name
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Position
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Status
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sidebar-border">
                    <tr v-for="boardMember in boardMembers.data" :key="boardMember.id"
                        class="transition-colors hover:bg-muted/30">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg border border-sidebar-border bg-muted">
                                    <img v-if="boardMember.media && boardMember.media.length > 0"
                                        :src="boardMember.media[0].url" :alt="boardMember.name"
                                        class="h-full w-full object-cover" />
                                    <div v-else
                                        class="flex h-full w-full items-center justify-center text-muted-foreground">
                                        <span class="text-xs">No img</span>
                                    </div>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-medium text-foreground">{{ boardMember.name }}</span>
                                    <span v-if="boardMember.details"
                                        class="mt-1 line-clamp-1 text-sm text-muted-foreground">
                                        {{ boardMember.details }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-foreground">
                                {{ boardMember.position || 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span :class="boardMember.active
                                ? 'bg-green-500/10 text-green-600 dark:text-green-400'
                                : 'bg-red-500/10 text-red-600 dark:text-red-400'"
                                class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium">
                                {{ boardMember.active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="$emit('edit', boardMember)"
                                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground"
                                    title="Edit">
                                    <Edit class="h-4 w-4" />
                                </button>
                                <button @click="$emit('delete', boardMember)"
                                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-red-500/10 hover:text-red-600 dark:hover:text-red-400"
                                    title="Delete">
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="boardMembers.data.length === 0">
                        <td colspan="4" class="px-6 py-12 text-center">
                            <p class="text-muted-foreground">No board members found</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div v-if="boardMembers.last_page > 1"
            class="flex items-center justify-between border-t border-sidebar-border px-6 py-4">
            <div class="text-sm text-muted-foreground">
                Showing {{ (boardMembers.current_page - 1) * boardMembers.per_page + 1 }}
                to {{ Math.min(boardMembers.current_page * boardMembers.per_page, boardMembers.total) }}
                of {{ boardMembers.total }} results
            </div>
            <div class="flex items-center gap-2">
                <button @click="goToPage(boardMembers.links[0]?.url)" :disabled="boardMembers.current_page === 1"
                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground disabled:cursor-not-allowed disabled:opacity-50">
                    <ChevronLeft class="h-4 w-4" />
                </button>
                <div class="flex gap-1">
                    <button v-for="(link, index) in boardMembers.links.slice(1, -1)" :key="index"
                        @click="goToPage(link.url)" :class="[
                            'min-w-[2rem] rounded-lg px-3 py-1 text-sm transition-colors',
                            link.active
                                ? 'bg-primary text-primary-foreground'
                                : 'text-muted-foreground hover:bg-muted hover:text-foreground',
                        ]" v-html="link.label"></button>
                </div>
                <button @click="goToPage(boardMembers.links[boardMembers.links.length - 1]?.url)"
                    :disabled="boardMembers.current_page === boardMembers.last_page"
                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground disabled:cursor-not-allowed disabled:opacity-50">
                    <ChevronRight class="h-4 w-4" />
                </button>
            </div>
        </div>
    </div>
</template>
