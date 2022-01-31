@extends('layouts.app')

@section('content')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-red-sunglo">
                <i class="icon-drop font-red-sunglo"></i>
                <span class="caption-subject bold uppercase"> Add Items in the bundle</span>
            </div>

        </div>
        <div class="portlet-body form">
            <form role="form" action="{{route('bundleItem.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="messageDiv">
                    @if(Session::has('success'))
                        @include('layouts.message.success')
                    @elseif(Session::has('error'))
                        @include('layouts.message.error')
                    @endif
                </div>
                <div class="form-body">
                    <div class="form-group">
                        <label for="single" class="control-label">Select Product</label>
                        <select id="single" class="form-control select2" name="product_id" tabindex="-1" aria-hidden="true" required>
                            <option>Select Product</option>
                            @foreach($products  as $product)
                                <option value="{{$product->id}}" >{{ $product->name_en }}</option>
                            @endforeach


                        </select>




                    </div>


                    <div class="form-group">
                        <label class="control-label">Original Price</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="original price"
                               data-container="body"></i>
                            <input type="number" name="original_price" class="form-control"></div>
                        @if ($errors->has('original_price'))
                            <span class="text-danger">{{ $errors->first('original_price') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="control-label">Bundle Price</label>
                        <div class="input-icon right">
                            <i class="fa fa-info-circle tooltips" data-original-title="bundle price"
                               data-container="body"></i>
                            <input type="number" name="bundle_price" class="form-control"></div>
                        @if ($errors->has('bundle_price'))
                            <span class="text-danger">{{ $errors->first('bundle_price') }}</span>
                        @endif
                    </div>
                    <input type="hidden" value="{{ $_GET['id'] }}" name="bundle_id">

                    <div class="form-actions left">
                        <button type="button" class="btn default">Cancel</button>
                        <button type="submit" class="btn green">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Bundle Items</div>

        <div class="tools"> </div>
    </div>


    <div class="portlet-body">
        <div class="table-scrollable table-responsive">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Product Name</th>
                        <th> Original Price </th>
                        <th> Bundle Price </th>
                        <th>Action </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($bundle_items as $key=>$bundle_item)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $bundle_item->name_en }} </td>
                        <td> {{ $bundle_item->original_price }} </td>
                        <td> {{ $bundle_item->bundle_price }} </td>

                        <td>
                            <a href="{{ route('bundleItem.delete',['id'=>$bundle_item->id]) }}" onclick="return confirm('Are your sure to delete this item')" class="btn btn-xs label label-sm label-success ">Remove</a>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- END Portlet PORTLET-->

@endsection


@push('stylesheets')
    @include('layouts.asset.datatable-css-header')
    <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

@endpush

@push('scripts')
    @include('layouts.asset.js.datatable')
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/app.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>


@endpush
