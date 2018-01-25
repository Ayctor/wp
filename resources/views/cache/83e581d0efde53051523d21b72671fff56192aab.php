<?php $__env->startSection('content'); ?>
    Hello World Page rendered at <?php echo e(date('Y-m-d H:i:s')); ?>

    <br>
    <br>Variable toto = <?php echo e($toto); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>