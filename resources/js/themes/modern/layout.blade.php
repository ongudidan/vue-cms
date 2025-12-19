<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $page->title ?? config('app.name', 'Laravel') }}</title>

    @if($page->description ?? false)
        <meta name="description" content="{{ $page->description }}">
    @endif

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
            @php
                $getUrl = function ($item) {
                    if ($item instanceof \App\Models\Page) {
                        return $item->is_homepage ? '/' : '/' . $item->slug;
                    } elseif ($item instanceof \App\Models\Project) {
                        return '/projects/' . $item->slug;
                    } elseif ($item instanceof \App\Models\Blog) {
                        return '/blogs/' . $item->slug;
                    } elseif ($item instanceof \App\Models\Service) {
                        return '/services/' . $item->slug;
                    } elseif ($item instanceof \App\Models\Event) {
                        return '/events/' . $item->slug;
                    } elseif ($item instanceof \App\Models\Menu) {
                        $url = $item->url;
                        if ($item->type === 'page' && $item->page) {
                            $url = $item->page->is_homepage ? '/' : '/' . $item->page->slug;
                        }
                        return $url;
                    }
                    return '#';
                };

                $checkActive = function ($url) {
                    if ($url === '/') {
                        return request()->is('/');
                    }
                    return request()->is(trim($url, '/') . '*');
                };
            @endphp

            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-primary">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    @foreach($navigation_menus as $menu)
                        @php
                            $url = $getUrl($menu);
                            $hasChildren = $menu->has_children;
                            $isActive = $checkActive($url);

                            $childItems = $hasChildren ? $menu->getChildItems() : [];
                            if ($hasChildren && !$isActive && $menu->child_type !== 'pages') {
                                foreach ($childItems as $child) {
                                    if ($checkActive($getUrl($child))) {
                                        $isActive = true;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        @if($hasChildren)
                            <div class="relative group" x-data="{ open: false }" @mouseenter="open = true"
                                @mouseleave="open = false">
                                <button
                                    class="flex items-center transition py-2 {{ $isActive ? 'text-primary font-medium' : 'text-gray-900 hover:text-primary' }}">
                                    {{ $menu->title }}
                                    <i data-feather="chevron-down" class="w-4 h-4 ml-1"></i>
                                </button>
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="absolute left-0 mt-0 w-48 bg-white border border-gray-100 shadow-lg rounded-md overflow-hidden z-50">
                                    @foreach($childItems as $child)
                                        @php
                                            $childUrl = $getUrl($child);
                                            $isChildActive = $checkActive($childUrl);
                                        @endphp
                                        <a href="{{ $childUrl }}"
                                            class="block px-4 py-2 text-sm transition {{ $isChildActive ? 'text-primary bg-gray-50 font-medium' : 'text-gray-700 hover:bg-gray-50 hover:text-primary' }}">
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $url }}"
                                class="transition {{ $isActive ? 'text-primary font-medium' : 'text-gray-900 hover:text-primary' }}">{{ $menu->title }}</a>
                        @endif
                    @endforeach
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
                class="md:hidden pb-4" x-cloak>
                <div class="flex flex-col space-y-2">
                    @foreach($navigation_menus as $menu)
                        @php
                            $url = $getUrl($menu);
                            $hasChildren = $menu->has_children;
                            $isActive = $checkActive($url);

                            $childItems = $hasChildren ? $menu->getChildItems() : [];
                            if ($hasChildren && !$isActive && $menu->child_type !== 'pages') {
                                foreach ($childItems as $child) {
                                    if ($checkActive($getUrl($child))) {
                                        $isActive = true;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        @if($hasChildren)
                            <div x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">
                                <button @click="open = !open"
                                    class="flex items-center justify-between w-full transition py-2 {{ $isActive ? 'text-primary font-medium' : 'text-gray-900 hover:text-primary' }}">
                                    <span>{{ $menu->title }}</span>
                                    <i data-feather="chevron-down" class="w-4 h-4 transition-transform"
                                        :class="{'rotate-180': open}"></i>
                                </button>
                                <div x-show="open" class="pl-4 space-y-2 border-l border-gray-100 ml-1">
                                    @foreach($childItems as $child)
                                        @php
                                            $childUrl = $getUrl($child);
                                            $isChildActive = $checkActive($childUrl);
                                        @endphp
                                        <a href="{{ $childUrl }}"
                                            class="block py-2 text-sm transition {{ $isChildActive ? 'text-primary font-medium' : 'text-gray-600 hover:text-primary' }}">
                                            {{ $child->title }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $url }}"
                                class="block py-2 transition {{ $isActive ? 'text-primary font-medium' : 'text-gray-900 hover:text-primary' }}">
                                {{ $menu->title }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
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
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
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