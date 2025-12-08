<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    data: { type: Object, default: () => ({}) },
    editing: { type: Boolean, default: false }
});

const emit = defineEmits(['save', 'cancel']);

const formData = ref({
    title: props.data.title || '',
    sub_title: props.data.sub_title || '',
    video_url: props.data.video_url || '',
    video_type: props.data.video_type || 'youtube',
    autoplay: props.data.autoplay || false,
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
            <label class="mb-1.5 block text-sm font-medium text-foreground">Section Title</label>
            <input v-model="formData.title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                placeholder="Watch Our Video" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Subtitle</label>
            <input v-model="formData.sub_title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                placeholder="Learn more about us" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Video URL</label>
            <input v-model="formData.video_url" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                placeholder="https://www.youtube.com/watch?v=..." />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Video Type</label>
            <select v-model="formData.video_type"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
                <option value="youtube">YouTube</option>
                <option value="vimeo">Vimeo</option>
                <option value="direct">Direct Link</option>
            </select>
        </div>

        <div class="flex items-center gap-3">
            <input id="autoplay" v-model="formData.autoplay" type="checkbox"
                class="h-4 w-4 rounded border-sidebar-border text-primary focus:ring-2 focus:ring-primary/20" />
            <label for="autoplay" class="text-sm font-medium text-foreground">Autoplay Video</label>
        </div>

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

    <div v-else class="space-y-2">
        <div class="rounded-lg bg-muted/30 p-4">
            <h3 class="mb-2 text-lg font-bold text-foreground">{{ formData.title || 'Video Section' }}</h3>
            <p v-if="formData.sub_title" class="mb-2 text-sm text-muted-foreground">{{ formData.sub_title }}</p>
            <div v-if="formData.video_url" class="mt-2 text-xs text-muted-foreground">
                Video: {{ formData.video_url.substring(0, 50) }}...
            </div>
            <div class="mt-2 flex gap-2">
                <span class="rounded-full bg-red-500/10 px-2 py-1 text-xs font-medium text-red-600 dark:text-red-400">
                    {{ formData.video_type }}
                </span>
                <span v-if="formData.autoplay"
                    class="rounded-full bg-green-500/10 px-2 py-1 text-xs font-medium text-green-600 dark:text-green-400">
                    Autoplay
                </span>
            </div>
        </div>
    </div>
</template>
