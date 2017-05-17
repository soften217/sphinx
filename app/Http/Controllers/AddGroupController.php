<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Eloquent;

class AddGroupController extends Controller
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
            return view('faculty/addgroup');
        }
       else
        {
            return view('student/addgroup');
        }
    }
  
    public function add(Request $request)
    {
        if (auth()->user()->isFaculty == 1) 
          {
            $course  = $request->input('course');
            $section = $request->input('section');
            $yearStart = $request->input('year');
            $yearEnd = $yearStart + 1;
            $term = $request->input('term');
            
            $id = $course . '-' . $section . '-' . ($yearStart-2000) . ($yearEnd-2000) . '-T' . $term;
            
            $check_id = DB::table('groups')->where('id', '=', $id)->first();
            
            if($check_id==NULL)
            {
                    $code = str_random(8);
                    $check = DB::table('groups')->where('code', '=', $code)->first();

                     while(!($check==NULL) )
                     {
                       $code = str_random(8);
                       $check = DB::table('groups')->where('code', '=', $code)->first();
                     }

                     DB::table('groups')->insert(
                        ['id' => $id , 'course' =>  $course, 'section' => $section, 'year_start' => $yearStart, 'year_end' => $yearEnd, 'term' => $term, 'code' => $code, 'creator_id' => auth()->user()->id]
                     );

                     $user_group = DB::table('user_group')->insertGetId(
                        ['user_id' =>  auth()->user()->id, 'group_id' => $id]
                     );

                     echo 'Added successfully.';

                      return view('faculty/addgroup');
            }
            else
            {
              echo 'There is already an existing group for that!';
            }
          }
         else
          {
              $code = $request->input('code');
            
              $check_code = DB::table('groups')->where('code', '=', $code)->first();
              
              if(!($check_code==NULL))
              {
                    $id = $check_code->id;
                    $isArchived = $check_code->isArchived;

                    if($isArchived==0)
                    {
                      $check_existing = DB::table('user_group')->where('user_id', '=', auth()->user()->id)->where('group_id', '=', $id)->first();

                      if($check_existing==NULL)
                      {
                        $user_group = DB::table('user_group')->insertGetId(
                        ['user_id' =>  auth()->user()->id, 'group_id' => $id]
                         );

                         
                        return view('student/addgroup');
                        }
                        else
                        {
                          return view('errors/derror', ['notify' => 'Sorry, that group has already been archived.'] );
                        }
                    }
                else
                {
                  return view('errors/derror', ['notify' => 'Sorry, that group has already been archived.']);
                }
              }
              else
              {
                //alert()->error('Error Message', 'We cannot find the group you are looking for');
                return view('errors/derror', ['notify' => 'We cannot find the group you are looking for']);
              }
          }
    }
  
    

}
