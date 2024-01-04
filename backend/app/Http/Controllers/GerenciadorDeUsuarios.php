<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GerenciadorDeUsuarios extends Controller
{
    // public function auth(Request $request)
    // {   
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);
    //     var_dump($credentials);die;
        
    //     if (Auth::attempt($credentials)) {
    //         dd('logou');
    //         // $request->session()->regenerate();
    //         // return redirect()->intended('teste');
    //     } else {
    //         dd('não logou');
    //     }
    // }
}
