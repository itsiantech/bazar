@extends('layouts.app')

@section('content')
{{--    <div class="portlet light bordered">--}}
{{--        <div class="portlet-title">--}}
{{--            <div class="caption font-red-sunglo">--}}
{{--                <i class="icon-drop font-red-sunglo"></i>--}}
{{--                <span class="caption-subject bold uppercase"> Refund</span>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--        <div class="portlet-body form">--}}
{{--            <form role="form" action="{{route('refund.store')}}" method="post" enctype="multipart/form-data">--}}
{{--                @csrf--}}
{{--                <div id="messageDiv">--}}
{{--                    @if(Session::has('success'))--}}
{{--                        @include('layouts.message.success')--}}
{{--                    @elseif(Session::has('error'))--}}
{{--                        @include('layouts.message.error')--}}
{{--                    @endif--}}
{{--                </div>--}}
{{--                <div class="form-body">--}}

{{--                    <div class="form-group">--}}
{{--                        <label class="control-label">Order ID(ex : AUG252069)</label>--}}
{{--                        <div class="input-icon right">--}}
{{--                            <i class="fa fa-info-circle tooltips" data-original-title="order id"--}}
{{--                               data-container="body"></i>--}}
{{--                            <input type="text" name="order_id" class="form-control"></div>--}}
{{--                        @if ($errors->has('order_id'))--}}
{{--                            <span class="text-danger">{{ $errors->first('order_id') }}</span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    <div class="form-group">--}}
{{--                        <label class="control-label">Refund Price</label>--}}
{{--                        <div class="input-icon right">--}}
{{--                            <i class="fa fa-info-circle tooltips" data-original-title="amount "--}}
{{--                               data-container="body"></i>--}}
{{--                            <input type="number" name="amount" class="form-control"></div>--}}
{{--                        @if ($errors->has('amount'))--}}
{{--                            <span class="text-danger">{{ $errors->first('amount') }}</span>--}}
{{--                        @endif--}}
{{--                    </div>--}}

{{--                    <div class="form-actions left">--}}
{{--                        <button type="button" class="btn default">Cancel</button>--}}
{{--                        <button type="submit" class="btn green">Submit</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Refunds</div>

        <div class="tools"> </div>
    </div>


    <div class="portlet-body">

        <div id="messageDiv">
            @if(Session::has('success'))
                @include('layouts.message.success')
            @elseif(Session::has('error'))
                @include('layouts.message.error')
            @endif
        </div>

        <div class="table-scrollable table-responsive">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th class="text-center"> # </th>
                        <th class="text-center"> Order Id</th>
                        <th class="text-center"> User name </th>
                        <th class="text-center"> Order Amount </th>
                        <th class="text-center"> Refunded Amount </th>
                        <th class="text-center"> Withdrew Amount </th>
                        <th class="text-center"> Status </th>
                        <th class="text-center"> Time </th>
                        <th class="text-center">Action </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($refunds as $key=>$refund)
                    <tr>
                        <td class="text-center"> {{ ++$key }} </td>
                        <td class="text-center"> {{ $refund->unique_order_id }} </td>
                        <td class="text-center"> {{ $refund->name }} </td>
                        <td class="text-center"> {{ $refund->amount }} </td>
                        <td class="text-center"> {{ $refund->refunded_amount }} </td>
                        <td class="text-center"> {{ $refund->withdraw }} </td>
                        <td class="text-center"> {{ ucfirst($refund->status) }} </td>
                        <td class="text-center"> {{ date('d  M Y',strtotime($refund->created_at)) }}<br>
                             </td>

                        <td class="text-center">

                            @if($refund->status=='done' || $refund->status=='refunded')
                                <a href="{{ route('refund.changeStatus',['id'=>$refund->id,'status'=>'accepted']) }}" class="btn btn-xs label label-sm label-default ">Refunded</a>

                            @else
                                <a onclick="return confirm('Are your sure to delete this item')" href="{{ route('refund.delete',['id'=>$refund->id]) }}" class="btn btn-xs label label-sm label-danger ">Remove</a>
                                <a href="{{ route('refund.changeStatus',['id'=>$refund->id,'status'=>'refunded']) }}" class="btn btn-xs label label-sm label-success ">Mark As Refunded</a>
                            @endif

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
    <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

@endpush

@push('scripts')
    @include('layouts.asset.js.datatable')
    <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>


@endpush
