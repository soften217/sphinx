<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class QuestionBankController extends Controller
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
      
      $data['sortBy'] = "cmpCourse";
      
        if (auth()->user()->isFaculty == 1) 
        {
            return view('faculty/questionbank')->with($data);
        }
       else
        {
            return view('student/home');
        }
    }
  
  public function sort($method)
    {
      
        $data['sortBy'] = $method;
      
        if (auth()->user()->isFaculty == 1) 
        {
            return view('faculty/questionbank')->with($data);
        }
       else
        {
            return view('student/home');
        }
    }

}
