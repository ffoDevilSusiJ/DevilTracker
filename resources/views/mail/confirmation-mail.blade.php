@component('mail::message')
# Подтверждение почты

Спасибо за регистрацию, {{$user.username}}!
Пожалуйста, нажмите на кнопку ниже, чтобы подтвердить свой адрес электронной почты:

@component('mail::button', ['url' => $url])
Подтвердить почту
@endcomponent

С уважением,<br>
{{ config('app.name') }}
@endcomponent