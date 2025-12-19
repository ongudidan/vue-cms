<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($page->title ?? config('app.name', 'Laravel')); ?></title>

    <?php if($page->description ?? false): ?>
        <meta name="description" content="<?php echo e($page->description); ?>">
    <?php endif; ?>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#10B981',
                    }
                }
            }
        }
    </script>

    <!-- AOS Animations -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans antialiased">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white shadow-sm" x-data="{ mobileMenuOpen: false }">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-primary">
                        <?php echo e(config('app.name', 'Laravel')); ?>

                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <?php $__currentLoopData = $navigation_menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $url = $menu->url;
                            if ($menu->type === 'page' && $menu->page) {
                                $url = $menu->page->is_homepage ? '/' : '/' . $menu->page->slug;
                            }
                            $hasChildren = $menu->has_children;
                        ?>

                        <?php if($hasChildren): ?>
                            <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                                @mouseleave="open = false">
                                <button class="flex items-center text-gray-900 hover:text-primary transition py-2">
                                    <?php echo e($menu->title); ?>

                                    <i data-feather="chevron-down" class="w-4 h-4 ml-1"></i>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="absolute left-0 mt-0 w-48 bg-white border border-gray-100 shadow-lg rounded-md overflow-hidden z-50">
                                    <?php $__currentLoopData = $menu->getChildItems(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $childUrl = '#';
                                            if ($child instanceof \App\Models\Page) {
                                                $childUrl = $child->is_homepage ? '/' : '/' . $child->slug;
                                            } elseif ($child instanceof \App\Models\Project) {
                                                $childUrl = '/projects/' . $child->slug;
                                            } elseif ($child instanceof \App\Models\Blog) {
                                                $childUrl = '/blogs/' . $child->slug;
                                            } elseif ($child instanceof \App\Models\Service) {
                                                $childUrl = '/services/' . $child->slug;
                                            } elseif ($child instanceof \App\Models\Event) {
                                                $childUrl = '/events/' . $child->slug;
                                            } elseif ($child instanceof \App\Models\Menu) {
                                                $childUrl = $child->url;
                                                if ($child->type === 'page' && $child->page) {
                                                    $childUrl = $child->page->is_homepage ? '/' : '/' . $child->page->slug;
                                                }
                                            }
                                        ?>
                                        <a href="<?php echo e($childUrl); ?>"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary">
                                            <?php echo e($child->title); ?>

                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php if($loop->last): ?>
                                <a href="<?php echo e($url); ?>"
                                    class="px-4 py-2 rounded-md bg-primary text-white hover:bg-opacity-90 transition"><?php echo e($menu->title); ?></a>
                            <?php else: ?>
                                <a href="<?php echo e($url); ?>" class="text-gray-900 hover:text-primary transition"><?php echo e($menu->title); ?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-900 focus:outline-none">
                        <i data-feather="menu" x-show="!mobileMenuOpen" class="w-6 h-6"></i>
                        <i data-feather="x" x-show="mobileMenuOpen" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="md:hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <?php $__currentLoopData = $navigation_menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $url = $menu->url;
                            if ($menu->type === 'page' && $menu->page) {
                                $url = $menu->page->is_homepage ? '/' : '/' . $menu->page->slug;
                            }
                            $hasChildren = $menu->has_children;
                        ?>

                        <?php if($hasChildren): ?>
                            <div x-data="{ open: false }">
                                <button @click="open = !open"
                                    class="flex items-center justify-between w-full text-gray-900 hover:text-primary transition py-2">
                                    <span><?php echo e($menu->title); ?></span>
                                    <i data-feather="chevron-down" class="w-4 h-4 transition-transform"
                                        :class="{'rotate-180': open}"></i>
                                </button>
                                <div x-show="open" class="pl-4 space-y-2 border-l border-gray-100 ml-1">
                                    <?php $__currentLoopData = $menu->getChildItems(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $childUrl = '#';
                                            if ($child instanceof \App\Models\Page) {
                                                $childUrl = $child->is_homepage ? '/' : '/' . $child->slug;
                                            } elseif ($child instanceof \App\Models\Project) {
                                                $childUrl = '/projects/' . $child->slug;
                                            } elseif ($child instanceof \App\Models\Blog) {
                                                $childUrl = '/blogs/' . $child->slug;
                                            } elseif ($child instanceof \App\Models\Service) {
                                                $childUrl = '/services/' . $child->slug;
                                            } elseif ($child instanceof \App\Models\Event) {
                                                $childUrl = '/events/' . $child->slug;
                                            } elseif ($child instanceof \App\Models\Menu) {
                                                $childUrl = $child->url;
                                                if ($child->type === 'page' && $child->page) {
                                                    $childUrl = $child->page->is_homepage ? '/' : '/' . $child->page->slug;
                                                }
                                            }
                                        ?>
                                        <a href="<?php echo e($childUrl); ?>" class="block py-2 text-sm text-gray-600 hover:text-primary">
                                            <?php echo e($child->title); ?>

                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" class="block py-2 text-gray-900 hover:text-primary transition">
                                <?php echo e($menu->title); ?>

                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <!-- Company -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Company</h3>
                    <ul class="space-y-2">
                        <li><a href="/about" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="/careers" class="text-gray-400 hover:text-white transition">Careers</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <!-- Products -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Products</h3>
                    <ul class="space-y-2">
                        <li><a href="/features" class="text-gray-400 hover:text-white transition">Features</a></li>
                        <li><a href="/pricing" class="text-gray-400 hover:text-white transition">Pricing</a></li>
                        <li><a href="/api" class="text-gray-400 hover:text-white transition">API</a></li>
                    </ul>
                </div>

                <!-- Resources -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="/docs" class="text-gray-400 hover:text-white transition">Documentation</a></li>
                        <li><a href="/blog" class="text-gray-400 hover:text-white transition">Blog</a></li>
                        <li><a href="/support" class="text-gray-400 hover:text-white transition">Support</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Subscribe</h3>
                    <p class="text-gray-400 mb-4">Get the latest news and updates</p>
                    <div class="flex">
                        <input type="email" placeholder="Your email"
                            class="px-4 py-2 rounded-l-md bg-gray-800 text-white w-full focus:outline-none focus:ring-2 focus:ring-primary">
                        <button class="px-4 py-2 bg-primary text-white rounded-r-md hover:bg-opacity-90 transition">
                            Subscribe
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">
                    &copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i data-feather="facebook" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i data-feather="twitter" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i data-feather="instagram" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i data-feather="linkedin" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AOS Animation Script -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        feather.replace();

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>

</html>
<?php /**PATH /home/ongudidan/Projects/vue-cms/resources/js/themes/modern/layout.blade.php ENDPATH**/ ?>