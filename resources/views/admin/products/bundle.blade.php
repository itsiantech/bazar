@extends('layouts.app')

@push("stylesheets")
    <link href="{{asset("assets/global/plugins/select2/css/select2.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("assets/global/plugins/select2/css/select2-bootstrap.min.css")}}" rel="stylesheet" type="text/css"/>
@endpush

@push("scripts")
    <script src="{{asset("assets/global/plugins/select2/js/select2.full.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/pages/scripts/components-select2.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('#products').select2();
        });

        function submitBundleUpdateForm(id)
        {
            $('#bundle-form-'+id).submit();
        }


    </script>
@endpush


@section('content')
    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Add Bundle Product
            </div>
            <div class="actions">
                <a href="{{ route('product.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-6">
                    <form role="form" action="{{route('product.syncBundle', ['product' => $product->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div id="messageDiv1">
                            @if(Session::has('success'))
                                @include('layouts.message.success')
                            @elseif(Session::has('error'))
                                @include('layouts.message.error')
                            @endif
                        </div>
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Select Product</label>
                                        <select class="form-control" name="product_id[]" id="products" multiple="multiple">
                                            @foreach($products as $pd)
                                                <option {{in_array($pd->id, $bundleProductsId)?'selected=selected':''}} value="{{ $pd->id }}">{{ $pd->name_en }}</option>
                                            @endforeach
                                        </select>
                                        {!! $errors->first('product_id')?'<span class="text-danger">'.$errors->first('product_id').'</span>':'' !!}
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="discount" class="control-label">Discount</label>
                                    <input id="discount" name="discount" class="form-control" type="number" step="0.01" value="{{!empty($product->bundle)?$product->bundle->discount:''}}" placeholder="Give bundle discount">
                                    {!! $errors->first('discount')?'<span class="text-danger">'.$errors->first('discount').'</span>':'' !!}
                                </div>
                                <div class="col-md-12">
                                    <label class="mt-checkbox">
                                        <input type="hidden" value="0" name="is_percent">
                                        <input type="checkbox" value="1" name="is_percent" {{!empty($product->bundle) && $product->bundle->is_percent == 1?'checked':''}}>
                                        Percentage<span></span>
                                    </label>
                                    {!! $errors->first('is_percent')?'<span class="text-danger">'.$errors->first('is_percent').'</span>':'' !!}
                                </div>

                            </div>

                            <div class="form-actions right">
                                <button type="button" class="btn default">Cancel</button>
                                <input type="submit" value="Submit" class="btn green">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-md-6">
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th>Total</th>
                                <td>{{$total['price']}} BDT.</td>
                            </tr>
                            <tr>
                                <th>Discounted</th>
                                <td>{{$total['saved']}} BDT.</td>
                            </tr>
                            <tr>
                                <th>Grand Total</th>
                                <td>{{$total['grandTotal']}} BDT.</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- END Portlet PORTLET-->



    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Bundle Products
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable">
                <table class="table table-striped table-hover" id="sample_2">
                    <thead>
                    <tr>
                        <th> #</th>
                        <th> Product Name (BN)</th>
                        <th> Product Name (EN)</th>
                        <th> Price </th>
                        <th> Quantity </th>
                        <th> Description</th>
                        <th> Photo</th>
                        <th> Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($bundles as $item)
                        <tr>
                            <td> {{$loop->iteration}} </td>
                            <td> {{ $item->name_bn }} </td>
                            <td> {{ $item->name_en }} </td>
                            <td> {{ $item->price_en }} </td>
                            <td>
                            <form method="post" id="bundle-form-{{$item->bundle_id}}" action="{{route('bundle.update', ['bundle' => $item->bundle_id])}}">
                                @csrf
                                @method('patch')
                                    <div class="form-group">
                                        <input type="number" name="quantity" required="" class="form-control" value="{{$item->quantity}}" style="width: 80px">
                                    </div>
                            </form>
                            </td>
                            <td> {{ $item->description_en }} </td>
                            <td><img style="width: 200px" src="{{asset($item->featured_image)}}" alt=""></td>
                            <td>
                                <button onclick="submitBundleUpdateForm({{$item->bundle_id}})" class="btn btn-success">Update</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Bundle Found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Portlet PORTLET-->

@endsection
