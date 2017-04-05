<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

use Illuminate\Http\Request;

class CalendarController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index() { //code should be inside a method
        $events[] = \Calendar::event(
            'Event One', //event title
            false, //full day event?
            '2016-04-01T0800', //start time (you can also use Carbon instead of DateTime)
            '2016-04-01T1200', //end time (you can also use Carbon instead of DateTime)
            0 //optionally, you can specify an event ID
        );
      
        //$eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event  

        
        $calendar = \Calendar::addEvents($events) //add an array with addEvents
            ->setOptions([ //set fullcalendar options
                'firstDay' => 1
            ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                'viewRender' => 'function() {alert("Callbacks!");}'
        ]); 
 
      
        return view('calendar', compact('calendar'));
    }

}