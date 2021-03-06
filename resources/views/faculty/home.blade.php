@extends('layouts.app')

@section('content')

 @if (Session::has('sweet_alert.alert'))
    <script>
      swal({!!Session::get('sweet_alert.alert') !!});
    </script>
    <?php Session::forget('sweet_alert'); ?> @endif

<style>
  /* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 150px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 30%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
    padding: 2px 16px;
    background-color: #5cb85c;
    color: white;
}
  
/* ////////////////////////////////////////// */
  
  .yellowColor{
    color: yellow;
}
  
    .blueColor{
    color: #6fa1f2;
}
  
  .dateIsToday{
    background: #6fa1f2;
}
  
.dateHasSched{
    background: yellow;
}
  
.addtdBtn {
    width: 100%;
    color: #555;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s;
}

.addtdBtn:hover {
    background-color: #bbb;
}
</style>

<!-- <script src="js/sweetalert.min.js"></script> -->

    <!-- Include this after the sweet alert js file -->
<!--     @include('sweet::alert') -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                  <p> Welcome to iQUIZ!</p>
                  <p><i>Secure. Efficient. Accurate.</i></p> <br/>
              <p>iQuiz' secure, professional quiz system is an easy-to-use, customizable online quiz maker and  for training & educational assessment with tests & quizzes graded instantly saving you hours of paperwork!</p><br/>
              <p>Let's go ahead and start creating quizzes! </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-6 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;&nbsp;Calendar</div>

                <div class="panel-body">
                      
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

                    <?php
                  
                    $trigger = 0;
                  
                    $scheduledExams = (DB::table('exams')
                                       ->where('schedule', '!=', NULL)
                                       ->where('isArchived', '!=', 1)
                                       ->where('creator_id', '=', auth()->user()->id)
                                       ->get());
                  
                    $schedules = array();
                    $ids = array();
                    $coursesExams = array();
                    $nameExams = array();
                  
                    foreach($scheduledExams as $scheduledExam)
                    {
                       $schedules[]=$scheduledExam->schedule;
                       $ids[$scheduledExam->schedule][]=$scheduledExam->id;
                       $coursesExams[$scheduledExam->schedule][]=$scheduledExam->group_id;
                       $nameExams[$scheduledExam->schedule][]=$scheduledExam->name;
                    }
                  
                    $uniqueScheds = array_unique($schedules);
                    
                    /* Set the date */
                    $date = strtotime(date("Y-m-d"));

                    $day = date('d', $date);
                    $month = date('m', $date);
                    $year = date('Y', $date);
                    $firstDay = mktime(0,0,0,$month, 1, $year);
                    $title = strftime('%B', $firstDay);
                    $dayOfWeek = date('D', $firstDay);
                    $daysInMonth = cal_days_in_month(0, $month, $year);
                    /* Get the name of the week days */
                    $timestamp = strtotime('next Sunday');
                    $weekDays = array();
                    for ($i = 0; $i < 7; $i++) {
                      $weekDays[] = strftime('%a', $timestamp);
                      $timestamp = strtotime('+1 day', $timestamp);
                    }
                    $blank = date('w', strtotime("{$year}-{$month}-01"));
                  
                    // Today's Exams
                  
                    $todaysExams = DB::table('exams')
                      ->where('schedule', '=', ($year.'-'.$month.'-'.$day))
                     ->where('isArchived', '!=', 1)
                     ->where('creator_id', '=', auth()->user()->id)
                      ->get();

                    $todaysExamsArray = array();
                  
                    $todaysExamsStringID = "";
                    $todaysExamsStringCourse = "";
                    $todaysExamsStringName= "";

                    foreach($todaysExams as $todaysExam)
                    {
                      $todaysExamsArray[] = $todaysExam->id;
                      $todaysExamsStringID .= $todaysExam->id . ",";
                      $todaysExamsStringCourse .= $todaysExam->group_id . ",";
                      $todaysExamsStringName .= $todaysExam->name . ",";
                    }
                  
                  
                    ?>
                    <table class='table table-bordered' style="table-layout: fixed;">
                      <tr id="list">
                        <th colspan="7" class="text-center"> <?php echo $title ?> <?php echo $year ?> </th>
                      </tr>
                      <tr id="list">
                        <?php foreach($weekDays as $key => $weekDay) : ?>
                          <td class="text-center"><?php echo $weekDay ?></td>
                        <?php endforeach ?>
                      </tr>
                      <tr id="list">
                        <?php for($i = 0; $i < $blank; $i++): ?>
                          <td></td>
                        <?php endfor; ?>
                        <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
                          <?php if($day == $i): ?>
                        
                            <?php echo '<td class="dateIsToday addtdBtn" onclick=\'todaySchedule("'.$todaysExamsStringName.'", "'.$todaysExamsStringCourse.'");\'><strong>'.$i.'</strong></td>'; ?>
                           
                          <?php else: ?>
                          <?php foreach($uniqueScheds as $uniqueSched): ?>
                         <?php 
                                if($i <= 9)
                                {
                                   $dateStringCompare = $year.'-'.$month.'-0'.$i;
                                }
                                else
                                {
                                  $dateStringCompare = $year.'-'.$month.'-'.$i;
                                }
                          ?>
                          
                          <?php if($dateStringCompare == $uniqueSched): $trigger=1;?>
                                <?php 
                        
                                   $thisExamStringID = "";
                                   $thisExamStringCourse = "";
                                   $thisExamStringName = "";
                                   
                                   $tempCounter = 0;
                                    foreach($scheduledExams as $scheduledExam)
                                   {
                                     if($dateStringCompare == $scheduledExam->schedule)
                                     {
                                       $thisExamStringID .= $ids[$scheduledExam->schedule][$tempCounter] . ",";
                                        $thisExamStringCourse .= $coursesExams[$scheduledExam->schedule][$tempCounter] . ",";
                                       $thisExamStringName .= $nameExams[$scheduledExam->schedule][$tempCounter] . ",";
                                        $tempCounter++;
                                     }
                                        
                                   }
                        
                                    echo '<td class="dateHasSched addtdBtn" onclick=\'showExams("'.$thisExamStringName.'", "'.$thisExamStringCourse.'", "'.$uniqueSched.'");\'>'.$i.'</td>'; 
                              ?>
                          <?php else: ?>
                        
                          <?php endif; ?>
                        
                          <?php endforeach; ?>
                        
                        <?php if($trigger==0): ?>
                            <td class="addtdBtn"><?php echo $i ?></td>
                         <?php else: $trigger=0; ?>
                        
                         <?php endif; ?>
                        
                          <?php endif; ?>
                          <?php if(($i + $blank) % 7 == 0): ?>
                            </tr><tr id="list">
                          <?php endif; ?>
                        <?php endfor; ?>
                        <?php for($i = 0; ($i + $blank + $daysInMonth) % 7 != 0; $i++): ?>
                          <td></td>
                        <?php endfor; ?>
                      </tr>
                    </table>
                    
                  <div>
                    
                    <p><i class="fa fa-square yellowColor" aria-hidden="true"></i> &emsp; Has scheduled exams/quizzes</p>
                     <p><i class="fa fa-square blueColor" aria-hidden="true"></i> &emsp; Today's Date</p>
                    
                  </div>
                  
                </div>
            </div>
        </div>
      
      
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-6 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-thumb-tack" aria-hidden="true"></i>&nbsp;&nbsp;To Do List</div>

                <div class="panel-body">
                      
                    <div class="wrap">
