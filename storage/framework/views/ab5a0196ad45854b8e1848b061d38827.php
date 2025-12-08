<section class="section" id="<?php echo e($section->spa_section_id ?? ''); ?>">
   <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
       $customisation->section_width_style ?? 'container',
       'w__' . ($customisation->section_width ?? '100') ]); ?>"
   >
      <div class="row">
         <div class="col-md-10 col-12">
            <div class="mb-4 text-center">
               <?php if($section->sub_title): ?>
                  <p class="sub-title" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="100">
                     <?php echo e($section->sub_title); ?>

                  </p>
               <?php endif; ?>
               <h3 class="title" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="200">
                  <?php echo e($section->title); ?>

               </h3>
               <div class="details" data-aos="fade-in-up" data-aos-duration="1000" data-aos-delay="300">
                  <?php echo $section->details; ?>

               </div>
               <?php $__currentLoopData = $section->cta_buttons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $button): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="<?php echo e(url($button->page->slug ?? '#')); ?>" class="btn <?php echo e($button->cta_button_type . ' ' . $customisation->button_style ?? ''); ?>"
                     data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="<?php echo e(($key + 1) * 400); ?>">
                     <?php echo e($button->cta_button_text); ?>

                  </a>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         </div>
         <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="col-lg-6 mb-4 pb-2">
            <div class="card blog blog-primary shadow rounded overflow-hidden" data-aos="zoom-in-up" data-aos-duration="1000" data-aos-delay="<?php echo e(($key + 1) * 300); ?>">
               <div class="row align-items-center g-0">
                  <div class="col-md-6">
                     <div class="image card-img position-relative overflow-hidden">
                        <img src="<?php echo e($blog->media[0]->original_url ?? asset('website/dummy_800x600.jpg')); ?>"
                             class="img-fluid" alt="<?php echo e($blog->slug); ?>" style="width: 273px; height:204px;">
                        <div class="card-overlay"></div>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="card-body content">
                        <a href="<?php echo e(route('blogs.show', $blog->slug)); ?>" class="h5 text-dark d-block mb-0">
                           <?php echo e($blog->title); ?>

                        </a>
                        <div class="mt-2 mb-2 details">
                           <?php echo Str::words($blog->details, 9); ?>

                        </div>
                        <a href="<?php echo e(route('blogs.show', $blog->slug)); ?>" class="link text-dark">
                           Read More<i class="uil uil-arrow-right align-middle"></i>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
   </div>
</section>
<?php /**PATH C:\Users\Dan Ong'udi\Herd\vue-cms\resources\js/themes/default/sections/section-with-blogs.blade.php ENDPATH**/ ?>