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
     * @param $time
     * @return int
     */
    public function amount($time)
    {
        $resultseconds=0;

        foreach ($time as $value) {
            $resultseconds += $value->minutes;
        }

        return $resultseconds;
    }

}