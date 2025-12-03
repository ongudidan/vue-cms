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
    testimonials: props.data.testimonials || [
        {
            name: 'John Smith',
            position: 'CEO, Company Inc.',
            image: '',
            quote: 'Working with this team has been a game-changer for our business.'
        }
    ],
    ...props.data
});

watch(() => props.data, (newData) => {
    formData.value = { ...newData };
}, { deep: true });

const addTestimonial = () => {
    formData.value.testimonials.push({ name: '', position: '', image: '', quote: '' });
};

const removeTestimonial = (index) => {
    formData.value.testimonials.splice(index, 1);
};

const save = () => emit('save', formData.value);
</script>

<template>
    <div v-if="editing" class="space-y-4">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Title</label>
            <input v-model="formData.title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="What Our Clients Say" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Subtitle</label>
            <input v-model="formData.subtitle" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Don't just take our word for it" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Testimonials</label>
            <div class="space-y-3">
                <div v-for="(testimonial, index) in formData.testimonials" :key="index"
                    class="rounded-lg border border-sidebar-border p-3 space-y-2">
                    <div class="flex gap-2">
                        <input v-model="testimonial.name" type="text"
                            class="flex-1 rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                            placeholder="Name" />
                        <input v-model="testimonial.position" type="text"
                            class="flex-1 rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                            placeholder="Position" />
                        <button @click="removeTestimonial(index)" type="button"
                            class="rounded-lg border border-sidebar-border px-3 py-2 text-sm hover:bg-muted">
                            ×
                        </button>
                    </div>
                    <input v-model="testimonial.image" type="text"
                        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                        placeholder="Image URL" />
                    <textarea v-model="testimonial.quote" rows="2"
                        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                        placeholder="Testimonial quote"></textarea>
                </div>
                <button @click="addTestimonial" type="button"
                    class="w-full rounded-lg border border-dashed border-sidebar-border px-3 py-2 text-sm hover:bg-muted">
                    + Add Testimonial
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
        <h3 class="mb-2 text-lg font-bold">{{ formData.title || 'Testimonials' }}</h3>
        <p v-if="formData.subtitle" class="mb-2 text-sm text-muted-foreground">{{ formData.subtitle }}</p>
        <div class="text-xs text-muted-foreground">{{ formData.testimonials.length }} testimonials</div>
    </div>
</template>
