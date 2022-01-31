

<?php $__env->startSection('content'); ?>

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Delivery charges </div>
        <div class="actions">
            <a href="<?php echo e(route('deliveryCharge.create')); ?>" class="btn btn-default btn-sm">
                <i class="fa fa-plus"></i> Add </a>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable table-responsive">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> # </th>
                        <th>Charge amount </th>
                        <th>Minimum amount </th>
                        <th>Maximum amount </th>
                        <th>Action </th>

                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $delivery_charges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$delivery_charge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td> <?php echo e(++$key); ?> </td>
                        <td> <?php echo e($delivery_charge->charge_amount); ?> </td>
                        <td> <?php echo e($delivery_charge->minimum_amount); ?> </td>
                        <td> <?php echo e($delivery_charge->maximum_amount); ?> </td>

                        <td>
                            <a href="<?php echo e(route('deliveryCharge.edit',['id'=>$delivery_charge->id])); ?>" class="btn btn-xs label label-sm label-success ">Edit</a>
                            <a href="<?php echo e(route('deliveryCharge.delete',['id'=>$delivery_charge->id])); ?>" class="btn btn-xs label label-sm label-danger " onclick="return confirm('Are your sure to delete this item')">Delete</a>

                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END Portlet PORTLET-->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('stylesheets'); ?>
    <?php echo $__env->make('layouts.asset.datatable-css-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('layouts.asset.js.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/delivery_charges/index.blade.php ENDPATH**/ ?>