@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Employee
        </div>
        <div class="actions">
            <a href="{{ route('employee.create') }}" class="btn btn-default btn-sm">
                <i class="fa fa-plus"></i> Add </a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable table-responsive">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Name</th>
                        <th> Phone </th>
                        <th> Email </th>
                        <th> join </th>
                        <th> Roles </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $key=>$user)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $user->name }} </td>
                        <td> {{ $user->phone }} </td>
                        <td> {{ $user->email }} </td>
                        <td> {{ $user->created_at->diffForHumans() }} </td>
                        <td>
                            @foreach($user->roles  as $key => $role)
                                 <span class="label label-sm label-info">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
{{--                            <a href="{{ route('slider.edit',['id'=>$user->id]) }}" class="btn btn-xs label label-sm label-success ">Edit</a>--}}
                            <form action="{{route('employee.destroy',['employee'=>$user->id])}}" method="post">
                                @method("delete")
                                @csrf
                                <a href="{{ route('employee.assign_role',['user'=>$user->id]) }}" class="btn btn-xs label label-sm label-warning ">Assign Role</a>
                                <button class="btn btn-xs label label-sm label-danger" onclick="return confirm('Are your sure to delete this item')">Delete</button>
                            </form>
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
@endpush

@push('scripts')
    @include('layouts.asset.js.datatable')

@endpush
