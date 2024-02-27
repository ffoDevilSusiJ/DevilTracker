<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }
    
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            if (session('url.intended')) {
                return redirect(session('url.intended'))->with('success', 'Succelfull epta!');;
            }
            return redirect('/');
        }

        return back()->withErrors(['email' => __('Неправильный email или пароль')]);
    
    }
}
