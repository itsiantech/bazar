@extends('layouts.app')

@section('content')

    <!-- BEGIN Portlet PORTLET-->
    <div class="portlet box green-seagreen">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Roles
            </div>
            <div class="actions">
                <a href="{{ route('role.index') }}" class="btn btn-default btn-sm">
                    <i class="fa fa-list"></i> List </a>
            </div>
        </div>
        <div class="portlet-body">
            <form role="form" action="{{route('role.store')}}" method="post">
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
                        <label class="control-label">name</label>
                        <div class="input-icon right">
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                        </div>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="control-label">Permissions</label>
                        <div class="input-icon right">
                            <select name="permission_id[]" id="" multiple class="form-control" size="30">
                                @forelse($permissions as $id => $permission)
                                    <option value="{{$id}}">{{$permission}}</option>
                                @empty
                                    <option value="0">No Permissions Found</option>
                                @endforelse
                            </select>
                        </div>
                        @if ($errors->has('permission_id'))
                            <span class="text-danger">{{ $errors->first('permission_id') }}</span>
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
