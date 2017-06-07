<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Eloquent;
use Alert;
use DateTime;

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
          $ids = array();
          
          $points = $request->input('points');
          $ids = $request->input('id');
         
          $sum = 0;
          
          $count = 0;
          foreach($points as $point)
          {
            DB::table('user_question_answer')->where('exam_id', '=', $exam_id)->where('user_id', '=', $stud_id)->where('question_id', '=', $ids[$count])
              ->update(['subjPoints' => $point]);
            
            $sum += $point;
            $count++;
          }
          
          $exam_details = DB::table('exams')->where('id', '=', $exam_id)->first();
          
          DB::table('exam_user')->where('exam_id', '=', $exam_id)->where('user_id', '=', $stud_id)->increment('rawScore', $sum);
          DB::table('exam_user')->where('exam_id', '=', $exam_id)->where('user_id', '=', $stud_id)->update(['toBeChecked' => 0]);
          DB::table('exam_user')->where('exam_id', '=', $exam_id)->where('user_id', '=', $stud_id)->update(['subj_score' => $sum]);
          
          $exam_user_details = DB::table('exam_user')
            ->where('exam_id', '=', $exam_id)
            ->where('user_id', '=', $stud_id)
            ->first();
          
          $finalScore = $exam_user_details->rawScore;
          $totalAllInAll = ($exam_details->totalObjPts + $exam_details->totalSubjPts);
          
          DB::table('exam_user')
            ->where('exam_id', '=', $exam_id)
            ->where('user_id', '=', $stud_id)
            ->update(['percentScore' => round(($finalScore/$totalAllInAll)*100, 2)]);
