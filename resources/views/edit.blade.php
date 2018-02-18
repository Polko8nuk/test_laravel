@extends('layouts.app')



@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Изменение аватарки</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="/home/avatarpost">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="form-avatar">
                                    <img src="../../image/{{$image}}" alt="..." class="img-circle imageavatar">
                                </div>
                                <div class="col-md-6">
                                    <input type="file" class="form-control avatar" name="photo">
                                    @if ($errors->has('photo'))
                                        <span class="mssspan">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Изменить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Изменение имени, логина и email</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ URL::to('/home/loginpost') }}">
                            <div class="form-group">
                                {{ csrf_field() }}
                                <label for="name" class="col-md-4 control-label">Имя</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ $name }}">

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>
                            <div class="form-group">
                                {{ csrf_field() }}
                                <label for="name" class="col-md-4 control-label">Логин</label>

                                <div class="col-md-6">
                                    <input id="login" type="text" class="form-control" name="login" value="{{ $login }}">

                                    @if ($errors->has('login'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('login') }}</strong>
                                    </span>
                                    @endif
                                    @if (session('login'))
                                        <span class="help-block">
                                        <strong>{{session('login')}}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">E-Mail</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $email }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                    @if (session('email'))
                                        <span class="help-block">
                                        <strong>{{session('email')}}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Текущий пароль</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password1">

                                    @if ($errors->has('password1'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password1') }}</strong>
                                        </span>
                                    @endif
                                    @if (session('password1'))
                                        <span class="help-block">
                                        <strong>{{session('password1')}}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Изменить
                                    </button>
                                    @if (session('msg'))
                                        <span class="help-block">
                                        <strong>{{session('msg')}}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">Изменение пароля</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="/home/passpost">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Текущий пароль</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="passwordold">
                                    @if ($errors->has('passwordold'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('passwordold') }}</strong>
                                                </span>
                                    @endif
                                    @if (session('passwordold'))
                                        <span class="help-block">
                                        <strong>{{session('passwordold')}}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Новый пароль</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Подтвердите новый пароль</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Изменить
                                    </button>
                                    @if (session('msgpassword'))
                                        <span class="help-block">
                                        <strong>{{session('msgpassword')}}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
