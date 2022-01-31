@extends('layouts.app')

@section('content')
    @include("layouts.message.errors_all")

    <div class="portlet solid margin-top-20 margin-bottom-20">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Invoice
            </div>
        </div>
        <div class="portlet-body">
         <img width="100" src="{{ asset('assets/layouts/layout/img/ed.png') }}" alt="">

            <div class="margin-top-20 note note-info">
                <div class="row">
                    <div class="col-md-4">Supplier Address</div>
                    <div class="col-md-4">Delivery Address</div>
                    <div class="col-md-4">Invoice</div>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-4">
                    <strong>  Ekhoni Dorkar</strong>
                    <address>
                        House: 1148, Road: Josim Uddin Ave,<br>
                        Badsherteck, Turag,<br>
                        Dhaka-1230<br>

                    </address>
                    <address>
                        <strong>Phone</strong> +01724666301 <br>
                        <strong>Email</strong> support@bangoshop.com
                    </address>
                </div>
                <div class="col-md-4">
                    @if(isset($order->address))

                    <address>
                        {{ (isset($order->address)?$order->address->receiver_name:'') }}<br>
                         {{ (isset($order->address)?$order->address->receiver_phone:'') }}<br>
                        {{ (isset($order->address)?$order->address->address:'') }}<br>


                    </address>
                    @else
                    <address>
                        <strong>{{$order->user->name}}</strong>
                        <strong>Phone</strong> {{ $order->user->phone }} <br>
                        <strong>Email</strong> {{ $order->user->email }}
                    </address>
                    @endif
                </div>
                <div class="col-md-4">
                    <p class="margin-bottom-10"><strong>Order ID</strong> #{{ $order->unique_order_id }}</p>
                    <p class="margin-bottom-10"><strong>Customer ID</strong> #{{ $order->user->customerId }}</p>
                    <p class="margin-bottom-10"><strong> Order
                            Date </strong> {{ date('d  M Y',strtotime($order->created_at)) }}</p>
                    <p class="margin-bottom-10"><strong>Payment</strong> Paid</p>

                </div>
            </div> --}}
            <div class="row">
                <div class="col-md-12">
                    <div id="messageDiv1">
                        @if(Session::has('success'))
                            @include('layouts.message.success')
                        @elseif(Session::has('error'))
                            @include('layouts.message.error')
                        @endif
                    </div>
                    <div class="table-scrollable">
                        <table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> Product Name</th>

                                <th class="text-center"> Unit</th>
                                <th class="text-center"> Quantity</th>
                                <th class="text-center"> Price/Unit</th>
                                <th class="text-center"> VAT</th>
                                <th class="text-center"> Price <span style="font-size: 10px">
                                            ( including VAT)</span></th>
                                <th style="width: 200px"> Action </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderItems as $key=>$item)

                                <tr>
                                    <td> {{ ++$key }} </td>

                                    <td> {{ $item->product->name_en }} </td>

                                    <td class="text-center"> {{ $item->product->quantity }} {{ $item->product->unit }}</td>
                                    <td class="text-center"> {{ $item->quantity }} </td>
                                    <td class="text-center"> {{ $item->price}}</td>
                                    <td class="text-center"> {{ $item->product->vat_percent }}% <span style="font-size: 10px">
                                            ({{ \App\Models\Order::GetPercentInValue($item->price,$item->product->vat_percent) }} tk)</span>
                                    </td>

                                    <td class="text-center">
                                        {{($item->price*$item->quantity)+\App\Models\Order::GetPercentInValue($item->price*$item->quantity,$item->product->vat_percent)}}
                                    </td>

                                    <td style="display: inline-block !important;">

                                        <form role="form" action="{{route('refund.store')}}" method="post">

                                            <a href="{{ route('order.removeItem',[
                                        'id'=>$item->id,
                                        'order_id'=>$item->order_id,
                                        'product_id'=>$item->product_id,

                                        ]) }}" class="btn btn-xs btn-danger" onclick="return confirm('Confirm to remove this item')"> Remove </a>
                                            @csrf
                                            <input type="hidden" name="unique_order_id" value="{{$order->unique_order_id}}">
                                            <input type="hidden" name="order_item_id" value="{{$item->id}}">
                                            <input onclick="return confirm('Confirm to refund this item')" type="submit" value="Refund" class="btn btn-primary btn-xs">
                                        </form>
                                    </td>


                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4"></td>
                            </tr>
                            <form action="{{ route('order.addItem',['id'=>$order->id]) }}" method="POST">
                                @csrf

                                <td colspan="3">
                                    <div class="form-group">
                                        <select id="products" class="form-control" name="product_id" tabindex="-1" aria-hidden="true" required>
                                            <option>Select Product</option>

                                        @foreach($products  as $product)
                                                <option value="{{$product->id}}" >{{ $product->name_en }} {{ $product->quantity }} {{ $product->unit }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">

                                         <input type="text" name="quantity" class="form-control" required placeholder="quantity">
                                        <input type="hidden" value="{{ $order->id }}" name="order_id">

                                    </div>
                                </td>

                                <td>

                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                </td>
                            </form>
                            <tr>
                                <td colspan="3"></td>
                                <form action="{{ route('order.discount',['id'=>$order->id]) }}" method="POST">
                                    @csrf

                                    <td>

                                        <select class="form-control" name="discount_id">
                                            <option value="NULL">Select Discount( Remove )</option>
                                            @foreach($discounts as $discount)
                                                <option value="{{ $discount->id }}">{{ $discount->title_en }}
                                                    ( {{ $discount->amount   }}{{($discount->is_percent==1?' %':" Taka")}}
                                                    )
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-sm btn-success">Apply</button>
                                    </td>
                                </form>
                            </tr>

                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Total</strong></td>
                                <td><strong>{{ $total['itemTotal'] }}</strong></td>
                            </tr>
                            @if($total['deliveryCharge']>0)
                                <tr>
                                    <td colspan="3"></td>
                                    <td><strong>Delivery Charge</strong></td>
                                    <td><strong>{{ $total['deliveryCharge'] }}</strong></td>
                                </tr>
                            @endif
                            @if($total['discount']>0)
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Discount</strong></td>
                                <td><strong>{{ $total['discount'] }}</strong></td>
                            </tr>
                            @endif
                            @if($total['coupon']>0)
                                <tr>
                                    <td colspan="3"></td>
                                    <td><strong>Coupon</strong></td>
                                    <td><strong>{{ $total['coupon'] }}</strong></td>
                                </tr>
                            @endif

                            @if($total['totalSaved']>0)
                                <tr>
                                    <td colspan="3"></td>
                                    <td><strong>Total Saved</strong></td>
                                    <td><strong>{{ $total['totalSaved'] }}</strong></td>
                                </tr>
                            @endif

                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Grand Total</strong></td>
                                <td><strong>{{ $total['netTotal'] }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Total Paid</strong></td>
                                <td><strong>{{ $order->wallet_reduction }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td><strong>Payable Amount</strong></td>
                                <td><strong>{{ $total['netTotal'] - $order->wallet_reduction }}</strong></td>
                            </tr>
                            </tbody>
                        </table>
                        <a href="{{ route('order.invoice',['id'=>$order->id]) }}" class="btn btn-lg blue hidden-print margin-bottom-5"> Print
                            <i class="fa fa-print"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('stylesheets')
    @include('layouts.asset.datatable-css-header')
    {{ asset('assets/pages/css/invoice.min.css') }}
    <link href="{{asset("assets/global/plugins/select2/css/select2.min.css")}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset("assets/global/plugins/select2/css/select2-bootstrap.min.css")}}" rel="stylesheet" type="text/css"/>

@endpush

@push('scripts')
    <script src="{{asset("assets/global/plugins/select2/js/select2.full.min.js")}}" type="text/javascript"></script>
    <script src="{{asset("assets/pages/scripts/components-select2.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('#products').select2();
        });
    </script>


@endpush
