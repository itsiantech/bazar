@extends('layouts.app')

@section('content')

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Orders </div>
            <div class="actions">
                <a href="{{ route('product.create') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-plus"></i> Add </a>
            </div>
        </div>

        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12" style="margin-bottom: 10px">
                    <a href="{{ route('order.index',['state'=>'new']) }}" class="btn btn-sm btn-success">New Orders</a>
                    <a href="{{ route('order.index',['state'=>'today']) }}" class="btn btn-sm btn-success">Orders today</a>
                    <a href="{{ route('order.index',['state'=>'delivered']) }}" class="btn btn-sm btn-success">Delivered Orders</a>
                    <a href="{{ route('order.index',['state'=>'undelivered']) }}" class="btn btn-sm btn-success">Undelivered Orders</a>
                    <a href="{{ route('order.index',['state'=>'all']) }}" class="btn btn-sm btn-success">All Orders</a>
                    <a href="{{ route('order.ExportDailyOrders',['state'=>'all']) }}" class="btn btn-sm btn-success">Export Orders</a>
                    <a href="{{ route('sslIpnResposne') }}" class="btn btn-sm btn-success">SSL Response</a>
                </div>

                <div class="col-md-6">
                    <select class="form-control" id="state">
                        <option>Select one</option>
                        <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                        <option value="canceled">Canceled</option>
                        <option value="on_delivery">On Way</option>
                        <option value="delivered">Delivered</option>
                    </select>
                </div>
                @yield("table-date-range-filter")
                <div class="col-md-12">
                    <div class="table-scrollable">
                        @yield("table")
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Portlet PORTLET-->

@endsection
@push('stylesheets')
    @include('layouts.asset.datatable-css-header')
    @include("layouts.asset.css.dateTimePicker")
@endpush

@push('scripts')
    @include('layouts.asset.js.datatable')
    @include("layouts.asset.js.dateTimePicker")
    <script>
        $("#state").change(function()
        {
            var state = $(this).val()
            window.location = '{{route('order.index')}}'+'?state='+state;
        });
    </script>
@endpush

