

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make("layouts.message.errors_all", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="portlet solid margin-top-20 margin-bottom-20">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Invoice
            </div>
        </div>
        <div class="portlet-body">
         <img width="100" src="<?php echo e(asset('assets/layouts/layout/img/ed.png')); ?>" alt="">

            <div class="margin-top-20 note note-info">
                <div class="row">
                    <div class="col-md-4">Supplier Address</div>
                    <div class="col-md-4">Delivery Address</div>
                    <div class="col-md-4">Invoice</div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div id="messageDiv1">
                        <?php if(Session::has('success')): ?>
                            <?php echo $__env->make('layouts.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php elseif(Session::has('error')): ?>
                            <?php echo $__env->make('layouts.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> Product Name</th>

                                <th class="text-center"> Unit</th>
                                <th class="text-center"> Quantity</th>
                                <th class="text-center"> Price/Unit</th>
                                <th class="text-center"> VAT</th>
                                <th class="text-center"> Price <span style="font-size: 10px">
                                            ( including VAT)</span></th>
                                <th style="width: 200px"> Action </th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td> <?php echo e(++$key); ?> </td>

                                    <td> <?php echo e($item->product->name_en); ?> </td>

                                    <td class="text-center"> <?php echo e($item->product->quantity); ?> <?php echo e($item->product->unit); ?></td>
                                    <td class="text-center"> <?php echo e($item->quantity); ?> </td>
                                    <td class="text-center"> <?php echo e($item->price); ?></td>
                                    <td class="text-center"> <?php echo e($item->product->vat_percent); ?>% <span style="font-size: 10px">
                                            (<?php echo e(\App\Models\Order::GetPercentInValue($item->price,$item->product->vat_percent)); ?> tk)</span>
                                    </td>

                                    <td class="text-center">
                                        <?php echo e(($item->price*$item->quantity)+\App\Models\Order::GetPercentInValue($item->price*$item->quantity,$item->product->vat_percent)); ?>

                                    </td>

                                    <td style="display: inline-block !important;">

                                        <form role="form" action="<?php echo e(route('refund.store')); ?>" method="post">

                                            <a href="<?php echo e(route('order.removeItem',[
                                        'id'=>$item->id,
                                        'order_id'=>$item->order_id,
                                        'product_id'=>$item->product_id,

                                        ])); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Confirm to remove this item')"> Remove </a>
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="unique_order_id" value="<?php echo e($order->unique_order_id); ?>">
                                            <input type="hidden" name="order_item_id" value="<?php echo e($item->id); ?>">
                                            <input onclick="return confirm('Confirm to refund this item')" type="submit" value="Refund" class="btn btn-primary btn-xs">
                                        </form>
                                    </td>


                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <form action="<?php echo e(route('order.addItem',['id'=>$order->id])); ?>" method="POST">
                                <?php echo csrf_field(); ?>

                                <td colspan="3">
                                    <div class="form-group">
                                        <select id="products" class="form-control" name="product_id" tabindex="-1" aria-hidden="true" required>
                                            <option>Select Product</option>

                                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($product->id); ?>" ><?php echo e($product->name_en); ?> <?php echo e($product->quantity); ?> <?php echo e($product->unit); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">

                                         <input type="text" name="quantity" class="form-control" required placeholder="quantity">
                                        <input type="hidden" value="<?php echo e($order->id); ?>" name="order_id">

                                    </div>
                                </td>

                                <td>

                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                </td>
                            </form>
                            <tr>
                                <td colspan="3"></td>
                                <form action="<?php echo e(route('order.discount',['id'=>$order->id])); ?>" method="POST">
                                    <?php echo csrf_field(); ?>

                                    <td>

                                        <select class="form-control" name="discount_id">
                                            <option value="NULL">Select Discount( Remove )</option>
                                            <?php $__currentLoopData = $discounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($discount->id); ?>"><?php echo e($discount->title_en); ?>

                                                    ( <?php echo e($discount->amount); ?><?php echo e(($discount->is_percent==1?' %':" Taka")); ?>

                                                    )
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-success">Apply</button>
                                    </td>
                                </form>
                            </tr>

                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Total</strong></td>
                                <td><strong><?php echo e($total['itemTotal']); ?></strong></td>
                            </tr>
                            <?php if($total['deliveryCharge']>0): ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td><strong>Delivery Charge</strong></td>
                                    <td><strong><?php echo e($total['deliveryCharge']); ?></strong></td>
                                </tr>
                            <?php endif; ?>
                            <?php if($total['discount']>0): ?>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Discount</strong></td>
                                <td><strong><?php echo e($total['discount']); ?></strong></td>
                            </tr>
                            <?php endif; ?>
                            <?php if($total['coupon']>0): ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td><strong>Coupon</strong></td>
                                    <td><strong><?php echo e($total['coupon']); ?></strong></td>
                                </tr>
                            <?php endif; ?>

                            <?php if($total['totalSaved']>0): ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td><strong>Total Saved</strong></td>
                                    <td><strong><?php echo e($total['totalSaved']); ?></strong></td>
                                </tr>
                            <?php endif; ?>

                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Grand Total</strong></td>
                                <td><strong><?php echo e($total['netTotal']); ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Total Paid</strong></td>
                                <td><strong><?php echo e($order->wallet_reduction); ?></strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Payable Amount</strong></td>
                                <td><strong><?php echo e($total['netTotal'] - $order->wallet_reduction); ?></strong></td>
                            </tr>
                            </tbody>
                        </table>
                        <a href="<?php echo e(route('order.invoice',['id'=>$order->id])); ?>" class="btn btn-lg blue hidden-print margin-bottom-5"> Print
                            <i class="fa fa-print"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('stylesheets'); ?>
    <?php echo $__env->make('layouts.asset.datatable-css-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo e(asset('assets/pages/css/invoice.min.css')); ?>

    <link href="<?php echo e(asset("assets/global/plugins/select2/css/select2.min.css")); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo e(asset("assets/global/plugins/select2/css/select2-bootstrap.min.css")); ?>" rel="stylesheet" type="text/css"/>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset("assets/global/plugins/select2/js/select2.full.min.js")); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset("assets/pages/scripts/components-select2.js")); ?>"></script>
    <script>
        $(document).ready(function () {
            $('#products').select2();
        });
    </script>


<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/orders/show.blade.php ENDPATH**/ ?>