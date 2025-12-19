<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gray-50 pt-12 pb-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8 text-sm text-gray-500 overflow-x-auto whitespace-nowrap" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li><a href="/" class="hover:text-primary transition">Home</a></li>
                    <li class="flex items-center space-x-2">
                        <i data-feather="chevron-right" class="w-4 h-4"></i>
                        <a href="/services" class="hover:text-primary transition">Services</a>
                    </li>
                    <li class="flex items-center space-x-2">
                        <i data-feather="chevron-right" class="w-4 h-4"></i>
                        <span
                            class="text-gray-900 font-medium truncate max-w-[200px] sm:max-w-md"><?php echo e($service->title); ?></span>
                    </li>
                </ol>
            </nav>

            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up">
                <!-- Featured Image -->
                <?php if($service->media && $service->media->count() > 0): ?>
                    <div class="relative h-[300px] sm:h-[400px]">
                        <img src="/media-file/<?php echo e($service->media->first()->file_path); ?>" alt="<?php echo e($service->title); ?>"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                <?php endif; ?>

                <div class="p-8 md:p-12">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 leading-tight">
                        <?php echo e($service->title); ?>

                    </h1>

                    <div class="prose prose-lg prose-primary max-w-none text-gray-700 leading-relaxed">
                        <?php echo nl2br(e($service->details)); ?>

                    </div>

                    <?php if($service->media && $service->media->count() > 1): ?>
                        <div class="mt-12">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Gallery</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <?php $__currentLoopData = $service->media->slice(1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="aspect-video rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                                        <img src="/media-file/<?php echo e($image->file_path); ?>" alt="<?php echo e($service->title); ?>"
                                            class="w-full h-full object-cover hover:scale-105 transition duration-500">
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <!-- CTA Section -->
            <div class="mt-12 bg-primary rounded-2xl p-8 md:p-12 text-center text-white shadow-xl" data-aos="zoom-in">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Interested in this service?</h2>
                <p class="text-white/80 mb-8 max-w-2xl mx-auto">Contact us today to discuss how we can help you achieve your
                    goals with our professional solutions.</p>
                <a href="/contact"
                    class="inline-flex items-center px-8 py-3 bg-white text-primary font-bold rounded-full hover:bg-gray-100 transition shadow-lg">
                    Get a Quote
                    <i data-feather="arrow-right" class="ml-2 w-5 h-5"></i>
                </a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($layout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/ongudidan/Projects/vue-cms/resources/js/themes/modern/components/services/show.blade.php ENDPATH**/ ?>