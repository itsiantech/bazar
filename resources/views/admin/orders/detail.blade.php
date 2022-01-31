@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Order detail </div>
        <div class="actions">
            <a href="{{ route('product.create') }}" class="btn btn-default btn-sm">
                <i class="fa fa-plus"></i> Add </a>
        </div>
    </div>
    <div class="panel-body">
        <h3>user info</h3>
        <span>user name :{{ $order->user->name }}</span></br>
        <span>user phone :{{ $order->user->phone }}</span></br>

        <h3>Order Info</h3>
        <span>Order Id: {{ $order->unique_order_id }}</span> </br>
        <span>Customer Id: {{ $order->user->customerId }}</span> </br>
        <span>Order status: {{ $order->status }}</span> </br>
        <span>Order payment Method: {{ $order->paymentMethod->name }}</span> </br>
        <span>Order time: {{ date('d  M Y',strtotime($order->created_at)) }}<br>
                            {{ $order->created_at->diffForHumans() }}</span> </br>
        @if(!empty($order->schedule))
            <span>Scheduled Time: {{$order->schedule}}</span>
        @endif

    </div>
    <div class="portlet-body">
        <div class="table-scrollable">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> product id </th>
                        <th> product name </th>
                        <th> product price </th>
                        <th> VAT(amount)</th>



                    </tr>
                </thead>
                <tbody>

                @foreach($order->orderItems as $key=>$product)

                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $product->product_id }} </td>
                        <td> {{ $product->product->name_en }} </td>
                        <td> {{ $product->product->price_en }} </td>
                        <td> {{ $product->product->vat_percent }}% <span style="font-size: 10px">({{ \App\Models\Order::GetPercentInValue($product->product->price_en,$product->product->tax_percent) }} tk)</span> </td>

                    </tr>
                @endforeach
                <form action="{{ route('order.discount',['id'=>$order->id]) }}" method="POST">
                    @csrf
                    <tr>

                        <td></td>
                        <td></td>

                        <td>Add Discount</td>
                        <td>

                            <select class="form-control" name="discount_id">
                                <option value="NULL">Select Discount( Remove )</option>
                                @foreach($discounts as $discount)
                                    <option value="{{ $discount->id }}">{{ $discount->title_en }} ( {{ $discount->amount   }}{{($discount->is_percent==1?' %':" Taka")}})</option>
                                @endforeach
                            </select>
                        </td>
                        <td><button type="submit" class="btn btn-sm btn-success">Apply</button></td>

                    </tr>
                </form>
                </tbody>
            </table>
        </div>
        <span class="pull-right"> Total Price :{{$total['itemTotal'] }}</span><br>
        <span class="pull-right"> discount value :{{$total['discount'] }}</span><br>
        <span class="pull-right"> coupon value :{{$total['coupon'] }}</span><br>
        <span class="pull-right"> total deducted :{{$total['deduction'] }}</span><br>
        <span class="pull-right"> Payble Total :{{$total['netTotal'] }}</span>

    </div>
</div>
<!-- END Portlet PORTLET-->

@endsection
