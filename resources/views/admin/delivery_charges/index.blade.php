@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Delivery charges </div>
        <div class="actions">
            <a href="{{ route('deliveryCharge.create') }}" class="btn btn-default btn-sm">
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
                        <th>Charge amount </th>
                        <th>Minimum amount </th>
                        <th>Maximum amount </th>
                        <th>Action </th>

                    </tr>
                </thead>
                <tbody>
                @foreach($delivery_charges as $key=>$delivery_charge)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $delivery_charge->charge_amount }} </td>
                        <td> {{ $delivery_charge->minimum_amount }} </td>
                        <td> {{ $delivery_charge->maximum_amount }} </td>

                        <td>
                            <a href="{{ route('deliveryCharge.edit',['id'=>$delivery_charge->id]) }}" class="btn btn-xs label label-sm label-success ">Edit</a>
                            <a href="{{ route('deliveryCharge.delete',['id'=>$delivery_charge->id]) }}" class="btn btn-xs label label-sm label-danger " onclick="return confirm('Are your sure to delete this item')">Delete</a>

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
