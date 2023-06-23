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
        if(auth()->user()->level == 1) {
            return redirect('/admin/dashboard');
        } else if(auth()->user()->level == 2) {
            return redirect('/admin2/dashboard');
        }else if(auth()->user()->level == 0) {
            return redirect('/user/dashboard');
        }else if(auth()->user()->level == 4) {
            return redirect('/gKecil/dashboard');
        }else if(auth()->user()->level == 5) {
            return redirect('/gBesar/dashboard');
        }else if(auth()->user()->level == 6) {
            return redirect('/pimArea/dashboard');
        }else if(auth()->user()->level == 7) {
            return redirect('/headAcc/dashboard');
        } else if (auth()->user()->level == 8) {
            return redirect('/spo/dashboard');
        } else {
            return view('home');
        }
    }
}
