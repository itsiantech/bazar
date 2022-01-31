@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Pages </div>
        <div class="actions">
            <a href="{{ route('page.create') }}" class="btn btn-default btn-sm">
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
                        <th> title</th>
                        <th> image </th>
                        <th> status </th>

                    </tr>
                </thead>
                <tbody>
                @foreach($pages as $key=>$page)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $page->title }} </td>
                        <td> <img src="{{ asset($page->banner_image) }}" width="200" height="150" alt="Image"> </td>

                        <td>
                            <a href="{{ route('page.edit',['id'=>$page->id]) }}" class="btn btn-xs label label-sm label-success ">Edit</a>
                            <a href="{{ route('page.delete',['id'=>$page->id]) }}" class="btn btn-xs label label-sm label-danger " onclick="return confirm('Are your sure to delete this item')">Delete</a>

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
