<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Eloquent;
use Alert;

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

                     Alert::success('Group was added sucessfully', 'Success!');
                    return redirect('/group/'.$id);
//                       return view('faculty/'.$id);
//                return view('faculty/home');
            }
            else
            {
              Alert::info('There is already an existing group for that!', 'Existing Group');
              return view('faculty/addgroup');
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

                        Alert::success('Group was added sucessfully', 'Success!');
                        return redirect('/group/'.$id);
                        }
                        else
                        {
                          Alert::error('Sorry, that group has already been archived.','Error');
                          return view('student/addgroup');
                        }
                    }
                else
                {
                  Alert::warning('Sorry, that group has already been archived','Archived Group');
                  return view('student/addgroup');
                }
              }
              else
              {
                //alert()->error('Error Message', 'We cannot find the group you are looking for');
                Alert::error('We cannot find the group you are looking for','Error');
                return view('student/addgroup');
              }
          }
    }
  
    

}
