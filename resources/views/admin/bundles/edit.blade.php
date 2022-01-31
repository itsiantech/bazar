@extends('layouts.app')

@section('content')
    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Bundle Edit</div>
            <div class="actions">
                <a href="{{ route('bundle.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="{{route('bundle.update',['id'=>$bundle->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="messageDiv1">
                    @if(Session::has('success'))
                        @include('layouts.message.success')
                    @elseif(Session::has('error'))
                        @include('layouts.message.error')
                    @endif
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label">Bundle name in English</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips"   data-original-title="Bundle name in English" data-container="body"></i>
                            <input type="text" name="name_en" value="{{ $bundle->name_en }}" class="form-control"> </div>
                        @if ($errors->has('name_en'))
                            <span class="text-danger">{{ $errors->first('name_en') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label">Bundle name in Bangla</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips"   data-original-title="Bundle name in Bangla" data-container="body"></i>
                            <input type="text" name="name_bn" value="{{ $bundle->name_bn }}" class="form-control"> </div>
                        @if ($errors->has('name_bn'))
                            <span class="text-danger">{{ $errors->first('name_bn') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label">Bundle Description in English</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips"   data-original-title="Bundle name in English" data-container="body"></i>
                            <textarea rows="10" class="form-control" name="description_en">{{ $bundle->description_en }}</textarea>
                        </div>
                        @if ($errors->has('description_en'))
                            <span class="text-danger">{{ $errors->first('description_en') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="control-label">Bundle Description in Bangla</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips"   data-original-title="Bundle name in Bangla" data-container="body"></i>
                            <textarea rows="10" class="form-control" name="description_bn">{{ $bundle->description_bn }}</textarea>
                        </div>
                        @if ($errors->has('description_bn'))
                            <span class="text-danger">{{ $errors->first('description_bn') }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Price in english</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"   data-original-title="Vat percent" data-container="body"></i>
                                <input type="number" class="form-control" value="{{ $bundle->price_en }}" name="price_en">
                            </div>
                            @if ($errors->has('price_en'))
                                <span class="text-danger">{{ $errors->first('price_en') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Price in Bangla</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"   data-original-title="Tax percent" data-container="body"></i>
                                <input type="text" value="{{ $bundle->price_bn }}" class="form-control" name="price_bn">
                            </div>
                            @if ($errors->has('price_bn'))
                                <span class="text-danger">{{ $errors->first('price_bn') }}</span>
                            @endif
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Quantity</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"   data-original-title="Vat percent" data-container="body"></i>
                                <input type="number" class="form-control" name="quantity" value="{{ $bundle->quantity }}">
                            </div>
                            @if ($errors->has('quantity'))
                                <span class="text-danger">{{ $errors->first('quantity') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Unit per Quantity</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"   data-original-title="Tax percent" data-container="body"></i>
                                <input type="text" class="form-control" name="unit" value="{{ $bundle->unit }}">
                            </div>
                            @if ($errors->has('unit'))
                                <span class="text-danger">{{ $errors->first('unit') }}</span>
                            @endif
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label class="control-label">Vat percent</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"   data-original-title="Vat percent" data-container="body"></i>
                                <input type="number" value="{{ $bundle->vat_percent }}" class="form-control" name="vat_percent">
                            </div>
                            @if ($errors->has('vat_percent'))
                                <span class="text-danger">{{ $errors->first('vat_percent') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Sold amount</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"   data-original-title="Tax percent" data-container="body"></i>
                                <input type="number" value="{{ $bundle->sold_amount }}" class="form-control" name="sold_amount">
                            </div>
                            @if ($errors->has('sold_amount'))
                                <span class="text-danger">{{ $errors->first('sold_amount') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Is Sold Out</label>
                            <div class="input-icon right">
                                <input type="checkbox" @if($bundle->is_sold_out==1)checked @endif  name="is_sold_out" class="form-control">
                            </div>
                            @if ($errors->has('is_sold_out'))
                                <span class="text-danger">{{ $errors->first('is_sold_out') }}</span>
                            @endif
                        </div>
                        <div class="form-group col-md-3">
                            <label class="control-label">Discount</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"   data-original-title="Discount percent" data-container="body"></i>
                                <input type="number" value="{{ $bundle->discount }}" class="form-control" name="discount">
                            </div>
                            @if ($errors->has('discount'))
                                <span class="text-danger">{{ $errors->first('discount') }}</span>
                            @endif
                        </div>
                    </div>

                        <div class="form-group">
                            <label class="control-label">Bundle featured Image</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips"   data-original-title="featured image" data-container="body"></i>
                                <input type="file"class="form-control" onchange="loadFile(event)"
                                       id="image" name="featured_image"> </div>
                            <p><img src="{{asset($bundle->featured_image)}}" id="output" width="200"/></p>
                            @if ($errors->has('featured_image'))
                                <span class="text-danger">{{ $errors->first('featured_image') }}</span>
                            @endif
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

@endsection
