<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check() && Auth::user()->isKasir()) {
            return redirect()->route('kasir.index');
        }

        return view('app');
    }
}
