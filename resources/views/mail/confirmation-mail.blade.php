@component('mail::message')
# Введение

Вас пригласил {{$user->username}} ( {{$user->email}} )
В проект {{$project->title}}

@component('mail::button', ['url' => 'http://localhost:8000/' . $confirmationLink])
Присоедениться
@endcomponent

С уважением,<br>
{{ config('app.name') }}
@endcomponent