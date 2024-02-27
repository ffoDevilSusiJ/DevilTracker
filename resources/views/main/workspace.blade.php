
@extends('app')

@section('css')
    @parent
    <!-- more css -->
@endsection

@section('navbar')
    <header-component :user="{{ $user }}" :projects="{{$projects}}"></header-component>
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
                    <task-board :tasks='{{$project->tasks}}'></task-board>
                    @break
                @case('statistics')
                    <statistics></statistics>
                    @break
                @default
                {{ request()->route('show_missing_view') }}
            @endswitch
         @else
            <project-menu :project='{{$project}}'></project-menu>
         @endif
    @endif
</div>

@endsection

@section('js')
@endsection