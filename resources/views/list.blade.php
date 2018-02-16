@extends("layouts.head")


@section('task')
    @if (!Auth::guest())
        <div id="auth">
            <a href="/home">{{Auth::user()->login}}</a>
            <a href="/logout">Выйти</a>
        </div>
        @else
        <div id="add">
            <button id="register">Регистрация</button>
            <button id="entry">Вход</button>

        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div id="form-register">
        <form>
            {{csrf_field()}}
            <p>Регистрация</p>
            <div id="name">
                <label>Имя</label>
                <input type="text" placeholder="Введите логин" name="name" value="{{old('name')}}">
            </div>

            <div id="login">
                <label>Логин</label>
                <input type="text" placeholder="Введите логин" name="login" value="{{old('login')}}">
            </div>

            <div id="email">
                <label>Введите email</label>
                <input type="email" placeholder="Введите email" name="email" value="{{old('email')}}">
            </div>

            <div id="password">
                <label>Пароль</label>
                <input type="password" placeholder="Введите пароль" name="password" >
            </div>
            <div id="confirm">
                <label>Подтвердите пароль</label>
                <input type="password" placeholder="Повторите пароль" name="password_confirmation">
            </div>

            <button>Регистрация</button>
        </form>
    </div>
    <div id="form-auth">
        <form>
            {{csrf_field()}}
            <p>Авторизация</p>
            <div>
                <label>Логин</label>
                <input type="text" placeholder="Введите логин" name="login">
            </div>
            <div>
                <label>Пароль</label>
                <input type="password" placeholder="Введите пароль" name="password">
            </div>
            <button>Вход</button>
        </form>
    </div>
    <div id="blackout">
    </div>
    <div id="viewreport">
        <a href="/report" class="btn btn-primary">Отчет</a>
    </div>
    <div id="addtaskhref">
        <button class="addtask">Добавить задачу</button>
    </div>
    <div id="addtask">
        <form  action="/add" method="post">
            {{csrf_field()}}
            <textarea class="title" cols="45" rows="10" name="title" placeholder="Введите наименование новой задачи"></textarea>
            <textarea class="description" cols="45" rows="10" name="description" placeholder="Введите описание новой задачи"></textarea>
            <br>
            <button>Создать</button>
        </form>
    </div>
    <div id="annulment">
        <button>Отменить создание новой задачи</button>
    </div>
    <div id="container">
        <div id="thead"  class="clearfix">
            <div class="th">
                <div class="numberoforder">
                    <h4> # </h4>
                </div>
            </div>
            <div class="th">
                <div class="title">
                    <h4> Наименование </h4>
                </div>
            </div>
            <div class="th">
                <div class="status">
                    <h4> Статус </h4>
                </div>
            </div>
            <div class="th">
                <div class="time">
                    <h4> Затраченое время </h4>
                </div>
            </div>
            <div class="th">
                <div class="work">
                    <h4> Работа </h4>
                </div>
            </div>
            <div class="th">
                <div class="edit">
                    <h4> Редактирование и удаление </h4>
                </div>
            </div>
        </div>
        <hr>
        @foreach($taskslist as $value)
            <div class="clearfix test">
                <div class="th">
                    <div class="tasknumber">
                        <p> {{$value->id}} </p>
                    </div>
                </div>
                <div class="th">
                    <div class="tasktitle" >
                        <H4 title="temp">{{$value->title}}</H4>
                    </div>
                </div>
                <div class="th">
                    <div class="taskstatus">
                        <p> {{$value->status->status}} </p>
                    </div>
                </div>
                <div class="th">
                    <div class="tasktime">
                        @if (array_key_exists($value->id, $result))
                            <p> {{date( 'G часов i  минут s секунд', $result[$value->id])}} </p>
                        @else
                            <p> 0 </p>
                        @endif
                    </div>
                </div>
                <div class="th">
                    @switch($value->status_id)
                        @case(1)
                            <div class="taskwork" data-id="{{$value->id}}">
                                <button class="button" data-type="start"> Старт </button>
                                <button class="button" data-type="pause" disabled> Пауза </button>
                                <button class="button" data-type="complete" disabled> Завершить </button>
                            </div>
                            @break
                        @case(2)
                            @if ($activeresult === null)
                               <div class="taskwork active" data-id="{{$value->id}}">
                            @else
                                <div class="taskwork active" data-idtime="{{$activeresult}}" data-id="{{$value->id}}">
                            @endif
                                <button class="button" data-type="start" disabled> Старт </button>
                                <button class="button" data-type="pause" > Пауза </button>
                                <button class="button" data-type="complete" > Завершить </button>
                            </div>
                            @break
                        @case(3)
                        <div class="taskwork" data-id="{{$value->id}}">
                            <button class="button" data-type="start" > Старт </button>
                            <button class="button" data-type="pause" disabled> Пауза </button>
                            <button class="button" data-type="complete" disabled> Завершить </button>
                        </div>
                        @break
                        @case(4)
                        <div class="taskwork" data-id="{{$value->id}}">
                            <button class="button" data-type="start" disabled> Старт </button>
                            <button class="button" data-type="pause" disabled> Пауза </button>
                            <button class="button" data-type="complete" disabled> Завершить </button>
                        </div>
                        @break
                    @endswitch
                </div>
                <div class="th">
                    <div class="taskedit">
                            <a class="edit btn btn-primary" href="/task/{{$value->id}}" role="button"> Редактировать </a>
                            <a class="remove  btn btn-primary" href="/remove/{{$value->id}}"> Удалить </a>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
    </div>
@endsection
