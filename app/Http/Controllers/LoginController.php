<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        // $user = User::where('email', '=', $request->email);

        // // ユーザーの存在チェック
        // if(is_null($user)) {
        //     return response()->json([
        //         'error' => 'emailが間違っています。'
        //     ], 401);
        // }

        // return response()->json([
        //     'user_id' => time(),
        //     'name' => $user->name,
        //     'error' => '',
        // ], 200);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $res = response()->json();

            return response()->json(Auth::user());
        }


        return response()->json([], 401);
    }
    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(true);
    }
}
