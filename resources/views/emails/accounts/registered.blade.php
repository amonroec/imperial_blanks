@component('mail::message')
There has been a new user try to register on the Stock Imperial Site.

@component('mail::button', ['url' => $url])
Go To Site
@endcomponent

Thanks,<br>
@endcomponent
