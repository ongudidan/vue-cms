<script setup>
import { useForm } from '@inertiajs/vue3';
import { Upload, X } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    partner: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['close']);

const isEditing = computed(() => !!props.partner);
const imagePreview = ref(null);
const existingMedia = ref([]);

const form = useForm({
    name: '',
    images: null,
    active: true,
});

// Watch for partner changes to populate form
watch(
    () => props.partner,
    (newPartner) => {
        if (newPartner) {
            form.name = newPartner.name;
            form.active = newPartner.active;
            form.images = null;
            imagePreview.value = null;
            existingMedia.value = newPartner.media || [];
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
    if (isEditing.value && props.partner) {
        form.put(`/admin/partners/${props.partner.id}`, {
            preserveScroll: true,
            onSuccess: () => emit('close'),
        });
    } else {
        form.post('/admin/partners', {
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

        <div class="w-full max-w-2xl rounded-xl border border-sidebar-border bg-card shadow-xl overflow-hidden">

            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-sidebar-border px-6 py-4">
                <h2 class="text-xl font-semibold text-foreground">
                    {{ isEditing ? 'Edit Partner' : 'Create Partner' }}
                </h2>
                <button @click="close"
                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">
                    <X class="h-5 w-5" />
                </button>
            </div>

            <!-- Modal Body -->
            <form @submit.prevent="submit" class="p-6">
                <div class="space-y-4">

                    <!-- Name Field -->
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-medium text-foreground">
                            Name <span class="text-red-500">*</span>
                        </label>
                        <input id="name" v-model="form.name" type="text" required
                            class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-1.5 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                            placeholder="Enter partner name" />
                        <p v-if="form.errors.name" class="mt-1 text-xs text-red-600 dark:text-red-400">
                            {{ form.errors.name }}
                        </p>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="images" class="mb-1.5 block text-sm font-medium text-foreground">
                            Logo
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
                                    {{ existingMedia.length > 0 ? 'Replace logo' : 'Click to upload logo' }}
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
