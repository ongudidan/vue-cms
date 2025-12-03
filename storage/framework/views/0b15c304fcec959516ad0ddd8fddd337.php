<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($page->title ?? config('app.name', 'Laravel')); ?></title>

    <?php if($page->description): ?>
    <meta name="description" content="<?php echo e($page->description); ?>">
    <?php endif; ?>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Theme Assets (if any) -->
    <?php if($theme && file_exists(resource_path("js/themes/{$theme->slug}/assets/css/theme.css"))): ?>
    <link rel="stylesheet" href="<?php echo e(asset("resources/js/themes/{$theme->slug}/assets/css/theme.css")); ?>">
    <?php endif; ?>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-white">
        <!-- Header/Navigation -->
        <header class="bg-white shadow">
            <div class="container mx-auto px-4 py-6">
                <h1 class="text-3xl font-bold text-gray-900">
                    <?php echo e(config('app.name', 'Laravel')); ?>

                </h1>
            </div>
        </header>

        <!-- Main Content -->
        <main>
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white mt-12">
            <div class="container mx-auto px-4 py-6 text-center">
                <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <!-- Theme Scripts (if any) -->
    <?php if($theme && file_exists(resource_path("js/themes/{$theme->slug}/assets/js/theme.js"))): ?>
    <script src="<?php echo e(asset("resources/js/themes/{$theme->slug}/assets/js/theme.js")); ?>"></script>
    <?php endif; ?>
</body>

</html><?php /**PATH C:\Users\Dan Ong'udi\Herd\vue-cms\resources\js/themes/default/layout.blade.php ENDPATH**/ ?>