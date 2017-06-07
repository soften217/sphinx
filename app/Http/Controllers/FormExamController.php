<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Eloquent;
use Alert;
use DateTime;

class FormExamController extends Controller
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
            return view('faculty/formexam');
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
            $group  = $request->input('group');
            $selected = $request->input('selecteditems');
            
            $name = $request->input('name');
            $topic = $request->input('topic');
            
            $pointsPerObj = $request->input('objpoints');
            $pointsPerSubj = $request->input('subjpoints');
            
            $totalObjPts = 0;
            $totalSubjPts = 0;
            
            $hours = $request->input('hours');
            $minutes = $request->input('minutes');
            
            $duration = ($hours*3600000) + ($minutes*60000);
            
//             foreach ($selected as $selectedOption)
//             {
//               $result_explode = explode('|', $selectedOption);
//               echo $result_explode[0] ."+";
//             }
            
            
        $data['id'] = $group;
        $groups = DB::table('groups')->where('id', '=', $group)->first();
        $code = $groups->code;
        $data['code'] = $code;
            
        $availabledate = $request->input('availabledate');
      
            
           //echo $selected;
            
            $exam_id = DB::table('exams')->insertGetId(
               ['group_id' =>  $group, 'duration' => $duration, 'creator_id' => auth()->user()->id, 'schedule' => $availabledate, 'name' => $name, 'topic' => $topic ]
              );
            
            $totalItems = 0;
            
           foreach($selected as $selectedquestion)
           {
             $possiblePoints = 1;
             
             $question = DB::table('questions')->where('content', '=', $selectedquestion)->first();
             $question_id = $question->id;
             
             if($question->type == "OBJECTIVE")
             {
               $possiblePoints = $pointsPerObj;
               $totalObjPts += $pointsPerObj;
             }
             else
             {
               $possiblePoints = $pointsPerSubj;
               $totalSubjPts += $pointsPerSubj;
             }
             
             $exam_questions = DB::table('exam_question')->insertGetId(
              ['exam_id' => $exam_id, 'question_id' => $question_id, 'possiblePoints' => $possiblePoints]
             );
             
             $totalItems++;
            }
            
            DB::table('exams')->where('id', '=', $exam_id)->update(['items' => $totalItems, 'totalObjPts' => $totalObjPts, 'totalSubjPts' => $totalSubjPts]);
                     
                     Alert::success('Exam has been created successfully!', 'Done!');

                      return back()->withInput();
              
           
          }
         else
          {
             return back()->withInput();
          }

    }
  
  public function create($id)
    {
        $data['id'] = $id;
      
        if (auth()->user()->isFaculty == 1) 
          {
            
//             $question = DB::table('questions')->where('id', '=', $id)->get();
            
//             $data['course'] = $question->course;
//             $data['type'] = $question->type;
//             $data['content'] = $question->content;
            
//             $answer = DB::table('answers')->where('question_id', '=', $id)->get();
            
//             $data['value'] = $answer->value;


            return view('faculty/formexam')->with($data);
           
          }
         else
          {
             return back()->withInput();
          }
      
    }
  
  
   public function delete($group_id, $exam_id)
    {
        if (auth()->user()->isFaculty == 1) 
          {
            $exam = DB::table('exams')->where('id', '=', $exam_id)->update(['isArchived' => 1]);
      
            Alert::success('Exam has been deleted successfully!', 'Deletion Complete');
            
            return redirect()->action(
                  'GroupController@show', ['id' => $group_id]
              );
           
          }
         else
          {
             
          }
      
    }
  
  public function activate($id)
  {
    $today = date("Y-m-d");
    
    if (auth()->user()->isFaculty == 1) 
          {
             DB::table('exams')
            ->where('id', $id)
            ->update(['schedule' => $today]);
    
//     return redirect()->action('FormExamController@view', ['id' => $id]);
    
    return back()->withInput();
           
          }
         else
          {
             return back()->withInput();
          }
    
   
  }
  
  
    public function view($group_id, $id)
    {
        $data['id'] = $id;
      
        $data['group_id'] = $group_id;
      
      $exam = DB::table('exams')->where('id', '=', $id)->first();
      
      $data['duration'] = $exam->duration;
        
      
        $questions = DB::table('exam_question')->where('exam_id', '=', $id)->get();
        $availability = $exam -> schedule;
            
            $question_count = 0;
            
            $arrayQuestions = array();
            
            foreach ($questions as $question)
            {
              $questionProper = DB::table('questions')->where('id', '=', $question->question_id)->first();
              
              $arrayQuestions[$question_count] = array();
              $arrayQuestions[$question_count]['id'] = $questionProper->id;
              $arrayQuestions[$question_count]['content'] = $questionProper->content;
              $arrayQuestions[$question_count]['type'] = $questionProper->type;
              $arrayQuestions[$question_count]['subtype'] = $questionProper->subtype;
              
              $choiceCount = 0;
              
              if($questionProper->subtype=="MULTIPLECHOICE")
              {
                $choices = array();
                $answersProper = DB::table('answers')->where('question_id', '=', $question->question_id)->get();
                
                foreach($answersProper as $answerProper)
                {
                  $choices[$choiceCount]['value'] = $answerProper->value;
                  $choiceCount++;
                }
                $arrayQuestions[$question_count]['choices'] =  $choices;
              }
              
              $arrayQuestions[$question_count]['choiceCount'] = $choiceCount;
              
              if($questionProper->type=="OBJECTIVE")
              {
                $answer = DB::table('answers')->where('question_id', '=', $questionProper->id)->where('isCorrect', '=', 1)->first();
                $arrayQuestions[$question_count]['answer'] = $answer->value;
              }
              else
              {
                $arrayQuestions[$question_count]['answer'] = "SUBJECTIVE";
              }
              
              $question_count++;
            }
            
            $data['arrayQuestions'] = $arrayQuestions;
            $data['availabledate'] = $availability;
            
      
        if (auth()->user()->isFaculty == 1) 
          {
//             foreach($arrayQuestions as $arrayQuestion)
//             {
//               echo $arrayQuestion['id'] . "\n";
//               echo $arrayQuestion['content'] . "\n";
//               echo $arrayQuestion['type'] . "\n";
//             }
            
            return view('faculty/viewexam')->with($data);
            
           
          }
         else
          {
            $users_exams = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id', '=', $id)->get();
            
            $exam_group = DB::table('exams')->where('id', '=', $id)->first();
            
            $users_groups = DB::table('user_group')->where('user_id', '=',auth()->user()->id)->get();
            
            $allowTake = false;
            
            $date = $exam_group->schedule;
            $now = new DateTime();
            
            $todaysDate = date_format($now, 'Y-m-d');
            
            foreach($users_groups as $user_group)
            {
              if($exam_group->group_id == $user_group->group_id && (($date == $todaysDate)||$date==NULL))
              {
                $allowTake = true;
              }
            }
            
            if(!empty($users_exams))
            {
//               Alert::error('You\'ve already taken this exam!', 'Invalid Entry!');
              return redirect('../viewexam/'.$id)->with($data);
            }
            else if($allowTake==false)
            {
              
              Alert::error('You\'re not allowed to take this exam!', 'Invalid Entry!');
              return redirect('../group/'.$group_id)->with($data);
            }
               else
            {
              $transactionID = DB::table('exam_user')->insertGetId(
              ['user_id' =>  auth()->user()->id, 'exam_id' => $id, 'isTaken' => 1, 'rawScore' => 0, 'percentScore' => 0, 'toBeChecked' => 0]
             );
              
              return view('student/viewexam')->with($data);
            }
            
             
          }
      
    }
  

}
