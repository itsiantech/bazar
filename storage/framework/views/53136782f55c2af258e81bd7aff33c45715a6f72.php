

<?php $__env->startSection('content'); ?>

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Categories
            </div>
            <div class="actions">
                <a href="<?php echo e(route('category.index')); ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="<?php echo e(route('category.store')); ?>" method="post" enctype="multipart/form-data">
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
                        <label class="control-label">Category name in English</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Category name in English"
                               data-container="body"></i>
                            <input type="text" name="name_en" class="form-control"></div>
                        <?php if($errors->has('name_en')): ?>
                            <span class="text-danger"><?php echo e($errors->first('name_en')); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Category name in Bangla</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Category name in Bangla"
                               data-container="body"></i>
                            <input type="text" name="name_bn" class="form-control"></div>
                        <?php if($errors->has('name_bn')): ?>
                            <span class="text-danger"><?php echo e($errors->first('name_bn')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Slug</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips"   data-original-title="Category name in Bangla" data-container="body"></i>
                            <input type="text" name="slug"  class="form-control"> </div>
                        <?php if($errors->has('slug')): ?>
                            <span class="text-danger"><?php echo e($errors->first('slug')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Select Parent Category</label>
                        <div class="input-icon right">
                            <select class="form-control" name="parent_id">
                                <option value="NULL"> Select Parent Category</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name_en); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                        </div>

                        <div class="form-group">
                            <label class="control-label">Category Banner Image</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Category name in Bangla"
                                   data-container="body"></i>
                                <input type="file" class="form-control" onchange="loadFile(event)"
                                       id="image" name="image">
                            </div>
                            <p><img id="output" width="200"/></p>
                            <?php if($errors->has('name_bn')): ?>
                                <span class="text-danger"><?php echo e($errors->first('name_bn')); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Category Icon</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Category icon"
                                   data-container="body"></i>
                                <input type="file" class="form-control"
                                         name="icon">
                            </div>
                            <p><img id="output" width="200"/></p>
                            <?php if($errors->has('icon')): ?>
                                <span class="text-danger"><?php echo e($errors->first('icon')); ?></span>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/categories/create.blade.php ENDPATH**/ ?>