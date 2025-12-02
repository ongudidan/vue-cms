<script setup>
import { ref } from 'vue';
import draggable from 'vuedraggable';
import { GripVertical, Edit, Trash2, ChevronDown, ChevronUp } from 'lucide-vue-next';
import HeroSection from './Sections/HeroSection.vue';
import TextSection from './Sections/TextSection.vue';
import ImageSection from './Sections/ImageSection.vue';
import CTASection from './Sections/CTASection.vue';

const props = defineProps({
    content: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['update:content']);

const sections = ref([...props.content]);
const drag = ref(false);
const editingSection = ref(null);

// Available section types
const sectionTypes = [
    { type: 'hero', label: 'Hero Banner', icon: '🎯', component: HeroSection },
    { type: 'text', label: 'Text Content', icon: '📝', component: TextSection },
    { type: 'image', label: 'Image', icon: '🖼️', component: ImageSection },
    { type: 'cta', label: 'Call to Action', icon: '🎬', component: CTASection },
];

// Get component for section type
const getSectionComponent = (type) => {
    const sectionType = sectionTypes.find(s => s.type === type);
    return sectionType?.component || TextSection;
};

// Add new section
const addSection = (type) => {
    const newSection = {
        id: `section-${Date.now()}`,
        type: type,
        order: sections.value.length,
        data: getDefaultData(type),
    };

    sections.value.push(newSection);
    updateContent();
};

// Get default data for section type
const getDefaultData = (type) => {
    const defaults = {
        hero: {
            title: 'Hero Title',
            subtitle: 'Hero subtitle text',
            buttonText: 'Learn More',
            buttonLink: '#',
            backgroundImage: '',
            settings: { alignment: 'center', padding: 'large' },
        },
        text: {
            content: '<p>Enter your text content here...</p>',
            settings: { alignment: 'left', padding: 'medium' },
        },
        image: {
            url: '',
            alt: '',
            caption: '',
            settings: { alignment: 'center', padding: 'medium' },
        },
        cta: {
            title: 'Ready to get started?',
            description: 'Join thousands of satisfied customers',
            buttonText: 'Get Started',
            buttonLink: '#',
            settings: { alignment: 'center', padding: 'large', background: '#f3f4f6' },
        },
    };

    return defaults[type] || {};
};

// Remove section
const removeSection = (index) => {
    sections.value.splice(index, 1);
    updateSectionOrders();
    updateContent();
};

// Edit section
const editSection = (index) => {
    editingSection.value = index;
};

// Save section
const saveSection = (index, data) => {
    sections.value[index].data = data;
    editingSection.value = null;
    updateContent();
};

// Cancel edit
const cancelEdit = () => {
    editingSection.value = null;
};

// Move section
const moveSection = (index, direction) => {
    const newIndex = direction === 'up' ? index - 1 : index + 1;
    if (newIndex >= 0 && newIndex < sections.value.length) {
        const temp = sections.value[index];
        sections.value[index] = sections.value[newIndex];
        sections.value[newIndex] = temp;
        updateSectionOrders();
        updateContent();
    }
};

// Update section orders after drag/drop or move
const updateSectionOrders = () => {
    sections.value.forEach((section, index) => {
        section.order = index;
    });
};

// Drag end handler
const onDragEnd = () => {
    drag.value = false;
    updateSectionOrders();
    updateContent();
};

// Update parent content
const updateContent = () => {
    emit('update:content', sections.value);
};
</script>

<template>
    <div class="flex gap-6 min-h-[500px]">
        <!-- Left Sidebar - Available Sections -->
        <div class="w-64 flex-shrink-0 space-y-3">
            <h3 class="text-sm font-semibold text-foreground mb-3">Available Sections</h3>
            <p class="text-xs text-muted-foreground mb-4">Click to add to your page</p>
            <div class="space-y-2">
                <button v-for="sectionType in sectionTypes" :key="sectionType.type"
                    @click="addSection(sectionType.type)" type="button"
                    class="w-full flex items-center gap-3 rounded-lg border border-sidebar-border bg-card p-3 text-left transition-all hover:border-primary hover:shadow-md hover:scale-105">
                    <span class="text-2xl">{{ sectionType.icon }}</span>
                    <span class="text-sm font-medium text-foreground">{{ sectionType.label }}</span>
                </button>
            </div>
        </div>

        <!-- Right Content - Page Sections -->
        <div class="flex-1 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-foreground">Page Sections</h3>
                <span class="text-xs text-muted-foreground">
                    {{ sections.length }} section{{ sections.length !== 1 ? 's' : '' }}
                </span>
            </div>

            <!-- Sections List -->
            <draggable v-model="sections" @start="drag = true" @end="onDragEnd" item-key="id" handle=".drag-handle"
                class="space-y-3">
                <template #item="{ element: section, index }">
                    <div
                        class="group rounded-lg border border-sidebar-border bg-card overflow-hidden transition-shadow hover:shadow-md">
                        <!-- Section Header -->
                        <div class="flex items-center gap-3 bg-muted/30 px-4 py-3">
                            <button type="button"
                                class="drag-handle cursor-move text-muted-foreground hover:text-foreground">
                                <GripVertical class="h-5 w-5" />
                            </button>
                            <div class="flex-1">
                                <span class="text-sm font-medium text-foreground">
                                    {{sectionTypes.find(s => s.type === section.type)?.label || section.type}}
                                </span>
                            </div>
                            <div class="flex items-center gap-1">
                                <button v-if="index > 0" @click="moveSection(index, 'up')" type="button"
                                    class="rounded p-1 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground"
                                    title="Move up">
                                    <ChevronUp class="h-4 w-4" />
                                </button>
                                <button v-if="index < sections.length - 1" @click="moveSection(index, 'down')"
                                    type="button"
                                    class="rounded p-1 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground"
                                    title="Move down">
                                    <ChevronDown class="h-4 w-4" />
                                </button>
                                <button @click="editSection(index)" type="button"
                                    class="rounded p-1 text-muted-foreground transition-colors hover:bg-muted hover:text-foreground"
                                    title="Edit">
                                    <Edit class="h-4 w-4" />
                                </button>
                                <button @click="removeSection(index)" type="button"
                                    class="rounded p-1 text-muted-foreground transition-colors hover:bg-red-100 hover:text-red-600 dark:hover:bg-red-950"
                                    title="Delete">
                                    <Trash2 class="h-4 w-4" />
                                </button>
                            </div>
                        </div>

                        <!-- Section Content -->
                        <div class="p-4">
                            <component :is="getSectionComponent(section.type)" :data="section.data"
                                :editing="editingSection === index" @save="(data) => saveSection(index, data)"
                                @cancel="cancelEdit" />
                        </div>
                    </div>
                </template>
            </draggable>

            <!-- Empty State -->
            <div v-if="sections.length === 0"
                class="rounded-lg border-2 border-dashed border-sidebar-border bg-muted/30 p-12 text-center">
                <p class="text-sm text-muted-foreground">No sections yet. Click a section type from the left sidebar to
                    add it to
                    your page.</p>
            </div>
        </div>
    </div>
</template>
