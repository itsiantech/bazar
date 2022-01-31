@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> Categories </div>
        <div class="actions">
            <a href="{{ route('slider.create') }}" class="btn btn-default btn-sm">
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

                    </tr>
                </thead>
                <tbody>
                @foreach($sliders as $key=>$slider)
                    <tr>
                        <td> {{ ++$key }} </td>
                        <td> {{ $slider->title }} </td>
                        <td> <img src="{{ asset($slider->image) }}" width="200" height="150"> </td>

                        <td>
                            <a href="{{ route('slider.edit',['id'=>$slider->id]) }}" class="btn btn-xs label label-sm label-success ">Edit</a>
                            <a href="{{ route('slider.delete',['id'=>$slider->id]) }}" class="btn btn-xs label label-sm label-danger " onclick="return confirm('Are your sure to delete this item')">Delete</a>

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
