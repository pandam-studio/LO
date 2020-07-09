<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\alumni as Status;
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
        return view('home');
    }

    public function status(){
        $status = Status::all();
        return view('status',['status'=>$status]);
    }
    public function laporan(){
        return view('laporan');
    }
}
