@extends('layouts.app')

@section('content')

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Wallet Transactions
            </div>
        </div>

        <div class="portlet-body">


            <div class="margin-top-20 note note-info">
                <div class="row">
                    <div class="col-md-4">Supplier Address</div>
                    <div class="col-md-4">User Info</div>
                </div>
            </div>

            {{-- <div class="row">
                <div class="col-md-4">
                    <strong> Ekhoni Dorkar</strong>
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

                    @if(!empty($wallet->user))
                        <address>
                            <strong>Name:</strong>{{$wallet->user->name}}<br>
                            <strong>Phone:</strong>{{$wallet->user->phone}}<br>
                            <strong>Address:</strong>{{$wallet->user->profile?$wallet->user->profile->address:'Profile Not Found'}}<br>
                            <strong>Current Wallet:</strong> <strong>BDT.{{$wallet->balance}}</strong><br>
                        </address>
                    @else
                        <address>
                            User Not Found <br>
                        </address>
                    @endif
                </div>
            </div> --}}


            <div class="table-scrollable">
                <table class="table table-striped table-hover" id="sample_2">
                    <thead>
                    <tr>
                        <th> #</th>
                        <th> Order Id</th>
                        <th> Transaction Amount</th>
                        <th> Created At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($transactionHistory as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                @if(!empty($item->transactionable) && $item->transactionable_type == App\Models\Order::class)
                                    {{$item->transactionable->unique_order_id??"<span class='badge badge-warning'>N/A</span>"}}
                                @else
                                    <span class="badge badge-danger">Not Found</span>
                                @endif
                            </td>
                            <td>{{$item->amount}}</td>
                            <td>{{$item->created_at}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No Transaction found</td>
                        </tr>
                    @endforelse
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

