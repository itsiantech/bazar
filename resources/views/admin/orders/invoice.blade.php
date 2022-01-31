@extends('layouts.invoice')

@section('content')
    <div class="invoice">
        <div class="row  invoice-logo">
            <div class=" col-xs-4">
            </div>
            <div class=" col-xs-4 invoice-logo-space">
                <img src="{{ asset('assets/layouts/layout/img/logo.min.en.png') }}" class="pull-center img-responsive"
                     alt=""/>
            </div>
            <div class=" col-xs-4">
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-xs-4">
                <h3>Delivery Address</h3>
                {{--            <ul class="list-unstyled">--}}
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
            {{--            </ul>--}}

            <div class="col-xs-4">


            </div>
            <div class="col-xs-4 invoice-payment">
                <h3>Order Details:</h3>

                <ul class="list-unstyled">

                    <li><strong>Order ID :</strong> {{ $order->unique_order_id }} </li>
                    <li><strong>Customer ID :</strong> {{ $order->user->customerId }} </li>
                    <li><strong>Order Date:</strong> {{ date('d  M Y',strtotime($order->created_at)) }} </li>
                    @if(!empty($order->schedule))
                        <li><strong>Scheduled Time:</strong> {{$order->schedule}} </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="text-center"> #</th>
                        <th class="text-center"> Product Name</th>
                        <th class="text-center"> Unite</th>
                        <th class="text-center"> Quantity</th>
                        <th class="text-center"> Price/Unit</th>
                        <th class="text-center"> VAT</th>
                        <th class="text-center"> Price <span style="font-size: 10px">
                                            ( including VAT)</span></th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->orderItems as $key=>$item)

                        <tr>
                            <td class="text-center"> {{ ++$key }} </td>

                            <td class="text-center"> {{ $item->product->name_en }} </td>
                            <td class="text-center"> {{ $item->product->quantity }} {{ $item->product->unit }}</td>
                            <td class="text-center"> {{ $item->quantity }} </td>
                            <td class="text-center"> {{ $item->price}}</td>
                            <td class="text-center"> {{ $item->product->vat_percent }}% <span style="font-size: 10px">
                                            ({{ \App\Models\Order::GetPercentInValue($item->price,$item->product->vat_percent) }} tk)</span>
                            </td>
                            <td class="text-center"> {{ ($item->price*$item->quantity)+\App\Models\Order::GetPercentInValue($item->price,$item->product->vat_percent) }} </td>


                            {{--                                <td> {{ $product->product->vat_percent }}% <span style="font-size: 10px">({{ \App\Models\Order::GetPercentInValue($product->product->price,$product->product->tax_percent) }} tk)</span> </td>--}}

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-xs-4">
                <div class="">
                    <h3> Ekhoni Dorkar</h3>

                    <address>
                        House: 1148, Road: Josim Uddin Ave,<br>
                        Badsherteck, Turag,
                        Dhaka-1230<br>
                        <strong>Phone</strong> +01724666301<br>
                        <strong>Email:</strong>support@bangoshop.com
                    </address>
                </div>
            </div>
            <div class="col-xs-8 invoice-block">
                <ul class="list-unstyled amounts">

                    <li>
                        <strong>Sub - Total amount:</strong> {{ $total['itemTotal']  }} </li>
                    <li><strong>Delivery Charge:</strong> {{ $total['deliveryCharge'] }} </li>
                    @if($total['discount']>0)
                        <li><strong>Discount:</strong> {{ $total['discount'] }} </li>
                    @endif
                    @if($total['coupon']>0)
                        <li><strong>Discount:</strong> {{ $total['coupon'] }} </li>
                    @endif
                    @if($total['totalSaved']>0)
                        <li><strong>Total Saved:</strong> {{ $total['totalSaved'] }} </li>
                    @endif
                    <li><strong>Grand Total:</strong> {{$total['netTotal']}} </li>
                    <li><strong>Total Paid:</strong> {{$order->wallet_reduction}} </li>
                    <li><strong>Payable Amount:</strong> {{$total['netTotal'] - $order->wallet_reduction}} </li>
                </ul>
                <br/>
                <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> Print
                    <i class="fa fa-print"></i>
                </a>
                <a class="btn btn-lg green hidden-print margin-bottom-5"> Submit Your Invoice
                    <i class="fa fa-check"></i>
                </a>
            </div>
        </div> --}}
        <div class="text-center">
            <span style="font-size: 10px">**This is System Generated invoice email. For any query please send us email or call us !</span>

        </div>
    </div>


@endsection
