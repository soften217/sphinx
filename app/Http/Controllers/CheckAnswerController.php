<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Eloquent;

class CheckAnswerController extends Controller
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
            return view('faculty/home');
        }
       else
        {
            return view('student/getresult')->with($data);
        }
    }
  
  public function check(Request $request)
    {
      $exam_id = $request->input('exam_id_holder');
      
      $group_id = DB::table('exams')->where('id', '=', $exam_id)->first();
      
      $data['group_id'] = $group_id->group_id;
        
        $totalItems = 0;
      
        $hasSubjective = 0;
      
        $correctAnswerCount = 0;
      
        $arrayAnswerChecker = array();
      
        foreach($_POST as $key => $value)
        {
          $properties = explode("|", $key);
          
          if($properties[0]=='question')
          {
            $totalItems++;
            
            $question_num = $properties[1];
            $question_id = $properties[2];
            $question_type = $properties[3];

            $arrayAnswerChecker[$question_num] = array();
            
            if($question_type=="OBJECTIVE")
            {
              $answerProper = DB::table('answers')->where('question_id', '=', $question_id)->first();
              if(strtoupper($answerProper->value)==strtoupper($value)) 
                 {
                   $arrayAnswerChecker[$question_num]['isCorrect'] = "true";
                   $correctAnswerCount++;
                 }
                else
                {
                  $arrayAnswerChecker[$question_num]['isCorrect'] = "false";
                }
              
              $arrayAnswerChecker[$question_num]['correctAnswer'] = $answerProper->value; 
              $arrayAnswerChecker[$question_num]['yourAnswer'] = $value; 
            }
            else
            {
              $arrayAnswerChecker[$question_num]['correctAnswer'] = "SUBJECTIVE"; 
              $arrayAnswerChecker[$question_num]['yourAnswer'] = $value; 
              $arrayAnswerChecker[$question_num]['isCorrect'] = "SUBJECTIVE";
              
              $hasSubjective = 1;
            }
          }
          else
          {
            
          }
        }
      
     $transactionID = DB::table('exam_user')->insertGetId(
         ['user_id' =>  auth()->user()->id, 'exam_id' => $exam_id, 'isTaken' => 1, 'rawScore' => $correctAnswerCount, 'percentScore' => ($correctAnswerCount/$totalItems)*100, 'toBeChecked' => $hasSubjective]
       );
      
      $data['arrayAnswerChecker'] = $arrayAnswerChecker;
      $data['correctAnswerCount'] = $correctAnswerCount;
      
       return view('student/getresult')->with($data);

    }
 
  

}
