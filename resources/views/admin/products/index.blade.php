@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Products </div>
        <div class="actions">
            <a href="{{ route('product.create') }}" class="btn btn-default btn-sm">
                <i class="fa fa-plus"></i> Add </a>

        </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Name English </th>
                        <th> Name Bangla </th>
                        <th> slug </th>
                        <th> Featured </th>
                        <th> Status </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $key=>$product)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $product->name_en }} </td>
                        <td> {{ $product->name_bn }} </td>
                        <td> {{ $product->slug }} </td>
                        <td>
                            @if($product->is_featured==0)
                                <a href="{{ route('product.featured',['id'=>$product->id]) }}" class="btn btn-xs btn-default  ">Mark As Featured</a>
                            @else
                                <a href="{{ route('product.featured',['id'=>$product->id]) }}" class="btn btn-xs btn-danger  ">Unmark from Featured</a>
                            @endif

                        </td>

                        <td class="">
                            <a href="{{ route('product_image.index',['id'=>$product->id]) }}" class="btn btn-xs btn-success ">Add images</a>

                            <a href="{{ route('product.edit',['id'=>$product->id]) }}" class="btn btn-xs btn-primary  ">Edit</a>
                            <a href="{{ route('product.delete',['id'=>$product->id]) }}" onclick=" return confirm('Are you sure? Want to delete this product!')" class="btn btn-xs btn-danger  ">Delete</a>

                            <a href="{{route('product.makeBundle', ['product' => $product->id])}}" class="btn btn-xs btn-success" >Bundle Product</a>
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
