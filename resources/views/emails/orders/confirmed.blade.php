@component('mail::message')
We have received your order and will start processing it as soon as possible. <br />

If you have any questions feel free to call or email us.<br />


@component('mail::button', ['url' => $obj->url])
Go To Order
@endcomponent

Thanks
@endcomponent
