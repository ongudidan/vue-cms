
<section class="relative h-screen flex items-center justify-center bg-gray-900 overflow-hidden">
    <?php if(!empty($section['data']['background_image'])): ?>
        <img src="<?php echo e($section['data']['background_image']); ?>" alt="Hero background" 
            class="absolute inset-0 w-full h-full object-cover opacity-70">
    <?php endif; ?>
    
    <div class="absolute inset-0 bg-gradient-to-r from-primary/80 to-secondary/80"></div>
    
    <div class="relative z-10 px-4 text-center max-w-4xl mx-auto">
        <?php if(!empty($section['data']['title'])): ?>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6" data-aos="fade-up">
                <?php echo e($section['data']['title']); ?>

            </h1>
        <?php endif; ?>

        <?php if(!empty($section['data']['subtitle'])): ?>
            <p class="text-xl text-gray-100 mb-8" data-aos="fade-up" data-aos-delay="100">
                <?php echo e($section['data']['subtitle']); ?>

            </p>
        <?php endif; ?>

        <?php if(!empty($section['data']['primary_button_text']) || !empty($section['data']['secondary_button_text'])): ?>
            <div class="flex flex-col sm:flex-row justify-center gap-4" data-aos="fade-up" data-aos-delay="200">
                <?php if(!empty($section['data']['primary_button_text'])): ?>
                    <a href="<?php echo e($section['data']['primary_button_url'] ?? '#'); ?>" 
                        class="px-8 py-3 bg-white text-primary rounded-md font-medium hover:bg-opacity-90 transition">
                        <?php echo e($section['data']['primary_button_text']); ?>

                    </a>
                <?php endif; ?>

                <?php if(!empty($section['data']['secondary_button_text'])): ?>
                    <a href="<?php echo e($section['data']['secondary_button_url'] ?? '#'); ?>" 
                        class="px-8 py-3 border-2 border-white text-white rounded-md font-medium hover:bg-white hover:text-primary transition">
                        <?php echo e($section['data']['secondary_button_text']); ?>

                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php /**PATH /home/ongudidan/Projects/vue-cms/resources/js/themes/modern/sections/hero-fullscreen.blade.php ENDPATH**/ ?>