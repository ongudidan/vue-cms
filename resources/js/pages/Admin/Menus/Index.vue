<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import MenuModal from './MenuModal.vue';
import Toast from '@/components/Toast.vue';
import { Head, router } from '@inertiajs/vue3';
import { Plus, Search, GripVertical } from 'lucide-vue-next';
import { ref, computed, watch } from 'vue';
import draggable from 'vuedraggable';

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Menus', href: '/admin/menus' },
];

// Modal state
const showModal = ref(false);
const editingMenu = ref(null);
const deletingMenu = ref(null);

// Search state
const searchQuery = ref(props.data.filters.search || '');

// Draggable menus - sync with props
const menus = ref([...props.data.menus]);
const drag = ref(false);

// Watch for changes in props.data.menus and update local menus
watch(() => props.data.menus, (newMenus) => {
    menus.value = [...newMenus];
}, { deep: true });

// Modal handlers
const openCreateModal = () => {
    editingMenu.value = null;
    showModal.value = true;
};

const openEditModal = (menu) => {
    editingMenu.value = { ...menu };
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    editingMenu.value = null;
};

// Search
const handleSearch = () => {
    router.get('/admin/menus', {
        search: searchQuery.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

// Delete handlers
const confirmDelete = (menu) => {
    deletingMenu.value = menu;
};

const deleteMenu = () => {
    if (!deletingMenu.value) return;

    router.delete(`/admin/menus/${deletingMenu.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            deletingMenu.value = null;
        },
    });
};

const cancelDelete = () => {
    deletingMenu.value = null;
};

// Drag and drop handlers
const onDragStart = () => {
    drag.value = true;
};

const onDragEnd = () => {
    drag.value = false;
    updateMenuOrder();
};

const updateMenuOrder = () => {
    const orderedMenus = menus.value.map((menu, index) => ({
        id: menu.id,
        order: index,
    }));

    router.post('/admin/menus/reorder', {
        menus: orderedMenus,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

// Helper to get menu link
const getMenuLink = (menu) => {
    if (menu.type === 'page' && menu.page) {
        return `/${menu.page.slug}`;
    } else if (menu.type === 'custom') {
        return menu.url || '#';
    }
    return '#';
};

// Helper to get child type label
const getChildTypeLabel = (menu) => {
    if (!menu.has_children) return 'No';
    if (menu.child_type === 'pages') {
        const count = menu.pages?.length || 0;
        return `Pages (${count})`;
    } else if (menu.child_type === 'components') {
        return `Component: ${menu.component}`;
    }
    return 'Yes';
};
</script>

<template>

    <Head title="Menus" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <h1 class="text-3xl font-bold tracking-tight text-foreground">
                        Menu Management
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        Manage navigation menu items and their order
                    </p>
                </div>
                <button @click="openCreateModal"
                    class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-all hover:bg-primary/90 hover:shadow-md">
                    <Plus class="h-4 w-4" />
                    Create Menu Item
                </button>
            </div>

            <!-- Search -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div class="relative flex-1">
                    <Search class="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" />
                    <input v-model="searchQuery" @keyup.enter="handleSearch" type="text" placeholder="Search menus..."
                        class="w-full rounded-lg border border-sidebar-border bg-background py-2 pl-10 pr-4 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
                </div>
            </div>

            <!-- Menus Table with Drag and Drop -->
            <div class="overflow-hidden rounded-xl border border-sidebar-border bg-card shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="border-b border-sidebar-border bg-muted/50">
                            <tr>
                                <th class="w-12 px-6 py-3"></th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                                    Title
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                                    Type
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                                    Link
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-muted-foreground">
                                    Dropdown
                                </th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-muted-foreground">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <draggable v-model="menus" tag="tbody" item-key="id" handle=".drag-handle" @start="onDragStart"
                            @end="onDragEnd" class="divide-y divide-sidebar-border">
                            <template #item="{ element: menu }">
                                <tr :class="[
                                    'transition-colors hover:bg-muted/30',
                                    drag ? 'cursor-grabbing' : 'cursor-grab'
                                ]">
                                    <td class="px-6 py-4">
                                        <div
                                            class="drag-handle cursor-grab text-muted-foreground hover:text-foreground">
                                            <GripVertical class="h-5 w-5" />
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-foreground">{{ menu.title }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span :class="menu.type === 'page'
                                            ? 'bg-blue-500/10 text-blue-600 dark:text-blue-400'
                                            : 'bg-purple-500/10 text-purple-600 dark:text-purple-400'"
                                            class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium capitalize">
                                            {{ menu.type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <code class="rounded bg-muted px-2 py-1 text-xs text-foreground">
                                            {{ getMenuLink(menu) }}
                                        </code>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-muted-foreground">
                                            {{ getChildTypeLabel(menu) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">
                                            <button @click="openEditModal(menu)"
                                                class="rounded-lg px-3 py-1.5 text-xs font-medium text-foreground transition-colors hover:bg-muted">
                                                Edit
                                            </button>
                                            <button @click="confirmDelete(menu)"
                                                class="rounded-lg px-3 py-1.5 text-xs font-medium text-red-600 transition-colors hover:bg-red-500/10 dark:text-red-400">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </draggable>
                    </table>

                    <div v-if="menus.length === 0" class="px-6 py-12 text-center">
                        <p class="text-muted-foreground">No menu items found</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menu Modal -->
        <MenuModal :show="showModal" :menu="editingMenu" :pages="data.pages" @close="closeModal" />

        <!-- Delete Confirmation Modal -->
        <div v-if="deletingMenu" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            @click.self="cancelDelete">
            <div class="w-full max-w-md rounded-xl border border-sidebar-border bg-card p-6 shadow-xl">
                <h3 class="text-lg font-semibold text-foreground">Delete Menu Item</h3>
                <p class="mt-2 text-sm text-muted-foreground">
                    Are you sure you want to delete "{{ deletingMenu.title }}"?
                    This action cannot be undone.
                </p>
                <div class="mt-6 flex justify-end gap-3">
                    <button @click="cancelDelete"
                        class="rounded-lg border border-sidebar-border px-4 py-2 text-sm font-medium text-foreground transition-colors hover:bg-muted">
                        Cancel
                    </button>
                    <button @click="deleteMenu"
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        <!-- <Toast /> -->
    </AppLayout>
</template>
