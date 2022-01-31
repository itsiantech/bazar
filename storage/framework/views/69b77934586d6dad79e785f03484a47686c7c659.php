

<?php $__env->startSection('content'); ?>

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Delivery Charge Create
            </div>
            <div class="actions">
                <a href="<?php echo e(route('deliveryCharge.index')); ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="<?php echo e(route('deliveryCharge.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div id="messageDiv">
                    <?php if(Session::has('success')): ?>
                        <?php echo $__env->make('layouts.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php elseif(Session::has('error')): ?>
                        <?php echo $__env->make('layouts.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label">Charge Amount</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="charge amount"
                               data-container="body"></i>
                            <input type="number" name="charge_amount" required class="form-control"></div>
                        <?php if($errors->has('charge_amount')): ?>
                            <span class="text-danger"><?php echo e($errors->first('charge_amount')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Minimum Amount</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="minimum amount"
                               data-container="body"></i>
                            <input type="number" name="minimum_amount" required class="form-control"></div>
                        <?php if($errors->has('minimum_amount')): ?>
                            <span class="text-danger"><?php echo e($errors->first('minimum_amount')); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Maximum Amount</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="maximum amount"
                               data-container="body"></i>
                            <input type="number" name="maximum_amount" required class="form-control"></div>
                        <?php if($errors->has('maximum_amount')): ?>
                            <span class="text-danger"><?php echo e($errors->first('maximum_amount')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-actions right">
                        <button type="button" class="btn default">Cancel</button>
                        <button type="submit" class="btn green">Submit</button>
                    </div>
                    </div>
            </form>
        </div>
    </div>
    <!-- END Portlet PORTLET-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/delivery_charges/create.blade.php ENDPATH**/ ?>