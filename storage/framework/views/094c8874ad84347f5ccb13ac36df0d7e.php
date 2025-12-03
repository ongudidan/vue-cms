
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if(!empty($section['data']['title']) || !empty($section['data']['subtitle'])): ?>
        <div class="text-center mb-12">
            <?php if(!empty($section['data']['title'])): ?>
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                <?php echo e($section['data']['title']); ?>

            </h2>
            <?php endif; ?>

            <?php if(!empty($section['data']['subtitle'])): ?>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                <?php echo e($section['data']['subtitle']); ?>

            </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if(!empty($section['data']['faqs']) && is_array($section['data']['faqs'])): ?>
        <div class="max-w-3xl mx-auto">
            <?php $__currentLoopData = $section['data']['faqs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="mb-4 border border-gray-200 rounded-lg overflow-hidden">
                <button onclick="toggleFaq(<?php echo e($index); ?>)"
                    class="w-full flex justify-between items-center p-4 text-left bg-gray-50 hover:bg-gray-100 transition">
                    <?php if(!empty($faq['question'])): ?>
                    <span class="font-medium text-gray-900"><?php echo e($faq['question']); ?></span>
                    <?php endif; ?>
                    <i data-feather="chevron-down"
                        class="faq-icon-<?php echo e($index); ?> w-5 h-5 text-gray-500 transform transition-transform duration-200"></i>
                </button>

                <div id="faq-<?php echo e($index); ?>" class="faq-content hidden p-4 bg-white">
                    <?php if(!empty($faq['answer'])): ?>
                    <p class="text-gray-600"><?php echo e($faq['answer']); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    function toggleFaq(index) {
        const content = document.getElementById('faq-' + index);
        const icon = document.querySelector('.faq-icon-' + index);

        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script><?php /**PATH C:\Users\Dan Ong'udi\Herd\vue-cms\resources\js/themes/modern/sections/faq-accordion.blade.php ENDPATH**/ ?>