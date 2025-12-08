<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import ServiceModal from './ServiceModal.vue';
import ServiceTable from './ServiceTable.vue';
import { Head, router } from '@inertiajs/vue3';
import { Plus, Search } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
});

const breadcrumbs = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Components', href: '/admin/components' },
    { title: 'Services', href: '/admin/services' },
];

// Modal state
const showModal = ref(false);
const editingService = ref(null);
const deletingService = ref(null);

// Search and filter state
const searchQuery = ref(props.data.filters.search || '');
const activeFilter = ref(props.data.filters.active || '');

// Modal handlers
const openCreateModal = () => {
    editingService.value = null;
    showModal.value = true;
};

const openEditModal = (service) => {
    editingService.value = service;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    editingService.value = null;
};

// Search and filter
const handleSearch = () => {
    router.get('/admin/services', {
        search: searchQuery.value,
        active: activeFilter.value,
    }, {
        preserveState: true,
        preserveScroll: true,
    });
};

// Delete handlers
const confirmDelete = (service) => {
    deletingService.value = service;
};

const deleteService = () => {
    if (!deletingService.value) return;
    
    router.delete(`/admin/services/${deletingService.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            deletingService.value = null;
        },
    });
};

const cancelDelete = () => {
    deletingService.value = null;
};
</script>

<template>
    <Head title="Services" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Page Header -->
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <h1 class="text-3xl font-bold tracking-tight text-foreground">
                        Services
                    </h1>
                    <p class="text-sm text-muted-foreground">
                        Manage your service offerings
                    </p>
                </div>
                <button
                    @click="openCreateModal"
                    class="flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-all hover:bg-primary/90 hover:shadow-md"
                >
                    <Plus class="h-4 w-4" />
                    Create Service
                </button>
            </div>

            <!-- Search and Filters -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                <div class="relative flex-1">
                    <Search class="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" />
                    <input
                        v-model="searchQuery"
                        @keyup.enter="handleSearch"
                        type="text"
                        placeholder="Search services..."
                        class="w-full rounded-lg border border-sidebar-border bg-background py-2 pl-10 pr-4 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                    />
                </div>
                <select
                    v-model="activeFilter"
                    @change="handleSearch"
                    class="rounded-lg border border-sidebar-border bg-background px-4 py-2 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                >
                    <option value="">All Status</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <!-- Services Table -->
            <ServiceTable 
                :services="data.services" 
                @edit="openEditModal" 
                @delete="confirmDelete" 
            />
        </div>

        <!-- Service Modal -->
        <ServiceModal
            :show="showModal"
            :service="editingService"
            @close="closeModal"
        />

        <!-- Delete Confirmation Modal -->
        <div
            v-if="deletingService"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
            @click.self="cancelDelete"
        >
            <div class="w-full max-w-md rounded-xl border border-sidebar-border bg-card p-6 shadow-xl">
                <h3 class="text-lg font-semibold text-foreground">Delete Service</h3>
                <p class="mt-2 text-sm text-muted-foreground">
                    Are you sure you want to delete "{{ deletingService.title }}"?
                    This action cannot be undone.
                </p>
                <div class="mt-6 flex justify-end gap-3">
                    <button
                        @click="cancelDelete"
                        class="rounded-lg border border-sidebar-border px-4 py-2 text-sm font-medium text-foreground transition-colors hover:bg-muted"
                    >
                        Cancel
                    </button>
                    <button
                        @click="deleteService"
                        class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
