<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user && $user->isKasir()) {
                return redirect()->route('kasir.index');
            } elseif ($user && $user->isPimpinan()) {
                return redirect()->route('pimpinan.dashboard');
            }

            return redirect()->intended('/admin/dashboard');
        }

        return back()
            ->withErrors(['email' => 'Invalid Email or password'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
