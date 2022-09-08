<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\GenericUser;

class UserController extends Controller
{
    public function checkPassword($pwd, &$errors): bool  {
    
        if (strlen($pwd) < 8) {
            $errors = "Пароль дуже короткий. Повино бути більше 8 символів";
            return false;
        }
    
        if (!preg_match("#[0-9]+#", $pwd)) {
            $errors = "Пароль має містити принаймі одну цифру";
            return false;
        }
    
        if (!preg_match("#[a-zA-Z]+#", $pwd)) {
            $errors = "Пароль має містити принаймі одну букву";
            return false;   
        }     
        return true;
    }
    public function postRegister(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
            'confirmPassword' => 'required',
        ];
        if($request->input('password') != $request->input('confirmPassword')){
            return view('register')->with('records', 'Різні паролі');
        }
        if($this->checkPassword($request->input('password'), $error)){
            $this->validate($request, $rules);
            $user = new User();
            $user->email = $request->input('email');
            $user->password = Crypt::encrypt($request->input('password'));
            $user->name = $request->input('name');
            $user->save();
            return view('Homepage')->with('user', $request->session()->get('user'));;
        }
        return view('register')->with('records', $error);
    }

    public function postLogin(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        $this->validate($request, $rules);

        $user = User::where('email', $request->input('email'))->first();
        if ($user != null && Crypt::decrypt($user->password) == $request->password){
            $api_token = base64_encode(Str::random(60));
            $user->remember_token = $api_token;
            $user->save();
            $request->session()->put('user', $user);
            return view('Homepage')->with('user', $request->session()->get('user'));
        } else {
            return view('login')->with('records', 'Не правильна пошта або пароль');
        }
    }

    public function postLogout(Request $request)
    {
        $user = $request->session()->put('user',  0);
        return view('Homepage')->with('user', $request->session()->get('user'));;
    }
}