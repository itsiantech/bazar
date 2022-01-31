

<?php $__env->startSection('content'); ?>

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Product Requests </div>

        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable table-responsive">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Product title </th>
                        <th> Quantity </th>
                        <th> Customer phone </th>
                        <th> Customer Address </th>
                        <th> Description </th>
                        <th> Date </th>
                        <th> Action </th>

                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $productRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$productRequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td> <?php echo e(++$key); ?> </td>
                        <td> <?php echo e($productRequest->title); ?> </td>
                        <td> <?php echo e($productRequest->quantity); ?> </td>
                        <td> <?php echo e($productRequest->phone); ?> </td>
                        <td> <?php echo e($productRequest->address); ?> </td>
                        <td> <?php echo e($productRequest->description); ?> </td>
                        <td><?php echo e(date('d  M Y',strtotime($productRequest->created_at))); ?><br>
                            <?php echo e($productRequest->created_at->diffForHumans()); ?> </td>
                        <td>
                            <a href="<?php echo e(route('product_request.delete',['id'=>$productRequest->id])); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are your sure to delete this item')"><i class="fa fa-trash"></i> Delete</a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/product_requests/index.blade.php ENDPATH**/ ?>