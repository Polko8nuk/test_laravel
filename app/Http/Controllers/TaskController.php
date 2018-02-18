<?php

namespace App\Http\Controllers;

use App\Helpers\HomeControllersHelpers;
use App\Helpers\TaskHelpers;
use App\Task;
use App\Time;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;


class TaskController extends Controller
{
    public $start;

    public $end;

    /**
     * Отображения страницы задач
     *
     *
     * @return @return \Illuminate\Http\Response
    */
    public function TasksList()
    {
        $data = [];

        //получение всех задач
        $tasklist = Task::with('status', 'times')->get();
        $data['taskslist'] = $tasklist;

        //перебор всех задач и всех временных меток для получение общего времени по задаче
        $result = [];
        foreach ($tasklist as $time)
        {
            $sum = 0;
            foreach ($time->times as $item)
            {
                $sum += $item->minutes;
            }
            $result[$time->id] = $sum;
        }

        $data['result'] = $result;

        //получение задачи, которая активная
        $active = Task::with(['times' => function($e) {
            $e->where('end_time', null);
        }])->where('status_id',2)->first();

        $activeresult = 0;

        //получение id задачи, которая выполняется
        if ($active) {
            foreach ($active->times as $value) {
                $activeresult = $value->id;
            }
            if ($activeresult) {
                $data['activeresult']=$activeresult;
            } else $data['activeresult']=null;
        } else $data['activeresult']=null;

        return view('list',$data);
    }

    /**
     * Отображения страницы одной задачи
     *
     * @param id
     *
     * @return @return \Illuminate\Http\Response
     */
    public function Task($id)
    {
        return view('task')->with(['task' => Task::findOrFail($id)]);
    }

    /**
     * Post запрос для обновления данных текущей задачи
     *
     * @param Illuminate\Http\Request;
     * @param App\Helpers\HomeControllerHelpers;
     *
     * @return \Illuminate\Http\Response
     */

    public function TaskEdit(Request $request, HomeControllersHelpers $helpers)
    {
        //удаление тегов и пробелов
        $data = $helpers->validateData($request->all());

        //получение обьекта текущей задачи и обновление данных
        $task = Task::find($data['id']);
        $task->title = $data['title'];
        $task->description = $data['description'];
        $task->save();

        //получение текущей задачи для выборки данных с отправкой в формате json
        $updatetask = Task::findOrFail($data['id']);

        return response()->json([
            'title' => $updatetask->title,
            'description' => $updatetask->description,
            'message' => 'Данные успешно обновлены'
        ]);
    }

    /**
     * Удаление задачи с переходом на страницу списка задач
     *
     * @param id
     *
     * @return @return \Illuminate\Http\Response
     */

    public function TaskRemove($id, HomeControllersHelpers $helpers)
    {
        //удаление задачи
        $task = Task::where('id', $id)->delete();

        return redirect()->route('list');
    }

    /**
     * Post запрос для добавления новой задачи с переходом на страницу списка задач
     *
     * @param Illuminate\Http\Request;
     * @param App\Helpers\HomeControllerHelpers;
     *
     * @return \Illuminate\Http\Response
     */
    public function TaskAdd(Request $request, HomeControllersHelpers $helpers)
    {
        //удаление тегов и пробелов
        $data = $helpers->validateData($request->all());

        $task = new Task();
        $task->title = $data['title'];
        $task->description = $data['description'];
        $task->created_at = Carbon::now();
        $task->save();

        return redirect()->route('list');
    }

    /**
    * Post для запуска задачи в работу
    *
    * @param Illuminate\Http\Request;
    * @param App\Helpers\HomeControllerHelpers;
    *
    * @return \Illuminate\Http\Response
    */
    public function TaskStart(Request $request, HomeControllersHelpers $helpers)
    {
        //удаление тегов и пробелов
        $data = $helpers->validateData($request->all());

        //изменение статуса задачи
        $task = Task::find($data['id']);
        $task->status_id=2;
        $task->save();

        //получение текущего времени
        $starttime = Carbon::now();

        //создание временной метки
        $time = new Time;
        $time->start_time=$starttime;
        $time->tasks_id = $data['id'];
        $time->save();

        //получение текущей метки
        $timesid = Time::where('start_time',$starttime)->first();

        //получение статуса
        $status = Task::find($data['id'])->status;

        return response()->json([
            'status' => $status->status,
            'id' => $timesid->id,
            'idtasks' => $timesid->tasks_id
        ]);
    }

