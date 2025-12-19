<script setup>
import { ref, watch, onBeforeUnmount } from 'vue';
import { X, Image as ImageIcon } from 'lucide-vue-next';

const props = defineProps({
    data: { type: Object, default: () => ({}) },
    editing: { type: Boolean, default: false }
});

const emit = defineEmits(['save', 'cancel']);

const formData = ref({
    title: props.data.title || '',
    subtitle: props.data.subtitle || '',
    primary_button_text: props.data.primary_button_text || '',
    primary_button_url: props.data.primary_button_url || '',
    secondary_button_text: props.data.secondary_button_text || '',
    secondary_button_url: props.data.secondary_button_url || '',
    background_image: props.data.background_image || '',
    ...props.data
});

watch(() => props.data, (newData) => {
    formData.value = { ...newData };
}, { deep: true });

const imagePreview = ref(null);

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        formData.value.background_image = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const removeImage = () => {
    formData.value.background_image = null;
    imagePreview.value = null;
};

onBeforeUnmount(() => {
    if (imagePreview.value) {
        URL.revokeObjectURL(imagePreview.value);
    }
});

const save = () => emit('save', formData.value);
</script>

<template>
    <div v-if="editing" class="space-y-4">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Title</label>
            <input v-model="formData.title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Build Amazing Digital Experiences" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Subtitle</label>
            <textarea v-model="formData.subtitle" rows="2"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="We help businesses grow through innovative solutions"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-foreground">Primary Button Text</label>
                <input v-model="formData.primary_button_text" type="text"
                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                    placeholder="Get Started" />
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-foreground">Primary Button URL</label>
                <input v-model="formData.primary_button_url" type="text"
                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                    placeholder="/contact" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="mb-1.5 block text-sm font-medium text-foreground">Secondary Button Text</label>
                <input v-model="formData.secondary_button_text" type="text"
                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                    placeholder="Learn More" />
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-medium text-foreground">Secondary Button URL</label>
                <input v-model="formData.secondary_button_url" type="text"
                    class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                    placeholder="/about" />
            </div>
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Background Image</label>
            <div class="mt-1 flex items-center gap-4">
                <div v-if="formData.background_image"
                    class="relative h-20 w-32 overflow-hidden rounded-lg border border-sidebar-border bg-muted">
                    <img :src="imagePreview || formData.background_image" class="h-full w-full object-cover" />
                    <button @click="removeImage" type="button"
                        class="absolute right-1 top-1 rounded-full bg-black/50 p-1 text-white hover:bg-black">
                        <X class="h-3 w-3" />
                    </button>
                </div>
                <div v-else
                    class="flex h-20 w-32 flex-col items-center justify-center rounded-lg border-2 border-dashed border-sidebar-border bg-muted/30 text-muted-foreground">
                    <ImageIcon class="h-6 w-6" />
                    <span class="text-[10px]">No image</span>
                </div>

                <label
                    class="cursor-pointer rounded-lg bg-secondary px-3 py-1.5 text-xs font-medium hover:bg-secondary/80">
                    <span>{{ formData.background_image ? 'Change' : 'Upload' }}</span>
                    <input type="file" @change="handleFileChange" accept="image/*" class="hidden" />
                </label>
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
        <h3 class="mb-2 text-lg font-bold">{{ formData.title || 'Hero Fullscreen' }}</h3>
        <p v-if="formData.subtitle" class="mb-2 text-sm text-muted-foreground">{{ formData.subtitle }}</p>
        <div class="flex gap-2">
            <span v-if="formData.primary_button_text"
                class="rounded-full bg-primary/10 px-2 py-1 text-xs font-medium text-primary">
                {{ formData.primary_button_text }}
            </span>
            <span v-if="formData.secondary_button_text"
                class="rounded-full bg-secondary/10 px-2 py-1 text-xs font-medium text-secondary">
                {{ formData.secondary_button_text }}
            </span>
        </div>
    </div>
</template>
