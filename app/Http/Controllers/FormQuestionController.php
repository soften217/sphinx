<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Eloquent;

class FormQuestionController extends Controller
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
            return view('faculty/formquestion');
        }
       else
        {
            return view('student/home');
        }
    }
  
  public function form(Request $request)
    {
        if (auth()->user()->isFaculty == 1) 
          {
            $course  = $request->input('course');
            $type = $request->input('type');
            $subtype = $request->input('subtype');
            $content = $request->input('content');
            $answer = $request->input('answer');

            
             $question_id = DB::table('questions')->insertGetId(
                ['course' =>  $course, 'type' => $type, 'content' => $content,  'creator_id' => auth()->user()->id]
             );
                     
            if($answer!=NULL)
            {
              DB::table('answers')->insertGetId(
                        ['value' =>  $answer, 'question_id' => $question_id]
                     );

            }
                     
                     echo 'Added successfully.';

                      return view('faculty/questionbank');
           
          }
         else
          {
             
          }
    }

}
