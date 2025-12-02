<script setup>
import { Edit, Trash2, Home, Eye, EyeOff } from 'lucide-vue-next';

defineProps({
    pages: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(['edit', 'delete']);
</script>

<template>
    <div class="overflow-hidden rounded-lg border border-sidebar-border bg-card">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-sidebar-border bg-muted/50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Title
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Slug
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Status
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Sections
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-muted-foreground">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sidebar-border">
                    <tr v-for="page in pages" :key="page.id" class="transition-colors hover:bg-muted/50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-foreground">{{ page.title }}</span>
                                <Home v-if="page.is_homepage" class="h-4 w-4 text-primary" title="Homepage" />
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-muted-foreground">{{ page.slug }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <Eye v-if="page.published" class="h-4 w-4 text-green-600" />
                                <EyeOff v-else class="h-4 w-4 text-muted-foreground" />
                                <span class="text-sm"
                                    :class="page.published ? 'text-green-600' : 'text-muted-foreground'">
                                    {{ page.published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-muted-foreground">
                                {{ page.content?.length || 0 }} sections
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="emit('edit', page)"
                                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground"
                                    title="Edit">
                                    <Edit class="h-4 w-4" />
                                </button>
                                <button @click="emit('delete', page)"
                                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-950"
                                    title="Delete">
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr v-if="pages.length === 0">
                        <td colspan="5" class="px-6 py-12 text-center">
                            <p class="text-sm text-muted-foreground">No pages found</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
