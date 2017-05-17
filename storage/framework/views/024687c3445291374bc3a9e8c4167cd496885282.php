<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <table>
            <tr>
            <td style="width:50px">
              <button onclick="goBack()"><<</button>
              </td>
              <td>
              Go back to Group Page
              </td>
            </tr>
          </table>
           <br>
            <div class="panel panel-default">
                <div class="panel-heading">Viewing Exam ID number <?php echo e($id); ?></div>

                <div class="panel-body">
                  <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/getresult')); ?>">
                       <?php echo e(csrf_field()); ?>

                     <table>
                       <tr>
                       <th width="200px">Your Answer</th>
                       <th width="150px">No.</th>
                       <th width= "600px">Question</th>
                       </tr>
                       
                       <div id="exam_id_hold" style="display:none;">
                        <span><input type="text" name="exam_id_holder" value=<?php echo e($id); ?>></span>
                       </div>
                       
                       <?php
                       
                       $count=1;
                       
                       foreach($arrayQuestions as $arrayQuestion)
                       {
                         echo '<tr>';
                         echo '<td>';
                         
                         if($count==1)
                         {
                           echo '<div id="answerBox|'.$count.'" style="display:block;">';
                         }
                         else
                         {
                           echo '<div id="answerBox|'.$count.'" style="display:none;">';
                         }
                         echo '<span><input type="text" name="question|'.$count.'|'.$arrayQuestions[$count-1]["id"].'|'.$arrayQuestions[$count-1]["type"].'"\></span>';
                         echo '</div>';
                         echo '</td>';
                         
                         echo '<td>';
                         if($count==1)
                         {
                           echo '<div id="qNumber|'.$count.'" style="display:block;">';
                         }
                         else
                         {
                           echo '<div id="qNumber|'.$count.'" style="display:none;">';
                         }
                         echo '<span>'. $count . ' out of ' . sizeof($arrayQuestions) . '</span>';
                         echo '</div>';
                         echo  '</td>';
                         
                         echo '<td>';
                         if($count==1)
                         {
                           echo '<div id="question|'.$count.'" style="display:block;">';
                         }
                         else
                         {
                           echo '<div id="question|'.$count.'" style="display:none;">';
                         }
                         echo '<span>'. $arrayQuestions[$count-1]["content"] . '</span>';
                         echo '</div>';
                         echo '</td>';
                         echo '</tr>';
                         
                         echo '<tr>';
                         echo '<td>';
                         if($count==1)
                         {
                           echo '<div id="previousButton|'.$count.'" style="display:none;">';
                         }
                         else
                         {
                           echo '<div id="previousButton|'.$count.'" style="display:none;">';
                         }
                         echo '<span><a onclick="displayPreviousQuestion('.$count.');">PREVIOUS QUESTION</a></span>';
                         echo '</div>';
                         echo '</td>';
                         
                         echo '<td></td>';
                         
                         echo '<td>';
                         if($count==1&&(sizeof($arrayQuestions)!=1))
                         {
                           echo '<div id="nextButton|'.$count.'" style="display:block;">';
                         }
                         else
                         {
                           echo '<div id="nextButton|'.$count.'" style="display:none;">';
                         }
                         echo '<span><a onclick="displayNextQuestion('.$count.');">NEXT QUESTION</a></span>';
                         echo '</div>';
                         echo '</td>';
                         
                         echo '</tr>';
                         
                         $count++;
                       }
                       
                       ?>
                  </table>
                    <br><br>
                    <?php if(sizeof($arrayQuestions)!=1): ?>
                    <div id="submitAnswers" style="display:none;">
                    <?php else: ?>
                    <div id="submitAnswers" style="display:block;">
                    <?php endif; ?>
                    <span><input type="submit" value="Submit" onclick="return theFunction();"/></span>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
  function goBack() {
                      window.history.back();
                  }
  function theFunction () {
        if (confirm('Are you sure you want to submit this exam?')) {
          return true;
        } else {
          return false;
        }
    }
  
  function displayNextQuestion(qNum) {
    
                      if(qNum>=1)
                        {
                          document.getElementById('answerBox|'+(qNum+1)).style.display = "block";
                          document.getElementById('answerBox|'+(qNum)).style.display = "none";
                          
                          document.getElementById('qNumber|'+(qNum+1)).style.display = "block";
                          document.getElementById('qNumber|'+(qNum)).style.display = "none";
                          
                          document.getElementById('question|'+(qNum+1)).style.display = "block";
                          document.getElementById('question|'+(qNum)).style.display = "none";
                          
                          document.getElementById('previousButton|'+(qNum+1)).style.display = "block";
                          document.getElementById('previousButton|'+(qNum)).style.display = "none";
                          
                          if(qNum==<?php echo e(sizeof($arrayQuestions)-1); ?>)
                            {
                              document.getElementById('nextButton|'+(qNum+1)).style.display = "none";
                              document.getElementById('submitAnswers').style.display = "block";
                            }
                          else{
                            document.getElementById('nextButton|'+(qNum+1)).style.display = "block";
                          }
                          
                          document.getElementById('nextButton|'+(qNum)).style.display = "none";
                          
                          return false;
                        }
                      else
                        {
                          //document.getElementById(id).style.display = "none";
                        }
                       
                    }
  function displayPreviousQuestion(qNum) {
                      
                      if(qNum-1>=1)
                        {
                          document.getElementById('answerBox|'+(qNum-1)).style.display = "block";
                          document.getElementById('answerBox|'+(qNum)).style.display = "none";
                          
                          document.getElementById('qNumber|'+(qNum-1)).style.display = "block";
                          document.getElementById('qNumber|'+(qNum)).style.display = "none";
                          
                          document.getElementById('question|'+(qNum-1)).style.display = "block";
                          document.getElementById('question|'+(qNum)).style.display = "none";
                          
                          if(qNum==2)
                            {
                              document.getElementById('previousButton|'+(qNum-1)).style.display = "none";
                            }
                          else
                          {
                            document.getElementById('previousButton|'+(qNum-1)).style.display = "block";
                          }
                          
                          document.getElementById('previousButton|'+(qNum)).style.display = "none";
                          
                          if(qNum==<?php echo e(sizeof($arrayQuestions)); ?>)
                            {
                              document.getElementById('nextButton|'+(qNum-1)).style.display = "block";
                              document.getElementById('submitAnswers').style.display = "none";
                            }
                          else{
                            document.getElementById('nextButton|'+(qNum-1)).style.display = "block";
                          }
                          
                          document.getElementById('nextButton|'+(qNum)).style.display = "none";
                          
                          return false;
                        }
                      else
                        {
                          //document.getElementById(id).style.display = "none";
                        }
                       
                    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>