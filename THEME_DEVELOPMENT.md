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
8. [Creating Theme Layout](#creating-theme-layout)
9. [Adding Assets](#adding-assets)
10. [Testing Your Theme](#testing-your-theme)
11. [Best Practices](#best-practices)
12. [Troubleshooting](#troubleshooting)

---

## Overview

Themes in this CMS define the available page sections that content editors can use when building pages. Each theme is a complete package consisting of:

- **Vue Form Components**: Admin forms for configuring sections
- **Blade Templates**: Frontend rendering templates for sections
- **Layout File**: Main page structure (header, footer, navigation)
- **Assets**: CSS, JavaScript, images, and fonts
- **Configuration**: `theme.json` defining sections and metadata

**All theme files are stored in one location**: `resources/js/themes/your-theme/`

---

## Theme Architecture

### Unified Directory Structure

All theme files are in a single location for better organization and portability:

```
resources/js/themes/your-theme/
├── theme.json                      # Theme configuration
├── layout.blade.php                # Main page layout (optional)
├── forms/                          # Vue form components
│   ├── HeroSectionForm.vue
│   └── FeaturesForm.vue
├── sections/                       # Blade section templates
│   ├── hero-section.blade.php
│   └── features.blade.php
└── assets/                         # CSS, JS, images, fonts
    ├── css/
    │   └── theme.css
    ├── js/
    │   └── theme.js
    ├── images/
    │   └── logo.svg
    └── fonts/
        └── custom-font.woff2
```

### How It Works

1. **Admin creates page** → Adds sections using Vue forms
2. **Data is saved** → Section data stored as JSON in database
3. **Frontend renders** → Blade templates receive data as arrays
4. **Layout wraps content** → Theme layout (or default) provides structure

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

### Step 4: Create a Blade Section Template

Create `resources/js/themes/my-theme/sections/hero-banner.blade.php`:

```blade
{{-- Hero Banner Section --}}
<section class="hero-banner relative overflow-hidden bg-gradient-to-br from-blue-600 to-purple-600 py-20">
    <div class="container mx-auto px-4">
        <div class="mx-auto max-w-4xl text-center text-white">
            @if(!empty($section['data']['subtitle']))
                <p class="mb-4 text-lg opacity-90">
                    {{ $section['data']['subtitle'] }}
                </p>
            @endif

            @if(!empty($section['data']['title']))
                <h1 class="mb-6 text-5xl font-bold leading-tight md:text-6xl">
                    {{ $section['data']['title'] }}
                </h1>
            @endif

            @if(!empty($section['data']['button_text']))
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ $section['data']['button_url'] ?? '#' }}"
                       class="inline-flex items-center rounded-lg bg-white px-8 py-3 font-semibold text-blue-600 shadow-lg transition hover:bg-gray-100">
                        {{ $section['data']['button_text'] }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
```

### Step 5: Create Theme Layout

Create `resources/js/themes/my-theme/layout.blade.php`:

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title ?? config('app.name') }}</title>
    
    @if($page->description)
        <meta name="description" content="{{ $page->description }}">
    @endif

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Theme CSS -->
    @if(file_exists(resource_path("js/themes/my-theme/assets/css/theme.css")))
        <link rel="stylesheet" href="{{ asset('resources/js/themes/my-theme/assets/css/theme.css') }}">
    @endif
</head>
<body class="font-sans antialiased">
    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-6">
            <nav class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ config('app.name') }}
                </h1>
                <ul class="flex gap-6">
                    <li><a href="/" class="text-gray-700 hover:text-blue-600">Home</a></li>
                    <li><a href="/about" class="text-gray-700 hover:text-blue-600">About</a></li>
                    <li><a href="/contact" class="text-gray-700 hover:text-blue-600">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-8">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Theme JS -->
    @if(file_exists(resource_path("js/themes/my-theme/assets/js/theme.js")))
        <script src="{{ asset('resources/js/themes/my-theme/assets/js/theme.js') }}"></script>
    @endif
</body>
</html>
```

### Step 6: Sync and Activate

1. Navigate to `/admin/themes`
2. Click "Sync Themes" button
3. Your theme should appear in the list
4. Click "Activate" to make it active

---

## Directory Structure

### Complete Theme Example

```
resources/js/themes/corporate/
├── theme.json                      # Theme metadata
├── layout.blade.php                # Main page layout
├── forms/                          # Vue form components (Admin)
│   ├── HeroBannerForm.vue
│   ├── FeaturesForm.vue
│   ├── TestimonialsForm.vue
│   ├── TeamForm.vue
│   └── ContactForm.vue
├── sections/                       # Blade templates (Frontend)
│   ├── hero-banner.blade.php
│   ├── features.blade.php
│   ├── testimonials.blade.php
│   ├── team.blade.php
│   └── contact.blade.php
└── assets/                         # Theme assets
    ├── css/
    │   ├── theme.css
    │   └── components.css
    ├── js/
    │   ├── theme.js
    │   └── animations.js
    ├── images/
    │   ├── logo.svg
    │   ├── hero-bg.jpg
    │   └── pattern.png
    └── fonts/
        ├── custom-font.woff2
        └── custom-font-bold.woff2
```

---

## Creating theme.json

### Complete Schema

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
            "type": "features",
            "label": "Features Grid",
            "icon": "⭐",
            "bladeTemplate": "themes.corporate.sections.features",
            "vueForm": "corporate/forms/FeaturesForm.vue"
        }
    ]
}
```

### Field Descriptions

- **name**: Display name shown in admin
- **slug**: Unique identifier (lowercase-with-dashes)
- **version**: Theme version (semver format)
- **author**: Your name or organization
- **description**: Brief description
- **sections**: Array of available sections

#### Section Fields

- **type**: Unique identifier (e.g., "hero-banner")
- **label**: Human-readable name (e.g., "Hero Banner")
- **icon**: Emoji or icon character (e.g., "🎯")
- **bladeTemplate**: View path using namespace syntax (e.g., "themes.corporate.sections.hero-banner")
- **vueForm**: Path to Vue form component (e.g., "corporate/forms/HeroBannerForm.vue")

> **Important**: The `bladeTemplate` uses dot notation which Laravel converts to namespace syntax internally (`themes.corporate::sections.hero-banner`)

---

## Building Vue Form Components

### Required Structure

Every Vue form component must follow this pattern:

```vue
<script setup>
import { ref, watch } from 'vue';

// Required props
const props = defineProps({
    data: { type: Object, default: () => ({}) },
    editing: { type: Boolean, default: false }
});

// Required emits
const emit = defineEmits(['save', 'cancel']);

// Form data with defaults
const formData = ref({
    field1: props.data.field1 || 'default value',
    field2: props.data.field2 || '',
    ...props.data
});

// Watch for external changes
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
        <!-- Your form fields here -->
        
        <!-- Required action buttons -->
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
        <!-- Preview of the section data -->
    </div>
</template>
```

### Common Form Fields

#### Text Input
```vue
<div>
    <label class="mb-1.5 block text-sm font-medium text-foreground">Title</label>
    <input v-model="formData.title" type="text"
        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
        placeholder="Enter title" />
</div>
```

#### Textarea
```vue
<div>
    <label class="mb-1.5 block text-sm font-medium text-foreground">Description</label>
    <textarea v-model="formData.description" rows="4"
        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm"
        placeholder="Enter description"></textarea>
</div>
```

#### Checkbox
```vue
<div class="flex items-center gap-3">
    <input id="show_icons" v-model="formData.show_icons" type="checkbox"
        class="h-4 w-4 rounded border-sidebar-border text-primary" />
    <label for="show_icons" class="text-sm font-medium text-foreground">Show Icons</label>
</div>
```

#### Select Dropdown
```vue
<div>
    <label class="mb-1.5 block text-sm font-medium text-foreground">Layout</label>
    <select v-model="formData.layout"
        class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm">
        <option value="grid">Grid</option>
        <option value="list">List</option>
        <option value="carousel">Carousel</option>
    </select>
</div>
```

---

## Creating Blade Templates

### Understanding the Data Structure

Blade templates receive a `$section` variable as an **array** with this structure:

```php
$section = [
    'id' => 'section-123',
    'type' => 'hero-banner',
    'order' => 0,
    'data' => [
        'title' => 'Welcome to Our Site',
        'subtitle' => 'We build amazing things',
        'button_text' => 'Get Started',
        'button_url' => '/contact'
    ]
]
```

### Template Pattern

```blade
{{-- Section Name --}}
<section class="my-section py-16">
    <div class="container mx-auto px-4">
        {{-- Always check if data exists before using it --}}
        @if(!empty($section['data']['title']))
            <h2 class="text-4xl font-bold">
                {{ $section['data']['title'] }}
            </h2>
        @endif

        @if(!empty($section['data']['description']))
            <p class="mt-4 text-lg text-gray-600">
                {{ $section['data']['description'] }}
            </p>
        @endif
    </div>
</section>
```

### Complete Example: Features Section

```blade
{{-- Features Section --}}
<section class="features-section bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        @if(!empty($section['data']['title']))
            <div class="mb-12 text-center">
                <h2 class="mb-4 text-4xl font-bold text-gray-900">
                    {{ $section['data']['title'] }}
                </h2>
                
                @if(!empty($section['data']['subtitle']))
                    <p class="text-lg text-gray-600">
                        {{ $section['data']['subtitle'] }}
                    </p>
                @endif
            </div>
        @endif

        @if(!empty($section['data']['features']) && is_array($section['data']['features']))
            <div class="grid gap-8 md:grid-cols-{{ $section['data']['columns'] ?? 3 }}">
                @foreach($section['data']['features'] as $feature)
                    <div class="rounded-lg bg-white p-6 shadow-md transition hover:shadow-lg">
                        @if(!empty($section['data']['show_icons']) && !empty($feature['icon']))
                            <div class="mb-4 text-4xl">{{ $feature['icon'] }}</div>
                        @endif

                        @if(!empty($feature['title']))
                            <h3 class="mb-2 text-xl font-semibold text-gray-900">
                                {{ $feature['title'] }}
                            </h3>
                        @endif

                        @if(!empty($feature['description']))
                            <p class="text-gray-600">
                                {{ $feature['description'] }}
                            </p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
```

### Best Practices for Blade Templates

1. **Always check if data exists**: Use `!empty($section['data']['field'])`
2. **Use array syntax**: `$section['data']['field']` not `$section->field`
3. **Provide fallbacks**: Use `??` operator for defaults
4. **Escape output**: Use `{{ }}` for text, `{!! !!}` only for trusted HTML
5. **Keep it simple**: Avoid complex logic, handle that in the form component

---

## Creating Theme Layout

The layout file wraps all page content and provides the overall structure.

### Layout File Location

`resources/js/themes/your-theme/layout.blade.php`

### Complete Layout Example

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $page->title ?? config('app.name', 'Laravel') }}</title>

    @if($page->description)
        <meta name="description" content="{{ $page->description }}">
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Theme CSS -->
    @if(file_exists(resource_path("js/themes/{$theme->slug}/assets/css/theme.css")))
        <link rel="stylesheet" href="{{ asset("resources/js/themes/{$theme->slug}/assets/css/theme.css") }}">
    @endif
