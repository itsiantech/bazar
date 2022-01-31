

<?php $__env->startSection('content'); ?>

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Wallet Transactions
            </div>
        </div>

        <div class="portlet-body">


            <div class="margin-top-20 note note-info">
                <div class="row">
                    <div class="col-md-4">Supplier Address</div>
                    <div class="col-md-4">User Info</div>
                </div>
            </div>

            


            <div class="table-scrollable">
                <table class="table table-striped table-hover" id="sample_2">
                    <thead>
                    <tr>
                        <th> #</th>
                        <th> Order Id</th>
                        <th> Transaction Amount</th>
                        <th> Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $transactionHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td>
                                <?php if(!empty($item->transactionable) && $item->transactionable_type == App\Models\Order::class): ?>
                                    <?php echo e($item->transactionable->unique_order_id??"<span class='badge badge-warning'>N/A</span>"); ?>

                                <?php else: ?>
                                    <span class="badge badge-danger">Not Found</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($item->amount); ?></td>
                            <td><?php echo e($item->created_at); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4">No Transaction found</td>
                        </tr>
                    <?php endif; ?>
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


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/wallets/show.blade.php ENDPATH**/ ?>