<div class="task-list">
                            
     <form action="/addtask" method="POST" class="form-horizontal">
                          {{ csrf_field() }}

                          <!-- Task Name -->
                          <div class="form-group">
                              <label for="task-name" class="col-sm-3 control-label">Task</label>

                              <div class="col-sm-6">
                                  <input type="text" name="task" id="task-name" class="form-control">
                              </div>
                          </div>

                          <!-- Add Task Button -->
                          <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-6">
                                  <button type="submit" class="btn btn-default">
                                      <i class="fa fa-plus"></i> Add Task
                                  </button>
                              </div>
                          </div>
                      </form>
                     </div>
                  </div>
              </div>
              
      
             
          </div>         
          
       @if (isset($tasktable) && count($tasktable) > 0)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Current Tasks
                                    </div>

                                    <div class="panel-body">
                                        <table class="table">

                                            <!-- Table Headings -->
                                            <thead>
                                                <th>Task</th>
                                                <th>&nbsp;</th>
                                            </thead>

                                            <!-- Table Body -->
                                            <tbody>
                                                @foreach ($tasktable as $hello)
                                                    <tr>
                                                        <!-- Task Name -->
                                                        <td class="table-text">
                                                            <div>{{ $hello->task }}</div>
                                                        </td>
                                                        <td>
                                                            <a href='./deletetask/{{$hello->id}}'>DELETE</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                          @endif
      </div>
 
