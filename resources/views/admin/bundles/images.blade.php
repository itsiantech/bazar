@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Product Images </div>

    </div>

    <div class="portlet-body">
        <form role="form" action="{{route('product_image.store',['product_id'=>$productImages->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="messageDiv">
                @if(Session::has('success'))
                    @include('layouts.message.success')
                @elseif(Session::has('error'))
                    @include('layouts.message.error')
                @endif
            </div>
            <div class="form-body">

                <div class="row">
                    <div class="col-lg-2 col-md-2 ">
                        <label class="control-label">Select Image</label>
                    </div>
                    <div class="col-lg-6 col-md-6 ">
                        <div class="input-icon">
                            <i class="fa fa-info-circle tooltips" data-original-title="Category name in Bangla"
                               data-container="body"></i>
                            <input type="file" class="form-control" onchange="loadFile(event)"
                                   id="logo" name="image">
{{--                            <input type="hidden" name="product_id" value="{{$productImages->id}}">--}}
                        </div>
                        <p><img id="output" width="200"/></p>
                        @if ($errors->has('logo'))
                            <span class="text-danger">{{ $errors->first('logo') }}</span>
                        @endif
                    </div>

                    <div class=" col-lg-3 col-md-3 form-actions">
                        <button type="button" class="btn default">Cancel</button>
                        <button type="submit" class="btn green">Submit</button>
                    </div>
                </div>

            </div>
        </form>
        <div class="table-scrollable">

            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> sln </th>
                        <th> Image </th>
                        <th> Name Bangla </th>
                        <th> Status </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($productImages->productImages as $key=>$productImage)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> <img src="{{ asset($productImage->image) }}" width="250" height="250"> </td>


                        <td>

                            <a href="{{ route('product_image.delete',['id'=>$productImage->id]) }}" class="btn btn-xs label label-sm label-danger ">Delete</a>

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
@endpush

@push('scripts')
    @include('layouts.asset.js.datatable')

@endpush