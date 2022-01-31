

<?php $__env->startSection('content'); ?>

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Employee
        </div>
        <div class="actions">
            <a href="<?php echo e(route('employee.create')); ?>" class="btn btn-default btn-sm">
                <i class="fa fa-plus"></i> Add </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable table-responsive">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Name</th>
                        <th> Phone </th>
                        <th> Email </th>
                        <th> join </th>
                        <th> Roles </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td> <?php echo e(++$key); ?> </td>
                        <td> <?php echo e($user->name); ?> </td>
                        <td> <?php echo e($user->phone); ?> </td>
                        <td> <?php echo e($user->email); ?> </td>
                        <td> <?php echo e($user->created_at->diffForHumans()); ?> </td>
                        <td>
                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <span class="label label-sm label-info"><?php echo e($role->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>
                        <td>

                            <form action="<?php echo e(route('employee.destroy',['employee'=>$user->id])); ?>" method="post">
                                <?php echo method_field("delete"); ?>
                                <?php echo csrf_field(); ?>
                                <a href="<?php echo e(route('employee.assign_role',['user'=>$user->id])); ?>" class="btn btn-xs label label-sm label-warning ">Assign Role</a>
                                <button class="btn btn-xs label label-sm label-danger" onclick="return confirm('Are your sure to delete this item')">Delete</button>
                            </form>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/employee/index.blade.php ENDPATH**/ ?>