</div>

<ul id="myUL">
<!--   <li id="todo">Hit the gym</li>
  <li id="todo" class="checked">Pay bills</li>
  <li id="todo">Meet George</li>
  <li id="todo">Buy eggs</li>
  <li id="todo">Read a book</li>
  <li id="todo">Organize office</li> -->
</ul>

    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
      

      
      <script>
      // Create a "close" button and append it to each list item
var myNodelist = document.getElementsByTagName("LI");
var i;
// for (i = 0; i < myNodelist.length; i++) {
//   if(myNodelist[i].attr('id')=="todo")
//     {
//       var span = document.createElement("SPAN");
//       var txt = document.createTextNode("\u00D7");
//       span.className = "close";
//       span.appendChild(txt);
//       myNodelist[i].appendChild(span);
//     }
// }

// Click on a close button to hide the current list item
var close = document.getElementsByClassName("close");
var i;
for (i = 0; i < close.length; i++) {
  close[i].onclick = function() {
    var div = this.parentElement;
    div.style.display = "none";
  }
}

// Add a "checked" symbol when clicking on a list item
var list = document.querySelector('ul');
list.addEventListener('click', function(ev) {
  if (ev.target.tagName === 'LI') {
    ev.target.classList.toggle('checked');
  }
}, false);

// Create a new list item when clicking on the "Add" button
function newElement() {
  var li = document.createElement("li");
  var inputValue = document.getElementById("myInput").value;
  var t = document.createTextNode(inputValue);
  li.appendChild(t);
  if (inputValue === '') {
    alert("You must write something!");
  } else {
    document.getElementById("myUL").appendChild(li);
  }
  document.getElementById("myInput").value = "";

  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  li.appendChild(span);

  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      var div = this.parentElement;
      div.style.display = "none";
    }
  }
}
      
      </script>
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <span class="close">&times;</span>
      <h2 id="previewHeader">Question Preview</h2>
    </div>
    <div class="modal-body">
      <p id="questionContent"></p>
    </div>
<!--     <div class="modal-footer">
      <h3>Preview</h3>
    </div> -->
  </div>
</div>

<script type="text/javascript">
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
// var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
// btn.onclick = function() {
//     modal.style.display = "block";
// }

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script type="text/javascript">
function showExams(examSchedStringID, examSchedStringCourse, examSched)
  {
    var resID = examSchedStringID.split(",");
    var resCourse = examSchedStringCourse.split(",");
    
    document.getElementById('previewHeader').innerHTML = "Exams/Quizzes for " + examSched;
    
    var stringContent = "<br><table style='margin: 0 auto; width:100%;'><tr><td style='width:30%; border: 1px solid gray; position: relative; padding: 12px 12px 12px 12px;'>Questionnaire</td><td style='border: 1px solid gray; position: relative; padding: 12px 12px 12px 12px;'>Course</td>";
    
    for(var x = 0; x < resID.length-1; x++)
      {
        stringContent += "<tr><td style='border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;'>"
         stringContent += resID[x] + "</td><td style='border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;''>" + resCourse[x];
        stringContent += "</td></tr>";
      }
    
    stringContent += "</table>";
    
    document.getElementById('questionContent').innerHTML = stringContent;
    
     modal.style.display = "block";
  }
  
  function todaySchedule(examSchedStringID, examSchedStringCourse)
  {
    var resID = examSchedStringID.split(",");
    var resCourse = examSchedStringCourse.split(",");
    
    document.getElementById('previewHeader').innerHTML = "Exams/Quizzes for Today";
    
    var stringContent = "<br><table style='margin: 0 auto; width:100%;'><tr><td style='width:30%; border: 1px solid gray; position: relative; padding: 12px 12px 12px 12px;'>Questionnaire</td><td style='border: 1px solid gray; position: relative; padding: 12px 12px 12px 12px;'>Course</td>";
    
    for(var x = 0; x < resID.length-1; x++)
      {
        stringContent += "<tr><td style='border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;'>"
         stringContent += resID[x] + "</td><td style='border: 1px solid gray; position: relative; padding: 12px 8px 12px 20px;''>" + resCourse[x];
        stringContent += "</td></tr>";
      }
    
    stringContent += "</table>";
    
    document.getElementById('questionContent').innerHTML = stringContent;
    
     modal.style.display = "block";
  }
</script>

@endsection


