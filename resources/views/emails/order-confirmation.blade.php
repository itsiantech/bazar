
@component('mail::message')
# Your order placed successfully

Thank you for being with us.

## Order summery
@component('mail::table')
| Name | Quantity | Price |
| ------------- |:-------------:| --------:|
@foreach($order_details['orderItems'] as $item)
| {{ $item->product['name_en'] }}  ( {{ $item->product['name_bn']}} )  | {{$item->quantity }}  | {{$item->price}} |
@endforeach

@endcomponent
 

Delivery time : Within 3 hours


{{-- @component('mail::button', ['url' => ''])
View order
@endcomponent --}}

@endcomponent
