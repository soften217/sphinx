<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Eloquent;

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
            
//             foreach ($selected as $selectedOption)
//             {
//               $result_explode = explode('|', $selectedOption);
//               echo $result_explode[0] ."+";
//             }
            
            
        $data['id'] = $group;
        $groups = DB::table('groups')->where('id', '=', $group)->first();
        $code = $groups->code;
        $data['code'] = $code;
      
            
           //echo $selected;
            
            $exam_id = DB::table('exams')->insertGetId(
               ['group_id' =>  $group, 'creator_id' => auth()->user()->id]
              );
            
            
            
           foreach($selected as $selectedquestion)
           {
             $question = DB::table('questions')->where('content', '=', $selectedquestion)->first();
             
             $question_id = $question->id;
             
             $exam_questions = DB::table('exam_question')->insertGetId(
              ['exam_id' => $exam_id, 'question_id' => $question_id]
             );
            }
                     
                     echo 'Added successfully.';

                      return view('faculty/group')->with($data);
              
           
          }
         else
          {
             
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
             
          }
      
    }
  
  
   public function delete($group_id, $exam_id)
    {
        if (auth()->user()->isFaculty == 1) 
          {
            $exam = DB::table('exams')->where('id', '=', $exam_id)->update(['isArchived' => 1]);
            echo 'DELETED SUCESSFULLY';
            
            
            return redirect()->action(
                  'GroupController@show', ['id' => $group_id]
              );
           
          }
         else
          {
             
          }
      
    }
  
  
    public function view($id)
    {
        $data['id'] = $id;
      
        $questions = DB::table('exam_question')->where('exam_id', '=', $id)->get();
            
            $question_count = 0;
            
            $arrayQuestions = array();
            
            foreach ($questions as $question)
            {
              $questionProper = DB::table('questions')->where('id', '=', $question->question_id)->first();
              
              $arrayQuestions[$question_count] = array();
              $arrayQuestions[$question_count]['id'] = $questionProper->id;
              $arrayQuestions[$question_count]['content'] = $questionProper->content;
              $arrayQuestions[$question_count]['type'] = $questionProper->type;
              
              if($questionProper->type=="OBJECTIVE")
              {
                $answer = DB::table('answers')->where('question_id', '=', $questionProper->id)->first();
                $arrayQuestions[$question_count]['answer'] = $answer->value;
              }
              else
              {
                $arrayQuestions[$question_count]['answer'] = "SUBJECTIVE";
              }
              
              $question_count++;
            }
            
            $data['arrayQuestions'] = $arrayQuestions;
            
      
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
             return view('student/viewexam')->with($data);
          }
      
    }
  

}
