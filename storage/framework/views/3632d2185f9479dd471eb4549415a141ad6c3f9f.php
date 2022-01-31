<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>
        <td> <?php echo e(++$key); ?> </td>
        <td> <?php echo e($order->unique_order_id); ?> </td>
        <td> <?php echo e(isset($order->user->name)?$order->user->name:''); ?> </td>
        <td class="text-center"> <?php echo e($order->calculateOriginalAmountAfterDiscount()); ?> </td>
        <td> <?php echo e(date('d  M Y',strtotime($order->created_at))); ?><br>
            <?php echo e($order->created_at->diffForHumans()); ?>

        </td>
        <td> <?php echo e($order->paymentMethod->name); ?> </td>
        <td class="text-center">
            <?php if($order->status=='delivered'): ?>
                <span class=" label label-sm label-success"><i class="fa fa-check"></i></span>
            <?php else: ?>
                <span class="label label-sm label-warning"><?php echo e(ucfirst($order->status)); ?></span>
            <?php endif; ?>
        </td>
        <td>
            <?php if($order->status=='pending'): ?>
                <a href="<?php echo e(route('order.changeStatus',['id'=>$order->id,'status'=>'accepted'])); ?>"
                   class="btn btn-xs label label-sm label-default ">Accept</a>

            

            <?php elseif($order->status=='accepted'): ?>
                   <a href="<?php echo e(route('order.changeStatus',['id'=>$order->id,'status'=>'delivered'])); ?>"
                      class="btn btn-xs label label-sm label-success ">Deliver</a>

            <?php elseif($order->status=='order_processing'): ?>
                <a href="<?php echo e(route('order.changeStatus',['id'=>$order->id,'status'=>'on_delivery'])); ?>"
                   class="btn btn-xs label label-sm label-warning ">On The Way</a>

            <?php elseif($order->status=='on_delivery'): ?>
                <a href="<?php echo e(route('order.changeStatus',['id'=>$order->id,'status'=>'delivered'])); ?>"
                   class="btn btn-xs label label-sm label-success ">Deliver</a>

            <?php elseif($order->status=='canceled'): ?>
                <a href="<?php echo e(route('order.changeStatus',['id'=>$order->id,'status'=>'pending'])); ?>"
                   class="btn btn-xs label label-sm label-warning ">Pending</a>

            <?php endif; ?>
            <a href="<?php echo e(route('order.changeStatus',['id'=>$order->id,'status'=>'canceled'])); ?>"
               class="btn btn-xs label label-sm label-danger " >Cancel</a>

        </td>

        <td>
            <a href="<?php echo e(route('order.detail',['id'=>$order->id])); ?>" class="btn btn-xs btn-primary">View Detail</a>
            <a href="<?php echo e(route('order.invoice',['id'=>$order->id])); ?>" class="btn btn-xs btn-success">Invoice</a>
            <a href="<?php echo e(route('order.delete',['id'=>$order->id])); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are your sure to delete this item')">delete</a>

        </td>
    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/orders/order_table.blade.php ENDPATH**/ ?>