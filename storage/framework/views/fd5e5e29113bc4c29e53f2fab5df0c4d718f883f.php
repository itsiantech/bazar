<?php $__env->startSection('content'); ?>

    <div class="row">
        <div class="col-md-6">

            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> Update top products ( please perform this task at least after 12 am) </div>

                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <ul class="sort_menu list-group">
                        <?php $__currentLoopData = $topTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item" data-id="<?php echo e($row->id); ?>">
                                <span class="handle"></span> <?php echo e($row->name); ?>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
            <!-- END Portlet PORTLET-->

        </div>
        <div class="col-md-6">

            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> Update top products ( please perform this task at least after 12 am) </div>

                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable table-responsive">
                        <table class="table table-striped table-hover" id="sample_2">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> Top Type Name </th>
                                <th> Status </th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $__currentLoopData = $topTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$topType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                    <td> <?php echo e(++$key); ?> </td>
                                    <td> <?php echo e($topType->name); ?> </td>

                                    <td>
                                        <a href="<?php echo e(route('topProduct.update',['id'=>$topType->id])); ?>" class="btn btn-xs label label-sm label-success ">Update</a>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END Portlet PORTLET-->

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('stylesheets'); ?>
    <?php echo $__env->make('layouts.asset.datatable-css-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>

    <style>
        .list-group-item {
            display: flex;
            align-items: center;
        }

        .highlight {
            background: #f7e7d3;
            min-height: 30px;
            list-style-type: none;
        }

        .handle {
            min-width: 18px;
            background: #607D8B;
            height: 15px;
            display: inline-block;
            cursor: move;
            margin-right: 10px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('layouts.asset.js.datatable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function(){

            function updateToDatabase(idString){
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'}});

                $.ajax({
                    url:'<?php echo e(route('topProduct.updateTypeOrder')); ?>',
                    method:'POST',
                    data:{ids:idString},
                    success:function(){
                        alert('Type index updated')
                    },
                    error: function (error){
                        console.log(error)
                    }
                })
            }

            var target = $('.sort_menu');
            target.sortable({
                handle: '.handle',
                placeholder: 'highlight',
                axis: "y",
                update: function (e, ui){
                    var sortData = target.sortable('toArray',{ attribute: 'data-id'})
                    updateToDatabase(sortData.join(','))
                }
            })

        })
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/bazar/resources/views/admin/top_products/index.blade.php ENDPATH**/ ?>