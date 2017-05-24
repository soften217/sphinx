<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class GroupController extends Controller
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
            return view('faculty/group');
        }
       else
        {
            return view('student/group');
        }
    }

    public function show($id)
    {

        $data['id'] = $id;

        $authenticated = FALSE;

        $getmembers = DB::table('user_group')->where('group_id', '=', $id)->get();

        $getexams = DB::table('exams')->where('group_id', '=', $id)->where('isArchived', '!=', 1)->get();

        $members = array();


        $arraykey = 0;
        foreach($getmembers as $getmember)
        {

            $user_info = DB::table('users')->where('id', '=', $getmember->user_id)->first();

            $members[$arraykey]['name'] =  $user_info->name;
            $members[$arraykey]['id'] =  $user_info->id;
            $members[$arraykey]['isFaculty'] =  $user_info->isFaculty;

//             $userscores = DB::table('exam_user')->where('user_id', '=', $getmember->user_id)->get();

//             foreach($getexams as $getexam)
//             {
//               foreach($userscores as $userscore)
//               {
//                 if($userscore->exam_id == $getexam->id)
//                 {
//                   $members[$arraykey][$getexam->id] = $userscore->rawScore; //CONTINUE HERE
//                 }
//               }
//             }

            $arraykey++;
        }

        $data['exams'] = $getexams;

        $data['members'] = $members;

        $groups = DB::table('groups')->where('id', '=', $id)->first();

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
                 else
                  {
                      return view('student/group')->with($data);
                  }
                }
                else
                {
                    return view('welcome');
                }
        }
      else
      {
        echo 'Sorry. This Group has already been archived.';
      }


    }

    public function archive($id)
    {
        $data['id'] = $id;

        $allowArchive = FALSE;

      
        $group = DB::table('groups')->where('id', '=', $id)->first();

        if($group->creator_id == auth()->user()->id)
        {
          $allowArchive = TRUE;
        }

      if($allowArchive == TRUE)
      {
        DB::table('groups')
            ->where('id', $id)
            ->update(['isArchived' => 1]);

        return view('faculty/home');
      }
      else
      {
          return view('welcome');
      }

    }
}
