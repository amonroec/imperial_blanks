@component('mail::message')

@component('mail::panel')
Hi Berti,

This is an email from the wonderful Bass Believe It site. Hope you enjoyed this.
@endcomponent

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
