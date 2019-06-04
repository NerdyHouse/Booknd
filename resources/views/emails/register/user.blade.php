@component('mail::message')
# Welcome To Booknd!

Hello {{$user->name}}!<br />
Welcome to Booknd, the best new way to find great books.

@component('mail::button', ['url' => 'http://bookndapp.com'])
Login to Booknd
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
