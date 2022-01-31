@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Discounts </div>
        <div class="actions">
            <a href="{{ route('discount.create') }}" class="btn btn-default btn-sm">
                <i class="fa fa-plus"></i> Add </a>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable table-responsive">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> # </th>
                        <th>Title</th>
                        <th> Amount</th>
                        <th> Status </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($discounts as $key=>$discount)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $discount->title_en }} </td>
                        <td> {{ $discount->amount }} </td>

                        <td>
                            <a href="{{ route('discount.edit',['id'=>$discount->id]) }}" class="btn btn-xs label label-sm label-success ">Edit</a>
                            <a href="{{ route('discount.delete',['id'=>$discount->id]) }}" class="btn btn-xs label label-sm label-danger " onclick="return confirm('Are your sure to delete this item')">Delete</a>

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
