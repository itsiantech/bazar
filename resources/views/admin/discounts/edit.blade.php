@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green-seagreen">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Coupon </div>
        <div class="actions">
            <a href="{{ route('discount.index') }}" class="btn btn-default btn-sm">
                <i class="fa fa-list"></i> List </a>
        </div>
    </div>
    <div class="portlet-body">
        <form role="form" action="{{route('discount.update',['id'=>$discount->id])}}" method="post" enctype="multipart/form-data">
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
                    <label class="control-label">Title </label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="title"
                           data-container="body"></i>
                        <input type="text" name="title_en"  value="{{ $discount->title_en }}" class="form-control"></div>
                    @if ($errors->has('title_en'))
                        <span class="text-danger">{{ $errors->first('title_en') }}</span>
                    @endif
                </div>


                <div class="form-group">
                    <label class="control-label">Amount</label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="Amount"
                           data-container="body"></i>
                        <input type="number" name="amount" value="{{ $discount->amount }}" class="form-control"></div>
                    @if ($errors->has('amount'))
                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                    @endif
                </div>


                <div class="form-group">

                    <div class="input-icon right">

                        <input type="checkbox" name="is_percent" @if($discount->is_percent==1)checked @endif class="icheck"> Is percent</div>
                    @if ($errors->has('is_percent'))
                        <span class="text-danger">{{ $errors->first('is_percent') }}</span>
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