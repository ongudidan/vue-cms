<script setup>
import { useForm } from '@inertiajs/vue3';
import { X } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    menu: {
        type: Object,
        default: null,
    },
    pages: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(['close']);

const isEditing = computed(() => !!props.menu);

const form = useForm({
    title: '',
    type: 'page',
    page_id: null,
    url: '',
    has_children: false,
    child_type: null,
    component: null,
    pages: [],
});

// Watch for menu changes to populate form
watch(
    () => props.menu,
    (newMenu) => {
        if (newMenu) {
            form.title = newMenu.title;
            form.type = newMenu.type;
            form.page_id = newMenu.page_id;
            form.url = newMenu.url || '';
            form.has_children = newMenu.has_children || false;
            form.child_type = newMenu.child_type;
            form.component = newMenu.component;
            form.pages = newMenu.pages?.map(p => p.id) || [];
        } else {
            form.reset();
        }
    },
    { immediate: true }
);

// Reset form when modal closes
watch(
    () => props.show,
    (newShow) => {
        if (!newShow) {
            form.reset();
            form.clearErrors();
        }
    }
);

// Watch type changes to clear irrelevant fields
watch(
    () => form.type,
    (newType) => {
        if (newType === 'page') {
            form.url = '';
        } else if (newType === 'custom') {
            form.page_id = null;
        }
    }
);

// Watch has_children changes
watch(
    () => form.has_children,
    (hasChildren) => {
        if (!hasChildren) {
            form.child_type = null;
            form.component = null;
            form.pages = [];
        }
    }
);

// Watch child_type changes
watch(
    () => form.child_type,
    (childType) => {
        if (childType === 'pages') {
            form.component = null;
        } else if (childType === 'components') {
            form.pages = [];
        } else {
            form.component = null;
            form.pages = [];
        }
    }
);

const submit = () => {
    if (isEditing.value && props.menu) {
        form.put(`/admin/menus/${props.menu.id}`, {
            preserveScroll: true,
            onSuccess: () => emit('close'),
        });
    } else {
        form.post('/admin/menus', {
            preserveScroll: true,
            onSuccess: () => emit('close'),
        });
    }
};

const close = () => emit('close');