    /**
     * Post для постановки задачи на паузу и на завершение
     *
     * @param Illuminate\Http\Request;
     * @param App\Helpers\HomeControllerHelpers;
     * @param App\Helpers\TaskHelpers;
     *
     * @return \Illuminate\Http\Response
     */
    public function TaskPause(Request $request,  HomeControllersHelpers $helpers, TaskHelpers $taskHelpers)
    {
        //удаление тегов и пробелов
        $data = $helpers->validateData($request->all());

        //получение текущего времени
        $end_time = Carbon::now();

        //поиск временной метки
        $result = Time::find($data['idstart']);

        //получение начало запуска
        $start_time = $result->start_time;

        //получение метки времени в Unix
        $seconds = strtotime($end_time) - strtotime($start_time);

        //запись в БД
        $result->end_time=$end_time;
        $result->minutes=$seconds;
        $result->save();

        //получение всех записей (метки времени)
        $seconds = Time::where('tasks_id', $data['id'])->get();

        //получение общее количество затрачего времени на выполнение задачи
        $resultseconds = $taskHelpers->amount($seconds);

        //если запрос пришел от кнопки пауза
        $status = "";
        if (in_array('pause', $data))
        {
            $task = Task::find($data['id']);
            $task->status_id=3;
            $task->save();
            //получение статуса
            $status = Task::find($data['id'])->status;
        }

        //если запрос пришел от кнопки завершить
        if (in_array('complete', $data))
        {
            $task = Task::find($data['id']);
            $task->status_id=4;
            $task->save();
            //получение статуса
            $status = Task::find($data['id'])->status;
        }

        return response()->json([
            'status' => $status->status,
            'seconds' => $resultseconds,
        ]);
    }

    /**
     * Post для постановки задачи на паузу при нажатии на кнопку старт
     *
     * @param Illuminate\Http\Request;
     * @param App\Helpers\HomeControllerHelpers;
     * @param App\Helpers\TaskHelpers;
     *
     * @return \Illuminate\Http\Response
     */
    public function TaskChange(Request $request, HomeControllersHelpers $helpers, TaskHelpers $taskHelpers)
    {
        //удаление тегов и пробелов
        $data = $helpers->validateData($request->all());

        //изменение статуса задачи, которую приостановили
        $old = Task::find($data['idold']);
        $old->status_id = 3;
        $old->save();

        //получение временной метки приостановленой задачи
        $oldtime = Time::find($data['idtimeold']);

        //получение текущего времени
        $end_time = Carbon::now();

        //получение начало запуска
        $start_time = $oldtime->start_time;

        //получение метки времени в Unix
        $seconds = strtotime($end_time) - strtotime($start_time);

        //запись в БД
        $oldtime->end_time=$end_time;
        $oldtime->minutes=$seconds;
        $oldtime->save();

        //изменение статуса задачи, которую запустили
        $new = Task::find($data['id']);
        $new->status_id = 2;
        $new->save();

        //запись новой метки
        $newtime = Carbon::now();

        //запись в БД новой временной метки
        $time = new Time;
        $time->start_time=$newtime;
        $time->tasks_id = $data['id'];
        $time->save();

        //получение статуса приостановленой и текущей задачи
        $sendold = Task::find($data['idold'])->status;
        $sendnew = Task::find($data['id'])->status;

        //получение временной метки предыдущей задачи
        $seconds = Time::where('tasks_id', $data['idold'])->get();

        //получение общее количество затрачего времени на выполнение задачи
        $resultseconds = $taskHelpers->amount($seconds);

        //получение временной метки для новой задачи
        $timesid = Time::where('start_time',$newtime)->first();

        return response()->json([
            'statusold' => $sendold->status,
            'statusnew' => $sendnew->status,
            'seconds' => $resultseconds,
            'id' => $timesid->id,
            'idtasks' => $timesid->tasks_id,
        ]);
    }

    /**
     * Отображении страницы отчета
     *
     */
    public function TaskReport(Request $request, TaskHelpers $taskHelpers)
    {
        //получение всех задач
        $list = DB::table('tasks')
            ->join('times_new', 'tasks.id', '=', 'times_new.tasks_id')->get();

        //запись в массив данных о задачах. подсчитывается общая сумма
        list($listarray, $time) = $taskHelpers->listReport($list);

        return view('report')->with(['list'=> $listarray , 'resultseconds' => $time]);
    }

    /**
     * Post для получения задач в определенном периоде
     */
    public function TaskReportPost(Request $request, HomeControllersHelpers $helpers, TaskHelpers $taskHelpers)
    {
        //удаление тегов и пробелов
        $data = $helpers->validateData($request->all());

        //запись даты, которая пришла с формы
        $this->start = $data['start'];
        $this->end = $data['end'];

        $list = DB::table('tasks')
            ->join('times_new', function ($join) {
                $join->on('tasks.id', '=', 'times_new.tasks_id')
                    ->where([
                        ['start_time', '>' , $this->start],
                        ['end_time' , '<' , $this->end]
                    ]);
            })
            ->get();

        //запись в массив данных о задачах. подсчитывается общая сумма времени
        list($listarray, $time) = $taskHelpers->listReport($list);

        return view('report')->with(['list'=> $listarray , 'resultseconds' => $time]);
    }

}
