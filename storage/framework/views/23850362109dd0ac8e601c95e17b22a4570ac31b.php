


<?php $__env->startSection("table-date-range-filter"); ?>
    <?php echo $__env->make("layouts.partials.table-date-range-filter", ['state' => (isset($state) && !empty($state))?$state:'', 'actionURL' => 'order.getDateFilteredOrder'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection("table"); ?>
    <table class="table table-striped table-hover" id="sample_2">
        <thead>
        <tr>
            <th> #</th>
            <th> Order ID</th>
            <th> Ordered By</th>
            <th class="text-center"> Total Price</th>
            <th> Order time</th>
            <th> Payment Method</th>
            <th> Status</th>
            <th>Change Status</th>
            <th>View Detail</th>
        </tr>
        </thead>
        <tbody>
        <?php echo $__env->make('admin.orders.order_table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </tbody>
    </table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.partials.order.index", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>