const componentOptions = [
    { value: 'Projects', label: 'Projects' },
    { value: 'Blogs', label: 'Blogs' },
    { value: 'Services', label: 'Services' },
    { value: 'Events', label: 'Events' },
];
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" @click.self="close">

        <div
            class="w-full max-w-5xl max-h-[90vh] overflow-y-auto rounded-xl border border-sidebar-border bg-card shadow-xl">

            <!-- Modal Header -->
            <div
                class="sticky top-0 z-10 flex items-center justify-between border-b border-sidebar-border bg-card px-6 py-4">
                <h2 class="text-xl font-semibold text-foreground">
                    {{ isEditing ? 'Edit Menu Item' : 'Create Menu Item' }}
                </h2>
                <button @click="close"
                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">
                    <X class="h-5 w-5" />
                </button>
            </div>

            <!-- Modal Body -->
            <form @submit.prevent="submit" class="p-6">

                <!-- 🔥 NEW GRID WRAPPER FOR SIDE-BY-SIDE LAYOUT -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- LEFT: Basic Information Section -->
                    <div class="space-y-4 rounded-lg border border-sidebar-border p-4">
                        <div class="border-b border-sidebar-border pb-2">
                            <h3 class="text-sm font-semibold text-foreground">Basic Information</h3>
                            <p class="text-xs text-muted-foreground">Configure the menu item details</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <!-- Title Field -->
                            <div>
                                <label for="title" class="mb-1.5 block text-sm font-medium text-foreground">
                                    Title <span class="text-red-500">*</span>
                                </label>
                                <input id="title" v-model="form.title" type="text" required
                                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                    placeholder="Enter menu title" />
                                <p v-if="form.errors.title" class="mt-1 text-xs text-red-600 dark:text-red-400">
                                    {{ form.errors.title }}
                                </p>
                            </div>

                            <!-- Type Field -->
                            <div>
                                <label for="type" class="mb-1.5 block text-sm font-medium text-foreground">
                                    Type <span class="text-red-500">*</span>
                                </label>
                                <select id="type" v-model="form.type" required
                                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                                    <option value="page">Page</option>
                                    <option value="custom">Custom</option>
                                </select>
                                <p v-if="form.errors.type" class="mt-1 text-xs text-red-600 dark:text-red-400">
                                    {{ form.errors.type }}
                                </p>
                            </div>

                            <!-- Page ID Field -->
                            <div v-if="form.type === 'page'">
                                <label for="page_id" class="mb-1.5 block text-sm font-medium text-foreground">
                                    Page <span class="text-red-500">*</span>
                                </label>
                                <select id="page_id" v-model="form.page_id" :required="form.type === 'page'"
                                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                                    <option :value="null">Select a page</option>
                                    <option v-for="page in pages" :key="page.id" :value="page.id">
                                        {{ page.title }}
                                    </option>
                                </select>
                                <p v-if="form.errors.page_id" class="mt-1 text-xs text-red-600 dark:text-red-400">
                                    {{ form.errors.page_id }}
                                </p>
                            </div>

                            <!-- URL Field -->
                            <div v-if="form.type === 'custom'">
                                <label for="url" class="mb-1.5 block text-sm font-medium text-foreground">
                                    URL <span class="text-red-500">*</span>
                                </label>
                                <input id="url" v-model="form.url" type="text" :required="form.type === 'custom'"
                                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                    placeholder="https://example.com" />
                                <p v-if="form.errors.url" class="mt-1 text-xs text-red-600 dark:text-red-400">
                                    {{ form.errors.url }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT: Dropdown Configuration Section -->
                    <div class="space-y-4 rounded-lg border border-sidebar-border p-4">
                        <div class="border-b border-sidebar-border pb-2">
                            <h3 class="text-sm font-semibold text-foreground">Dropdown Configuration</h3>
                            <p class="text-xs text-muted-foreground">Configure dropdown menu settings</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4">

                            <!-- Has Children Toggle -->
                            <div>
                                <div class="flex items-center gap-3">
                                    <input id="has_children" v-model="form.has_children" type="checkbox"
                                        class="h-4 w-4 rounded border-sidebar-border text-primary focus:ring-2 focus:ring-primary/20" />
                                    <label for="has_children" class="text-sm font-medium text-foreground">
                                        Has Dropdown
                                    </label>
                                </div>
                            </div>

                            <!-- Child Type -->
                            <div v-if="form.has_children">
                                <label for="child_type" class="mb-1.5 block text-sm font-medium text-foreground">
                                    Child Type <span class="text-red-500">*</span>
                                </label>
                                <select id="child_type" v-model="form.child_type" :required="form.has_children"
                                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                                    <option :value="null">Select child type</option>
                                    <option value="pages">Pages</option>
                                    <option value="components">Components</option>
                                </select>
                                <p v-if="form.errors.child_type" class="mt-1 text-xs text-red-600 dark:text-red-400">
                                    {{ form.errors.child_type }}
                                </p>
                            </div>

                            <!-- Component Select -->
                            <div v-if="form.child_type === 'components'">
                                <label for="component" class="mb-1.5 block text-sm font-medium text-foreground">
                                    Component <span class="text-red-500">*</span>
                                </label>
                                <select id="component" v-model="form.component"
                                    :required="form.child_type === 'components'"
                                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                                    <option :value="null">Select a component</option>
                                    <option v-for="comp in componentOptions" :key="comp.value" :value="comp.value">
                                        {{ comp.label }}
                                    </option>
                                </select>
                                <p v-if="form.errors.component" class="mt-1 text-xs text-red-600 dark:text-red-400">
                                    {{ form.errors.component }}
                                </p>
                            </div>

                            <!-- Pages Multi-Select -->
                            <div v-if="form.child_type === 'pages'">
                                <label for="pages" class="mb-1.5 block text-sm font-medium text-foreground">
                                    Pages <span class="text-red-500">*</span>
                                </label>
                                <Multiselect v-model="form.pages" :options="pages" mode="tags" :searchable="true"
                                    :create-option="false" :close-on-select="false" placeholder="Select pages..."
                                    label="title" track-by="id" value-prop="id"
                                    class="multiselect-custom" />
                                <p class="mt-1 text-xs text-muted-foreground">
                                    Search and select multiple pages for the dropdown menu
                                </p>
                                <p v-if="form.errors.pages" class="mt-1 text-xs text-red-600 dark:text-red-400">
                                    {{ form.errors.pages }}
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="close"
                        class="rounded-lg border border-sidebar-border px-4 py-1.5 text-sm font-medium text-foreground transition-colors hover:bg-muted"
                        :disabled="form.processing">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-primary px-4 py-1.5 text-sm font-medium text-primary-foreground shadow-sm transition-all hover:bg-primary/90 hover:shadow-md disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="form.processing">
                        {{ form.processing ? 'Saving...' : isEditing ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

