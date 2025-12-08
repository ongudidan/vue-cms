<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
    editing: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['save', 'cancel']);

const formData = ref({ ...props.data });

watch(() => props.data, (newData) => {
    formData.value = { ...newData };
}, { deep: true });

const save = () => {
    emit('save', formData.value);
};

const cancel = () => {
    formData.value = { ...props.data };
    emit('cancel');
};
</script>

<template>
    <!-- Edit Mode -->
    <div v-if="editing" class="space-y-4">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Content</label>
            <textarea v-model="formData.content" rows="6"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm font-mono"
                placeholder="Enter HTML content..."></textarea>
            <p class="mt-1 text-xs text-muted-foreground">Supports HTML</p>
        </div>
        <div class="flex justify-end gap-2">
            <button @click="cancel" type="button"
                class="rounded-lg border border-sidebar-border px-3 py-1.5 text-sm font-medium transition-colors hover:bg-muted">
                Cancel
            </button>
            <button @click="save" type="button"
                class="rounded-lg bg-primary px-3 py-1.5 text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90">
                Save
            </button>
        </div>
    </div>

    <!-- Preview Mode -->
    <div v-else class="prose prose-sm max-w-none" v-html="data.content"></div>
</template>
