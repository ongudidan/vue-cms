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
            <label class="mb-1.5 block text-sm font-medium text-foreground">Title</label>
            <input v-model="formData.title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm" />
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Description</label>
            <textarea v-model="formData.description" rows="3"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-foreground">Button Text</label>
                <input v-model="formData.buttonText" type="text"
                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm" />
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-foreground">Button Link</label>
                <input v-model="formData.buttonLink" type="text"
                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm" />
            </div>
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
    <div v-else class="rounded-lg bg-muted/30 p-8 text-center"
        :style="{ backgroundColor: data.settings?.background || '#f3f4f6' }">
        <h3 class="text-2xl font-bold text-foreground">{{ data.title }}</h3>
        <p class="mt-2 text-muted-foreground">{{ data.description }}</p>
        <button class="mt-4 rounded-lg bg-primary px-6 py-2 text-sm font-medium text-primary-foreground">
            {{ data.buttonText }}
        </button>
    </div>
</template>
