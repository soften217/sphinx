<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
<!--           <table>
            <tr>
            <td style="width:50px">
              <button onclick="goBack()"><<</button>
              </td>
              <td>
              Go back to Group Page
              </td>
            </tr>
          </table> -->
           <br>
            <div class="panel panel-default">
                <div class="panel-heading">Exam/Quiz Results of <?php echo e($student_name); ?></div>

                <div class="panel-body">
                   <form class="form-horizontal" role="form" method="POST" action="/updategrades/<?php echo e($student_id); ?>/<?php echo e($exam_id); ?>">
                      <?php echo e(csrf_field()); ?>

                     <table>
                       <tr>
                       <th width="5%">No.</th>
                       <th width="25%">Questions</th>
                       <th width= "15%">Correct Answer</th>
                       <th width= "25%">Your Answer</th>
                       <th width= "15%">Is Correct?</th>
                       <th width= "15%">Points Earned</th>
                       </tr>
                       
                       <?php
                       
                       $questionDisplay = array();
                       $questionType = array();
                       
                       $answerDisplay = array();
                       $myAnswerDisplay = array();
                       
                       foreach($questionsArray as $questionArray)
                       {
                         $questionDisplay[]=$questionArray->content;
                         $questionType[]=$questionArray->type;
                       }
                       
                       foreach($answerArray as $ansArray)
                       {
                         $answerDisplay[]=$ansArray->value;
                       }
                       
                       foreach($myanswerArray as $myansArray)
                       {
                         $myAnswerDisplay[]=$myansArray->answer;
                       }
                       
                       
                       $count=0;
                       
                       foreach($questionsArray as $questionArray)
                       {
                         echo '<tr>';
                         echo '<td>' . ($count+1). '</td>';
                         echo '<td>' . $questionDisplay[$count]. '</td>';
                         echo '<td>' . $answerDisplay[$count]. '</td>';
                         echo '<td>' . $myAnswerDisplay[$count]. '</td>';
                         
                         if($isCorrect[$count]==1)
                         {
                           echo '<td>YES</td>';
                         }
                         else if($questionType[$count]=="SUBJECTIVE")
                         {
                           echo '<td>To be checked</td>';
                         }
                         else
                         {
                           echo '<td>NO</td>';
                         }
                         
                         if($questionType[$count]=="SUBJECTIVE")
                         {
                            echo '<td><input name="points[]" type="number" min=0 max=30 step="5" value="0"/> pts</td>';
                         }
                         else if($isCorrect[$count]==1)
                         {
                             echo '<td>1 pt</td>';
                         }
                         else
                         {
                              echo '<td>0 pt</td>';
                         }
                         echo '</tr>';
                         
                         $count++;
                       }
                       
                       ?>
                       <tr><td>
                         <br><br>
                         
                      <input type="submit" value="Update Grades">
                        </td></tr>
                       
                  </table>
                  </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>