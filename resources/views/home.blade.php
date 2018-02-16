@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Привет, пользователь {{Auth::user()->login}}</div>

                    <div class="panel-body">
                        Вы успешно авторизировались
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="/home/edit">Редактировать данные</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
