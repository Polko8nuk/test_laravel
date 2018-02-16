@extends("layouts.head")

@section('task')
    <div id="home">
        <button>
            <a href="/taskslist">Список задач</a>
        </button>
    </div>
    <div id="containertask">
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
                <div class="description">
                    <h4> Описание </h4>
                </div>
            </div>
        </div>
        <hr>
        <div id="task" class="clearfix">
            <div class="th">
                <div class="tasknumber">
                    <p> {{$task->id}} </p>
                </div>
            </div>
            <div class="th">
                <div class="tasktitle">
                    <textarea cols="45" rows="10" disabled="disabled">{{$task->title}}</textarea>
                </div>
            </div>
            <div class="th">
                <div class="taskdescription">
                    <textarea cols="52" rows="10" disabled="disabled">{{$task->description}}</textarea>
                </div>
            </div>
        </div>
        <hr>
        <div id="form">
            <form>
                <button class="editbutton">Редактировать</button>
                <button disabled="disabled" class="savebutton">Сохранить</button>
            </form>
        </div>
    </div>

@endsection




