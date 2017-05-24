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
            $content = $request->input('content');
            
            // GETTING NECESSARY DATA
            if($type == 'OBJECTIVE')
            {
              $subtype = $request->input('subtype');
              
              if($subtype == 'IDENTIFICATION')
              {
                $answer = $request->input('answer');
              }
              else if($subtype == 'MULTIPLECHOICE')
              {
                $choiceCount = $request->input('choiceCount');
                
                $correctAnswers = array();
                $correctAnswers = $request->input('correctAnswers');
                
                $choices = array();
                
                for($counter = 1; $counter <= $choiceCount; $counter++)
                {
                  $choices[$counter] = $request->input('choice'.$counter);
                }
              }
              else
              {
                
              }
            }
            else
            {
              $subtype = "NONE";
              $answer == NULL;
            }

            // ADDING THE QUESTION TO DATABASE
             $question_id = DB::table('questions')->insertGetId(
                ['course' =>  $course, 'type' => $type, 'subtype' => $subtype, 'content' => $content,  'creator_id' => auth()->user()->id]
             );
            
            // ADDING IDENTIFICATION ANSWER TO DATABASE
            if($subtype == 'IDENTIFICATION')
            {
              DB::table('answers')->insertGetId(
                        ['value' =>  $answer, 'question_id' => $question_id, 'isCorrect' => 1]
                     );
            }
            
            // ADDING MULTIPLE CHOICE ANSWER TO DATABASE
            else if($subtype == 'MULTIPLECHOICE')
            {
              for($counter = 1; $counter <= $choiceCount; $counter++)
              {
                $isCorrect = 0;
                
                foreach($correctAnswers as $correctAnswer)
                  {
                    if($correctAnswer == $counter)
                    {
                      $isCorrect = 1;
                    }
                  }
                
                DB::table('answers')->insertGetId(
                        ['value' =>  $choices[$counter], 'question_id' => $question_id, 'isCorrect' => $isCorrect]
                     );
              }
            }
            else
            {
              
            }
            
                     
                     echo 'Added successfully.';
            

                      return view('faculty/questionbank');
           
          }
         else
          {
             
          }

    }
  
  public function edit($id)
    {
        $data['id'] = $id;
      
        if (auth()->user()->isFaculty == 1) 
          {
            
            $questions = DB::table('questions')->where('id', '=', $id)->get();
            
            foreach($questions as $question)
            {
              $data['course'] = $question->course;
              $data['type'] = $question->type;
              $data['content'] = $question->content;
            }
            
            $answers = DB::table('answers')->where('question_id', '=', $id)->get();
            
            foreach($answers as $answer)
            {
              $data['value'] = $answer->value;
            }
            
            return view('faculty/editquestion')->with($data);
           
          }
         else
          {
             
          }
      
    }
  
  
   public function delete($id)
    {
        $data['id'] = $id;
      
        if (auth()->user()->isFaculty == 1) 
          {
            $question = DB::table('questions')->where('id', '=', $id)->update(['isArchived' => 1]);
            echo 'DELETED SUCESSFULLY';
            return view('faculty/editquestion');
           
          }
         else
          {
             
          }
      
    }
  

}
