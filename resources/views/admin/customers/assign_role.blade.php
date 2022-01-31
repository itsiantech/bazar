@extends('layouts.app')

@section('content')

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Roles
            </div>
            <div class="actions">
                <a href="{{ route('user.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="{{route('user.sync_role', ['user' => $user->id])}}" method="post">
                @csrf
                <input type="hidden" name="_method" value="patch">
                <div id="messageDiv">
                    @if(Session::has('success'))
                        @include('layouts.message.success')
                    @elseif(Session::has('error'))
                        @include('layouts.message.error')
                    @endif
                </div>
                @if(empty($user))
                    <p class="alert alert-warning alert-dismissable">User Not Found</p>
                @else
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label">name</label>
                            <div class="input-icon right">
                                <input disabled type="text" name="name" value="{{ $user->name }}" class="form-control">
                            </div>
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="control-label">Role</label>
                            <div class="input-icon right">
                                <select name="role_id[]" id="" class="form-control">
                                    @forelse($roles as $id => $role)
                                        <option value="{{$id}}">{{$role}}</option>
                                    @empty
                                        <option value="0">No Role Found</option>
                                    @endforelse
                                </select>
                            </div>
                            @if ($errors->has('role_id'))
                                <span class="text-danger">{{ $errors->first('role_id') }}</span>
                            @endif
                        </div>

                        <div class="form-actions right">
                            <button type="button" class="btn default">Cancel</button>
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
    <!-- END Portlet PORTLET-->

@endsection
