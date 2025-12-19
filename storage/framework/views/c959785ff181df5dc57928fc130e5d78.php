<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gray-50 pt-12 pb-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-sm text-gray-500 overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="/" class="hover:text-primary transition">Home</a></li>
                    <li class="flex items-center space-x-2">
                        <i data-feather="chevron-right" class="w-4 h-4"></i>
                        <a href="/blogs" class="hover:text-primary transition">Blog</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i data-feather="chevron-right" class="w-4 h-4"></i>
                        <span class="text-gray-900 font-medium truncate max-w-[200px] sm:max-w-md"><?php echo e($blog->title); ?></span>
                    </li>
                </ol>
            </nav>

            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up">
                <!-- Featured Image -->
                <?php if($blog->media && $blog->media->count() > 0): ?>
                    <div class="relative h-[300px] sm:h-[400px] md:h-[500px]">
                        <img src="/media-file/<?php echo e($blog->media->first()->file_path); ?>" alt="<?php echo e($blog->title); ?>"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 p-8 text-white">
                            <div class="flex flex-wrap items-center gap-4 text-sm mb-4">
                                <?php if($blog->date): ?>
                                    <span class="flex items-center">
                                        <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                                        <?php echo e(\Carbon\Carbon::parse($blog->date)->format('M d, Y')); ?>

                                    </span>
                                <?php endif; ?>
                                <span class="flex items-center">
                                    <i data-feather="user" class="w-4 h-4 mr-2"></i>
                                    <?php echo e($blog->user->name ?? 'Admin'); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="p-8 md:p-12">
                    <?php if(!$blog->media || $blog->media->count() == 0): ?>
                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6">
                            <?php if($blog->date): ?>
                                <span class="flex items-center">
                                    <i data-feather="calendar" class="w-4 h-4 mr-2"></i>
                                    <?php echo e(\Carbon\Carbon::parse($blog->date)->format('M d, Y')); ?>

                                </span>
                            <?php endif; ?>
                            <span class="flex items-center">
                                <i data-feather="user" class="w-4 h-4 mr-2"></i>
                                <?php echo e($blog->user->name ?? 'Admin'); ?>

                            </span>
                        </div>
                    <?php endif; ?>

                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-8 leading-tight">
                        <?php echo e($blog->title); ?>

                    </h1>

                    <?php if($blog->tags): ?>
                        <div class="flex flex-wrap gap-2 mb-8">
                            <?php
                                $tags = is_array($blog->tags) ? $blog->tags : explode(',', $blog->tags);
                            ?>
                            <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span
                                    class="px-3 py-1 bg-primary/10 text-primary text-xs font-semibold rounded-full uppercase tracking-wider">
                                    <?php echo e(trim($tag)); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    <div class="prose prose-lg prose-primary max-w-none text-gray-700 leading-relaxed">
                        <?php echo nl2br(e($blog->details)); ?>

                    </div>

                    <!-- Shared Socials -->
                    <div class="mt-16 pt-8 border-t border-gray-100 flex flex-wrap items-center justify-between gap-6">
                        <div class="flex items-center space-x-4">
                            <span class="text-sm font-semibold text-gray-900 uppercase tracking-widest">Share:</span>
                            <div class="flex space-x-3">
                                <a href="#"
                                    class="p-2 bg-gray-50 text-gray-400 hover:text-white hover:bg-blue-600 rounded-full transition shadow-sm">
                                    <i data-feather="facebook" class="w-5 h-5"></i>
                                </a>
                                <a href="#"
                                    class="p-2 bg-gray-50 text-gray-400 hover:text-white hover:bg-blue-400 rounded-full transition shadow-sm">
                                    <i data-feather="twitter" class="w-5 h-5"></i>
                                </a>
                                <a href="#"
                                    class="p-2 bg-gray-50 text-gray-400 hover:text-white hover:bg-blue-700 rounded-full transition shadow-sm">
                                    <i data-feather="linkedin" class="w-5 h-5"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Back to Blog -->
            <div class="mt-12 text-center">
                <a href="/blogs" class="inline-flex items-center text-primary font-semibold hover:underline">
                    <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back to all posts
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($layout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ongudidan/Projects/vue-cms/resources/js/themes/modern/components/blogs/show.blade.php ENDPATH**/ ?>