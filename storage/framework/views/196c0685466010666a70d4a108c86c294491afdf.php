

<?php $__env->startSection('content'); ?>

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Product
            </div>
            <div class="actions">
                <a href="<?php echo e(route('product.index')); ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="<?php echo e(route('product.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div id="messageDiv1">
                    <?php if(Session::has('success')): ?>
                        <?php echo $__env->make('layouts.message.success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php elseif(Session::has('error')): ?>
                        <?php echo $__env->make('layouts.message.error', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label">Product name in English</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Product name in English"
                               data-container="body"></i>
                            <input type="text" name="name_en" required class="form-control"></div>
                        <?php if($errors->has('name_en')): ?>
                            <span class="text-danger"><?php echo e($errors->first('name_en')); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Product name in Bangla</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Product name in Bangla"
                               data-container="body"></i>
                            <input type="text" name="name_bn" required class="form-control"></div>
                        <?php if($errors->has('name_bn')): ?>
                            <span class="text-danger"><?php echo e($errors->first('name_bn')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Slug</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Product slug"
                               data-container="body"></i>
                            <input type="text" name="slug" required class="form-control"></div>
                        <?php if($errors->has('slug')): ?>
                            <span class="text-danger"><?php echo e($errors->first('slug')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Product Description in English</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Product name in English"
                               data-container="body"></i>
                            <textarea rows="10" class="form-control" name="description_en"></textarea>
                        </div>
                        <?php if($errors->has('description_en')): ?>
                            <span class="text-danger"><?php echo e($errors->first('description_en')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Product Description in Bangla</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="Product name in Bangla"
                               data-container="body"></i>
                            <textarea rows="10" class="form-control" name="description_bn"></textarea>
                        </div>
                        <?php if($errors->has('description_bn')): ?>
                            <span class="text-danger"><?php echo e($errors->first('description_bn')); ?></span>
                        <?php endif; ?>
                    </div>


                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Price in english</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Vat percent"
                                   data-container="body"></i>
                                <input type="number" class="form-control" name="price_en">
                            </div>
                            <?php if($errors->has('price_en')): ?>
                                <span class="text-danger"><?php echo e($errors->first('price_en')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Price in Bangla</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Tax percent"
                                   data-container="body"></i>
                                <input type="text" class="form-control" name="price_bn">
                            </div>
                            <?php if($errors->has('price_bn')): ?>
                                <span class="text-danger"><?php echo e($errors->first('price_bn')); ?></span>
                            <?php endif; ?>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Quantity</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Vat percent"
                                   data-container="body"></i>
                                <input type="number" class="form-control" name="quantity">
                            </div>
                            <?php if($errors->has('quantity')): ?>
                                <span class="text-danger"><?php echo e($errors->first('quantity')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Attribute</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Vat percent"
                                   data-container="body"></i>
                                <input min="0" step="0.01" type="number" class="form-control" name="attribute">
                            </div>
                            <?php if($errors->has('attribute')): ?>
                                <span class="text-danger"><?php echo e($errors->first('attribute')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Unit per Quantity</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Tax percent"
                                   data-container="body"></i>
                                <input type="text" class="form-control" name="unit">
                            </div>
                            <?php if($errors->has('unit')): ?>
                                <span class="text-danger"><?php echo e($errors->first('unit')); ?></span>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="control-label">Vat percent</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Vat percent"
                                   data-container="body"></i>
                                <input type="number" class="form-control" name="vat_percent">
                            </div>
                            <?php if($errors->has('vat_percent')): ?>
                                <span class="text-danger"><?php echo e($errors->first('vat_percent')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Sold amount</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Sold Amount"
                                   data-container="body"></i>
                                <input type="number" class="form-control" name="sold_amount">
                            </div>
                            <?php if($errors->has('sold_amount')): ?>
                                <span class="text-danger"><?php echo e($errors->first('sold_amount')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Is Sold Out</label>
                            <div class="input-icon right">
                                <input type="checkbox" value="IS" name="is_sold_out" class="form-control"></div>
                            <?php if($errors->has('is_sold_out')): ?>
                                <span class="text-danger"><?php echo e($errors->first('is_sold_out')); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Discount</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Discount percent"
                                   data-container="body"></i>
                                <input type="number" class="form-control" name="discount">
                            </div>
                            <?php if($errors->has('discount')): ?>
                                <span class="text-danger"><?php echo e($errors->first('discount')); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label">Select Product Category</label>
                                <div class="input-icon right">
                                    <select class="form-control" name="category_id">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>"><?php echo e($category->name_en); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class="control-label">Select Brand</label>
                                <div class="input-icon right">
                                    <select class="form-control" name="brand_id">
                                        <option value="NULL">Select Brand</option>
                                        <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group  col-lg-6 col-md-6">
                            <label class="control-label">Product featured Image</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="featured image"
                                   data-container="body"></i>
                                <input type="file" class="form-control" onchange="loadFile(event)"
                                       id="image" name="featured_image"></div>
                            <p><img id="output" width="200"/></p>
                            <?php if($errors->has('featured_image')): ?>
                                <span class="text-danger"><?php echo e($errors->first('featured_image')); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- <div class="form-group col-lg-6 col-md-6">
                            <label class="control-label">Cart Limit</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"   data-original-title="featured image" data-container="body"></i>
                                <input type="number" class="form-control" name="cart_limit">
                            </div>
                            <?php if($errors->has('cart_limit')): ?>
                                <span class="text-danger"><?php echo e($errors->first('cart_limit')); ?></span>
                            <?php endif; ?>
                        </div> -->
                    </div>

                    <div class="form-actions right">
                        <button type="button" class="btn default">Cancel</button>
                        <button type="submit" class="btn green">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Portlet PORTLET-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\asiful\Desktop\laravel\bazar\resources\views/admin/products/create.blade.php ENDPATH**/ ?>