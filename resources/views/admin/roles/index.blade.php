@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Roles </div>
        <div class="actions">
            <a href="{{ route('role.create') }}" class="btn btn-default btn-sm">
                <i class="fa fa-plus"></i> Add </a>
        </div>
        <div class="tools"> </div>
    </div>
    <div class="portlet-body">
        <div class="table-scrollable table-responsive">
            <table class="table table-striped table-hover" id="sample_2">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Name</th>
                        <th> Permissions </th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                @foreach($roles as $key=>$role)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $role->name }} </td>
                        <td>
                            @foreach($role->permissions  as $key => $value)
                                 <span class="label label-sm label-info">{{ $value->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('role.edit',['role'=>$role->id]) }}" class="btn btn-xs label label-sm label-success ">Edit</a>
{{--                            <a href="" class="btn btn-xs label label-sm label-danger ">Delete</a>--}}
                            <form  method="post" action="{{ route('role.destroy',['role'=>$role->id]) }}">
                                @csrf
                                <input type="hidden" name="_method" value="delete">
                                <input onclick="return confirm('Are your sure to delete this item')"  type="submit" value="Delete" class="btn btn-xs btn-danger">
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