//           
//           
//           Group
//           
        $data['id'] = $exam_details->group_id;
      
        $authenticated = FALSE;
      
        $getmembers = DB::table('user_group')->where('group_id', '=', $exam_details->group_id)->get();
      
        $getexams = DB::table('exams')->where('group_id', '=', $exam_details->group_id)->where('isArchived', '!=', 1)->get();
      
        $members = array();
     
      
        $arraykey = 0;
        foreach($getmembers as $getmember)
        {
          
            $user_info = DB::table('users')->where('id', '=', $getmember->user_id)->first();
          
            $members[$arraykey]['name'] =  $user_info->name;
            $members[$arraykey]['id'] =  $user_info->id;
            $members[$arraykey]['isFaculty'] =  $user_info->isFaculty;
            $arraykey++;
        }
      
        $data['exams'] = $getexams;  
      
        $data['members'] = $members;
      
        $groups = DB::table('groups')->where('id', '=', $exam_details->group_id)->first();
      
        $code = $groups->code;
      
        $data['code'] = $code;
      
        if($groups->isArchived==0)
        {
          $user_groups = DB::table('user_group')->where('user_id', '=', auth()->user()->id)->get();
              
                  foreach ($user_groups as $user_group) {
                          if($user_group->group_id == $groups->id)
                          {
                            $authenticated = TRUE;
                          }
                  }

                if($authenticated == TRUE)
                {
                  if (auth()->user()->isFaculty == 1) 
                  {
                    
                      return view('faculty/group')->with($data);
                  }
                }
        }
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
        $subjectiveItems = 0;
      
        $hasSubjective = 0;
      
        $correctAnswerCount = 0;
        $aftersaveAnswerCount = 0;
      
        $arrayAnswerChecker = array();
        $questionArray = array();
        foreach($_POST as $key => $value)
        {
          $properties = explode("|", $key);
          
          $temp_question = 0;
          
          
          if($properties[0]=='question')
          {
            $totalItems++;
            
            
            $question_num = $properties[1];
            $question_id = $properties[2];
            $question_type = $properties[3];
            
            $temp_question = $question_id;
            
            
            $questionFromDB = DB::table('questions')->where('id', '=', $question_id)->first();
            $questionArray[$question_num] = $questionFromDB->content;
            
            $arrayAnswerChecker[$question_num] = array();
            
            $subjPts = true;
            
            if($question_type=="OBJECTIVE")
            {
              $subjPts = false;
              
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
              
                DB::table('questions')->where('id', '=', $question_id)->increment('takenCount', 1);
            }
            else
            {
              $arrayAnswerChecker[$question_num]['correctAnswer'] = "SUBJECTIVE"; 
              $arrayAnswerChecker[$question_num]['yourAnswer'] = $value; 
              $arrayAnswerChecker[$question_num]['isCorrect'] = "SUBJECTIVE";
              
              $hasSubjective = 1;
              $subjectiveItems++;
            }
            
            $users_exams = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id', '=', $exam_id)->get();
           
            if($subjPts == false)
            {
              $save = DB::table('user_question_answer')->insertGetId(
               ['user_id' =>  auth()->user()->id, 'exam_id' => $exam_id, 'question_id' =>  $properties[2], 'answer' => $value, 'isCorrect' => $correctAnswerCount - $aftersaveAnswerCount, 'subjPoints' => (-1) ]);
            }
            else
            {
              $save = DB::table('user_question_answer')->insertGetId(
               ['user_id' =>  auth()->user()->id, 'exam_id' => $exam_id, 'question_id' =>  $properties[2], 'answer' => $value, 'isCorrect' => $correctAnswerCount - $aftersaveAnswerCount, 'subjPoints' => 0 ]);
            }
               
            
              $aftersaveAnswerCount = $correctAnswerCount;  
          }
          else
          {
            
          }
          
//           This is the question-data analyzer
//           
//           if($properties[0]=='question')
//           {
//           $this->evaluate($temp_question);
//           }
          
      }
      
      $users_exams = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id', '=', $exam_id)->get();
            

     
      if($subjectiveItems == 0)
      {
        $totalObjMultiplier = $group_id->totalObjPts/($totalItems-$subjectiveItems);
        
        $transactionID = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id' , '=', $exam_id)->update(
         ['rawScore' => ($correctAnswerCount*$totalObjMultiplier),'obj_score' => ($correctAnswerCount*$totalObjMultiplier), 'percentScore' => round(($correctAnswerCount*$totalObjMultiplier)/($group_id->totalObjPts)*100, 2), 'toBeChecked' => $hasSubjective]
       );
      }
      else if($totalItems==$subjectiveItems)
      {
        $transactionID = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id' , '=', $exam_id)->update(
         ['rawScore' => 0,'obj_score' => 0, 'percentScore' => 0, 'toBeChecked' => $hasSubjective]
       );
      }
      else
      {
        $totalObjMultiplier = $group_id->totalObjPts/($totalItems-$subjectiveItems);
        
        $transactionID = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id' , '=', $exam_id)->update(
         ['rawScore' => ($correctAnswerCount*$totalObjMultiplier),'obj_score' => ($correctAnswerCount*$totalObjMultiplier), 'percentScore' => 0, 'toBeChecked' => $hasSubjective]
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
      
      $isAllObjective = 1;
      $subjCount = 0;
      
      foreach ($questions as $question){
        $question_id = $question->id;
        $question_type = $question->type;
        
        if($question_type=="SUBJECTIVE")
        {
          $isAllObjective = 0;
          $subjCount++;
        }
        
        $dataDB = DB::table('user_question_answer')->where('user_id', '=' , $stud_id) -> where ('exam_id' ,'=', $exam_id) -> where('question_id', '=', $question_id) -> first();
 
        if((DB::table('answers')->where('question_id', '=', $question_id)->where('isCorrect', '=', 1)->first())==NULL)
        {
          $answerArray[] = DB::table('answers')->where('question_id', '=', 0)->where('isCorrect', '=', 1)->first();
        }
        else
        {
          $answerArray[] = DB::table('answers')->where('question_id', '=', $question_id)->where('isCorrect', '=', 1)->first();
        }
        
        if($dataDB==NULL)
        {
          $myanswerArray[] = DB::table('user_question_answer')->where('user_id', '=' , 0) -> where ('exam_id' ,'=', 0) -> where('question_id', '=', 0) -> first();
          $isCorrectArray[] = 0;
        }
        else
        {
          $myanswerArray[] = $dataDB;
          $isCorrectArray[] = $dataDB->isCorrect;
        }
        
        
         }
      
        $exam_details = DB::table('exams')->where('id', '=', $exam_id)->first();
      
        if($subjCount!=$exam_details->items)
        {
          $multiplierObj = ($exam_details->totalObjPts / ($exam_details->items - $subjCount));
        }
        else
        {
          $multiplierObj = 1;
        }
      
        $exam_user_details = DB::table('exam_user')->where('exam_id', '=', $exam_id)->where('user_id', '=', $stud_id)->first();
      
        $data['answerArray'] = $answerArray;
        $data['questionsArray'] = $questions; 
        $data['myanswerArray'] = $myanswerArray; 
        $data['student_name'] = DB::table('users') -> where('id' , '=', $stud_id) -> value('name');
        $data['student_id'] = $stud_id;
        $data['exam_id'] = $exam_id;
        $data['isCorrect'] = $isCorrectArray;
      
        $data['isAllObjective'] = $isAllObjective;
        $data['multiplierObj'] = $multiplierObj;
        $data['allowUpdate'] = $exam_user_details->toBeChecked;
        
       return view('faculty/getresult')->with($data);

   }
  
  
   function recheckans(Request $request,int $exam_id){
    
                    $users_exams = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id', '=', $exam_id)->get();

                    $exam_group = DB::table('exams')->where('id', '=', $exam_id)->first();

                    $users_groups = DB::table('user_group')->where('user_id', '=',auth()->user()->id)->get();

                    $allowView = false;

                    $data['group_id'] = $exam_group->group_id;

                    $date = $exam_group->schedule;
                    $now = new DateTime();

                    $todaysDate = date_format($now, 'Y-m-d');

                    foreach($users_groups as $user_group)
                    {
                      if($exam_group->group_id == $user_group->group_id)
                      {
                        $allowView = true;
                      }
                    }

            if(empty($users_exams))
                    {
                      if(auth()->user()->isFaculty == 1)
                      {
                        return redirect('../viewexam/'.$exam_group->group_id.'/'.$exam_id);
                      }
                      else{
                        Alert::error('You\'re not allowed to view this exam!', 'Invalid Entry!');
                      return redirect('../group/'.$exam_group->group_id)->with($data);
                      }
                    }
                    else if($allowView==false)
                    {

                      if(auth()->user()->isFaculty == 1)
                      {
                        return redirect('../viewexam/'.$exam_group->group_id.'/'.$exam_id);
                      }
                      else{
                        Alert::error('You\'re not allowed to view this exam!', 'Invalid Entry!');
                        return redirect('../group/'.$exam_group->group_id)->with($data);
                      }
                      
                    }
                       else
                    {
                      $stud_id = auth()->user()->id;
                       $answerArray = array();
                      $myanswerArray = array();
                      $isCorrectArray = array();
                      $realquestionsArray = array();
                      $questions = array();

                      $questionsDB=DB::table('exam_question')->where('exam_id' , '=' , $exam_id)->get(); 

                      foreach($questionsDB as $temp){
                        $questions[]=DB::table('questions')->where('id', '=', $temp->question_id)->first();
                      }
                      
                      $subjCount = 0;

                      foreach ($questions as $question){
                        $question_id = $question->id;
                        $question_type = $question->type;
                        
                        if($question_type=="SUBJECTIVE")
                        {
                          $subjCount++;
                        }

                        $dataDB = DB::table('user_question_answer')->where('user_id', '=' , $stud_id) -> where ('exam_id' ,'=', $exam_id) -> where('question_id', '=', $question_id) -> first();

                        if((DB::table('answers')->where('question_id', '=', $question_id)->where('isCorrect', '=', 1)->first())==NULL)
                        {
                          $answerArray[] = DB::table('answers')->where('question_id', '=', 0)->where('isCorrect', '=', 1)->first();
                        }
                        else
                        {
                          $answerArray[] = DB::table('answers')->where('question_id', '=', $question_id)->where('isCorrect', '=', 1)->first();
                        }

                        if ($dataDB == NULL){
                          Alert::info('No answer has been detected', 'Cheating or Invalid');
                          return redirect('home');
                        }
                        $myanswerArray[] = $dataDB;
                        $isCorrectArray[] = $dataDB->isCorrect;

                         }
                      
                      $exam_details = DB::table('exams')->where('id', '=', $exam_id)->first();
      
                        if($subjCount!=$exam_details->items)
                        {
                          $multiplierObj = ($exam_details->totalObjPts / ($exam_details->items - $subjCount));
                        }
                        else
                        {
                          $multiplierObj = 1;
                        }
                      
                        $exam_user_details = DB::table('exam_user')->where('exam_id', '=', $exam_id)->where('user_id', '=', $stud_id)->first();

                        $data['answerArray'] = $answerArray;
                        $data['questionsArray'] = $questions; 
                        $data['myanswerArray'] = $myanswerArray; 
                        $data['student_name'] = DB::table('users') -> where('id' , '=', $stud_id) -> value('name');
                        $data['student_id'] = $stud_id;
                        $data['exam_id'] = $exam_id;
                        $data['isCorrect'] = $isCorrectArray;
                      
                         $data['multiplierObj'] = $multiplierObj;
                      $data['allowUpdate'] = $exam_user_details->toBeChecked;

                      return view('student/review')->with($data);
                    }
  }
  
  
  //-------------------------------------------------------------------------------------------------------------
  
