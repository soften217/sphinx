<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Eloquent;
use Alert;

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
        if (auth()->user()->isFaculty == 1) 
        {
            return view('faculty/formquestion');
        }
       else
        {
            return view('student/home');
        }
      }
    }
  
  public function form(Request $request)
    {
        if (auth()->user()->isFaculty == 1) 
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
            
            
            
            
            $course  = $request->input('course');
            $type = $request->input('type');
            $content = $request->input('content');
            $topic = $request->input('topic');
            
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
              $answer = NULL;
            }

            // ADDING THE QUESTION TO DATABASE
             $question_id = DB::table('questions')->insertGetId(
                ['course' =>  $course, 'topic' => $topic, 'type' => $type, 'subtype' => $subtype, 'content' => $content,  'creator_id' => auth()->user()->id]
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
           
      
            $data['courseQ'] = $group->course;
            $data['sortBy'] = "cmpCourse";
            
                     
                     Alert::success('Question has been added to the Question Bank!', 'Success!');
            

                      return view('faculty/questionbank')->with($data);
           
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
            
            $group = DB::table('groups')->where('creator_id', '=', auth()->user()->id)->first();
            
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
      
            $data['courseQ'] = $group->course;
            $data['sortBy'] = "cmpCourse";
            
            Alert::success('Question #'.$id.' has been removed from the Question Bank.', 'Success!');
            
            return view('faculty/questionbank')->with($data);
           
          }
         else
          {
             
          }
      
    }
  

}
