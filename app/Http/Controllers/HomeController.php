<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Alert;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->isFaculty == 1) 
        {
          Alert::message('Welcome to iQUIZ!', ("Hello, ".auth()->user()->name));
          
            return view('faculty/home')->with(app('App\Http\Controllers\TaskController')->showtask()); 
        }
       else
        {
            return view('student/home')->with(app('App\Http\Controllers\TaskController')->showtask());
        }
    }
  
//   public function portal()
//     {
//         if (auth()->check) 
//         {
//             if (auth()->user()->isFaculty == 1) 
//             {
//             Alert::message('Welcome to iQUIZ!', ("Hello, ".auth()->user()->name));

//                 return view('faculty/'); 
//             }
//            else
//             {
//                 return view('student/home');
//             }
//         }
//        else
//         {
//             return view('welcome');
//         }
//     }
    
}
