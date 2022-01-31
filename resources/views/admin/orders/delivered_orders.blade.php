@extends("layouts.partials.order.index")


@section("table-date-range-filter")
    @include("layouts.partials.table-date-range-filter", ['operation' => isset($operation)?$operation:'getOrdersByDateRange'])
@endsection

@section("table")
    <table class="table table-striped table-hover" id="sample_2">
        <thead>
        <tr>
            <th> #</th>
            <th> Order ID</th>
            <th> Ordered By</th>
            <th class="text-center"> Total Price</th>
            <th> Order time</th>
            <th> Payment Method</th>
            <th> Status</th>
            <th>Change Status</th>
            <th>View Detail</th>
        </tr>
        </thead>
        <tbody>
        @include('admin.orders.order_table')
        </tbody>
    </table>
@endsection
