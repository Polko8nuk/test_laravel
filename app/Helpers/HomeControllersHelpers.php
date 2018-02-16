<?php

namespace App\Helpers;

use App\Helpers\Contracts\HomeHelpers;
use App\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;


class HomeControllersHelpers //implements HomeHelpers
{
    /**
     * Проверка пароля на подлинность
     *
     * @param  $request
     * @param  $password
     * @return bool
     */
    public static function checkPasswordAuth($request,$password)
    {
        $decrypted_secret = Crypt::decrypt($password);

        if (! ($decrypted_secret == $request) ) {
            return false;
        }
        return true;

    }

    /**
     * Удаление пробелов и тегом HTML
     *
     * @param  $data
     * @return array
     */
    public static function validateData($data)
    {
        $result = [];
        foreach ($data as $key => $value) {
            $result[$key] = trim(strip_tags($value));
        }

        return $result;
    }

    /**
     * Проверка на то, является ли пользователем текущим и
     * проверка на существование нового пользователя с логином или email, в зависимости какой параметр передан
     *
     * @param  $requestlogin
     * @param  $userlogin
     * @param  $login
     * @return bool
     */
    public static function checkExistenceRecord($request, $user, $columb)
    {
        if (($request == $user)) {
            $usernew = User::where($columb, $request)->first();
            if ($usernew) {
               return true;
            }
        }
        return false;
    }


}