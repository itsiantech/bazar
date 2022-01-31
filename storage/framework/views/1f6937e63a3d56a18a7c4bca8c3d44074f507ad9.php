
<?php $__env->startComponent('mail::message'); ?>
# Your order placed successfully

Thank you for being with us.

## Order summery
<?php $__env->startComponent('mail::table'); ?>
| Name | Quantity | Price |
| ------------- |:-------------:| --------:|
<?php $__currentLoopData = $order_details['orderItems']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php echo e($item->product['name_en']); ?>  ( <?php echo e($item->product['name_bn']); ?> )  | <?php echo e($item->quantity); ?>  | <?php echo e($item->price); ?> |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if (isset($__componentOriginal20cb600a4a4149597e6997e789a6c2fa917d1906)): ?>
<?php $component = $__componentOriginal20cb600a4a4149597e6997e789a6c2fa917d1906; ?>
<?php unset($__componentOriginal20cb600a4a4149597e6997e789a6c2fa917d1906); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
 

Delivery time : Within 3 hours




<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/emails/order-confirmation.blade.php ENDPATH**/ ?>