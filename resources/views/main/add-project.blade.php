@extends('app')

@section('css')
    @parent
    <!-- more css -->
@endsection

@section('navbar')
    <header-component initial-data="{{ json_encode($user) }}"></header-component>
@endsection

@section('content')
    <div class="add-project">
        <div class="add-project__container">
            <h2 class="add-project__title">Создание проекта</h2>
            <form class="add-project__form" method="POST" action="{{ route('project.store') }}">
                @csrf
                <div class="form-group">
                    <label for="title"><i class="zmdi zmdi-email"></i></label>
                    <input required type="text" name="title" id="email" placeholder="Название проекта" />
                </div>
                <div class="form-group">
                    <label for="description"><i class="zmdi zmdi-lock"></i></label>
                    <textarea required name="description" id="discription" placeholder="Описание проекта"></textarea>
                </div>
                <div id="member-list" class="form-group">
                    <div>Добавить участников (нажать Enter)</div>
                    <div class="form-group__divider">
                        <input class="form-group__member" required type="email" name="members[]" id="email"
                            placeholder="Почта участника" />
                        <select name="roles[]">
                            <option value="2">Исполнитель</option>
                            <option value="3">Менеджер</option>
                        </select>
                    </div>

                </div>
                <div class="form-group form-button">
                    <input type="submit" name="signup" id="signup" class="form-submit" value="Создать проект" />
                </div>
            </form>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            console.log(1);
        }
    });
    document.addEventListener('keydown', function(event) {
        if (document.activeElement.classList.contains('form-group__member')) {
            var element = document.querySelector('#modal');
            if (event.key === 'Enter') {
                let divider = document.getElementsByClassName('form-group__divider')[0].cloneNode(true);
                divider.children[0].value = '';

                divider.children[0].addEventListener('keydown', function(event) {
                    if (event.key === 'Backspace' && document.activeElement.value == '') {
                        divider.parentNode.removeChild(divider);
                        let childs = document.getElementById('member-list').children
                        childs[childs.length - 1].children[0].focus();
                    }
                });

                document.getElementById('member-list').appendChild(divider);
                divider.children[0].focus();
            }
        }

    });
</script>
@section('js')
@endsection
