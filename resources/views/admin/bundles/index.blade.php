@extends('layouts.app')

@section('content')
<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Bundle </div>
        <div class="actions">
            <a href="{{ route('bundle.create') }}" class="btn btn-default btn-sm">
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
                        <th> Image </th>
                        <th> Status </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($bundles as $key=>$bundle)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $bundle->name_en }} </td>
                        <td> {{ $bundle->name_bn }} </td>
                        <td> <img src="{{ asset($bundle->featured_image) }}" width="100" height="100"> </td>
                        <td class="">
                            <a href="{{ route('bundleItem.index',['id'=>$bundle->id]) }}" class="btn btn-xs btn-success ">Add Items</a>

                            <a href="{{ route('bundle.edit',['id'=>$bundle->id]) }}" class="btn btn-xs btn-primary  ">Edit</a>
                            <a href="{{ route('bundle.delete',['id'=>$bundle->id]) }}" class="btn btn-xs btn-danger  " onclick="return confirm('Are your sure to delete this item')">Delete</a>

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