//   1. Upon checking send to evaluate with question_id?
//   2. 
  public function arrangeByHighest($a, $b)
                        {
                            return $b->objScore - $a->objScore;
                        }
  
  public function arrangeByLowest($a, $b)
                        {
                            return  $a->objScore - $b->objScore;
                        }
  
  
  public function evaluate($q_id)
  {
    
    $examsContainingQuestion = DB::table('exam_question')->where('question_id', '=', $q_id)->get();
    
    
    foreach($examsContainingQuestion as $examContainingQuestion)
    {
      $studentsWhoHadTakenHigh = DB::table('exam_user')->where('exam_id', '=', $examContainingQuestion->exam_id)->get();
      $studentsWhoHadTakenLow = DB::table('exam_user')->where('exam_id', '=', $examContainingQuestion->exam_id)->get();
    
    
//     $counter = 0;
//     foreach($studentsWhoHadTaken as $studentWhoHadTaken)
//     {
//       $studentList[$counter]['score'] = $studentWhoHadTaken->objScore;
//       $studentList[$counter]['id'] = $studentWhoHadTaken->user_id;
//       $counter++;
//     }
    
      usort($studentsWhoHadTakenHigh,array($this, "arrangeByHighest"));
      usort($studentsWhoHadTakenLow, array($this, "arrangeByLowest"));
    
    }
    
    $take = DB::table('questions')->where('id', '=', $q_id)->first();
    $takenCount = $take->takenCount;
    
    $takenHighCorrect = array();
    $countTakenHighCorrect = 0;
    foreach($studentsWhoHadTakenHigh as $studentWhoHadTakenHigh)
    {
      $isCorrect = DB::table('user_question_answer')->where('user_id', '=', $studentWhoHadTakenHigh->user_id)->where('question_id', '=', $q_id)->first();
      
      $takenHighCorrect[] = $isCorrect->isCorrect;
    }
    for($x = 0; $x < floor($takenCount*0.27); $x++)
    {
      if($takenHighCorrect[$x]==1)
      {
        $countTakenHighCorrect++;
      }
    }
    
    $takenLowCorrect = array();
    $countTakenLowCorrect = 0;
    foreach($studentsWhoHadTakenLow as $studentsWhoHadTakenLow)
    {
      $isCorrect = DB::table('user_question_answer')->where('user_id', '=', $studentsWhoHadTakenLow->user_id)->where('question_id', '=', $q_id)->first();
      
      $takenLowCorrect[] = $isCorrect->isCorrect;
    }
    for($x = 0; $x < floor($takenCount*0.27); $x++)
    {
      if($takenLowCorrect[$x]==1)
      {
        $countTakenLowCorrect++;
      }
    }
    
    if(floor($takenCount*0.27)!=0)
    {
      $upperPercent = $countTakenHighCorrect/floor($takenCount*0.27);
      $lowerPercent = $countTakenLowCorrect/floor($takenCount*0.27);
    }
    else
    {
      $upperPercent = 0;
      $lowerPercent = 0;
    }
    
    DB::table('questions')->where('id','=', $q_id)->update(['dis_index' => ($upperPercent-$lowerPercent), 'dif_level' => (($upperPercent+$lowerPercent)/2)]);

    
  }
}