

<?php $__env->startSection('content'); ?>


















































<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Refunds</div>

        <div class="tools"> </div>
    </div>


    <div class="portlet-body">

        <div id="messageDiv">
            <?php if(Session::has('success')): ?>
                <?php echo $__env->make('layouts.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php elseif(Session::has('error')): ?>
                <?php echo $__env->make('layouts.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>

        <div class="table-scrollable table-responsive">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th class="text-center"> # </th>
                        <th class="text-center"> Order Id</th>
                        <th class="text-center"> User name </th>
                        <th class="text-center"> Order Amount </th>
                        <th class="text-center"> Refunded Amount </th>
                        <th class="text-center"> Withdrew Amount </th>
                        <th class="text-center"> Status </th>
                        <th class="text-center"> Time </th>
                        <th class="text-center">Action </th>
                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $refunds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$refund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"> <?php echo e(++$key); ?> </td>
                        <td class="text-center"> <?php echo e($refund->unique_order_id); ?> </td>
                        <td class="text-center"> <?php echo e($refund->name); ?> </td>
                        <td class="text-center"> <?php echo e($refund->amount); ?> </td>
                        <td class="text-center"> <?php echo e($refund->refunded_amount); ?> </td>
                        <td class="text-center"> <?php echo e($refund->withdraw); ?> </td>
                        <td class="text-center"> <?php echo e(ucfirst($refund->status)); ?> </td>
                        <td class="text-center"> <?php echo e(date('d  M Y',strtotime($refund->created_at))); ?><br>
                             </td>

                        <td class="text-center">

                            <?php if($refund->status=='done' || $refund->status=='refunded'): ?>
                                <a href="<?php echo e(route('refund.changeStatus',['id'=>$refund->id,'status'=>'accepted'])); ?>" class="btn btn-xs label label-sm label-default ">Refunded</a>

                            <?php else: ?>
                                <a onclick="return confirm('Are your sure to delete this item')" href="<?php echo e(route('refund.delete',['id'=>$refund->id])); ?>" class="btn btn-xs label label-sm label-danger ">Remove</a>
                                <a href="<?php echo e(route('refund.changeStatus',['id'=>$refund->id,'status'=>'refunded'])); ?>" class="btn btn-xs label label-sm label-success ">Mark As Refunded</a>
                            <?php endif; ?>

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
    <link href="<?php echo e(asset('assets/global/plugins/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/global/plugins/select2/css/select2-bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('layouts.asset.js.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(asset('assets/global/plugins/select2/js/select2.full.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('assets/pages/scripts/components-select2.min.js')); ?>" type="text/javascript"></script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/refunds/index.blade.php ENDPATH**/ ?>