@extends("layouts.head")

@section('task')
    <div id="home">
        <button>
            <a href="/">Список задач</a>
        </button>
    </div>
    <div class="container">
        <div id="form-report">
            <form action="/reportpost" method="post">
                {{csrf_field()}}
                <div>
                    <p>Введите начальную дату</p>
                    <input type="date" name="start"><br>
                </div>
                <div>
                    <p>Введите конечную дату</p>
                    <input type="date" name="end"><br>
                </div>
                <input type="submit" class="btn-primary btn" value="Отправить">
            </form>
        </div>
    <div id="containerreport">
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
                <div class="time">
                    <h4> Затраченое время </h4>
                </div>
            </div>
        </div>
        <hr>
            @foreach($list as $key => $value)
            <div class="clearfix test">
                <div class="th">
                    <div class="tasknumber">
                        <p>{{$key}}</p>
                    </div>
                </div>
                <div class="th">
                    <div class="tasktitle" >
                        <H4 title="temp">{{$list[$key]['title']}}</H4>
                    </div>
                </div>

                <div class="th">
                    <div class="tasktime">
                            <p>{{date( 'G часов i  минут s секунд', $list[$key]['minutes'])}}</p>
                    </div>
                </div>
            </div>
            <hr>
            @endforeach
        <div>
            <p>Количество затраченого времени:</p><span>{{$resultseconds}}</span>
        </div>
    </div>
    </div>
@endsection
