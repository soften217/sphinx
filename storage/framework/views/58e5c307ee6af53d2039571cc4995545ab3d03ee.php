<?php $__env->startSection('content'); ?>
<style>
  
  .blueicon{
    color: #0075ba;
  }
  
  .redicon{
    color: #c40000;
  }
  
  .greenicon{
    color: #009607
  }
  
</style>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo e($id); ?> </div>

                <div class="panel-body">
                   <p> Welcome Student to your Group Dashboard! </p>     
                  <p>
                    Click on the Quiz or Exam that you are specified to take by your professor within the alloted timeframe.
                  </p><br/>
                  <p>
                    Good luck!
                  </p>
                  
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">List of Exams/Quizzes for this group</div>

                <div class="panel-body">
                    <table style="width: 100%; text-align: center">
                      <tr id="list" style="text-align: center;">
                        <th style="text-align: center;" width=15%>Name</th> 
                        <th style="text-align: center;" width=20%>Topic</th>
                        <th style="text-align: center;" width=15%>Duration</th>
                        <th style="text-align: center;" width=20%>Date</th>
                        <th style="text-align: center;" width=10%>Score</th>
                        <th style="text-align: center;" width=10%>Grade</th>
                        <th style="text-align: center;" width=10%>Status</th>
                      </tr>
                        
                     <?php
                      $exams = DB::table('exams')->where('group_id', '=', $id)->get();
                              foreach ($exams as $exam) {
                                if($exam->isArchived==0)
                                {                                               
                                    $exam_id = $exam->id;
                                  
                                    if($exam->duration < 60000) {
                                    $duration = round(($exam->duration / 1000), 2) ; 
                                    $time = 'Seconds';
                                    }
                                    else if($exam->duration < 3600000){
                                    $duration = round(($exam->duration / 60000), 2) ; 
                                    $time = 'Minutes';
                                    } else {
                                    $duration = round(($exam->duration / 3600000), 2) ; 
                                    $time = 'Hours';
                                    }
                                  $availabledate = $exam ->schedule;
                                  $topic = $exam->topic;
                                  $name = $exam->name;
                                  $verifyExamEntry = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id', '=', $exam_id)->first();
                                  
                                    
                                  
                                    if(count($verifyExamEntry)==null)
                                    {
                                      echo '<tr id="list"> 
                                    <td> <a onclick=\'return theFunction("'.$exam_id.'");\'>'.$name .'</a> </td>
                                    <td> '.$topic.'</td>
                                    <td> '.$duration.$time.' </td>
                                    <td> '.$availabledate.' </td>
                                    <td> -----</td>
                                    <td> ----- </td>
                                    <td>';
                                      
                                      if($availabledate == date("Y-m-d") || $availabledate == NULL){
                                        echo '<a onclick=\'return theFunction("'.$exam_id.'");\'><i class="fa fa-pencil blueicon" aria-hidden="true"></i></a></td>';
//                                      echo "<a onclick=' return theFunction(this);'>Start</a> </td>"  ;
                                      } else if($availabledate > date("Y-m-d")) {
                                        echo '<p><i class="fa fa-calendar-o blueicon" aria-hidden="true"></i></p>';
                                      } else {
                                        echo '<p><i class="fa fa-times redicon" aria-hidden="true"></i></p>';
                                      }
                                      
                                    echo '</tr>';
                                    }
                                    else if ($verifyExamEntry->isTaken==0)
                                    {
                                    echo '<tr id="list"> 
                                    <td> <a onclick=\'return theFunction("'.$exam_id.'");\'>'.$name .' </a></td>
                                    <td> '.$topic.'</td>
                                    <td> '.$duration. ' '.$time.' </td>
                                    <td> '.$availabledate.' </td>
                                    <td> ----- </td>
                                    <td> ----- </td>
                                    <td><a onclick=\'return theFunction("'.$exam_id.'");\'><i class="fa fa-play blueicon" aria-hidden="true"></i></a> </td></td>
                                    </tr>';                                   
                                    }
                                    else {
                                      
                                      $exam_details = DB::table('exams')->where('id', '=', $exam_id)->first();
                                        
                                      $total = ($exam_details->totalObjPts + $exam_details->totalSubjPts);
                                      
                                    echo '<tr id="list"> 
                                    <td> <a href="../viewexam/'. $exam_id . '"/a>'.$name .' </a></td>
                                    <td> '.$topic.'</td>
                                    <td> '.$duration. ' '.$time.' </td>
                                    <td> '.$availabledate.' </td>
                                    <td> '.$verifyExamEntry->rawScore .'/'.$total.' </td>
                                    <td> '.$verifyExamEntry->percentScore .'% </td>
                                    <td><a href="../viewexam/'. $exam_id . '"/a> <i class="fa fa-check greenicon" aria-hidden="true"></i></a></td>
                                    </tr>';
                                    }
                                }
                              }
                  ?>
                   </table>
                </div>
            </div>
          
        </div>
                
    </div>
</div>

<script>
                    function theFunction(examID)
                    {
                      swal({
                    title: "Start this exam?",
                    text: "WARNING: Please comply with the following restrictions: \n\n1. Do not refresh the page.\n2. Do not resize the window.\n3. Do not switch between browser tabs or windows.\n\nIf you do any of the things mentioned above, the exam will automatically be submitted and you will no longer be able to access it.",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                  },
                  function(){
                    window.location.href ='../viewexam/<?php echo e($id); ?>/'+examID;
                  });  
                    }
  
  
            
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>