<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class sendmail extends Controller
{
  
  public function __construct()
    {
        $this->middleware('auth');
    }
  
  public function index()
    {
        if (auth()->guest())
        {
            return view('home');
        }
       else
        {
            return view('help/gethelp');
        }
    }
  
    public function tsend(Request $request)
    {
        echo "Data Recieved";
        $to = $request->input('to');
      
        $title = $request->input('subject');
        $message =  $request->input('message');
        $from = auth()->user()->email;
        $fromn = auth()->user()->name;
     
        $data = $request->input('message');


      echo "MAIL";
      Mail::send(['text'=>'mail'], [$data], function($message, $to, $title, $from, $fromn) {
         $message->to($to, 'Jeian Nueva')->subject
            ($title);
         $message->from($from,$fromn);
      });
      
      echo "Basic Email Sent. Check your inbox.";
    }
  
  
  public function send() {
    $from = auth()->user()->email;
    $subject = "THIS IS THE SUBJECT";

    // 'contents' key in array matches variable name used in view
    $data = array(
        'contents' => "THIS IS A FREAKING TEST"
    );

    Mail::send('mail', $data, function($message) use ($from, $subject) {
        $message->from($from, auth()->user()->email);
        $message->to('201501060@iacademy.edu.ph','Jeian Nueva')->subject($subject);
    });
    
    echo "Test";
}
  
    public function test(){
      return view('welcome');
    }
  
    public function help(){
      return view('mail');
    }
}
  

