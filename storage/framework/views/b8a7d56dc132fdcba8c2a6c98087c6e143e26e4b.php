<?php $__env->startSection('content'); ?>

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Products </div>
        <div class="actions">
            <a href="<?php echo e(route('product.create')); ?>" class="btn btn-default btn-sm">
                <i class="fa fa-plus"></i> Add </a>

        </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Name English </th>
                        <th> Name Bangla </th>
                        <th> slug </th>
                        <th> Featured </th>
                        <th> Status </th>
                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td> <?php echo e(++$key); ?> </td>
                        <td> <?php echo e($product->name_en); ?> </td>
                        <td> <?php echo e($product->name_bn); ?> </td>
                        <td> <?php echo e($product->slug); ?> </td>
                        <td>
                            <?php if($product->is_featured==0): ?>
                                <a href="<?php echo e(route('product.featured',['id'=>$product->id])); ?>" class="btn btn-xs btn-default  ">Mark As Featured</a>
                            <?php else: ?>
                                <a href="<?php echo e(route('product.featured',['id'=>$product->id])); ?>" class="btn btn-xs btn-danger  ">Unmark from Featured</a>
                            <?php endif; ?>

                        </td>

                        <td class="">
                            <a href="<?php echo e(route('product_image.index',['id'=>$product->id])); ?>" class="btn btn-xs btn-success ">Add images</a>

                            <a href="<?php echo e(route('product.edit',['id'=>$product->id])); ?>" class="btn btn-xs btn-primary  ">Edit</a>
                            <a href="<?php echo e(route('product.delete',['id'=>$product->id])); ?>" onclick=" return confirm('Are you sure? Want to delete this product!')" class="btn btn-xs btn-danger  ">Delete</a>

                            <a href="<?php echo e(route('product.makeBundle', ['product' => $product->id])); ?>" class="btn btn-xs btn-success" >Bundle Product</a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bazar/resources/views/admin/products/index.blade.php ENDPATH**/ ?>