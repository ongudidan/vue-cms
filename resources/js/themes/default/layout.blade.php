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

    <!-- Theme Assets (if any) -->
    @if($theme && file_exists(resource_path("js/themes/{$theme->slug}/assets/css/theme.css")))
    <link rel="stylesheet" href="{{ asset("resources/js/themes/{$theme->slug}/assets/css/theme.css") }}">
    @endif
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-white">
        <!-- Header/Navigation -->
        <header class="bg-white shadow">
            <div class="container mx-auto px-4 py-6">
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ config('app.name', 'Laravel') }}
                </h1>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white mt-12">
            <div class="container mx-auto px-4 py-6 text-center">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Theme Scripts (if any) -->
    @if($theme && file_exists(resource_path("js/themes/{$theme->slug}/assets/js/theme.js")))
    <script src="{{ asset("resources/js/themes/{$theme->slug}/assets/js/theme.js") }}"></script>
    @endif
</body>

</html>