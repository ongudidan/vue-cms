<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({})
    },
    editing: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['save', 'cancel']);

const formData = ref({
    title: props.data.title || '',
    sub_title: props.data.sub_title || '',
    details: props.data.details || '',
    backgroundImage: props.data.backgroundImage || '',
    has_cta_buttons: props.data.has_cta_buttons || false,
    ...props.data
});

watch(() => props.data, (newData) => {
    formData.value = { ...newData };
}, { deep: true });

const save = () => {
    emit('save', formData.value);
};
</script>

<template>
    <div v-if="editing" class="space-y-4">
        <!-- Title -->
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">
                Title <span class="text-red-500">*</span>
            </label>
            <input v-model="formData.title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                placeholder="Enter hero title" />
        </div>

        <!-- Subtitle -->
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">
                Subtitle
            </label>
            <input v-model="formData.sub_title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                placeholder="Enter subtitle" />
        </div>

        <!-- Details -->
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">
                Details
            </label>
            <textarea v-model="formData.details" rows="4"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                placeholder="Enter hero details"></textarea>
        </div>

        <!-- Background Image URL -->
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">
                Background Image URL
            </label>
            <input v-model="formData.backgroundImage" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                placeholder="https://example.com/image.jpg" />
        </div>

        <!-- Has CTA Buttons -->
        <div class="flex items-center gap-3">
            <input id="has_cta_buttons" v-model="formData.has_cta_buttons" type="checkbox"
                class="h-4 w-4 rounded border-sidebar-border text-primary focus:ring-2 focus:ring-primary/20" />
            <label for="has_cta_buttons" class="text-sm font-medium text-foreground">
                Show CTA Buttons
            </label>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-2 border-t border-sidebar-border pt-4">
            <button @click="save" type="button"
                class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-all hover:bg-primary/90 hover:shadow-md">
                Save
            </button>
            <button @click="$emit('cancel')" type="button"
                class="rounded-lg border border-sidebar-border px-4 py-2 text-sm font-medium text-foreground transition-colors hover:bg-muted">
                Cancel
            </button>
        </div>
    </div>

    <!-- Preview Mode -->
    <div v-else class="space-y-2">
        <div class="rounded-lg bg-muted/30 p-4">
            <h3 class="mb-2 text-lg font-bold text-foreground">{{ formData.title || 'No title set' }}</h3>
            <p v-if="formData.sub_title" class="mb-2 text-sm text-muted-foreground">{{ formData.sub_title }}</p>
            <p v-if="formData.details" class="text-sm text-foreground">{{ formData.details }}</p>
            <div v-if="formData.backgroundImage" class="mt-2 text-xs text-muted-foreground">
                Background: {{ formData.backgroundImage }}
            </div>
            <div v-if="formData.has_cta_buttons" class="mt-2">
                <span class="rounded-full bg-primary/10 px-2 py-1 text-xs font-medium text-primary">
                    CTA Buttons Enabled
                </span>
            </div>
        </div>
    </div>
</template>
