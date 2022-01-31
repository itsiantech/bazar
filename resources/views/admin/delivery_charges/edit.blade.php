@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green-seagreen">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Coupon </div>
        <div class="actions">
            <a href="{{ route('deliveryCharge.index') }}" class="btn btn-default btn-sm">
                <i class="fa fa-list"></i> List </a>
        </div>
    </div>
    <div class="portlet-body">
        <form role="form" action="{{route('deliveryCharge.update',['id'=>$deliveryCharge->id])}}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="messageDiv">
                @if(Session::has('success'))
                    @include('layouts.message.success')
                @elseif(Session::has('error'))
                    @include('layouts.message.error')
                @endif
            </div>
            <div class="form-body">
                <div class="form-group">
                    <label class="control-label">Charge Amount</label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="charge amount"
                           data-container="body"></i>
                        <input type="number" name="charge_amount" value="{{ $deliveryCharge->charge_amount }}" class="form-control"></div>
                    @if ($errors->has('charge_amount'))
                        <span class="text-danger">{{ $errors->first('charge_amount') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="control-label">Minimum Amount</label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="minimum amount"
                           data-container="body"></i>
                        <input type="number" name="minimum_amount" value="{{ $deliveryCharge->minimum_amount }}" class="form-control"></div>
                    @if ($errors->has('minimum_amount'))
                        <span class="text-danger">{{ $errors->first('minimum_amount') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label class="control-label">Maximum Amount</label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="maximum amount"
                           data-container="body"></i>
                        <input type="number" name="maximum_amount" value="{{ $deliveryCharge->maximum_amount }}" class="form-control"></div>
                    @if ($errors->has('maximum_amount'))
                        <span class="text-danger">{{ $errors->first('maximum_amount') }}</span>
                    @endif
                </div>
                <div class="form-actions right">
                    <button type="button" class="btn default">Cancel</button>
                    <button type="submit" class="btn green">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- END Portlet PORTLET-->
                         
@endsection