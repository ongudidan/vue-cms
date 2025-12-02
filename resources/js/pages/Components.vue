<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import {
    Briefcase,
    Calendar,
    FileText,
    FolderKanban,
    Handshake,
    Users,
    UserSquare2,
} from 'lucide-vue-next';

const breadcrumbs = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Components',
        href: '/admin/components',
    },
];

const components = [
    {
        name: 'Services',
        description: 'Manage your service offerings and descriptions',
        icon: Briefcase,
        route: '/admin/services',
        gradient: 'from-blue-500 to-cyan-500',
    },
    {
        name: 'Projects',
        description: 'Showcase your portfolio and completed projects',
        icon: FolderKanban,
        route: '/admin/projects',
        gradient: 'from-purple-500 to-pink-500',
    },
    {
        name: 'Blogs',
        description: 'Create and publish blog posts and articles',
        icon: FileText,
        route: '/admin/blogs',
        gradient: 'from-orange-500 to-red-500',
    },
    {
        name: 'Events',
        description: 'Organize and manage upcoming events',
        icon: Calendar,
        route: '/admin/events',
        gradient: 'from-green-500 to-emerald-500',
    },
    {
        name: 'Board Members',
        description: 'Display your leadership team and board members',
        icon: UserSquare2,
        route: '/admin/board-members',
        gradient: 'from-indigo-500 to-blue-500',
    },
    {
        name: 'Partners',
        description: 'Highlight your business partners and collaborators',
        icon: Handshake,
        route: '/admin/partners',
        gradient: 'from-teal-500 to-cyan-500',
    },
    {
        name: 'Clients',
        description: 'Manage your client list and testimonials',
        icon: Users,
        route: '/admin/clients',
        gradient: 'from-rose-500 to-pink-500',
    },
];
</script>

<template>
    <Head title="Components" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Page Header -->
            <div class="space-y-2">
                <h1
                    class="text-3xl font-bold tracking-tight text-foreground"
                >
                    Components
                </h1>
                <p class="text-muted-foreground">
                    Manage your CMS components and content sections
                </p>
            </div>

            <!-- Components Grid -->
            <div
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            >
                <Link
                    v-for="component in components"
                    :key="component.name"
                    :href="component.route"
                    class="group relative overflow-hidden rounded-xl border border-sidebar-border/70 bg-card p-6 shadow-sm transition-all duration-300 hover:scale-105 hover:shadow-xl dark:border-sidebar-border"
                >
                    <!-- Gradient Background -->
                    <div
                        class="absolute inset-0 bg-gradient-to-br opacity-0 transition-opacity duration-300 group-hover:opacity-10"
                        :class="component.gradient"
                    ></div>

                    <!-- Content -->
                    <div class="relative z-10 flex flex-col gap-4">
                        <!-- Icon Container -->
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-lg bg-gradient-to-br shadow-lg transition-transform duration-300 group-hover:scale-110"
                            :class="component.gradient"
                        >
                            <component
                                :is="component.icon"
                                class="h-7 w-7 text-white"
                            />
                        </div>

                        <!-- Text Content -->
                        <div class="space-y-2">
                            <h3
                                class="text-lg font-semibold text-foreground transition-colors duration-300 group-hover:text-primary"
                            >
                                {{ component.name }}
                            </h3>
                            <p
                                class="text-sm leading-relaxed text-muted-foreground"
                            >
                                {{ component.description }}
                            </p>
                        </div>
                    </div>

                    <!-- Hover Arrow Indicator -->
                    <div
                        class="absolute bottom-4 right-4 opacity-0 transition-all duration-300 group-hover:opacity-100"
                    >
                        <svg
                            class="h-5 w-5 text-primary"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </div>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
