<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 16.02.2018
 * Time: 10:11
 */

namespace App\Helpers\Contracts;


interface HomeHelpers
{
    public static function checkPasswordAuth($requestpassword, $currentpassword);
}