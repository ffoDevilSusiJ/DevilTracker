@component('mail::message')
# Подтверждение почты

Спасибо за регистрацию, {{$username}}!
Пожалуйста, нажмите на кнопку ниже, чтобы подтвердить свой адрес электронной почты:

@component('mail::button', ['url' => 'https://tracker.devilhost.ru/confirm/' . $url])
Подтвердить почту
@endcomponent

С уважением,<br>
{{ config('app.name') }}
@endcomponent