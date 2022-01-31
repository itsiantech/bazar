@extends('layouts.app')

@section('content')

<!-- BEGIN Portlet PORTLET-->
<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-gift"></i> User
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-1">
                <a href="{{route('customer.export')}}" class="btn btn-success btn-block d-block">Export</a>

            </div>
            @include("layouts.partials.table-date-range-filter", ['state' => 'default', 'actionURL' => 'customer.dateFiltered'])

            <div class="col-md-12">
                <div class="table-scrollable table-responsive">
                    <table class="table table-striped table-hover" id="sample_2">
                        <thead>
                        <tr>
                            <th> # </th>
                            <th> Id</th>
                            <th> Name</th>
                            <th> Email</th>
                            <th> Phone </th>
                            <th> join </th>
                            <th> Customer Status </th>
                            <th> Action </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($customers as $key=>$customer)
                            <tr>
                                <td> {{ ++$key }} </td>
                                <td> {{ $customer->customerId }} </td>
                                <td> {{ $customer->name }} </td>
                                <td> {{ $customer->email }} </td>
                                <td> {{ $customer->phone }} </td>
                                <td> {{ $customer->created_at->diffForHumans() }} </td>
                                <td> {{ $customer->is_activated?"Activated":"Disabled" }} </td>
                                <td>
                                    <form method="post" action="{{route("customer.delete", ['id' => $customer->id])}}" id="form-{{$customer->id}}" class="form-inline">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete" id="form-method-hidden-{{$customer->id}}">
                                        <button onclick="return confirm('Are your sure to delete this customer')" class="btn btn-xs label label-sm label-danger" >Delete User</button>
                                        <button class="btn btn-xs label label-sm label-warning" onclick="submitForm(event, '{{$customer->id}}','{{ route('customer.disable_customer',['customer'=>$customer->id]) }}')">Disable User</button>
                                        <button class="btn btn-xs label label-sm label-success" onclick="submitForm(event, '{{$customer->id}}','{{ route('customer.enable_customer',['customer'=>$customer->id]) }}')">Enable User</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
    <script type="application/javascript">

        function submitForm(e, id, url){
            event.preventDefault()
            var form = "#form-"+id
            var methodInput = "#form-method-hidden-"+id

            $(form).attr("action", url)
            $(methodInput).val('patch')
            $(form).submit();
        }
    </script>
@endpush
