<?php

namespace App\Http\Controllers;

use App\Conversation;
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
        $conversations = Conversation::all();
//        dd($conversations[0]->data);
        return view('home',compact('conversations'));
    }
}
