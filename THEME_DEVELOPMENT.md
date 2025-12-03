# Theme Development Guide

Complete guide for creating custom themes for the Vue-Laravel CMS.

---

## Table of Contents

1. [Overview](#overview)
2. [Theme Architecture](#theme-architecture)
3. [Quick Start](#quick-start)
4. [Directory Structure](#directory-structure)
5. [Creating theme.json](#creating-themejson)
6. [Building Vue Form Components](#building-vue-form-components)
7. [Creating Blade Templates](#creating-blade-templates)
8. [Adding Assets](#adding-assets)
9. [Testing Your Theme](#testing-your-theme)
10. [Best Practices](#best-practices)
11. [Troubleshooting](#troubleshooting)

---

## Overview

Themes in this CMS define the available page sections that content editors can use when building pages. Each theme consists of:

- **Vue Form Components**: Admin forms for configuring sections
- **Blade Templates**: Frontend rendering templates
- **Assets**: CSS, JavaScript, images, and fonts
- **Configuration**: `theme.json` defining sections and metadata

**All theme files are stored in one location**: `resources/js/themes/your-theme/`

---

## Theme Architecture

### Unified Directory Structure

All theme files are now in a single location for better organization and portability:

```
resources/js/themes/your-theme/
├── theme.json                      # Theme configuration
├── forms/                          # Vue form components
│   └── YourSectionForm.vue
├── sections/                       # Blade templates
│   └── your-section.blade.php
└── assets/                         # CSS, JS, images, fonts
    ├── css/
    ├── js/
    ├── images/
    └── fonts/
```

**Benefits:**
- ✅ **Portable**: Entire theme in one directory
- ✅ **Organized**: No scattered files across project
- ✅ **Easy to share**: Zip one folder to distribute theme
- ✅ **Simpler**: One location to manage everything

---

## Quick Start

### Step 1: Create Directory Structure

```bash
# Create theme directory with all subdirectories
mkdir -p resources/js/themes/my-theme/{forms,sections,assets/{css,js,images,fonts}}
```

### Step 2: Create theme.json

Create `resources/js/themes/my-theme/theme.json`:

```json
{
    "name": "My Theme",
    "slug": "my-theme",
    "version": "1.0.0",
    "author": "Your Name",
    "description": "A custom theme for my website",
    "sections": [
        {
            "type": "hero-banner",
            "label": "Hero Banner",
            "icon": "🎯",
            "bladeTemplate": "themes.my-theme.sections.hero-banner",
            "vueForm": "my-theme/forms/HeroBannerForm.vue"
        }
    ]
}
```

### Step 3: Create a Vue Form Component

Create `resources/js/themes/my-theme/forms/HeroBannerForm.vue`:

```vue
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
    button_text: props.data.button_text || '',
    button_url: props.data.button_url || '',
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
            <label class="mb-1.5 block text-sm font-medium text-foreground">Title</label>
            <input v-model="formData.title" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Enter title" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Subtitle</label>
            <input v-model="formData.subtitle" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Enter subtitle" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Button Text</label>
            <input v-model="formData.button_text" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="Get Started" />
        </div>

        <div>
            <label class="mb-1.5 block text-sm font-medium text-foreground">Button URL</label>
            <input v-model="formData.button_url" type="text"
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
                placeholder="/contact" />
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
        <h3 class="mb-2 text-lg font-bold">{{ formData.title || 'Hero Banner' }}</h3>
        <p v-if="formData.subtitle" class="mb-2 text-sm text-muted-foreground">{{ formData.subtitle }}</p>
        <div v-if="formData.button_text" class="mt-2">
            <span class="rounded-full bg-primary/10 px-2 py-1 text-xs font-medium text-primary">
                Button: {{ formData.button_text }}
            </span>
        </div>
    </div>
</template>
```

### Step 4: Create a Blade Template

Create `resources/js/themes/my-theme/sections/hero-banner.blade.php`:

```blade
<section class="hero-banner py-20 bg-gradient-to-r from-blue-600 to-purple-600">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center text-white">
            @if(!empty($section['data']['title']))
                <h1 class="text-5xl font-bold mb-4">
                    {{ $section['data']['title'] }}
                </h1>
            @endif

            @if(!empty($section['data']['subtitle']))
                <p class="text-xl mb-8 opacity-90">
                    {{ $section['data']['subtitle'] }}
                </p>
            @endif

            @if(!empty($section['data']['button_text']))
                <a href="{{ $section['data']['button_url'] ?? '#' }}"
                   class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    {{ $section['data']['button_text'] }}
                </a>
            @endif
        </div>
    </div>
</section>
```

### Step 5: Sync and Activate

1. Navigate to `/admin/themes`
2. Click "Sync Themes" button
3. Your theme should appear in the list
4. Click "Activate" to make it active

---

## Directory Structure

### Complete Example

```
resources/js/themes/my-theme/
├── theme.json                      # Theme metadata
├── forms/                          # Vue form components
│   ├── HeroBannerForm.vue
│   ├── FeaturesForm.vue
│   ├── TestimonialsForm.vue
│   └── ContactForm.vue
├── sections/                       # Blade templates
│   ├── hero-banner.blade.php
│   ├── features.blade.php
│   ├── testimonials.blade.php
│   └── contact.blade.php
└── assets/                         # Theme assets
    ├── css/
    │   └── theme.css
    ├── js/
    │   └── theme.js
    ├── images/
    │   ├── logo.svg
    │   └── hero-bg.jpg
    └── fonts/
        └── custom-font.woff2
```

**File Locations:**
- **theme.json**: `resources/js/themes/my-theme/theme.json`
- **Vue Forms**: `resources/js/themes/my-theme/forms/*.vue`
- **Blade Templates**: `resources/js/themes/my-theme/sections/*.blade.php`
- **Assets**: `resources/js/themes/my-theme/assets/*`

---

## Creating theme.json

### Schema

```json
{
    "name": "string (required)",
    "slug": "string (required, lowercase-with-dashes)",
    "version": "string (semver format)",
    "author": "string",
    "description": "string",
    "sections": [
        {
            "type": "string (unique identifier)",
            "label": "string (display name)",
            "icon": "string (emoji or icon)",
            "bladeTemplate": "string (dot notation path)",
            "vueForm": "string (relative path from themes/)"
        }
    ]
}
```

### Field Descriptions

- **name**: Display name shown in admin
- **slug**: Unique identifier (used in URLs and paths)
- **version**: Theme version (e.g., "1.0.0")
- **author**: Your name or organization
- **description**: Brief description of the theme
- **sections**: Array of available sections

#### Section Fields

- **type**: Unique identifier (e.g., "hero-banner")
- **label**: Human-readable name (e.g., "Hero Banner")
- **icon**: Emoji or icon character (e.g., "🎯")
- **bladeTemplate**: Laravel view path (e.g., "themes.my-theme.sections.hero-banner")
- **vueForm**: Path to Vue form component (e.g., "my-theme/forms/HeroBannerForm.vue")

### Example with Multiple Sections

```json
{
    "name": "Corporate Theme",
    "slug": "corporate",
    "version": "1.0.0",
    "author": "Your Company",
    "description": "Professional theme for corporate websites",
    "sections": [
        {
            "type": "hero-banner",
            "label": "Hero Banner",
            "icon": "🎯",
            "bladeTemplate": "themes.corporate.sections.hero-banner",
            "vueForm": "corporate/forms/HeroBannerForm.vue"
        },
        {
            "type": "features-grid",
            "label": "Features Grid",
            "icon": "⭐",
            "bladeTemplate": "themes.corporate.sections.features-grid",
            "vueForm": "corporate/forms/FeaturesGridForm.vue"
        },
        {
            "type": "team-members",
            "label": "Team Members",
            "icon": "👥",
            "bladeTemplate": "themes.corporate.sections.team-members",
            "vueForm": "corporate/forms/TeamMembersForm.vue"
        },
        {
            "type": "contact-form",
            "label": "Contact Form",
            "icon": "📧",
            "bladeTemplate": "themes.corporate.sections.contact-form",
            "vueForm": "corporate/forms/ContactFormForm.vue"
        }
    ]
}
```

---

## Building Vue Form Components

### Component Structure

All Vue form components must follow this pattern:

```vue
<script setup>
import { ref, watch } from 'vue';

// Props
const props = defineProps({
    data: { type: Object, default: () => ({}) },
    editing: { type: Boolean, default: false }
});

// Emits
const emit = defineEmits(['save', 'cancel']);

// Form data
const formData = ref({
    // Initialize with props.data or defaults
    field1: props.data.field1 || '',
    field2: props.data.field2 || '',
    ...props.data
});

// Watch for external data changes
watch(() => props.data, (newData) => {
    formData.value = { ...newData };
}, { deep: true });

// Save handler
const save = () => {
    emit('save', formData.value);
};
</script>

<template>
    <!-- Edit Mode -->
    <div v-if="editing" class="space-y-4">
        <!-- Form fields here -->
        
        <!-- Action buttons -->
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

    <!-- Preview Mode -->
    <div v-else class="rounded-lg bg-muted/30 p-4">
        <!-- Preview content here -->
    </div>
</template>
```

### Common Form Fields

#### Text Input

```vue
<div>
    <label class="mb-1.5 block text-sm font-medium text-foreground">Field Label</label>
    <input v-model="formData.fieldName" type="text"
        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
        placeholder="Enter text" />
</div>
```

#### Textarea

```vue
<div>
    <label class="mb-1.5 block text-sm font-medium text-foreground">Description</label>
    <textarea v-model="formData.description" rows="4"
        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20"
        placeholder="Enter description"></textarea>
</div>
```

#### Checkbox

```vue
<div class="flex items-center gap-3">
    <input id="fieldName" v-model="formData.fieldName" type="checkbox"
        class="h-4 w-4 rounded border-sidebar-border text-primary focus:ring-2 focus:ring-primary/20" />
    <label for="fieldName" class="text-sm font-medium text-foreground">Enable Feature</label>
</div>
```

#### Select Dropdown

```vue
<div>
    <label class="mb-1.5 block text-sm font-medium text-foreground">Select Option</label>
    <select v-model="formData.option"
        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20">
        <option value="option1">Option 1</option>
        <option value="option2">Option 2</option>
        <option value="option3">Option 3</option>
    </select>
</div>
```

#### Number Input

```vue
<div>
    <label class="mb-1.5 block text-sm font-medium text-foreground">Count</label>
    <input v-model.number="formData.count" type="number" min="1" max="10"
        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm text-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-primary/20" />
</div>
```

---

## Creating Blade Templates

### Template Structure

Blade templates receive a `$section` variable containing the section data:

```blade
<section class="my-section">
    <div class="container">
        {{-- Access section data --}}
        @if(!empty($section['data']['title']))
            <h2>{{ $section['data']['title'] }}</h2>
        @endif

        @if(!empty($section['data']['content']))
            <p>{{ $section['data']['content'] }}</p>
        @endif
    </div>
</section>
```

### Available Data

- `$section['id']`: Section ID
- `$section['type']`: Section type
- `$section['order']`: Section order
- `$section['data']`: All form data (array)

### Example: Hero Section

```blade
<section class="hero-section relative overflow-hidden bg-gradient-to-br from-primary/10 to-primary/5 py-20">
    <div class="container mx-auto px-4">
        <div class="mx-auto max-w-4xl text-center">
            @if(!empty($section['data']['title']))
                <h1 class="mb-6 text-5xl font-bold leading-tight text-foreground md:text-6xl">
                    {{ $section['data']['title'] }}
                </h1>
            @endif

            @if(!empty($section['data']['subtitle']))
                <p class="mb-8 text-xl text-muted-foreground">
                    {{ $section['data']['subtitle'] }}
                </p>
            @endif

            @if(!empty($section['data']['button_text']))
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ $section['data']['button_url'] ?? '#' }}"
                       class="inline-flex items-center rounded-lg bg-primary px-8 py-3 font-semibold text-primary-foreground shadow-lg transition hover:bg-primary/90">
                        {{ $section['data']['button_text'] }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
```

### Conditional Rendering Best Practices

Always check if data exists before rendering:

```blade
{{-- Good ✅ --}}
@if(!empty($section['data']['title']))
    <h2>{{ $section['data']['title'] }}</h2>
@endif

{{-- Bad ❌ --}}
<h2>{{ $section['data']['title'] }}</h2>
```

---

## Adding Assets

### CSS Files

Place CSS in `resources/js/themes/your-theme/assets/css/`:

```css
/* resources/js/themes/my-theme/assets/css/theme.css */

.my-theme-hero {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.my-theme-button {
    @apply rounded-lg bg-primary px-6 py-3 font-semibold text-white transition hover:bg-primary/90;
}
```

### JavaScript Files

Place JS in `resources/js/themes/your-theme/assets/js/`:

```javascript
// resources/js/themes/my-theme/assets/js/theme.js

document.addEventListener('DOMContentLoaded', function() {
    // Theme-specific JavaScript
    console.log('My Theme loaded');
});
```

### Loading Assets in Blade

```blade
{{-- In your Blade template --}}
<link rel="stylesheet" href="{{ asset('resources/js/themes/my-theme/assets/css/theme.css') }}">
<script src="{{ asset('resources/js/themes/my-theme/assets/js/theme.js') }}"></script>
```

### Images

Place images in `resources/js/themes/your-theme/assets/images/`:

```blade
<img src="{{ asset('resources/js/themes/my-theme/assets/images/logo.svg') }}" alt="Logo">
```

---

## Testing Your Theme

### 1. Sync Theme

1. Navigate to `/admin/themes`
2. Click "Sync Themes" button
3. Verify your theme appears in the list

### 2. Activate Theme

1. Click "Activate" on your theme
2. Confirm activation in the modal
3. Verify the "Active" badge appears

### 3. Test in PageBuilder

1. Go to `/admin/pages`
2. Create a new page or edit existing
3. Switch to "Page Builder" tab
4. Verify your sections appear in the left sidebar
5. Add a section
6. Click edit icon
7. Fill in the form
8. Click "Save"
9. Verify data persists

### 4. Test Frontend Rendering

1. Publish the page
2. View the page on the frontend
3. Verify sections render correctly
4. Check responsive design
5. Test all interactive elements

---

## Best Practices

### 1. Naming Conventions

- **Theme slug**: lowercase-with-dashes (e.g., `corporate-theme`)
- **Section types**: lowercase-with-dashes (e.g., `hero-banner`)
- **Vue components**: PascalCase (e.g., `HeroBannerForm.vue`)
- **Blade templates**: lowercase-with-dashes (e.g., `hero-banner.blade.php`)

### 2. Theme Portability

Keep all theme files in one directory:
```
resources/js/themes/my-theme/
├── theme.json
├── forms/
├── sections/
└── assets/
```

This makes it easy to:
- Share themes (zip the folder)
- Version control themes
- Install themes from others

### 3. Data Validation

Always validate data in Vue forms:

```vue
<script setup>
const save = () => {
    // Validate required fields
    if (!formData.value.title) {
        alert('Title is required');
        return;
    }
    
    emit('save', formData.value);
};
</script>
```

### 4. Default Values

Provide sensible defaults:

```vue
const formData = ref({
    title: props.data.title || 'Default Title',
    columns: props.data.columns || 3,
    show_icons: props.data.show_icons !== false, // Default to true
    ...props.data
});
```

### 5. Responsive Design

Use Tailwind's responsive classes:

```blade
<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
    {{-- Content --}}
</div>
```

### 6. Accessibility

- Use semantic HTML
- Add proper ARIA labels
- Ensure keyboard navigation
- Maintain color contrast

```blade
<button aria-label="Close menu" class="...">
    <span class="sr-only">Close</span>
    ×
</button>
```

---

## Troubleshooting

### Theme Not Appearing After Sync

**Problem**: Theme doesn't show up after clicking "Sync Themes"

**Solutions**:
1. Check `theme.json` is in `resources/js/themes/your-theme/`
2. Verify JSON syntax is valid (use a JSON validator)
3. Ensure `slug` field is unique
4. Check browser console for errors
5. Clear Laravel cache: `php artisan cache:clear`

### Form Components Not Loading

**Problem**: "Component not found" error when editing sections

**Solutions**:
1. Verify Vue components are in `resources/js/themes/your-theme/forms/`
2. Check `vueForm` path in `theme.json` matches actual file path
3. Ensure component follows the required structure (props, emits)
4. Restart Vite dev server: Stop and run `npm run dev` again
5. Check browser console for import errors

### Blade Template Not Rendering

**Problem**: Section doesn't display on frontend

**Solutions**:
1. Verify Blade file is in `resources/js/themes/your-theme/sections/`
2. Check `bladeTemplate` path in `theme.json` uses dot notation correctly
3. Ensure you're accessing `$section['data']` correctly
4. Check for PHP/Blade syntax errors
5. Clear view cache: `php artisan view:clear`

### Assets Not Loading

**Problem**: CSS/JS/Images not loading

**Solutions**:
1. Verify assets are in `resources/js/themes/your-theme/assets/`
2. Check asset paths use `asset()` helper with correct path
3. Ensure files are accessible
4. Check file permissions
5. Verify Vite is running for development

---

## Sharing Your Theme

### Package Your Theme

1. Navigate to `resources/js/themes/`
2. Zip your theme folder: `my-theme.zip`
3. Share the zip file

### Install a Theme

1. Extract theme zip to `resources/js/themes/`
2. Navigate to `/admin/themes`
3. Click "Sync Themes"
4. Activate the new theme

---

## Example: Complete Theme

Here's a complete example of a simple theme:

### Directory Structure

```
resources/js/themes/simple/
├── theme.json
├── forms/
│   ├── HeaderForm.vue
│   └── ContentForm.vue
├── sections/
│   ├── header.blade.php
│   └── content.blade.php
└── assets/
    └── css/
        └── simple.css
```

### theme.json

```json
{
    "name": "Simple Theme",
    "slug": "simple",
    "version": "1.0.0",
    "author": "Your Name",
    "description": "A minimal, clean theme",
    "sections": [
        {
            "type": "header",
            "label": "Header",
            "icon": "📄",
            "bladeTemplate": "themes.simple.sections.header",
            "vueForm": "simple/forms/HeaderForm.vue"
        },
        {
            "type": "content",
            "label": "Content Block",
            "icon": "📝",
            "bladeTemplate": "themes.simple.sections.content",
            "vueForm": "simple/forms/ContentForm.vue"
        }
    ]
}
```

---

## Next Steps

1. **Study the Default Theme**: Examine `resources/js/themes/default/` for more examples
2. **Experiment**: Create test sections and iterate
3. **Share**: Package your theme for others to use
4. **Contribute**: Submit your themes to the community

---

## Resources

- [Vue.js Documentation](https://vuejs.org/)
- [Laravel Blade Documentation](https://laravel.com/docs/blade)
- [Tailwind CSS Documentation](https://tailwindcss.com/)
- [Vite Documentation](https://vitejs.dev/)

---

Happy theme building! 🎨
