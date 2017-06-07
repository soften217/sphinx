<?php
namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Alert;
use Auth;

class TaskController extends Controller
{
  /**
 * Display All Tasks
 */
        public function showtask(){
        $data['tasktable'] = DB::table('tasks')->where('creator',  Auth::user()->id)->get();
             return $data;
        }

      /**
       * Add A New Task
       */
      public function addtask(Request $request) {
        $task = $request->input('task');
        $save = DB::table('tasks')->insert(['task' => $task, 'creator' => Auth::user()->id]);
          return redirect('/home');
      }

      /**
       * Delete An Existing Task
       */
      public function deletetask($id) {
          $delete = DB::table('tasks')->where('creator', Auth::user()->id)->where('id', $id)->delete();
          return redirect('/home');
      }
}


