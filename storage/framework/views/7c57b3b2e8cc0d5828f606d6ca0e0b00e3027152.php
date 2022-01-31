

<?php $__env->startSection('content'); ?>

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Sliders
            </div>
            <div class="actions">
                <a href="<?php echo e(route('slider.index')); ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="<?php echo e(route('slider.store')); ?>" method="post" enctype="multipart/form-data">
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
                        <label class="control-label">Title</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="slider title is optional"
                               data-container="body"></i>
                            <input type="text" name="title" class="form-control"></div>
                        <?php if($errors->has('title')): ?>
                            <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                        <?php endif; ?>
                    </div>



                        <div class="form-group">
                            <label class="control-label">Slider Image</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Image"
                                   data-container="body"></i>
                                <input type="file" class="form-control" onchange="loadFile(event)"
                                       id="image" name="image" required>
                            </div>
                            <p><img id="output" width="200"/></p>
                            <?php if($errors->has('image')): ?>
                                <span class="text-danger"><?php echo e($errors->first('image')); ?></span>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/sliders/create.blade.php ENDPATH**/ ?>