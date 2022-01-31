<?php $__env->startSection('content'); ?>

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Orders </div>
            <div class="actions">
                <a href="<?php echo e(route('product.create')); ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-plus"></i> Add </a>
            </div>
        </div>

        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 10px">
                    <a href="<?php echo e(route('order.index',['state'=>'new'])); ?>" class="btn btn-sm btn-success">New Orders</a>
                    <a href="<?php echo e(route('order.index',['state'=>'today'])); ?>" class="btn btn-sm btn-success">Orders today</a>
                    <a href="<?php echo e(route('order.index',['state'=>'delivered'])); ?>" class="btn btn-sm btn-success">Delivered Orders</a>
                    <a href="<?php echo e(route('order.index',['state'=>'undelivered'])); ?>" class="btn btn-sm btn-success">Undelivered Orders</a>
                    <a href="<?php echo e(route('order.index',['state'=>'all'])); ?>" class="btn btn-sm btn-success">All Orders</a>
                    <a href="<?php echo e(route('order.ExportDailyOrders',['state'=>'all'])); ?>" class="btn btn-sm btn-success">Export Orders</a>
                    <a href="<?php echo e(route('sslIpnResposne')); ?>" class="btn btn-sm btn-success">SSL Response</a>
                </div>

                <div class="col-md-6">
                    <select class="form-control" id="state">
                        <option>Select one</option>
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                        <option value="canceled">Canceled</option>
                        <option value="on_delivery">On Way</option>
                        <option value="delivered">Delivered</option>
                    </select>
                </div>
                <?php echo $__env->yieldContent("table-date-range-filter"); ?>
                <div class="col-md-12">
                    <div class="table-scrollable">
                        <?php echo $__env->yieldContent("table"); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Portlet PORTLET-->

<?php $__env->stopSection(); ?>
<?php $__env->startPush('stylesheets'); ?>
    <?php echo $__env->make('layouts.asset.datatable-css-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("layouts.asset.css.dateTimePicker", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('layouts.asset.js.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make("layouts.asset.js.dateTimePicker", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        $("#state").change(function()
        {
            var state = $(this).val()
            window.location = '<?php echo e(route('order.index')); ?>'+'?state='+state;
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bazar/resources/views/layouts/partials/order/index.blade.php ENDPATH**/ ?>