</head>
<body class="font-sans antialiased">
    <!-- Header -->
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-4">
            <nav class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="text-2xl font-bold text-gray-900">
                        {{ config('app.name') }}
                    </a>
                </div>

                <!-- Navigation -->
                <ul class="hidden md:flex gap-8">
                    <li><a href="/" class="text-gray-700 hover:text-blue-600 transition">Home</a></li>
                    <li><a href="/about" class="text-gray-700 hover:text-blue-600 transition">About</a></li>
                    <li><a href="/services" class="text-gray-700 hover:text-blue-600 transition">Services</a></li>
                    <li><a href="/contact" class="text-gray-700 hover:text-blue-600 transition">Contact</a></li>
                </ul>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700" onclick="toggleMobileMenu()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </nav>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <ul class="flex flex-col gap-4">
                    <li><a href="/" class="text-gray-700 hover:text-blue-600">Home</a></li>
                    <li><a href="/about" class="text-gray-700 hover:text-blue-600">About</a></li>
                    <li><a href="/services" class="text-gray-700 hover:text-blue-600">Services</a></li>
                    <li><a href="/contact" class="text-gray-700 hover:text-blue-600">Contact</a></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Main Content (sections will be rendered here) -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-12">
            <div class="grid gap-8 md:grid-cols-4">
                <!-- Company Info -->
                <div>
                    <h3 class="mb-4 text-lg font-semibold">{{ config('app.name') }}</h3>
                    <p class="text-gray-400">Building amazing digital experiences.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="mb-4 text-lg font-semibold">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="/about" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="/services" class="text-gray-400 hover:text-white transition">Services</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h3 class="mb-4 text-lg font-semibold">Services</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Web Design</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Development</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Marketing</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="mb-4 text-lg font-semibold">Contact</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: info@example.com</li>
                        <li>Phone: (123) 456-7890</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Theme JavaScript -->
    @if(file_exists(resource_path("js/themes/{$theme->slug}/assets/js/theme.js")))
        <script src="{{ asset("resources/js/themes/{$theme->slug}/assets/js/theme.js") }}"></script>
    @endif

    <!-- Mobile Menu Toggle -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
