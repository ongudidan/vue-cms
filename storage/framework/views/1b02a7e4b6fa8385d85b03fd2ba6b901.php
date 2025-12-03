

<?php $__env->startSection('content'); ?>
<div class="page-content">
    <!-- <?php if($page->title): ?>
    <h1 class="page-title"><?php echo e($page->title); ?></h1>
    <?php endif; ?>

    <?php if($page->description): ?>
    <div class="page-description">
        <?php echo e($page->description); ?>

    </div>
    <?php endif; ?> -->

    <div class="page-sections">
        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionHtml): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $sectionHtml; ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($layout, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dan Ong'udi\Herd\vue-cms\resources\views/pages/show.blade.php ENDPATH**/ ?>