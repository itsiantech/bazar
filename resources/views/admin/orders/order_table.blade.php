@foreach($orders as $key=>$order)
    <tr>
        <td> {{ ++$key }} </td>
        <td> {{ $order->unique_order_id }} </td>
        <td> {{ isset($order->user->name)?$order->user->name:'' }} </td>
        <td class="text-center"> {{ $order->calculateOriginalAmountAfterDiscount()}} </td>
        <td> {{ date('d  M Y',strtotime($order->created_at)) }}<br>
            {{ $order->created_at->diffForHumans() }}
        </td>
        <td> {{ $order->paymentMethod->name }} </td>
        <td class="text-center">
            @if($order->status=='delivered')
                <span class=" label label-sm label-success"><i class="fa fa-check"></i></span>
            @else
                <span class="label label-sm label-warning">{{ ucfirst($order->status) }}</span>
            @endif
        </td>
        <td>
            @if($order->status=='pending')
                <a href="{{ route('order.changeStatus',['id'=>$order->id,'status'=>'accepted']) }}"
                   class="btn btn-xs label label-sm label-default ">Accept</a>

            {{-- @elseif($order->status=='accepted')
                <a href="{{ route('order.changeStatus',['id'=>$order->id,'status'=>'order_processing']) }}"
                   class="btn btn-xs label label-sm label-warning ">Processing</a> --}}

            @elseif($order->status=='accepted')
                   <a href="{{ route('order.changeStatus',['id'=>$order->id,'status'=>'delivered']) }}"
                      class="btn btn-xs label label-sm label-success ">Deliver</a>

            @elseif($order->status=='order_processing')
                <a href="{{ route('order.changeStatus',['id'=>$order->id,'status'=>'on_delivery']) }}"
                   class="btn btn-xs label label-sm label-warning ">On The Way</a>

            @elseif($order->status=='on_delivery')
                <a href="{{ route('order.changeStatus',['id'=>$order->id,'status'=>'delivered']) }}"
                   class="btn btn-xs label label-sm label-success ">Deliver</a>

            @elseif($order->status=='canceled')
                <a href="{{ route('order.changeStatus',['id'=>$order->id,'status'=>'pending']) }}"
                   class="btn btn-xs label label-sm label-warning ">Pending</a>

            @endif
            <a href="{{ route('order.changeStatus',['id'=>$order->id,'status'=>'canceled']) }}"
               class="btn btn-xs label label-sm label-danger " >Cancel</a>

        </td>

        <td>
            <a href="{{ route('order.detail',['id'=>$order->id]) }}" class="btn btn-xs btn-primary">View Detail</a>
            <a href="{{ route('order.invoice',['id'=>$order->id]) }}" class="btn btn-xs btn-success">Invoice</a>
            <a href="{{ route('order.delete',['id'=>$order->id]) }}" class="btn btn-xs btn-danger" onclick="return confirm('Are your sure to delete this item')">delete</a>

        </td>
    </tr>
@endforeach