```

### Available Variables in Layout

- `$page` - Current page object (title, description, etc.)
- `$theme` - Active theme object
- `$sections` - Array of rendered section HTML (used in show.blade.php)

### Layout is Optional

If you don't create a `layout.blade.php`, the system automatically uses Laravel's default layout at `resources/views/layouts/app.blade.php`.

---

## Adding Assets

### CSS Files

Create `resources/js/themes/your-theme/assets/css/theme.css`:

```css
/* Theme Variables */
:root {
    --primary-color: #3b82f6;
    --secondary-color: #8b5cf6;
    --text-color: #1f2937;
    --bg-color: #ffffff;
}

/* Custom Styles */
.hero-banner {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
}

.btn-primary {
    @apply rounded-lg bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}
```

### JavaScript Files

Create `resources/js/themes/your-theme/assets/js/theme.js`:

```javascript
// Theme JavaScript
document.addEventListener('DOMContentLoaded', function() {
    console.log('Theme loaded');

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Add animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    }, observerOptions);

    document.querySelectorAll('section').forEach(section => {
        observer.observe(section);
    });
});
```

### Loading Assets in Layout

```blade
<!-- In your layout.blade.php -->
<head>
    <!-- Theme CSS -->
    @if(file_exists(resource_path("js/themes/{$theme->slug}/assets/css/theme.css")))
        <link rel="stylesheet" href="{{ asset("resources/js/themes/{$theme->slug}/assets/css/theme.css") }}">
    @endif
