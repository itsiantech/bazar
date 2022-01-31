<?php $__env->startSection('content'); ?>

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> User
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-1">
                <a href="<?php echo e(route('customer.export')); ?>" class="btn btn-success btn-block d-block">Export</a>

            </div>
            <?php echo $__env->make("layouts.partials.table-date-range-filter", ['state' => 'default', 'actionURL' => 'customer.dateFiltered'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="col-md-12">
                <div class="table-scrollable table-responsive">
                    <table class="table table-striped table-hover" id="sample_2">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> Id</th>
                            <th> Name</th>
                            <th> Email</th>
                            <th> Phone </th>
                            <th> join </th>
                            <th> Customer Status </th>
                            <th> Action </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td> <?php echo e(++$key); ?> </td>
                                <td> <?php echo e($customer->customerId); ?> </td>
                                <td> <?php echo e($customer->name); ?> </td>
                                <td> <?php echo e($customer->email); ?> </td>
                                <td> <?php echo e($customer->phone); ?> </td>
                                <td> <?php echo e($customer->created_at->diffForHumans()); ?> </td>
                                <td> <?php echo e($customer->is_activated?"Activated":"Disabled"); ?> </td>
                                <td>
                                    <form method="post" action="<?php echo e(route("customer.delete", ['id' => $customer->id])); ?>" id="form-<?php echo e($customer->id); ?>" class="form-inline">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="_method" value="delete" id="form-method-hidden-<?php echo e($customer->id); ?>">
                                        <button onclick="return confirm('Are your sure to delete this customer')" class="btn btn-xs label label-sm label-danger" >Delete User</button>
                                        <button class="btn btn-xs label label-sm label-warning" onclick="submitForm(event, '<?php echo e($customer->id); ?>','<?php echo e(route('customer.disable_customer',['customer'=>$customer->id])); ?>')">Disable User</button>
                                        <button class="btn btn-xs label label-sm label-success" onclick="submitForm(event, '<?php echo e($customer->id); ?>','<?php echo e(route('customer.enable_customer',['customer'=>$customer->id])); ?>')">Enable User</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
    <script type="application/javascript">

        function submitForm(e, id, url){
            event.preventDefault()
            var form = "#form-"+id
            var methodInput = "#form-method-hidden-"+id

            $(form).attr("action", url)
            $(methodInput).val('patch')
            $(form).submit();
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bazar/resources/views/admin/customers/index.blade.php ENDPATH**/ ?>