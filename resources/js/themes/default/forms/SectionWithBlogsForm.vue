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
    details: props.data.details || '',
    show_all_blogs: props.data.show_all_blogs || true,
    blog_limit: props.data.blog_limit || 6,
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
                placeholder="Latest Blog Posts" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Subtitle</label>
            <input v-model="formData.sub_title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                placeholder="Read our latest articles" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Description</label>
            <textarea v-model="formData.details" rows="3"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                placeholder="Section description"></textarea>
        </div>

        <div class="flex items-center gap-3">
            <input id="show_all_blogs" v-model="formData.show_all_blogs" type="checkbox"
                class="h-4 w-4 rounded border-sidebar-border text-primary focus:ring-2 focus:ring-primary/20" />
            <label for="show_all_blogs" class="text-sm font-medium text-foreground">Show All Blogs</label>
        </div>

        <div v-if="!formData.show_all_blogs">
            <label class="mb-1.5 block text-sm font-medium text-foreground">Number of Blogs to Display</label>
            <input v-model.number="formData.blog_limit" type="number" min="1" max="20"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
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
            <h3 class="mb-2 text-lg font-bold text-foreground">{{ formData.title || 'Blogs Section' }}</h3>
            <p v-if="formData.sub_title" class="mb-2 text-sm text-muted-foreground">{{ formData.sub_title }}</p>
            <p v-if="formData.details" class="text-sm text-foreground">{{ formData.details }}</p>
            <div class="mt-2">
                <span
                    class="rounded-full bg-blue-500/10 px-2 py-1 text-xs font-medium text-blue-600 dark:text-blue-400">
                    {{ formData.show_all_blogs ? 'All Blogs' : `${formData.blog_limit} Blogs` }}
                </span>
            </div>
        </div>
    </div>
</template>
