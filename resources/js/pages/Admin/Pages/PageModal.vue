<script setup>
import { useForm } from '@inertiajs/vue3';
import { X } from 'lucide-vue-next';
import { computed, ref, watch } from 'vue';
import PageBuilder from '@/components/PageBuilder/PageBuilder.vue';

const props = defineProps({
    show: {
        type: Boolean,
        required: true,
    },
    page: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['close']);

const isEditing = computed(() => !!props.page);
const activeTab = ref('basic');

const form = useForm({
    title: '',
    slug: '',
    description: '',
    content: [],
    published: false,
    is_homepage: false,
});

// Watch for page changes to populate form
watch(
    () => props.page,
    (newPage) => {
        if (newPage) {
            form.title = newPage.title;
            form.slug = newPage.slug || '';
            form.description = newPage.description || '';
            form.content = newPage.content || [];
            form.published = newPage.published || false;
            form.is_homepage = newPage.is_homepage || false;
        } else {
            form.reset();
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
            activeTab.value = 'basic';
        }
    }
);

const submit = () => {
    if (isEditing.value && props.page) {
        form.put(`/admin/pages/${props.page.id}`, {
            preserveScroll: true,
            onSuccess: () => emit('close'),
        });
    } else {
        form.post('/admin/pages', {
            preserveScroll: true,
            onSuccess: () => emit('close'),
        });
    }
};

const close = () => emit('close');

const updateContent = (newContent) => {
    form.content = newContent;
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-2" @click.self="close">

        <div
            class="w-full max-w-[98vw] max-h-[95vh] overflow-y-auto rounded-xl border border-sidebar-border bg-card shadow-xl">

            <!-- Modal Header -->
            <div
                class="sticky top-0 z-10 flex items-center justify-between border-b border-sidebar-border bg-card px-6 py-4">
                <h2 class="text-xl font-semibold text-foreground">
                    {{ isEditing ? 'Edit Page' : 'Create Page' }}
                </h2>
                <button @click="close"
                    class="rounded-lg p-2 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground">
                    <X class="h-5 w-5" />
                </button>
            </div>

            <!-- Tabs -->
            <div class="border-b border-sidebar-border bg-muted/30 px-6">
                <div class="flex gap-4">
                    <button @click="activeTab = 'basic'"
                        class="relative px-4 py-3 text-sm font-medium transition-colors" :class="activeTab === 'basic'
                            ? 'text-primary'
                            : 'text-muted-foreground hover:text-foreground'">
                        Basic Information
                        <div v-if="activeTab === 'basic'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary">
                        </div>
                    </button>
                    <button @click="activeTab = 'builder'"
                        class="relative px-4 py-3 text-sm font-medium transition-colors" :class="activeTab === 'builder'
                            ? 'text-primary'
                            : 'text-muted-foreground hover:text-foreground'">
                        Page Builder
                        <div v-if="activeTab === 'builder'" class="absolute bottom-0 left-0 right-0 h-0.5 bg-primary">
                        </div>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form @submit.prevent="submit" class="p-6">
                <!-- Basic Information Tab -->
                <div v-show="activeTab === 'basic'" class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="mb-1.5 block text-sm font-medium text-foreground">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input id="title" v-model="form.title" type="text" required
                            class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                            placeholder="Enter page title" />
                        <p v-if="form.errors.title" class="mt-1 text-xs text-red-600 dark:text-red-400">
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="mb-1.5 block text-sm font-medium text-foreground">
                            Slug
                        </label>
                        <input id="slug" v-model="form.slug" type="text"
                            class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                            placeholder="auto-generated-from-title" />
                        <p class="mt-1 text-xs text-muted-foreground">
                            Leave empty to auto-generate from title
                        </p>
                        <p v-if="form.errors.slug" class="mt-1 text-xs text-red-600 dark:text-red-400">
                            {{ form.errors.slug }}
                        </p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="mb-1.5 block text-sm font-medium text-foreground">
                            Description
                        </label>
                        <textarea id="description" v-model="form.description" rows="3"
                            class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
                            placeholder="Enter page description (for SEO)"></textarea>
                        <p v-if="form.errors.description" class="mt-1 text-xs text-red-600 dark:text-red-400">
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <!-- Published Toggle -->
                    <div class="flex items-center gap-3">
                        <input id="published" v-model="form.published" type="checkbox"
                            class="h-4 w-4 rounded border-sidebar-border text-primary focus:ring-2 focus:ring-primary/20" />
                        <label for="published" class="text-sm font-medium text-foreground">
                            Published
                        </label>
                    </div>

                    <!-- Homepage Toggle -->
                    <div class="flex items-center gap-3">
                        <input id="is_homepage" v-model="form.is_homepage" type="checkbox"
                            class="h-4 w-4 rounded border-sidebar-border text-primary focus:ring-2 focus:ring-primary/20" />
                        <label for="is_homepage" class="text-sm font-medium text-foreground">
                            Set as Homepage
                        </label>
                    </div>
                </div>

                <!-- Page Builder Tab -->
                <div v-show="activeTab === 'builder'">
                    <PageBuilder :content="form.content" @update:content="updateContent" />
                </div>

                <!-- Modal Footer -->
                <div class="mt-6 flex justify-end gap-3 border-t border-sidebar-border pt-6">
                    <button type="button" @click="close"
                        class="rounded-lg border border-sidebar-border px-4 py-2 text-sm font-medium text-foreground transition-colors hover:bg-muted"
                        :disabled="form.processing">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-primary-foreground shadow-sm transition-all hover:bg-primary/90 hover:shadow-md disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="form.processing">
                        {{ form.processing ? 'Saving...' : isEditing ? 'Update' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
