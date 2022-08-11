<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //
    public function index(){
        if (Auth::user() && auth()->user()->role == 'admin')
            return redirect()->route('dashboard');
        else if (Auth::user() && auth()->user()->role == 'kitchenStaff')
            return redirect()->route('carOrder');
        return view('home');
    }
}
