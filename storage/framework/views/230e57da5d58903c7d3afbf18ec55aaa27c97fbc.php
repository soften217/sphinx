<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <a a href="#" onclick="history.go(-1);return false;" class="btn btn-default">Go Back</a><br>
           <br>
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
                       <tr id="list">
                       <th width="5%">No.</th>
                       <th width="25%">Questions</th>
                       <th width= "15%">Correct Answer</th>
                       <th width= "25%">Student's Answer</th>
                       <th width= "15%">Is Correct?</th>
                       <th width= "15%">Points Earned</th>
                       </tr>
                       
                       <?php
                       
                       $exam_questions_details = DB::table('exam_question')->where('exam_id', '=', $exam_id)->get();
                       
                       $questionDisplay = array();
                       $questionType = array();
                       
                       $answerDisplay = array();
                       $myAnswerDisplay = array();
                       
                       $questionID = array();
                       
                       foreach($questionsArray as $questionArray)
                       {
                         $questionDisplay[]=$questionArray->content;
                         $questionType[]=$questionArray->type;
                         $questionID[]=$questionArray->id;
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
                         
                         $maxPoints = 0;
                         $pointsEarned = 0;
                         
                         echo '<tr id="list">';
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
                           if($allowUpdate == 1)
                           {
                              echo '<td>To be checked</td>';
                           }
                           else
                           {
                             echo '<td>Already Checked</td>';
                           }
                         }
                         else
                         {
                           echo '<td>NO</td>';
                         }
                         
                         if($questionType[$count]=="SUBJECTIVE")
                         {
                           if($allowUpdate == 1)
                           {
                             
                             foreach($exam_questions_details as $exam_question_detail)
                             {
                               if($exam_question_detail->question_id==$questionID[$count])
                               {
                                 $maxPoints = $exam_question_detail->possiblePoints;
                               }
                             }
                             
                             echo '<td><input name="points[]" type="number" min=0 max='.$maxPoints.' step="1" value="0"/> pts<br>';
                             echo '<div id="dispAnswer" style="display:none;">
                                    <span><input type="text" name = "id[]" value = '.$questionID[$count].'></input></span>
                                    </div></td>';
                           }
                           else
                           {
                             $user_exam_question_details = DB::table('user_question_answer')
                               ->where('exam_id', '=', $exam_id)
                               ->where('user_id', '=', $student_id)
                               ->where('question_id', '=', $questionID[$count])
                               ->first();
                             
                             if($user_exam_question_details==NULL)
                             {
                               $user_exam_question_details = DB::table('user_question_answer')
                               ->where('exam_id', '=', 0)
                               ->where('user_id', '=', 0)
                               ->where('question_id', '=', 0)
                               ->first();
                             }
                             
                             echo '<td>'.$user_exam_question_details->subjPoints.' pt</td>';
                           }
                            
                         }
                         else if($isCorrect[$count]==1)
                         {
                             echo '<td>'.$multiplierObj .' pt</td>';
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
                      
                         <?php if($isAllObjective==0 && $allowUpdate == 1): ?>
                      <input type="submit" value="Update Grades">
                         <?php endif; ?>
                        </td></tr>
                       
                  </table>
                  </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>