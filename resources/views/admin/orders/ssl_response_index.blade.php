@extends("layouts.partials.order.index")

@section("table")
    <table class="table table-striped table-hover" id="sample_2">
        <thead>
        <tr>
            <th> #</th>
            <th> Status</th>
            <th> Transaction Id</th>
            <th> Validation Id</th>
            <th> Amount</th>
            <th> Card brand</th>
        </tr>
        </thead>
        <tbody>
        @forelse($sslResponse as $response)
            <tr>
                <td> {{$loop->iteration}} </td>
                <td> {{$response->status}} </td>
                <td> {{$response->tran_id}} </td>
                <td> {{$response->val_id}} </td>
                <td> {{$response->amount}} </td>
                <td> {{$response->card_brand}} </td>
            </tr>
        @empty
            <tr>
                <td>No Data Found</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection
