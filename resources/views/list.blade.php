@extends("layouts.head")


@section('task')

    <div class="container">
        <div class="row">
            @if (!Auth::guest())
                 <div class="col-sm registerajax">
                      <a href="/home" class="btn btn-primary">Добро пожаловать, {{Auth::user()->login}}</a>
                 </div>
                 <div class="col-sm entryajax">
                      <a href="/logout" class="btn btn-primary">Выйти</a>
                 </div>
            @else
                <div class="col-sm register">
                    <button class="btn btn-primary">Регистрация</button>
                </div>
                <div class="col-sm entry">
                    <button class="btn btn-primary">Вход</button>
                </div>
            @endif
            <div class="col-sm addtaskhref">
                <button class="btn btn-primary">Добавить задачу</button>
            </div>
            <div class="col-sm viewreport">
                <a href="/report" class="btn btn-primary">Отчет</a>
            </div>
        </div>
    </div>
    <div class="addtask">
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
                                <button class="button btn btn-primary" data-type="start"> Старт </button>
                                <button class="button btn btn-primary" data-type="pause" disabled> Пауза </button>
                                <button class="button btn btn-primary" data-type="complete" disabled> Завершить </button>
                            </div>
                            @break
                        @case(2)
                            @if ($activeresult === null)
                               <div class="taskwork active" data-id="{{$value->id}}">
                            @else
                                <div class="taskwork active" data-idtime="{{$activeresult}}" data-id="{{$value->id}}">
                            @endif
                                <button class="button btn btn-primary" data-type="start" disabled> Старт </button>
                                <button class="button btn btn-primary" data-type="pause" > Пауза </button>
                                <button class="button btn btn-primary" data-type="complete" > Завершить </button>
                            </div>
                            @break
                        @case(3)
                        <div class="taskwork" data-id="{{$value->id}}">
                            <button class="button btn btn-primary" data-type="start" > Старт </button>
                            <button class="button btn btn-primary" data-type="pause" disabled> Пауза </button>
                            <button class="button btn btn-primary" data-type="complete" disabled> Завершить </button>
                        </div>
                        @break
                        @case(4)
                        <div class="taskwork" data-id="{{$value->id}}">
                            <button class="button btn btn-primary" data-type="start" disabled> Старт </button>
                            <button class="button btn btn-primary" data-type="pause" disabled> Пауза </button>
                            <button class="button btn btn-primary" data-type="complete" disabled> Завершить </button>
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
            <div id="form-register">
                <form>
                    {{csrf_field()}}
                    <div class="panel-heading">
                        <p>Регистрация</p>
                    </div>
                    <div class="form-group">
                        <label class="formGroupExampleInput">Имя</label>
                        <input type="text" class="form-control"  placeholder="Введите имя" name="name">
                    </div>
                    <div class="form-group">
                        <label class="formGroupExampleInput2">Логин</label>
                        <input type="text" class="form-control"  placeholder="Введите логин" name="login" >
                    </div>
                    <div class="form-group">
                        <label class="formGroupExampleInput2">Email</label>
                        <input type="email" class="form-control"  placeholder="Введите email" name="email">
                    </div>
                    <div class="form-group">
                        <label class="formGroupExampleInput2">Пароль</label>
                        <input type="password" class="form-control"  placeholder="Введите пароль" name="password">
                        <small id="passwordHelpInline" class="text-muted">
                            Должно быть больше 6 символов.
                        </small>
                    </div>
                    <div class="form-group">
                        <label class="formGroupExampleInput2">Подтвердите пароль</label>
                        <input type="password" class="form-control" placeholder="Повторите пароль" name="password_confirmation">
                        <small id="passwordHelpInline" class="text-muted">
                            Пароли должны совпадать
                        </small>
                    </div>
                    <div class="button">
                        <button type="submit" class="btn btn-primary">Регистрация</button>
                    </div>
                </form>
            </div>
            <div id="form-auth">
                <form >
                    {{csrf_field()}}
                    <div class="panel-heading">
                        <p>Вход</p>
                    </div>
                    <div class="form-group">
                        <label class="formGroupExampleInput2">Логин</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Введите логин" name="login">
                    </div>
                    <div class="form-group">
                        <label class="formGroupExampleInput2">Пароль</label>
                        <input type="text" class="form-control" id="formGroupExampleInput2" placeholder="Введите пароль" name="password">
                    </div>
                    <div class="button">
                        <button type="submit" class="btn btn-primary">Вход</button>
                    </div>
                </form>
            </div>
            <div id="blackout">
            </div>
@endsection
