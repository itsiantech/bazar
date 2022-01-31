

<?php $__env->startSection('content'); ?>

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Roles
            </div>
            <div class="actions">
                <a href="<?php echo e(route('employee.index')); ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="<?php echo e(route('employee.sync_role', ['user' => $user->id])); ?>" method="post">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" value="patch">
                <div id="messageDiv">
                    <?php if(Session::has('success')): ?>
                        <?php echo $__env->make('layouts.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php elseif(Session::has('error')): ?>
                        <?php echo $__env->make('layouts.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
                <?php if(empty($user)): ?>
                    <p class="alert alert-warning alert-dismissable">User Not Found</p>
                <?php else: ?>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">name</label>
                            <div class="input-icon right">
                                <input disabled type="text" name="name" value="<?php echo e($user->name); ?>" class="form-control">
                            </div>
                            <?php if($errors->has('name')): ?>
                                <span class="text-danger"><?php echo e($errors->first('name')); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Role</label>
                            <div class="input-icon right">
                                <select name="role_id[]" id="" class="form-control">
                                    <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($id); ?>"><?php echo e($role); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <option value="0">No Role Found</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <?php if($errors->has('role_id')): ?>
                                <span class="text-danger"><?php echo e($errors->first('role_id')); ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-actions right">
                            <button type="button" class="btn default">Cancel</button>
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <!-- END Portlet PORTLET-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/employee/assign_role.blade.php ENDPATH**/ ?>