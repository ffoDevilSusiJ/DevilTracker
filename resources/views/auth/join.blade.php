@extends('app')

@section('navbar')
    <header-component></header-component>
@endsection

@section('content')
  <div class="auth">
      <div class="auth__container">
              <h2 class="auth__title">Регистрация в системе</h2>
              <form class="auth__form" method="POST" action="{{ route('join.store') }}">
                @csrf
                  <div class="form-group">
                      <label for="username"><i class="zmdi zmdi-account material-icons-name"></i></label>
                      <input required type="text" name="username" id="name" placeholder="Имя"/>
                  </div>
                  <div class="form-group">
                      <label for="email"><i class="zmdi zmdi-email"></i></label>
                      <input required type="email" name="email" id="email" placeholder="Почта"/>
                  </div>
                  <div class="form-group">
                      <label for="password"><i class="zmdi zmdi-lock"></i></label>
                      <input required type="password" name="password" id="pass" placeholder="Пароль"/>
                  </div>
                  <div class="form-group">
                      <label for="password_confirmation"><i class="zmdi zmdi-lock-outline"></i></label>
                      <input required type="password" name="password_confirmation" id="re_pass" placeholder="Подтверждение пароля"/>
                  </div>
                  <div class="form-group agree-term">
                      <input required type="checkbox" name="agree-term" id="agree-term" class="" />
                      <label for="agree-term" class="label-agree-term"><span><span></span></span>Я согласен со всеми пунктами <a href="#" class="term-service">Условия обслуживания</a></label>
                  </div>
                  <div class="form-group form-button">
                      <input type="submit" name="signup" id="signup" class="form-submit" value="Зарегистрироваться"/>
                      <a href="/login" class="signup-image-link">У меня уже есть аккаунт</a>
                  </div>
              </form>
          </div>
  </div>




@endsection