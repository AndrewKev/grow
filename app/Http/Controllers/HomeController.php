<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(auth()->user()->level);
        if(auth()->user()->level == 1 || auth()->user()->level == 2) {
            return redirect('/admin/dashboard');
        } else if(auth()->user()->level == 0) {
            return redirect('/user/dashboard');
        } else {
            return view('home');
        }
    }
}
