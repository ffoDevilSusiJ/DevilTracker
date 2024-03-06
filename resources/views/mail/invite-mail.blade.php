@component('mail::message')
# Введение

Вас пригласил {{$user->username}} ( {{$user->email}} )
В проект {{$project->title}}

@component('mail::button', ['url' => 'https://tracker.devilhost.ru/invite/' . $confirmationLink])
Присоедениться
@endcomponent

С уважением,<br>
{{ config('app.name') }}
@endcomponent