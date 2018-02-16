<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([[
            'title' => "Создать список задач",
            'description' => "Просмотр перечня задач: наименование, статус, затраченное время.",
            'created_at' => Carbon::now(),
            ], [
                'title' => "Создать страницу задачи",
                'description' => "Просмотр и редактирование наименования и описания задачи.",
                'created_at' => Carbon::now(),
            ], [
                'title' => "Создание отчета",
                'description' => "Указание периода формирования отчёта.",
                'created_at' => Carbon::now(),
            ]
            ]

        );
    }
}
