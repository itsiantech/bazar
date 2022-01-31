

<?php $__env->startSection('content'); ?>

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green-seagreen">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Coupon </div>
        <div class="actions">
            <a href="<?php echo e(route('discount.index')); ?>" class="btn btn-default btn-sm">
                <i class="fa fa-list"></i> List </a>
        </div>
    </div>
    <div class="portlet-body">
        <form role="form" action="<?php echo e(route('discount.update',['id'=>$discount->id])); ?>" method="post" enctype="multipart/form-data">
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
                    <label class="control-label">Title </label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="title"
                           data-container="body"></i>
                        <input type="text" name="title_en"  value="<?php echo e($discount->title_en); ?>" class="form-control"></div>
                    <?php if($errors->has('title_en')): ?>
                        <span class="text-danger"><?php echo e($errors->first('title_en')); ?></span>
                    <?php endif; ?>
                </div>


                <div class="form-group">
                    <label class="control-label">Amount</label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="Amount"
                           data-container="body"></i>
                        <input type="number" name="amount" value="<?php echo e($discount->amount); ?>" class="form-control"></div>
                    <?php if($errors->has('amount')): ?>
                        <span class="text-danger"><?php echo e($errors->first('amount')); ?></span>
                    <?php endif; ?>
                </div>


                <div class="form-group">

                    <div class="input-icon right">

                        <input type="checkbox" name="is_percent" <?php if($discount->is_percent==1): ?>checked <?php endif; ?> class="icheck"> Is percent</div>
                    <?php if($errors->has('is_percent')): ?>
                        <span class="text-danger"><?php echo e($errors->first('is_percent')); ?></span>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/discounts/edit.blade.php ENDPATH**/ ?>