<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo e($id); ?> </div>

                <div class="panel-body">
                    This is a sample STUDENT Group page.
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
                         <th width=50px>ID</th> 
                        <th width=150px>Take Exam</th>
                        <th width=50px>Score</th>
                        <th width=50px>Grade</th>
                      </tr>
                        
                    
                     <?php
                      $exams = DB::table('exams')->where('group_id', '=', $id)->get();
                              foreach ($exams as $exam) {
                                if($exam->isArchived==0)
                                {                                               
                                    $exam_id = $exam->id;
                                  
                                    $verifyExamEntry = DB::table('exam_user')->where('user_id', '=', auth()->user()->id)->where('exam_id', '=', $exam_id)->first();
                                    
                                  
                                    if(count($verifyExamEntry)==null)
                                    {
                                      echo '<tr> 
                                    <td> '.$exam_id .' </td>
                                    <td><a href="/viewexam/'.$exam_id.'" onclick="return theFunction();">TAKE EXAM</a></td>
                                    <td> ----- </td>
                                    <td> ----- </td>
                                    </tr>';
                                    }
                                    else if ($verifyExamEntry->isTaken==0)
                                    {
                                    echo '<tr> 
                                    <td> '.$exam_id .' </td>
                                    <td><a href="/viewexam/'.$exam_id.'" onclick="return theFunction();">TAKE EXAM</a></td>
                                    <td> ----- </td>
                                    <td> ----- </td>
                                    </tr>';
                                    }
                                    else {
                                    echo '<tr> 
                                    <td> '.$exam_id .' </td>
                                    <td>ALREADY TAKEN</td>
                                    <td> '.$verifyExamEntry->rawScore .' </td>
                                    <td> '.$verifyExamEntry->percentScore .'% </td>
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
>>>>>>> 2122ce65bcb88e274b35a1b6670bd7a117a259ea
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>