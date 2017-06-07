<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection; 
use Alert;
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
      $group = DB::table('groups')->where('creator_id', '=', auth()->user()->id)->where('isArchived', '!=', 1)->first();
      
      if($group == null){
        Alert::info('No Course Found', 'Create a group first');
        
        
        if (auth()->user()->isFaculty == 1) 
        {
            return view('faculty/home');
        }
       else
        {
            return view('student/home');
        }
      }
      else
      {
        $data['courseQ'] = $group->course;
      $data['sortBy'] = "cmpID";
      
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
  
  public function sort($course, $method)
    {
        $data['courseQ'] = $course;
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
