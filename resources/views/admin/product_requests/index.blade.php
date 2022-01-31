@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Product Requests </div>

        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable table-responsive">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Product title </th>
                        <th> Quantity </th>
                        <th> Customer phone </th>
                        <th> Customer Address </th>
                        <th> Description </th>
                        <th> Date </th>
                        <th> Action </th>

                    </tr>
                </thead>
                <tbody>
                @foreach($productRequests as $key=>$productRequest)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $productRequest->title }} </td>
                        <td> {{ $productRequest->quantity }} </td>
                        <td> {{ $productRequest->phone }} </td>
                        <td> {{ $productRequest->address }} </td>
                        <td> {{ $productRequest->description }} </td>
                        <td>{{ date('d  M Y',strtotime($productRequest->created_at)) }}<br>
                            {{ $productRequest->created_at->diffForHumans() }} </td>
                        <td>
                            <a href="{{ route('product_request.delete',['id'=>$productRequest->id]) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are your sure to delete this item')"><i class="fa fa-trash"></i> Delete</a>
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
