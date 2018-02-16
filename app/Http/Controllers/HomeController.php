<?php

namespace App\Http\Controllers;

use App\Helpers\Contracts\HomeHelpers;
use App\Helpers\HomeControllersHelpers;
use App\Http\Requests\PasswordValidate;
use App\Http\Requests\ValidateData;
use App\Http\Requests\ValidateFile;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{

    public $login = "login";

    public $email = "email";

    /**
     * Отображение страницы по адресу /home
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Отображение страницы по адресу /edit
     *
     */
    public function edit()
    {
        /**
         * Данные аутентифицированого пользователя
         *
         */

        $name = Auth::user()->name;
        $login = Auth::user()->login;
        $email = Auth::user()->email;
        $image = Auth::user()->image;

        return view('edit')->with(['name'=>$name, 'login'=>$login, 'email'=>$email,'image'=>$image]);
    }

    /**
     * Post запрос для изменения имени, логина и пароля
     *
     * @param App\Http\Requests\PasswordValidate;
     * @param App\Helpers\HomeControllerHelpers;
     *
     * @return @return \Illuminate\Http\Response
     */
    public function loginPost(ValidateData $request, HomeControllersHelpers $helpers)
    {
        //id текущего пользователя
        $id = Auth::user()->id;

        //запись текущего пользователя
        $user = User::find($id);

        //удаление пробелов и тегов
        $data = $helpers->validateData($request->all());

        //существует ли пользователь таким логином
        $usernewlogin = $helpers->checkExistenceRecord($data['login'], $user->login, $this->login);

        //если да, то возврат на предыдущую страницу с ошибкой
        if ($usernewlogin) {
            Session::flash('login' , 'Пользователь с таким логином уже существует');
            return redirect()->back();
        }

        //запись нового логина для изменения
        $user->login = $data['login'];

        //существует ли пользователь таким email
        $usernewemail = $helpers->checkExistenceRecord($data['email'], $user->email, $this->email);

        //если да, то возврат на предыдущую страницу с ошибкой
        if ($usernewemail) {
            Session::flash('email' , 'Пользователь с таким email уже существует');
            return redirect()->back();
        }

        //запись нового email для изменения
        $user->email = $data['email'];

        //проверка на подлинность пароля
        $check = $helpers->checkPasswordAuth($data['password1'], $user->crypt);

        //если пароль не совпадает, то возврат на предыдущую страницу с ошибкой
        if (!$check) {
            Session::flash('password1' , 'Неправильный пароль');
            return redirect()->back();
        }

        $user->name = $data['name'];
        $user->save();

        Session::flash('msg' , 'Данные успешно обновлены');

        return redirect()->back();
    }

    /**
     * Post запрос для изменения парол
     *
     * @param App\Http\Requests\PasswordValidate;
     *
     * @return @return \Illuminate\Http\Response
     */

    public function passwordPost(PasswordValidate $request, HomeControllersHelpers $helpers)
    {
        $user = Auth::user();

        //удаление пробелов и тегов
        $data = $helpers->validateData($request->all());

        //проверка на подлинность пароля
        $check = $helpers->checkPasswordAuth($data['passwordold'], $user->crypt);

        //если пароль не совпадает, то возврат на предыдущую страницу с ошибкой
        if (!$check) {
            Session::flash('passwordold' , 'Неправильный пароль');
            return redirect()->back();
        }

        $user->password = bcrypt($data['password']);
        $user->crypt =  Crypt::encrypt($data['password']);
        $user->save();

        Session::flash('msgpassword' , 'Данные успешно обновлены');

        return redirect()->back();
    }

    /**Post запрос для изменения аватарки
     *
     * @param App\Http\Requests\PasswordValidate;
     *
     * @return @return \Illuminate\Http\Response
     */
    public function avatarPost(ValidateFile $request)
    {
        $user = Auth::user();

        if($request->hasFile('photo'))
        {
            $file = $request->file('photo');
            $file->move(public_path() . '/image',$user->id . $file->getClientOriginalName());
        }

        $user->image = $user->id . $file->getClientOriginalName();
        $user->save();

        return redirect()->back();
    }


}