</head>
<body>
    <!-- Content -->

    <!-- Theme JS -->
    @if(file_exists(resource_path("js/themes/{$theme->slug}/assets/js/theme.js")))
        <script src="{{ asset("resources/js/themes/{$theme->slug}/assets/js/theme.js") }}"></script>
    @endif
</body>
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

### 3. Create a Test Page

1. Go to `/admin/pages`
2. Click "Create Page"
3. Fill in title and slug
4. Go to "Page Builder" tab
5. Add sections from your theme
6. Click edit icon on each section
7. Fill in the form fields
8. Click "Save"
9. Check "Published" checkbox
10. Save the page

### 4. View Frontend

1. Visit `/{your-page-slug}` to see your theme in action
2. Verify layout renders correctly
3. Verify sections display properly
4. Test responsive design on mobile
5. Test all interactive elements

---

## Best Practices

### 1. Naming Conventions

- **Theme slug**: `lowercase-with-dashes` (e.g., `corporate-theme`)
- **Section types**: `lowercase-with-dashes` (e.g., `hero-banner`)
- **Vue components**: `PascalCase` (e.g., `HeroBannerForm.vue`)
- **Blade templates**: `lowercase-with-dashes` (e.g., `hero-banner.blade.php`)

### 2. Data Structure

Always use array syntax in Blade templates:
```blade
✅ {{ $section['data']['title'] }}
❌ {{ $section->title }}
```

### 3. Form Validation

Validate data in Vue forms before saving:
```vue
const save = () => {
    if (!formData.value.title) {
        alert('Title is required');
        return;
    }
    emit('save', formData.value);
};
```

