

<?php $__env->startSection('content'); ?>

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Wallets
            </div>
        </div>

        <div class="portlet-body">

            <div class="table-scrollable">
                <table class="table table-striped table-hover" id="sample_2">
                    <thead>
                    <tr>
                        <th> #</th>
                        <th> Wallet Id</th>
                        <th> User Name</th>
                        <th> Balance</th>
                        <th> Status</th>
                        <th> Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($wallet->walletId??'N/A'); ?></td>
                            <td><?php echo e(!empty($wallet->user)?$wallet->user->name:"User Not Found"); ?></td>
                            <td><?php echo e($wallet->balance); ?></td>
                            <td><?php echo e($wallet->is_active == 1?'active':'disabled'); ?></td>
                            <td>
                                <a href="<?php echo e(route('wallet.show', ['wallet' => $wallet->id])); ?>" class="btn btn-xs btn-info">History</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5">No Wallet found</td>
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
    <script>
        $("#state").change(function () {
            //this is the #state dom element
            var state = $(this).val()
            // window.location = 'http://localhost:81/ed/public/private-panel/orders/index?state='+state;
            window.location = '<?php echo e(route('order.index')); ?>' + '?state=' + state;
            

            
            
            
            
            
            
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/wallets/index.blade.php ENDPATH**/ ?>