@component('mail::message')
# Booknd Contact Form

Someone has sent a message through the Booknd contact form:<br />
NAME: {{$name}}<br />
EMAIL: {{$email}}<br />
MESSAGE: {{$message}}
@endcomponent