### 4. Responsive Design

Use Tailwind's responsive classes:
```blade
<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
    {{-- Content --}}
</div>
```

### 5. Accessibility

- Use semantic HTML (`<header>`, `<main>`, `<footer>`, `<nav>`)
- Add ARIA labels where needed
- Ensure keyboard navigation works
- Maintain proper color contrast

### 6. Performance

- Optimize images (use WebP format)
- Minimize CSS/JS files
- Use lazy loading for images
- Avoid inline styles

---

## Troubleshooting

### Theme Not Appearing After Sync

**Solutions:**
1. Check `theme.json` is in `resources/js/themes/your-theme/`
2. Validate JSON syntax
3. Ensure `slug` is unique
4. Clear cache: `php artisan cache:clear`

### Form Components Not Loading

**Solutions:**
1. Verify Vue components are in `resources/js/themes/your-theme/forms/`
2. Check `vueForm` path in `theme.json`
3. Restart Vite: `npm run dev`
4. Check browser console for errors

### Blade Templates Not Rendering

**Solutions:**
1. Verify Blade files are in `resources/js/themes/your-theme/sections/`
2. Check `bladeTemplate` path uses correct format
3. Use array syntax: `$section['data']['field']`
4. Clear view cache: `php artisan view:clear`

### Layout Not Loading

**Solutions:**
1. Verify `layout.blade.php` exists in theme root
2. Check file has `@yield('content')`
3. Restart Laravel server
4. Check for PHP syntax errors

### Assets Not Loading

**Solutions:**
1. Verify assets are in `resources/js/themes/your-theme/assets/`
2. Use correct paths with `asset()` helper
3. Check file permissions
4. Clear browser cache

---

## Complete Theme Checklist

- [ ] Create theme directory structure
- [ ] Create `theme.json` with metadata
- [ ] Create `layout.blade.php` (optional but recommended)
- [ ] Create Vue form components for each section
- [ ] Create Blade templates for each section
- [ ] Add theme CSS in `assets/css/`
- [ ] Add theme JS in `assets/js/`
- [ ] Add images/fonts in `assets/`
- [ ] Test all sections in PageBuilder
- [ ] Test frontend rendering
- [ ] Test responsive design
- [ ] Test on different browsers
- [ ] Optimize performance
- [ ] Document custom features

---

## Example: Complete Minimal Theme

Here's everything you need for a working theme:

### 1. theme.json
```json
{
    "name": "Minimal Theme",
    "slug": "minimal",
    "version": "1.0.0",
    "author": "Your Name",
    "description": "A clean, minimal theme",
    "sections": [
        {
            "type": "hero",
            "label": "Hero Section",
            "icon": "🎯",
            "bladeTemplate": "themes.minimal.sections.hero",
            "vueForm": "minimal/forms/HeroForm.vue"
        }
    ]
}
```

### 2. forms/HeroForm.vue
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
                class="w-full rounded-lg border border-sidebar-border bg-background px-3 py-2 text-sm" />
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
        <h3 class="text-lg font-bold">{{ formData.title || 'Hero Section' }}</h3>
    </div>
</template>
```

### 3. sections/hero.blade.php
```blade
<section class="bg-blue-600 py-20 text-white">
    <div class="container mx-auto px-4 text-center">
        @if(!empty($section['data']['title']))
            <h1 class="text-5xl font-bold">{{ $section['data']['title'] }}</h1>
        @endif
    </div>
</section>
```

### 4. layout.blade.php
```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title ?? config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <header class="bg-white shadow p-4">
        <h1 class="text-2xl font-bold">{{ config('app.name') }}</h1>
    </header>
    <main>
        @yield('content')
    </main>
    <footer class="bg-gray-800 text-white p-4 text-center">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}</p>
    </footer>
</body>
</html>
```

That's it! You now have a complete, working theme.

---

## Resources

- [Vue.js Documentation](https://vuejs.org/)
- [Laravel Blade Documentation](https://laravel.com/docs/blade)
- [Tailwind CSS Documentation](https://tailwindcss.com/)
- [Vite Documentation](https://vitejs.dev/)

---

Happy theme building! 🎨
