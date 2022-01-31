

<?php $__env->startSection('content'); ?>

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Pages </div>
        <div class="actions">
            <a href="<?php echo e(route('page.create')); ?>" class="btn btn-default btn-sm">
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
                        <th> title</th>
                        <th> image </th>
                        <th> status </th>

                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td> <?php echo e(++$key); ?> </td>
                        <td> <?php echo e($page->title); ?> </td>
                        <td> <img src="<?php echo e(asset($page->banner_image)); ?>" width="200" height="150" alt="Image"> </td>

                        <td>
                            <a href="<?php echo e(route('page.edit',['id'=>$page->id])); ?>" class="btn btn-xs label label-sm label-success ">Edit</a>
                            <a href="<?php echo e(route('page.delete',['id'=>$page->id])); ?>" class="btn btn-xs label label-sm label-danger " onclick="return confirm('Are your sure to delete this item')">Delete</a>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/pages/index.blade.php ENDPATH**/ ?>