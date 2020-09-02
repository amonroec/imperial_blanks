@component('mail::message')
Your account has been approved and you are ready to start using the stock Imperial site. Click the button to take you to the website!

@component('mail::button', ['url' => $url])
Go To Site
@endcomponent

Thanks!
@endcomponent
