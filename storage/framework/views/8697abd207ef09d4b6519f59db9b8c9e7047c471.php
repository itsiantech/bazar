<?php $__env->startSection('content'); ?>

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Product Images </div>

    </div>

    <div class="portlet-body">
        <form role="form" action="<?php echo e(route('product_image.store',['product_id'=>$productImages->id])); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div id="messageDiv">
                <?php if(Session::has('success')): ?>
                    <?php echo $__env->make('layouts.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php elseif(Session::has('error')): ?>
                    <?php echo $__env->make('layouts.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            </div>
            <div class="form-body">

                <div class="row">
                    <div class="col-lg-2 col-md-2 ">
                        <label class="control-label">Select Image</label>
                    </div>
                    <div class="col-lg-6 col-md-6 ">
                        <div class="input-icon">
                            <i class="fa fa-info-circle tooltips" data-original-title="Category name in Bangla"
                               data-container="body"></i>
                            <input type="file" class="form-control" onchange="loadFile(event)"
                                   id="logo" name="image">

                        </div>
                        <p><img id="output" width="200"/></p>
                        <?php if($errors->has('logo')): ?>
                            <span class="text-danger"><?php echo e($errors->first('logo')); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class=" col-lg-3 col-md-3 form-actions">
                        <button type="button" class="btn default">Cancel</button>
                        <button type="submit" class="btn green">Submit</button>
                    </div>
                </div>

            </div>
        </form>
        <div class="table-scrollable">

            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> sln </th>
                        <th> Image </th>
                        <th> Name Bangla </th>
                        <th> Status </th>
                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $productImages->productImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$productImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td> <?php echo e(++$key); ?> </td>
                        <td> <img src="<?php echo e(asset($productImage->image)); ?>" width="250" height="250"> </td>


                        <td>

                            <a href="<?php echo e(route('product_image.delete',['id'=>$productImage->id])); ?>" class="btn btn-xs label label-sm label-danger ">Delete</a>

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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bazar/resources/views/admin/products/images.blade.php ENDPATH**/ ?>