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
    faqs: props.data.faqs || [
        {
            question: 'How do I get started?',
            answer: 'Getting started is easy! Simply sign up for an account and follow our onboarding guide.'
        }
    ],
    ...props.data
});

watch(() => props.data, (newData) => {
    formData.value = { ...newData };
}, { deep: true });

const addFaq = () => {
    formData.value.faqs.push({ question: '', answer: '' });
};

const removeFaq = (index) => {
    formData.value.faqs.splice(index, 1);
};

const save = () => emit('save', formData.value);
</script>

<template>
    <div v-if="editing" class="space-y-4">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Title</label>
            <input v-model="formData.title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Frequently Asked Questions" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Subtitle</label>
            <input v-model="formData.subtitle" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Find answers to common questions" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">FAQ Items</label>
            <div class="space-y-3">
                <div v-for="(faq, index) in formData.faqs" :key="index"
                    class="rounded-lg border border-sidebar-border p-3 space-y-2">
                    <div class="flex gap-2">
                        <input v-model="faq.question" type="text"
                            class="flex-1 rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                            placeholder="Question" />
                        <button @click="removeFaq(index)" type="button"
                            class="rounded-lg border border-sidebar-border px-3 py-2 text-sm hover:bg-muted">
                            ×
                        </button>
                    </div>
                    <textarea v-model="faq.answer" rows="3"
                        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                        placeholder="Answer"></textarea>
                </div>
                <button @click="addFaq" type="button"
                    class="w-full rounded-lg border border-dashed border-sidebar-border px-3 py-2 text-sm hover:bg-muted">
                    + Add FAQ
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
        <h3 class="mb-2 text-lg font-bold">{{ formData.title || 'FAQ Accordion' }}</h3>
        <p v-if="formData.subtitle" class="mb-2 text-sm text-muted-foreground">{{ formData.subtitle }}</p>
        <div class="text-xs text-muted-foreground">{{ formData.faqs.length }} FAQs</div>
    </div>
</template>
