
@extends('app')

@section('css')
    @parent
    <!-- more css -->
@endsection

@section('navbar')
    <header-component :user="{{ auth()->user() }}" :projects="{{$projects}}"></header-component>
@endsection

@section('content')

<div class="workspace">
    @if(Request::is('/'))
    <dashboard :projects='{{$projects}}' ></dashboard>
    @elseif (Request::is('project*'))
        <side-menu :project='{{$project}}'></side-menu>
         @if ($view)
            @switch($view)
                @case('info')
                    <project-menu :project='{{$project}}'></project-menu>
                    @break
                @case('board')
                    <task-board :user='{{auth()->user()}}' :project='{{$project}}' :tasks='{{$project->tasks}}'></task-board>
                    @break
                @case('statistics')
                    <statistics :project='{{$project}}'></statistics>
                    @break
                @default
                {{ request()->route('show_missing_view') }}
            @endswitch
         @else
            <project-menu :project='{{$project}}'></project-menu>
         @endif
    @endif
</div>
<error-modal></error-modal>
<success-modal></success-modal>
@if (session('error'))
<div style="display: none" id="error">{{ session('error') }}</div>
@endif
@if (session('success'))
<div style="display: none" id="success">{{ session('success') }}</div>
@endif
@endsection

@section('js')
@endsection