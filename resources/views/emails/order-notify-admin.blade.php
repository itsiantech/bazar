@component('mail::message')
# You have received a new order

Thank you for being with us.


@component('mail::button', ['url' => $url])
View order
@endcomponent

@endcomponent
