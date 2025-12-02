<script setup>
import { useForm } from '@inertiajs/vue3';
import { Upload, X } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    boardMember: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['close']);

const isEditing = computed(() => !!props.boardMember);
const imagePreview = ref(null);
const existingMedia = ref([]);

const form = useForm({
    name: '',
    slug: '',
    position: '',
    details: '',
    images: null,
    active: true,
});

// Watch for boardMember changes to populate form
watch(
    () => props.boardMember,
    (newBoardMember) => {
        if (newBoardMember) {
            form.name = newBoardMember.name;
            form.slug = newBoardMember.slug;
            form.position = newBoardMember.position || '';
            form.details = newBoardMember.details || '';
            form.active = newBoardMember.active;
            form.images = null;
            imagePreview.value = null;
            existingMedia.value = newBoardMember.media || [];
        } else {
            form.reset();
            imagePreview.value = null;
            existingMedia.value = [];
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
            imagePreview.value = null;
        }
    }
);

// Auto-generate slug from name (only when creating)
watch(
    () => form.name,
    (newName) => {
        if (!isEditing.value) {
            form.slug = newName
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    }
);

const handleImageUpload = (event) => {
    const files = event.target.files;

    if (files && files.length > 0) {
        form.images = Array.from(files);

        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.value = e.target?.result;
        };
        reader.readAsDataURL(files[0]);
    }
};

const removeImage = () => {
    form.images = null;
    imagePreview.value = null;
};

const submit = () => {
    if (isEditing.value && props.boardMember) {
        form.put(`/admin/board-members/${props.boardMember.id}`, {
            preserveScroll: true,
            onSuccess: () => emit('close'),
        });
    } else {
        form.post('/admin/board-members', {
            preserveScroll: true,
            onSuccess: () => emit('close'),
        });
    }
};

const close = () => emit('close');
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto bg-black/50 p-6"
        @click.self="close">

        <div class="w-full max-w-3xl rounded-xl border border-sidebar-border bg-card shadow-xl overflow-hidden">

            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-sidebar-border px-6 py-4">
                <h2 class="text-xl font-semibold text-foreground">
                    {{ isEditing ? 'Edit Board Member' : 'Create Board Member' }}
                </h2>
                <button @click="close"
                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">
                    <X class="h-5 w-5" />
                </button>
            </div>

            <!-- Modal Body -->
            <form @submit.prevent="submit" class="p-6 max-h-[75vh] overflow-y-auto">
                <div class="space-y-4">

                    <!-- Name Field -->
                    <div class="flex items-center gap-4">
                        <label for="name" class="w-24 text-sm font-medium text-foreground">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <div class="flex-1">
                            <input id="name" v-model="form.name" type="text" required
                                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                placeholder="Enter board member name" />
                            <p v-if="form.errors.name" class="mt-1 text-xs text-red-600 dark:text-red-400">
                                {{ form.errors.name }}
                            </p>
                        </div>
                    </div>

                    <!-- Slug Field -->
                    <div class="flex items-center gap-4">
                        <label for="slug" class="w-24 text-sm font-medium text-foreground">
                            Slug
                        </label>
                        <div class="flex-1">
                            <input id="slug" v-model="form.slug" type="text"
                                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                                placeholder="auto-generated-slug" />
                            <p class="mt-1 text-xs text-muted-foreground">
                                Auto-generated from name if left empty
                            </p>
                            <p v-if="form.errors.slug" class="mt-1 text-xs text-red-600 dark:text-red-400">
                                {{ form.errors.slug }}
                            </p>
                        </div>
                    </div>

                    <!-- Position Field -->
                    <div>
                        <label for="position" class="mb-1.5 block text-sm font-medium text-foreground">
                            Position
                        </label>
                        <input id="position" v-model="form.position" type="text"
                            class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                            placeholder="e.g., CEO, Board Chair, Director" />
                        <p v-if="form.errors.position" class="mt-1 text-xs text-red-600 dark:text-red-400">
                            {{ form.errors.position }}
                        </p>
                    </div>

                    <!-- Details Field -->
                    <div>
                        <label for="details" class="mb-1.5 block text-sm font-medium text-foreground">
                            Details
                        </label>
                        <textarea id="details" v-model="form.details" rows="3"
                            class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                            placeholder="Enter bio or description"></textarea>
                        <p v-if="form.errors.details" class="mt-1 text-xs text-red-600 dark:text-red-400">
                            {{ form.errors.details }}
                        </p>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="images" class="mb-1.5 block text-sm font-medium text-foreground">
                            Images
                        </label>
                        <div class="space-y-2">

                            <!-- Existing Media -->
                            <div v-if="existingMedia.length > 0 && !imagePreview" class="grid grid-cols-2 gap-2">
                                <div v-for="media in existingMedia" :key="media.id"
                                    class="relative rounded-lg border border-sidebar-border p-2">
                                    <img :src="media.url" :alt="media.file_name"
                                        class="h-20 w-full rounded object-cover" />
                                    <p class="mt-1 truncate text-xs text-muted-foreground" :title="media.file_name">
                                        {{ media.file_name }}
                                    </p>
                                </div>
                            </div>

                            <!-- Upload Button -->
                            <label v-if="!imagePreview" for="images"
                                class="flex cursor-pointer items-center justify-center gap-2 rounded-lg border-2 border-dashed border-sidebar-border bg-muted/30 px-4 py-6 text-sm text-muted-foreground transition-colors hover:border-primary hover:bg-muted/50">
                                <Upload class="h-4 w-4" />
                                <span>
                                    {{ existingMedia.length > 0 ? 'Replace images' : 'Click to upload images' }}
                                </span>
                                <input id="images" type="file" accept="image/*" multiple class="hidden"
                                    @change="handleImageUpload" />
                            </label>

                            <!-- New Image Preview -->
                            <div v-if="imagePreview" class="relative rounded-lg border border-sidebar-border p-2">
                                <img :src="imagePreview" alt="Preview" class="h-24 w-full rounded object-cover" />
                                <button type="button" @click="removeImage"
                                    class="absolute right-3 top-3 rounded-full bg-red-600 p-1 text-white shadow-lg transition-colors hover:bg-red-700">
                                    <X class="h-3 w-3" />
                                </button>
                            </div>

                            <p v-if="existingMedia.length > 0 && !imagePreview" class="text-xs text-muted-foreground">
                                Uploading new images will replace all existing images
                            </p>
                        </div>
                        <p v-if="form.errors.images" class="mt-1 text-xs text-red-600 dark:text-red-400">
                            {{ form.errors.images }}
                        </p>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center gap-3">
                        <input id="active" v-model="form.active" type="checkbox"
                            class="h-4 w-4 rounded border-sidebar-border text-primary focus:ring-2 focus:ring-primary/20" />
                        <label for="active" class="text-sm font-medium text-foreground">
                            Active
                        </label>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="mt-5 flex justify-end gap-3">
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
