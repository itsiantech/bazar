<table>
    <thead style="background-color: #0b94ea">
    <tr>
        <th>Date</th>
        <th>Unique Order Id</th>
        <th>User Id</th>
        <th>Customer Name</th>
        <th>Product Link</th>
        <th>Product Name</th>
        <th>Product Quantity</th>
        <th>Product Unit Price</th>
        <th>Product Total Price</th>
        <th>Delivery Charge</th>
        <th>Payment Mode</th>
        <th>Total Payable Amount</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orderItems as $item)
        <tr>
            <td>{{ $item->order_date }}</td>
            <td>{{$item->order_unique_order_id}}</td>
            <td>{{ $item->user_id }}</td>
            <td>{{ $item->user_name}}</td>
            <td>{{ $item->product_link}}</td>
            <td>{{ $item->product_name}}</td>
            <td>{{ $item->product_quantity}}</td>
            <td>{{ $item->product_unit_price}}</td>
            <td>{{ $item->product_total_price}}</td>
            <td>{{ $item->order_delivery_charge }}</td>
            <td>{{ $item->order_payment_mode }}</td>
            <td>{{ $item->order_amount }}</td>
            <td>{{ $item->order_status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
