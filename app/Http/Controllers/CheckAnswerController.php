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
  
  public function update(Request $request, int $stud_id, int $exam_id)
    {
        if (auth()->user()->isFaculty == 1) 
        {
          $points = array();
          
          $points = $request->input('points');
         
          $sum = 0;
          foreach($points as $points)
          {
            $sum += $points;
          }
          
          DB::table('exam_user')->where('exam_id', '=', $exam_id)->where('user_id', '=', $stud_id)->increment('rawScore', $sum);
          
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
        $aftersaveAnswerCount = 0;
      
        $arrayAnswerChecker = array();
        $questionArray = array();
        foreach($_POST as $key => $value)
        {
          $properties = explode("|", $key);
          

          
          
          if($properties[0]=='question')
          {
            $totalItems++;
            
            $question_num = $properties[1];
            $question_id = $properties[2];
            $question_type = $properties[3];
            
            
            $questionFromDB = DB::table('questions')->where('id', '=', $question_id)->first();
            $questionArray[$question_num] = $questionFromDB->content;
            
            $arrayAnswerChecker[$question_num] = array();
            
            if($question_type=="OBJECTIVE")
            {
              
                if($questionFromDB->subtype == "IDENTIFICATION")
              //IDENTIFICATION
                {
                  $answerProper = DB::table('answers')->where('question_id', '=', $question_id)->first();
                }
              //MULTIPLE CHOICE
                else
                {
                  $answerProper = DB::table('answers')->where('question_id', '=', $question_id)->where('isCorrect', '=', 1)->first();
                }
                
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
            
            $users_exams = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id', '=', $exam_id)->get();
            if(empty($users_exams))
            {
               $save = DB::table('user_question_answer')->insertGetId(
               ['user_id' =>  auth()->user()->id, 'exam_id' => $exam_id, 'question_id' =>  $properties[2], 'answer' => $value, 'isCorrect' => $correctAnswerCount - $aftersaveAnswerCount ]);
            }
              $aftersaveAnswerCount = $correctAnswerCount;  
          }
          else
          {
            
          }
          
      }
      
      $users_exams = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id', '=', $exam_id)->get();
            
     if(empty($users_exams))
     {
       $transactionID = DB::table('exam_user')->insertGetId(
         ['user_id' =>  auth()->user()->id, 'exam_id' => $exam_id, 'isTaken' => 1, 'rawScore' => $correctAnswerCount, 'percentScore' => round(($correctAnswerCount/$totalItems)*100, 2), 'toBeChecked' => $hasSubjective]
       );
     }
      
      
      $data['questionArray'] = $questionArray;
      $data['arrayAnswerChecker'] = $arrayAnswerChecker;
      $data['correctAnswerCount'] = $correctAnswerCount;
      
       return view('student/getresult')->with($data);
    }
 
  
  
 public function checkstudent(Request $request,int $stud_id, int $exam_id)
    {
      
      //$user_question_answer_DB = DB::table('user_question_answer')->where('user_id', '=' , $stud_id) -> where ('$exam_id' ,'=', $exam_id)->get();
      //$examArray = DB::table('exams')->where('id' , '=', $exam_id) -> get();
      $answerArray = array();
      $myanswerArray = array();
      $isCorrectArray = array();
      $realquestionsArray = array();
      $questions = array();
      
      $questionsDB=DB::table('exam_question')->where('exam_id' , '=' , $exam_id)->get(); 
      
      foreach($questionsDB as $temp){
        $questions[]=DB::table('questions')->where('id', '=', $temp->question_id)->first();
      }
      
      foreach ($questions as $question){
        $question_id = $question->id;
        $question_type = $question->type;
        
        $dataDB = DB::table('user_question_answer')->where('user_id', '=' , $stud_id) -> where ('exam_id' ,'=', $exam_id) -> where('question_id', '=', $question_id) -> first();
 
        if((DB::table('answers')->where('question_id', '=', $question_id)->where('isCorrect', '=', 1)->first())==NULL)
        {
          $answerArray[] = DB::table('answers')->where('question_id', '=', 0)->where('isCorrect', '=', 1)->first();
        }
        else
        {
          $answerArray[] = DB::table('answers')->where('question_id', '=', $question_id)->where('isCorrect', '=', 1)->first();
        }
        
        $myanswerArray[] = $dataDB;
        $isCorrectArray[] = $dataDB->isCorrect;
        
         }
      
        $data['answerArray'] = $answerArray;
        $data['questionsArray'] = $questions; 
        $data['myanswerArray'] = $myanswerArray; 
        $data['student_name'] = DB::table('users') -> where('id' , '=', $stud_id) -> value('name');
        $data['student_id'] = $stud_id;
        $data['exam_id'] = $exam_id;
        $data['isCorrect'] = $isCorrectArray;
       return view('faculty/getresult')->with($data);

   }

}