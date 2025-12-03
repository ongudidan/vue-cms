<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    data: { type: Object, default: () => ({}) },
    editing: { type: Boolean, default: false }
});

const emit = defineEmits(['save', 'cancel']);

const formData = ref({
    title: props.data.title || '',
    subtitle: props.data.subtitle || '',
    button_text: props.data.button_text || '',
    button_url: props.data.button_url || '',
    ...props.data
});

watch(() => props.data, (newData) => {
    formData.value = { ...newData };
}, { deep: true });

const save = () => emit('save', formData.value);
</script>

<template>
    <div v-if="editing" class="space-y-4">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Title</label>
            <input v-model="formData.title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Simple. Powerful. Effective." />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Subtitle</label>
            <textarea v-model="formData.subtitle" rows="2"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Our platform helps you focus on what matters most"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-foreground">Button Text</label>
                <input v-model="formData.button_text" type="text"
                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                    placeholder="Try It Free" />
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-foreground">Button URL</label>
                <input v-model="formData.button_url" type="text"
                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                    placeholder="/signup" />
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
        <h3 class="mb-2 text-lg font-bold">{{ formData.title || 'Hero Minimal' }}</h3>
        <p v-if="formData.subtitle" class="text-sm text-muted-foreground">{{ formData.subtitle }}</p>
    </div>
</template>
