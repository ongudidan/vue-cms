<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import PageModal from '@/pages/Admin/Pages/PageModal.vue';
import PageTable from '@/pages/Admin/Pages/PageTable.vue';
import { Head, router } from '@inertiajs/vue3';
import { Plus, Search } from 'lucide-vue-next';
import { ref, watch } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Pages', href: '/admin/pages' },
];

// Modal state
const showModal = ref(false);
const editingPage = ref(null);
const deletingPage = ref(null);

// Search and filter state
const searchQuery = ref(props.data.filters.search || '');
const publishedFilter = ref(props.data.filters.published || '');

// Modal handlers
const openCreateModal = () => {
    editingPage.value = null;
    showModal.value = true;
};

const openEditModal = (page) => {
    editingPage.value = { ...page };
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    editingPage.value = null;
};

// Search and filter
const handleSearch = () => {
    router.get('/admin/pages', {
        search: searchQuery.value,
        published: publishedFilter.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

// Delete handlers
const confirmDelete = (page) => {
    deletingPage.value = page;
};

const deletePage = () => {
    if (!deletingPage.value) return;

    router.delete(`/admin/pages/${deletingPage.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            deletingPage.value = null;
        },
    });
};

const cancelDelete = () => {
    deletingPage.value = null;
};
</script>

<template>

    <Head title="Pages" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <h1 class="text-3xl font-bold tracking-tight text-foreground">
                        Pages
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        Manage your website pages with dynamic content
                    </p>
                </div>
                <button @click="openCreateModal"
                    class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-all hover:bg-primary/90 hover:shadow-md">
                    <Plus class="h-4 w-4" />
                    Create Page
                </button>
            </div>

            <!-- Search and Filters -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div class="relative flex-1">
                    <Search class="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" />
                    <input v-model="searchQuery" @keyup.enter="handleSearch" type="text" placeholder="Search pages..."
                        class="w-full rounded-lg border border-sidebar-border bg-background py-2 pl-10 pr-4 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
                </div>
                <select v-model="publishedFilter" @change="handleSearch"
                    class="rounded-lg border border-sidebar-border bg-background px-4 py-2 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                    <option value="">All Status</option>
                    <option value="1">Published</option>
                    <option value="0">Draft</option>
                </select>
            </div>

            <!-- Pages Table -->
            <PageTable :pages="data.pages" @edit="openEditModal" @delete="confirmDelete" />
        </div>

        <!-- Page Modal -->
        <PageModal :show="showModal" :page="editingPage" @close="closeModal" />

        <!-- Delete Confirmation Modal -->
        <div v-if="deletingPage" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            @click.self="cancelDelete">
            <div class="w-full max-w-md rounded-xl border border-sidebar-border bg-card p-6 shadow-xl">
                <h3 class="text-lg font-semibold text-foreground">Delete Page</h3>
                <p class="mt-2 text-sm text-muted-foreground">
                    Are you sure you want to delete "{{ deletingPage.title }}"?
                    This action cannot be undone.
                </p>
                <div class="mt-6 flex justify-end gap-3">
                    <button @click="cancelDelete"
                        class="rounded-lg border border-sidebar-border px-4 py-2 text-sm font-medium text-foreground transition-colors hover:bg-muted">
                        Cancel
                    </button>
                    <button @click="deletePage"
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
