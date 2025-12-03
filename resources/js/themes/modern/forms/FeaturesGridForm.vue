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
    features: props.data.features || [
        { icon: 'shield', title: 'Secure Platform', description: 'Enterprise-grade security' },
        { icon: 'zap', title: 'Lightning Fast', description: 'Optimized for performance' },
        { icon: 'settings', title: 'Easy to Use', description: 'Intuitive interface' }
    ],
    ...props.data
});

watch(() => props.data, (newData) => {
    formData.value = { ...newData };
}, { deep: true });

const addFeature = () => {
    formData.value.features.push({ icon: '', title: '', description: '' });
};

const removeFeature = (index) => {
    formData.value.features.splice(index, 1);
};

const save = () => emit('save', formData.value);
</script>

<template>
    <div v-if="editing" class="space-y-4">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Title</label>
            <input v-model="formData.title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Why Choose Us" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Subtitle</label>
            <input v-model="formData.subtitle" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="We provide comprehensive solutions" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Features</label>
            <div class="space-y-3">
                <div v-for="(feature, index) in formData.features" :key="index"
                    class="rounded-lg border border-sidebar-border p-3 space-y-2">
                    <div class="flex gap-2">
                        <input v-model="feature.icon" type="text"
                            class="w-32 rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                            placeholder="Icon (e.g., shield)" />
                        <input v-model="feature.title" type="text"
                            class="flex-1 rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                            placeholder="Feature Title" />
                        <button @click="removeFeature(index)" type="button"
                            class="rounded-lg border border-sidebar-border px-3 py-2 text-sm hover:bg-muted">
                            ×
                        </button>
                    </div>
                    <textarea v-model="feature.description" rows="2"
                        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                        placeholder="Feature description"></textarea>
                </div>
                <button @click="addFeature" type="button"
                    class="w-full rounded-lg border border-dashed border-sidebar-border px-3 py-2 text-sm hover:bg-muted">
                    + Add Feature
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
        <h3 class="mb-2 text-lg font-bold">{{ formData.title || 'Features Grid' }}</h3>
        <p v-if="formData.subtitle" class="mb-2 text-sm text-muted-foreground">{{ formData.subtitle }}</p>
        <div class="text-xs text-muted-foreground">{{ formData.features.length }} features</div>
    </div>
</template>
