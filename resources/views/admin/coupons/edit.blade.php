@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green-seagreen">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Coupon </div>
        <div class="actions">
            <a href="{{ route('coupon.index') }}" class="btn btn-default btn-sm">
                <i class="fa fa-list"></i> List </a>
        </div>
    </div>
    <div class="portlet-body">
        <form role="form" action="{{route('coupon.update',['id'=>$coupon->id])}}" method="post" enctype="multipart/form-data">
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
                    <label class="control-label">Coupon Name</label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="Category name in English"
                           data-container="body"></i>
                        <input type="text" name="name" value="{{ $coupon->name }}" class="form-control"></div>
                    @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                </div>

                <div class="form-group">
                    <label class="control-label">Code</label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="Promo code"
                           data-container="body"></i>
                        <input type="text" name="code" value="{{ $coupon->code }}" class="form-control"></div>
                    @if ($errors->has('code'))
                        <span class="text-danger">{{ $errors->first('code') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="control-label">Minimum Amount</label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="minimum perches amount"
                           data-container="body"></i>
                        <input type="text" name="minimum_amount" value="{{ $coupon->minimum_amount }}" class="form-control"></div>
                    @if ($errors->has('minimum_amount'))
                        <span class="text-danger">{{ $errors->first('minimum_amount') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label class="control-label">Amount</label>
                    <div class="input-icon right">
                        <i class="fa fa-info-circle tooltips" data-original-title="Amount"
                           data-container="body"></i>
                        <input type="number" name="amount" value="{{ $coupon->amount }}" class="form-control"></div>
                    @if ($errors->has('amount'))
                        <span class="text-danger">{{ $errors->first('amount') }}</span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Is percent</label>
                            <div class="input-icon right">

                                <input type="checkbox" name="is_percent" @if($coupon->is_percent==1)checked @endif class="form-control"></div>
                            @if ($errors->has('is_percent'))
                                <span class="text-danger">{{ $errors->first('is_percent') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Is Cash back</label>
                            <div class="input-icon right">
                                <input type="checkbox" name="is_cash_back" @if($coupon->is_cash_back==1)checked @endif  class="form-control"></div>
                            @if ($errors->has('is_cash_back'))
                                <span class="text-danger">{{ $errors->first('is_cash_back') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Is Free delivery</label>
                            <div class="input-icon right">

                                <input type="checkbox" name="is_free_delivery" @if($coupon->is_free_delivery==1)checked @endif  data-on-text="Free" class="form-control"></div>
                            @if ($errors->has('is_free_delivery'))
                                <span class="text-danger">{{ $errors->first('is_free_delivery') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="control-label">Max use ability</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Category name in Bangla"
                                   data-container="body"></i>
                                <input type="number" name="max_use" value="{{ $coupon->max_use }}" class="form-control"></div>
                            @if ($errors->has('max_use'))
                                <span class="text-danger">{{ $errors->first('max_use') }}</span>
                            @endif
                        </div>


                    </div>
                    <div class="col-lg-6">


                        <div class="form-group">
                            <label class="control-label">Validity</label>
                            <div class="input-icon right">
                                <i class="fa fa-info-circle tooltips" data-original-title="Category name in Bangla"
                                   data-container="body"></i>
                                <input type="date" name="validity" value="{{ date('Y-m-d',strtotime($coupon->validity)) }}" class="form-control"></div>
                            @if ($errors->has('validity'))
                                <span class="text-danger">{{ $errors->first('validity') }}</span>
                            @endif
                        </div>
                    </div>
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