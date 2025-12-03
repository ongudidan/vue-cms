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
</head>

<body class="font-sans antialiased">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-primary">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-900 hover:text-primary transition">Home</a>
                    <a href="/about" class="text-gray-900 hover:text-primary transition">About</a>
                    <a href="/services" class="text-gray-900 hover:text-primary transition">Services</a>
                    <a href="/contact" class="px-4 py-2 rounded-md bg-primary text-white hover:bg-opacity-90 transition">Contact</a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button onclick="toggleMobileMenu()" class="text-gray-900">
                        <i data-feather="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-4">
                    <a href="/" class="text-gray-900 hover:text-primary transition">Home</a>
                    <a href="/about" class="text-gray-900 hover:text-primary transition">About</a>
                    <a href="/services" class="text-gray-900 hover:text-primary transition">Services</a>
                    <a href="/contact" class="text-gray-900 hover:text-primary transition">Contact</a>
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