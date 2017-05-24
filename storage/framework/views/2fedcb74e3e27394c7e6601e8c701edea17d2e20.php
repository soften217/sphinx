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
                <div class="panel-heading">Your grade is <?php echo e($correctAnswerCount); ?></div>

                <div class="panel-body">
                     <table>
                       <tr>
                       <th width="10%">No.</th>
                       <th width="40%">Questions</th>
                       <th width= "20%">Correct Answer</th>
                       <th width= "20%">Your Answer</th>
                       <th width= "10%">Is Correct?</th>
                       </tr>
                       
                       <?php
                       
                       $count=1;
                       
                       foreach($arrayAnswerChecker as $arrayCheck)
                       {
                         echo '<tr>';
                         echo '<td>' . $count . '</td>';
                         echo '<td>' . $questionArray[$count] . '</td>';
                         echo '<td>' . $arrayAnswerChecker[$count]["correctAnswer"] . '</td>';
                         echo '<td>' . $arrayAnswerChecker[$count]["yourAnswer"] . '</td>';
                         
                         if($arrayAnswerChecker[$count]["isCorrect"]=="true")
                         {
                           echo '<td>YES</td>';
                         }
                         else if($arrayAnswerChecker[$count]["isCorrect"]=="SUBJECTIVE")
                         {
                           echo '<td>To be checked</td>';
                         }
                         else
                         {
                           echo '<td>NO</td>';
                         }
                         
                         echo '</tr>';
                         
                         $count++;
                       }
                       
                       ?>
                       
                  </table>
                  
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function goBack() {
                      window.location.href = "/group/<?php echo e($group_id); ?>";
                  }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>