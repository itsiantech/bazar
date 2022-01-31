@extends('layouts.app')

@section('content')

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Wallets
            </div>
        </div>

        <div class="portlet-body">

            <div class="table-scrollable">
                <table class="table table-striped table-hover" id="sample_2">
                    <thead>
                    <tr>
                        <th> #</th>
                        <th> Wallet Id</th>
                        <th> User Name</th>
                        <th> Balance</th>
                        <th> Status</th>
                        <th> Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($wallets as $wallet)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$wallet->walletId??'N/A'}}</td>
                            <td>{{!empty($wallet->user)?$wallet->user->name:"User Not Found"}}</td>
                            <td>{{$wallet->balance}}</td>
                            <td>{{$wallet->is_active == 1?'active':'disabled'}}</td>
                            <td>
                                <a href="{{route('wallet.show', ['wallet' => $wallet->id])}}" class="btn btn-xs btn-info">History</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No Wallet found</td>
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
    <script>
        $("#state").change(function () {
            //this is the #state dom element
            var state = $(this).val()
            // window.location = 'http://localhost:81/ed/public/private-panel/orders/index?state='+state;
            window.location = '{{route('order.index')}}' + '?state=' + state;
            {{--var state = $(this).val();--}}

            {{--// parameter 1 : url--}}
            {{--// parameter 2: post data--}}
            {{--//parameter 3: callback function--}}
            {{--$.get( '{{route('order.status')}}' , { state : state } , function(htmlCode){ //htmlCode is the code retured from your controller--}}
            {{--    $("#table tbody").html(htmlCode);--}}
            {{--});--}}
        });
    </script>
@endpush

