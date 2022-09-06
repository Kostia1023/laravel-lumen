<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function checkPassword($pwd) {
    
        if (strlen($pwd) < 8) {
            return "Пароль дуже короткий. Повино бути більше 8 символів";
        }
    
        if (!preg_match("#[0-9]+#", $pwd)) {
            return "Пароль має містити принаймі одну цифру";
        }
    
        if (!preg_match("#[a-zA-Z]+#", $pwd)) {
            return "Пароль має містити принаймі одну букву";
        }     
        return null;
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
        $error = $this->checkPassword($request->input('password'));
        if($error != null){
            return view('register')->with('records', $error);
        }
        $this->validate($request, $rules);
        $user = new User();
        $user->email = $request->input('email');
        $user->password = Crypt::encrypt($request->input('password'));
        $user->name = $request->input('name');
        $user->save();
        return view('Homepage');
        //return response()->json($user);
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
            return view('Homepage');
        } else {
            return view('login')->with('records', 'Не правильна пошта або пароль');
        }
    }
}