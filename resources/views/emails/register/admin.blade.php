@component('mail::message')
# New Booknd User

A new user has just registered on Booknd:<br />
{{$user->name}}<br />
{{$user->email}}<br />

Thanks,<br>
{{ config('app.name') }}
@endcomponent
