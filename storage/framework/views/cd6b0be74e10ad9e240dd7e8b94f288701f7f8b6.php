<?php $__env->startSection('content'); ?>
    <div class="invoice">
        <div class="row  invoice-logo">
            <div class=" col-xs-4">
            </div>
            <div class=" col-xs-4 invoice-logo-space">
                <img src="<?php echo e(asset('assets/layouts/layout/img/logo.min.en.png')); ?>" class="pull-center img-responsive"
                     alt=""/>
            </div>
            <div class=" col-xs-4">
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-xs-4">
                <h3>Delivery Address</h3>
                
                <?php if(isset($order->address)): ?>

                    <address>
                        <?php echo e((isset($order->address)?$order->address->receiver_name:'')); ?><br>
                        <?php echo e((isset($order->address)?$order->address->receiver_phone:'')); ?><br>
                        <?php echo e((isset($order->address)?$order->address->address:'')); ?><br>


                    </address>
                <?php else: ?>
                    <address>
                        <strong><?php echo e($order->user->name); ?></strong>
                        <strong>Phone</strong> <?php echo e($order->user->phone); ?> <br>
                        <strong>Email</strong> <?php echo e($order->user->email); ?>

                    </address>
                <?php endif; ?>
            </div>
            

            <div class="col-xs-4">


            </div>
            <div class="col-xs-4 invoice-payment">
                <h3>Order Details:</h3>

                <ul class="list-unstyled">

                    <li><strong>Order ID :</strong> <?php echo e($order->unique_order_id); ?> </li>
                    <li><strong>Customer ID :</strong> <?php echo e($order->user->customerId); ?> </li>
                    <li><strong>Order Date:</strong> <?php echo e(date('d  M Y',strtotime($order->created_at))); ?> </li>
                    <?php if(!empty($order->schedule)): ?>
                        <li><strong>Scheduled Time:</strong> <?php echo e($order->schedule); ?> </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center"> #</th>
                        <th class="text-center"> Product Name</th>
                        <th class="text-center"> Unite</th>
                        <th class="text-center"> Quantity</th>
                        <th class="text-center"> Price/Unit</th>
                        <th class="text-center"> VAT</th>
                        <th class="text-center"> Price <span style="font-size: 10px">
                                            ( including VAT)</span></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>
                            <td class="text-center"> <?php echo e(++$key); ?> </td>

                            <td class="text-center"> <?php echo e($item->product->name_en); ?> </td>
                            <td class="text-center"> <?php echo e($item->product->quantity); ?> <?php echo e($item->product->unit); ?></td>
                            <td class="text-center"> <?php echo e($item->quantity); ?> </td>
                            <td class="text-center"> <?php echo e($item->price); ?></td>
                            <td class="text-center"> <?php echo e($item->product->vat_percent); ?>% <span style="font-size: 10px">
                                            (<?php echo e(\App\Models\Order::GetPercentInValue($item->price,$item->product->vat_percent)); ?> tk)</span>
                            </td>
                            <td class="text-center"> <?php echo e(($item->price*$item->quantity)+\App\Models\Order::GetPercentInValue($item->price,$item->product->vat_percent)); ?> </td>


                            

                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="text-center">
            <span style="font-size: 10px">**This is System Generated invoice email. For any query please send us email or call us !</span>

        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.invoice', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bazar/resources/views/admin/orders/invoice.blade.php ENDPATH**/ ?>