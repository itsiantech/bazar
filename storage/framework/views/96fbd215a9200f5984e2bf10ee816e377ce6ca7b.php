

<?php $__env->startSection('content'); ?>

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Coupon create
            </div>
            <div class="actions">
                <a href="<?php echo e(route('coupon.index')); ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="<?php echo e(route('coupon.store')); ?>" method="post" enctype="multipart/form-data">
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
                        <label class="control-label">Coupon Name</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Category name in English"
                               data-container="body"></i>
                            <input type="text" name="name" class="form-control"></div>
                        <?php if($errors->has('name')): ?>
                            <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Code</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Promo code"
                               data-container="body"></i>
                            <input type="text" name="code" class="form-control"></div>
                        <?php if($errors->has('code')): ?>
                            <span class="text-danger"><?php echo e($errors->first('code')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Minimum Amount</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="minimum perches amount"
                               data-container="body"></i>
                            <input type="text" name="minimum_amount" class="form-control"></div>
                        <?php if($errors->has('minimum_amount')): ?>
                            <span class="text-danger"><?php echo e($errors->first('minimum_amount')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Amount</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Amount"
                               data-container="body"></i>
                            <input type="number" name="amount" class="form-control"></div>
                        <?php if($errors->has('amount')): ?>
                            <span class="text-danger"><?php echo e($errors->first('amount')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Is percent</label>
                                <div class="input-icon right">

                                    <input type="checkbox" name="is_percent" class="form-control"></div>
                                <?php if($errors->has('is_percent')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('is_percent')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Is Cash back</label>
                                <div class="input-icon right">
                                    <input type="checkbox" name="is_cash_back" class="form-control"></div>
                                <?php if($errors->has('is_cash_back')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('is_cash_back')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Is Free delivery</label>
                                <div class="input-icon right">

                                    <input type="checkbox" name="is_free_delivery" data-on-text="Free" class="form-control"></div>
                                <?php if($errors->has('is_free_delivery')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('is_free_delivery')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label">Max use ability</label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-original-title="Category name in Bangla"
                                       data-container="body"></i>
                                    <input type="number" name="max_use" class="form-control"></div>
                                <?php if($errors->has('max_use')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('max_use')); ?></span>
                                <?php endif; ?>
                            </div>


                        </div>
                        <div class="col-lg-6">


                            <div class="form-group">
                                <label class="control-label">Validity</label>
                                <div class="input-icon right">
                                    <i class="fa fa-info-circle tooltips" data-original-title="Category name in Bangla"
                                       data-container="body"></i>
                                    <input type="date" name="validity" class="form-control"></div>
                                <?php if($errors->has('validity')): ?>
                                    <span class="text-danger"><?php echo e($errors->first('validity')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/coupons/create.blade.php ENDPATH**/ ?>