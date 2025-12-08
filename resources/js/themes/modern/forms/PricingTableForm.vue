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
    plans: props.data.plans || [
        {
            name: 'Basic',
            description: 'Perfect for small teams',
            price: '19',
            period: 'month',
            features: ['10 projects', '5 GB storage', 'Basic analytics'],
            button_text: 'Get Started',
            featured: false
        },
        {
            name: 'Pro',
            description: 'For growing businesses',
            price: '49',
            period: 'month',
            features: ['Unlimited projects', '50 GB storage', 'Advanced analytics', 'Priority support'],
            button_text: 'Get Started',
            featured: true
        },
        {
            name: 'Enterprise',
            description: 'For large organizations',
            price: '99',
            period: 'month',
            features: ['Unlimited projects', '500 GB storage', 'Enterprise analytics', '24/7 support', 'Custom solutions'],
            button_text: 'Contact Sales',
            featured: false
        }
    ],
    ...props.data
});

watch(() => props.data, (newData) => {
    formData.value = { ...newData };
}, { deep: true });

const addPlan = () => {
    formData.value.plans.push({
        name: '',
        description: '',
        price: '',
        period: 'month',
        features: [],
        button_text: 'Get Started',
        featured: false
    });
};

const removePlan = (index) => {
    formData.value.plans.splice(index, 1);
};

const addFeature = (planIndex) => {
    formData.value.plans[planIndex].features.push('');
};

const removeFeature = (planIndex, featureIndex) => {
    formData.value.plans[planIndex].features.splice(featureIndex, 1);
};

const save = () => emit('save', formData.value);
</script>

<template>
    <div v-if="editing" class="space-y-4">
        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Title</label>
            <input v-model="formData.title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Simple, Transparent Pricing" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Subtitle</label>
            <input v-model="formData.subtitle" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Choose the plan that fits your needs" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Pricing Plans</label>
            <div class="space-y-3 max-h-96 overflow-y-auto">
                <div v-for="(plan, planIndex) in formData.plans" :key="planIndex"
                    class="rounded-lg border border-sidebar-border p-3 space-y-2">
                    <div class="flex gap-2">
                        <input v-model="plan.name" type="text"
                            class="flex-1 rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                            placeholder="Plan Name" />
                        <label class="flex items-center gap-2">
                            <input v-model="plan.featured" type="checkbox" class="rounded">
                            <span class="text-sm">Featured</span>
                        </label>
                        <button @click="removePlan(planIndex)" type="button"
                            class="rounded-lg border border-sidebar-border px-3 py-2 text-sm hover:bg-muted">
                            ×
                        </button>
                    </div>
                    <input v-model="plan.description" type="text"
                        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                        placeholder="Description" />
                    <div class="grid grid-cols-3 gap-2">
                        <input v-model="plan.price" type="text"
                            class="rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                            placeholder="Price" />
                        <input v-model="plan.period" type="text"
                            class="rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                            placeholder="Period" />
                        <input v-model="plan.button_text" type="text"
                            class="rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                            placeholder="Button Text" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-medium">Features:</label>
                        <div v-for="(feature, featureIndex) in plan.features" :key="featureIndex" class="flex gap-2">
                            <input v-model="plan.features[featureIndex]" type="text"
                                class="flex-1 rounded-lg border border-sidebar-border bg-background px-3 py-1 text-sm"
                                placeholder="Feature" />
                            <button @click="removeFeature(planIndex, featureIndex)" type="button"
                                class="rounded-lg border border-sidebar-border px-2 text-sm hover:bg-muted">
                                ×
                            </button>
                        </div>
                        <button @click="addFeature(planIndex)" type="button"
                            class="w-full rounded-lg border border-dashed border-sidebar-border px-2 py-1 text-xs hover:bg-muted">
                            + Add Feature
                        </button>
                    </div>
                </div>
                <button @click="addPlan" type="button"
                    class="w-full rounded-lg border border-dashed border-sidebar-border px-3 py-2 text-sm hover:bg-muted">
                    + Add Plan
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
        <h3 class="mb-2 text-lg font-bold">{{ formData.title || 'Pricing Table' }}</h3>
        <p v-if="formData.subtitle" class="mb-2 text-sm text-muted-foreground">{{ formData.subtitle }}</p>
        <div class="text-xs text-muted-foreground">{{ formData.plans.length }} plans</div>
    </div>
</template>
