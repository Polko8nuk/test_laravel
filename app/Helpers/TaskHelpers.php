<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 16.02.2018
 * Time: 13:21
 */

namespace App\Helpers;


class TaskHelpers
{
    /*
     * Получение суммы элемента массива
     * преобразование в формат
     * @param $time
     * @return int
     */
    public function amount($time)
    {
        $resultseconds=0;

        foreach ($time as $value) {
            $resultseconds += $value->minutes;
        }

        $resultseconds = date( 'G часов i  минут s секунд', $resultseconds);

        return $resultseconds;
    }

    /*
     * преобразование коллекция обьектов в массив. подсчитывается общая сумма времени
     * преобразование в формат
     * @param $time
     * @return array
     */
    public function listReport($list)
    {
        $relutdata = [];

        $timeresult = 0;

        foreach ($list as $time) {
            if (array_key_exists($time->tasks_id, $relutdata))
            {
                $relutdata[$time->tasks_id]['minutes'] += $time->minutes;
            } else {
                $relutdata[$time->tasks_id]['title'] = $time->title;
                $relutdata[$time->tasks_id]['minutes'] = $time->minutes;
            }
            $timeresult += $time->minutes;
        }

        //преобразование метки Unix в формат
        $time = date( 'G часов i  минут s секунд', $timeresult);

        return [$relutdata, $time];


    }

}