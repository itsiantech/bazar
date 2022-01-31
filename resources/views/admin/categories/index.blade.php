@extends('layouts.app')

@section('content')
<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i> Update Parent Position </div>

            <div class="tools"> </div>
        </div>
        <div class="portlet-body">
            <div class="row">
                <div class="col-md-12">

                    <ul class="sort_menu list-group">
                        @foreach ($parents as $row)
                            <li class="list-group-item" data-id="{{$row->id}}">
                                <span class="handle"></span> {{$row->name_en}}</li>
                        @endforeach
                    </ul>

                </div>
            </div>
        </div>
    </div>


</div>
<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-gift"></i>Manage all categories </div>
            <div class="actions">
                <a href="{{ route('category.create') }}" class="btn btn-default btn-sm">
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
                        <th> Name English </th>
                        <th> Name Bangla </th>
                        <th> Status </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $key=>$category)
                        <tr>
                            <td> {{ ++$key }} </td>
                            <td> {{ $category->name_en }} </td>
                            <td> {{ $category->name_bn }} </td>

                            <td>
                                <a href="{{ route('category.edit',['id'=>$category->id]) }}" class="btn btn-xs label label-sm label-success ">Edit</a>
                                <a href="{{ route('category.delete',['id'=>$category->id]) }}" class="btn btn-xs label label-sm label-danger " onclick="return confirm('Are your sure to delete this item')">Delete</a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- BEGIN Portlet PORTLET-->
<!-- END Portlet PORTLET-->

@endsection

@push('stylesheets')
    @include('layouts.asset.datatable-css-header')

    <style>
        .list-group-item {
            display: flex;
            align-items: center;
        }

        .highlight {
            background: #f7e7d3;
            min-height: 30px;
            list-style-type: none;
        }

        .handle {
            min-width: 18px;
            background: #607D8B;
            height: 15px;
            display: inline-block;
            cursor: move;
            margin-right: 10px;
        }
    </style>

@endpush

@push('scripts')
    @include('layouts.asset.js.datatable')

    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>
    <script>
        $(document).ready(function(){

            function updateToDatabase(idString){
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});

                $.ajax({
                    url:'{{url('/private-panel/categories/update-order')}}',
                    method:'POST',
                    data:{ids:idString},
                    success:function(){
                        alert('Category positions Successfully updated')
                        //do whatever after success
                    }
                })
            }

            var target = $('.sort_menu');
            target.sortable({
                handle: '.handle',
                placeholder: 'highlight',
                axis: "y",
                update: function (e, ui){
                    var sortData = target.sortable('toArray',{ attribute: 'data-id'})
                    updateToDatabase(sortData.join(','))
                }
            })

        })
    </script>
@endpush
