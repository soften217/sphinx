<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo e($id); ?> </div>

                <div class="panel-body">
<<<<<<< HEAD
                    List of enrolled students in this group:
                  
=======
                    This is a sample STUDENT Group page.
>>>>>>> b8dbc83003d74bbcad6f42be6a4a3550a5946e15
                </div>
            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">List of Exams/Quizzes for this group</div>

                <div class="panel-body">
                    <table>
                      <tr>
                         <th width=5%>ID</th> 
                        <th width = 25%> Topic</th>
                        <th width = 20%> Duration</th>
                        <th width = 20%> Date</th>
                        <th width= 10%>Score</th>
                        <th width= 10%>Grade</th>
                        <th width= 10%>Status</th>
                      </tr>
                        
                    
                     <?php
                      $exams = DB::table('exams')->where('group_id', '=', $id)->get();
                              foreach ($exams as $exam) {
                                if($exam->isArchived==0)
                                {                                               
                                    $exam_id = $exam->id;
                                  
                                      if($exam->duration < 60000) {
                                        $duration = $exam->duration / 1000 ; 
                                        $time = ' Seconds';
                                      }
                                      else if($exam->duration < 3600000){
                                      $duration = $exam->duration / 60000 ; 
                                      $time = ' Minutes';
                                      } else {
                                      $duration = $exam->duration / 3600000 ; 
                                      $time = ' Hours';
                                      }
                                  $availabledate = $exam ->schedule;
                                  $topic = $exam ->topic;
                                  $verifyExamEntry = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id', '=', $exam_id)->first();
                                    
                                  
                                    if(count($verifyExamEntry)==null)
                                    {
                                      echo '<tr> 
                                    <td> '.$exam_id .' </td>
                                    <td> '.$topic.'</td>
                                    <td> '.$duration.$time.' </td>
                                    <td> '.$availabledate.' </td>
                                    <td> -----</td>
                                    <td> ----- </td>
                                    <td>';
                                      
                                      if($availabledate == date("Y-m-d") || $availabledate == NULL){
                                        echo '<a href="/viewexam/'.$exam_id.'" onclick="return theFunction();">Start</a></td>';
                                      } else if($availabledate > date("Y-m-d")) {
                                        echo '<p> PLANNED </p>';
                                      } else {
                                        echo '<p> MISSED </p>';
                                      }
                                      
                                    echo '</tr>';
                                    }
                                    else if ($verifyExamEntry->isTaken==0)
                                    {
                                    echo '<tr> 
                                    <td> '.$exam_id .' </td>
                                    <td> '.$exam_id .' </td>
                                    <td> '.$topic.'</td>
                                    <td> '.$duration. ' '.$time.' </td>
                                    <td> '.$availabledate.' </td>
                                    <td> ----- </td>
                                    <td> ----- </td>
                                    <td><a href="/viewexam/'.$exam_id.'" onclick="return theFunction();">Start</a></td>
                                    </tr>';                                   
                                    }
                                    else {
                                    echo '<tr> 
                                    <td> '.$exam_id .' </td>
                                    <td> '.$topic.'</td>
                                   <td> '.$duration. ' '.$time.' </td>
                                    <td> '.$availabledate.' </td>
                                    <td> '.$verifyExamEntry->rawScore .' </td>
                                    <td> '.$verifyExamEntry->percentScore .'% </td>
                                    <td>Completed</td>
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

<script type="text/javascript">
    function theFunction () {
        if (confirm('Are you sure you want to begin this exam?')) {
          return true;
        } else {
          return false;
        }
    }
</script>
=======
>>>>>>> b8dbc83003d74bbcad6f42be6a4a3550a5946e15
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>