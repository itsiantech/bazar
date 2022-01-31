@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i>Deleted Products </div>
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

                        <th> Status </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($products as $key=>$product)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $product->name_en }} </td>
                        <td> {{ $product->name_bn }} </td>


                        <td class="">

                            <a href="{{ route('product.restore',['id'=>$product->id]) }}" class="btn btn-xs btn-primary  ">Restore</a>

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