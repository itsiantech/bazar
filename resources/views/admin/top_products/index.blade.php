@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-6">

            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> Update top products ( please perform this task at least after 12 am) </div>

                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <ul class="sort_menu list-group">
                        @foreach ($topTypes as $row)
                            <li class="list-group-item" data-id="{{$row->id}}">
                                <span class="handle"></span> {{$row->name}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <!-- END Portlet PORTLET-->

        </div>
        <div class="col-md-6">

            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i> Update top products ( please perform this task at least after 12 am) </div>

                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable table-responsive">
                        <table class="table table-striped table-hover" id="sample_2">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> Top Type Name </th>
                                <th> Status </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($topTypes as $key=>$topType)

                                <tr>
                                    <td> {{ ++$key }} </td>
                                    <td> {{ $topType->name }} </td>

                                    <td>
                                        <!-- <a href="{{ route('topProduct.update',['id'=>$topType->id]) }}" class="btn btn-xs label label-sm label-success ">Update</a> -->
                                        <a href="{{ route('topProduct.edit',['id'=>$topType->id]) }}" class="btn btn-xs label label-sm label-success ">Update</a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END Portlet PORTLET-->

        </div>
    </div>

@endsection

@push('stylesheets')
    @include('layouts.asset.datatable-css-header')
    <link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>

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
    <script>
        $(document).ready(function(){

            function updateToDatabase(idString){
                $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{csrf_token()}}'}});

                $.ajax({
                    url:'{{route('topProduct.updateTypeOrder')}}',
                    method:'POST',
                    data:{ids:idString},
                    success:function(){
                        alert('Type index updated')
                    },
                    error: function (error){
                        console.log(error)
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
