<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Controller for user interaction
 *
 * The controller allows you to register a user, log in and log out
 */
class UserController extends Controller
{
    /**
     * Password complexity check
     *
     * @param string $pwd password to verify
     * @param string|null $errors password error
     * @return boolean returns true if the password passed verification
     */
    public function checkPassword($pwd, &$errors): bool
    {

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
    /**
     * Csreates a new user
     *
     * @param Request $request
     * @return void
     */
    public function postRegister(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
            'confirmPassword' => 'required',
        ];
        if ($request->input('password') != $request->input('confirmPassword')) {
            return view('register')->with('records', 'Різні паролі');
        }
        if ($this->checkPassword($request->input('password'), $error)) {
            $this->validate($request, $rules);
            $user = new User();
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->name = $request->input('name');
            $user->save();
            return view('Homepage')->with('user', $request->session()->get('user'));
        }
        return view('register')->with('records', $error);
    }
    /**
     * User authorization and adding it to the session
     *
     * @param Request $request
     * @return void
     */
    public function postLogin(Request $request)
    {
        $rules = [
            'email' => 'required',
            'password' => 'required',
        ];

        $this->validate($request, $rules);

        $user = User::where('email', $request->input('email'))->first();
        if ($user != null && Hash::check($request->password, $user->password)) {
            $api_token = base64_encode(Str::random(60));
            $user->remember_token = $api_token;
            $user->save();
            $request->session()->put('user', $user);
            return view('Homepage')->with('user', $request->session()->get('user'));
        } else {
            return view('login')->with('records', 'Не правильна пошта або пароль');
        }
    }
    /**
     * User logout and removal from the session
     *
     * @param Request $request
     * @return void
     */
    public function postLogout(Request $request)
    {
        $request->session()->forget('user');
        return view('Homepage')->with('user', $request->session()->get('user'));
    }
}
