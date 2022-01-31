<?php $__env->startSection('content'); ?>
<h1 class="page-title">
    Dashboard
    <small>BangoShop</small>
</h1>
<!-- END PAGE HEADER-->

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <i class="icon-globe font-red"></i>
                    <span class="caption-subject font-red bold uppercase">Date Filter</span>
                </div>
            </div>
            <div class="portlet-body" id="dateRangeSearch">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd" style="width: 100% !important;">
                                <input placeholder="start" autocomplete="off" type="text" class="form-control" name="start">
                                <span class="input-group-addon"> to </span>
                                <div class="input-group">
                                    <input placeholder="end" autocomplete="off" type="text" class="form-control" name="end" data-date-format="yyyy-mm-dd" value="">
                                    <span class="input-group-btn">
                                        <button id="filterSalesByDate" class="btn btn-success" type="submit">Start Filtering</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" id="dateRangeSearchBody">
                    <?php echo $__env->make('admin.Dashboard.dateWiseCardReport', ['filteredSales' => [], 'totalSales' => 0, 'totalOrders' => 0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="fa fa-users fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number"> <?php echo e($users); ?> ( new <?php echo e($newUsers); ?>  ) </div>
                <div class="desc"> Total Customers </div>
            </div>
            <a class="more" href="javascript:;"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>


    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat red">
            <div class="visual">
                <i class="fa fa-print-cart"></i>
            </div>
            <div class="details">
                <div class="number"><?php echo e($products); ?> </div>
                <div class="desc">  Products </div>
            </div>
            <a class="more" href="javascript:;"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="fa fa-shopping-cart"></i>
            </div>
            <div class="details">
                <div class="number"> <?php echo e($orders); ?> </div>
                <div class="desc">  Orders </div>
            </div>
            <a class="more" href="javascript:;"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        <div class="dashboard-stat green">
            <div class="visual">
                <i class="fa fa-group fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number"> <?php echo e($brands); ?> </div>
                <div class="desc"> Brands </div>
            </div>
            <a class="more" href="javascript:;"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 margin-bottom-10">
        <div class="dashboard-stat blue">
            <div class="visual">
                <i class="fa fa-users fa-icon-medium"></i>
            </div>
            <div class="details">
                <div class="number"> <?php echo e($sales); ?>  </div>
                <div class="desc"> Total Sales </div>
            </div>
            <a class="more" href="javascript:;"> View more
                <i class="m-icon-swapright m-icon-white"></i>
            </a>
        </div>
    </div>
</div>




<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <!-- Begin: life time stats -->
                <!-- BEGIN PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title tabbable-line">
                        <div class="caption">
                            <i class="icon-globe font-red"></i>
                            <span class="caption-subject font-red bold uppercase">Order Report</span>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#dailyOrders" id="statistics_orders_tab" data-toggle="tab"> Daily Orders </a>
                            </li>
                        </ul>
                    </div>
                    <div class="portlet-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="dailyOrders">
                                <div id="ordersPerDay" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End: life time stats -->
            </div>

            <div class="col-md-12">
                <!-- Begin: life time stats -->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-share font-blue"></i>
                            <span class="caption-subject font-blue bold uppercase">Overview</span>
                            <span class="caption-helper">report overview...</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="tabbable-line">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#new-orders" data-toggle="tab"> New Orders </a>
                                </li>

                                <li>
                                    <a href="#new-customers" data-toggle="tab"> New Customers </a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="new-orders">
                                    <div class="table-responsive">
                                        <table id="todayOrders" class="table table-striped table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th> # </th>
                                                <th> Order ID </th>
                                                <th> Ordered By </th>
                                                <th class="text-center"> Total Price</th>
                                                <th> Order time </th>
                                                <th> Payment Method</th>
                                                <th> Status </th>
                                                <th>Change Status </th>
                                                <th>View Detail</th>
                                            </tr>
                                            </thead>
                                            <tbody id="todayOrderBody">
                                                <?php echo $__env->make('admin.orders.order_table', ['orders' => $newOrders], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="new-customers">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
                                            <tr>
                                                <th> # </th>
                                                <th> Name</th>
                                                <th> Phone </th>
                                                <th> Email </th>
                                                <th> join </th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $newUserList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td> <?php echo e(++$key); ?> </td>
                                                    <td> <?php echo e($user->name); ?> </td>
                                                    <td> <?php echo e($user->phone); ?> </td>
                                                    <td> <?php echo e($user->email); ?> </td>
                                                    <td> <?php echo e($user->created_at->diffForHumans()); ?> </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
                <!-- End: life time stats -->
            </div>
        </div>
    </div>

    <div class="col-md-6">
       <div class="row">
           <div class="col-md-12">
               <!-- Begin: life time stats -->
               <!-- BEGIN PORTLET-->
               <div class="portlet light bordered">
                   <div class="portlet-title tabbable-line">
                       <div class="caption">
                           <i class="icon-globe font-red"></i>
                           <span class="caption-subject font-red bold uppercase">Order Report</span>
                       </div>
                       <ul class="nav nav-tabs">
                           <li class="active">
                               <a href="#monthly_orders" data-toggle="tab"> Monthly Orders </a>
                           </li>
                       </ul>
                   </div>
                   <div class="portlet-body">
                       <div class="tab-content">
                           <div class="tab-pane active" id="monthly_orders">
                               <div id="ordersPerMonth" style="height: 250px;"></div>
                           </div>
                       </div>
                   </div>
               </div>
               <!-- End: life time stats -->
           </div>

           <div class="col-md-12">
               <!-- Begin: life time stats -->
               <!-- BEGIN PORTLET-->
               <div class="portlet light bordered">
                   <div class="portlet-title tabbable-line">
                       <div class="caption">
                           <i class="icon-globe font-red"></i>
                           <span class="caption-subject font-red bold uppercase">Order Report</span>
                       </div>
                       <ul class="nav nav-tabs">
                           <li class="active">
                               <a href="#yearlyOrders" id="statistics_orders_tab" data-toggle="tab"> Yearly Orders </a>
                           </li>
                       </ul>
                   </div>
                   <div class="portlet-body">
                       <div class="tab-content">
                           <div class="tab-pane active" id="yearlyOrders">
                               <div id="ordersPerYear" style="height: 250px;"></div>
                           </div>
                       </div>
                   </div>
               </div>
               <!-- End: life time stats -->
           </div>

           <div class="col-md-12">
               <div class="portlet light bordered">
                   <div class="portlet-title tabbable-line">
                       <div class="caption">
                           <i class="icon-globe font-red"></i>
                           <span class="caption-subject font-red bold uppercase">Scheduled Orders</span>
                       </div>
                       <ul class="nav nav-tabs">
                           <li class="active">
                               <a href="#yearlyOrders" id="statistics_orders_tab" data-toggle="tab"> Scheduled Orders </a>
                           </li>
                       </ul>
                   </div>
                   <div class="portlet-body">
                       <div class="tab-content">
                           <div class="tab-pane active" id="yearlyOrders">
                               <div class="table-responsive">
                                   <table class="table table-striped table-hover table-bordered">
                                       <thead>
                                       <tr>
                                           <th> # </th>
                                           <th> Order Id</th>
                                           <th> Customer </th>
                                           <th> Total </th>
                                           <th> Created At </th>
                                           <th> Scheduled At </th>

                                       </tr>
                                       </thead>
                                       <tbody>
                                       <?php $__empty_1 = true; $__currentLoopData = $scheduledOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                           <tr>
                                               <td><?php echo e($loop->iteration); ?></td>
                                               <td>
                                                   <a href="<?php echo e(route('order.detail', ['id' => $order->id])); ?>"><?php echo e($order->unique_order_id); ?></a>
                                               </td>
                                               <td> <?php echo e(isset($order->user->name)?$order->user->name:''); ?> </td>
                                               <td class="text-center"> <?php echo e($order->calculateOriginalAmountAfterDiscount()); ?> </td>
                                               <td> <?php echo e(date('d  M Y',strtotime($order->created_at))); ?><br>
                                                   <?php echo e($order->created_at->diffForHumans()); ?>

                                               </td>
                                               <td>
                                                   <?php echo e($order->schedule); ?>

                                               </td>
                                           </tr>
                                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                           <tr class="text-center">
                                               <td colspan="6">No Scheduled Orders Found</td>
                                           </tr>
                                       <?php endif; ?>
                                       </tbody>
                                   </table>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>

    </div>
</div>









<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('/assets/global/plugins/morris/morris.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('/assets/global/plugins/morris/raphael-min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>" type="text/javascript"></script>
    <?php echo $__env->make("layouts.asset.js.dateTimePicker", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        $(document).ready(function (){

            $('#filterSalesByDate').on('click', function (){
                var startDate = $('#dateRangeSearch input[name="start"]').val()
                var endDate = $('#dateRangeSearch input[name="end"]').val()
                var url = '<?php echo e(route('dashboard.filterSalesByDate')); ?>'

                if(!!startDate && !!endDate){
                    url = url + '?start='+startDate+'&end='+endDate
                    $.ajax({
                        url: url,
                        method: 'get',
                        success: function(tableBody){
                            $('#dateRangeSearchBody').html(tableBody)
                        },
                        error: function (error){
                            console.log(error)
                        }
                    })
                }
            })



            $.ajax({
                url:'<?php echo e(route('monthlyOrderGraph')); ?>',
                method: 'get',
                success: function(data){
                    if(Array.isArray(data)){
                        var conf = {
                            data:data,
                            xKey: 'month',
                            yKeys: ['value'],
                            labels: ['totalOrders'],
                            element: 'ordersPerMonth'
                        }
                        // generateMorrisLineChart(conf)
                        generateBarChart(conf)
                    }
                },
                error: function (data){
                    var conf = {
                        data:[],
                        xKey: 'month',
                        yKeys: ['value'],
                        labels: ['totalOrders'],
                        element: 'ordersPerMonth'
                    }
                    // generateMorrisLineChart(conf)
                    generateBarChart(conf)
                }
            })


            $.ajax({
                url:'<?php echo e(route('dailyOrderGraph')); ?>',
                method: 'get',
                success: function(data){
                    if(Array.isArray(data)){
                        var conf = {
                            data:data,
                            xKey: 'day',
                            yKeys: ['current', 'previous'],
                            labels: ['current', 'previous'],
                            element: 'ordersPerDay'
                        }
                        generateMorrisLineChart(conf)
                    }
                },
                error: function (data){
                    var conf = {
                        data:[],
                        xKey: 'day',
                        yKeys: ['current', 'previous'],
                        labels: ['totalOrders'],
                        element: 'ordersPerDay'
                    }
                    generateMorrisLineChart(conf)
                }
            })


            $.ajax({
                url:'<?php echo e(route('yearlyOrderGraph')); ?>',
                method: 'get',
                success: function(data){
                    if(Array.isArray(data)){
                        var conf = {
                            data:data,
                            xKey: 'year',
                            yKeys: ['value'],
                            labels: ['totalOrders'],
                            element: 'ordersPerYear'
                        }
                        generateBarChart(conf)
                    }
                },
                error: function (data){
                    var conf = {
                        data:[],
                        xKey: 'year',
                        yKeys: ['value'],
                        labels: ['totalOrders'],
                        element: 'ordersPerYear'
                    }
                    generateBarChart(conf)
                }
            })


            function generateMorrisLineChart(conf){
                var config = {
                    element: conf.element,
                    data: conf.data,
                    parseTime: false,
                    xkey: conf.xKey,
                    ykeys: conf.yKeys,
                    labels: conf.labels,
                }
                new Morris.Line(config);
            }


            function generateBarChart(conf){
                var config = {
                    element: conf.element,
                    data: conf.data,
                    // parseTime: false,
                    xkey: conf.xKey,
                    ykeys: conf.yKeys,
                    labels: conf.labels,
                }
                new Morris.Bar(config);
            }


        })

        var totalNewOrders = <?php echo e(count($newOrders)); ?>


        Echo.private(`OrderCreated`)
            .listen('SuccessfulOrderNotification', (e) => {
                e = e.order
                console.log(e)
                var d = `
                    <tr>
                        <td> ${++totalNewOrders} </td>
                        <td> ${e.unique_order_id} </td>
                        <td> ${(!!e.user)?e.user.name:"N/A"} </td>
                        <td class="text-center"> ${e.amount} </td>
                        <td> ${(!!e.created_at)?JSON.stringify(e.created_at):"N/A"}</td>
                        <td> ${(!!e.payment_method)?e.payment_method.name:''}</td>
                        <td class="text-center">
                            <span class="label label-sm label-warning">Pending</span>
                        </td>
                        <td>
                            <a href='https://backend.bangoshop.com/private-panel/orders/change-status?id=${e.id}&amp;status=accepted' class='btn btn-xs label label-sm label-default '>Accept</a>
                            <a href='https://backend.bangoshop.com/private-panel/orders/change-status?id=${e.id}&amp;status=canceled' class='btn btn-xs label label-sm label-danger '>Cancel</a>
                        </td>
                        <td>
                            <a href='https://backend.bangoshop.com/private-panel/orders/detail/${e.id}' class='btn btn-xs btn-primary'>View Detail</a>
                            <a href='https://backend.bangoshop.com/private-panel/orders/invoice/${e.id}' class='btn btn-xs btn-success'>Invoice</a>
                            <a href='https://backend.bangoshop.com/private-panel/orders/delete/${e.id}' class='btn btn-xs btn-danger'>delete</a>
                        </td>
                    </tr>`
                $("#todayOrderBody").append(d)
            });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('stylesheets'); ?>
    <link href="<?php echo e(asset('/assets/global/plugins/morris/morris.css')); ?>" rel="stylesheet" type="text/css" />
    <?php echo $__env->make("layouts.asset.css.dateTimePicker", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bazar/resources/views/admin/index.blade.php ENDPATH**/ ?>