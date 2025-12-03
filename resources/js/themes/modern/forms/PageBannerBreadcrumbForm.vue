<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    data: { type: Object, default: () => ({}) },
    editing: { type: Boolean, default: false }
});

const emit = defineEmits(['save', 'cancel']);

const formData = ref({
    title: props.data.title || '',
    breadcrumb_items: props.data.breadcrumb_items || [
        { label: 'Home', url: '/' },
        { label: 'Blog', url: '/blog' }
    ],
    ...props.data
});

watch(() => props.data, (newData) => {
    formData.value = { ...newData };
}, { deep: true });

const addBreadcrumb = () => {
    formData.value.breadcrumb_items.push({ label: '', url: '' });
};

const removeBreadcrumb = (index) => {
    formData.value.breadcrumb_items.splice(index, 1);
};

const save = () => emit('save', formData.value);
</script>

<template>
    <div v-if="editing" class="space-y-4">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Title</label>
            <input v-model="formData.title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Article Title" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Breadcrumb Items</label>
            <div class="space-y-2">
                <div v-for="(item, index) in formData.breadcrumb_items" :key="index" class="flex gap-2">
                    <input v-model="item.label" type="text"
                        class="flex-1 rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                        placeholder="Label" />
                    <input v-model="item.url" type="text"
                        class="flex-1 rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                        placeholder="URL" />
                    <button @click="removeBreadcrumb(index)" type="button"
                        class="rounded-lg border border-sidebar-border px-3 py-2 text-sm hover:bg-muted">
                        ×
                    </button>
                </div>
                <button @click="addBreadcrumb" type="button"
                    class="w-full rounded-lg border border-dashed border-sidebar-border px-3 py-2 text-sm hover:bg-muted">
                    + Add Breadcrumb
                </button>
            </div>
        </div>

        <div class="flex gap-2 border-t border-sidebar-border pt-4">
            <button @click="save" type="button"
                class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground hover:bg-primary/90">
                Save
            </button>
            <button @click="$emit('cancel')" type="button"
                class="rounded-lg border border-sidebar-border px-4 py-2 text-sm font-medium hover:bg-muted">
                Cancel
            </button>
        </div>
    </div>

    <div v-else class="rounded-lg bg-muted/30 p-4">
        <h3 class="mb-2 text-lg font-bold">{{ formData.title || 'Page Banner with Breadcrumb' }}</h3>
        <div class="flex gap-2 text-xs text-muted-foreground">
            <span v-for="(item, index) in formData.breadcrumb_items" :key="index">
                {{ item.label }}<span v-if="index < formData.breadcrumb_items.length - 1"> / </span>
            </span>
        </div>
    </div>
</template>
