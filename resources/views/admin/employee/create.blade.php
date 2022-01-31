@extends('layouts.app')

@section('content')

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Roles
            </div>
            <div class="actions">
                <a href="{{ route('employee.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="{{route('employee.store')}}" method="post">
                @csrf
                <div id="messageDiv">
                    @if(Session::has('success'))
                        @include('layouts.message.success')
                    @elseif(Session::has('error'))
                        @include('layouts.message.error')
                    @endif
                </div>

                @include("layouts.message.errors_all")
                <div class="form-body">
                    <div class="form-group">
                        <label class="control-label">name</label>
                        <div class="input-icon right">
                            <input type="text" name="name" value="{{!empty(old('name'))?old('name'):''}}" class="form-control">
                        </div>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label">email</label>
                        <div class="input-icon right">
                            <input type="text" name="email" value="{{!empty(old('email'))?old('email'):''}}" class="form-control">
                        </div>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label">phone</label>
                        <div class="input-icon right">
                            <input type="text" name="phone" value="{{!empty(old('phone'))?old('phone'):''}}" class="form-control">
                        </div>
                        @if ($errors->has('phone'))
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>


                    <div class="form-group">
                        <label class="control-label">password</label>
                        <div class="input-icon right">
                            <input type="text" name="password" value="" class="form-control">
                        </div>
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
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
