@extends('app')

@section('navbar')
    <header-component></header-component>
@endsection

@section('content')
    <div class="auth">
        <div class="auth__container">
            <h2 class="auth__title">Авторизация в системе</h2>
            <form class="auth__form" method="POST" action="{{ route('authenticate') }}">
                @csrf
                <div class="form-group">
                    <label for="email"><i class="zmdi zmdi-email"></i></label>
                    <input required type="email" name="email" id="email" placeholder="Почта" />
                </div>
                <div class="form-group">
                    <label for="password"><i class="zmdi zmdi-lock"></i></label>
                    <input required type="password" name="password" id="pass" placeholder="Пароль" />
                </div>
                <div class="form-group form-button">
                    <input type="submit" name="signup" id="signup" class="form-submit" value="Войти" />
                    <a href="/login" class="signup-image-link">У меня нет аккаунта</a>
                </div>
            </form>
        </div>
    </div>
@endsection
