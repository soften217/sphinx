<?php $__env->startSection('content'); ?>

<style>
.myclassButton{
    display:inline-block;
    width: 80px;
    height: 40px;
}

</style>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Viewing Exam ID number <?php echo e($id); ?></div>

                <div class="panel-body" id="exam">
                  <p style="text-align: right; font-size:20px" id="displayTime"></p>
                  
                  <table name="exampanel" id="exampanel">
                    <tr>
                      <td width="80%" style="padding:15px; text-align:left;">
                      <div style="height: 500px; overflow:hidden;">
                  <form class="form-horizontal" id="studentExam" role="form" method="POST" action="<?php echo e(url('/getresult')); ?>">
                       <?php echo e(csrf_field()); ?>

                     <table >
                       <tr>
                       <th width="150px">No.</th>
                       <th width= "500px">Question</th>
                       <th width="300px">Your Answer</th>
                       </tr>
                       
                       <div id="exam_id_hold" style="display:none;">
                        <span><input type="text" name="exam_id_holder" value=<?php echo e($id); ?>></span>
                       </div>
                       
                       <?php
                       
                       shuffle($arrayQuestions);
                       
                       $count=1;
                       
                       foreach($arrayQuestions as $arrayQuestion)
                       {
                         echo '<tr>';
                         
                         // displaying Question Number
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
                         ///////////////////////////////////////
                         
                         // displaying Question Content
                         echo '<td>';
                         if($count==1)
                         {
                           echo '<div id="question|'.$count.'" style="display:block;">';
                         }
                         else
                         {
                           echo '<div id="question|'.$count.'" style="display:none;" >';
                         }
                         echo '<span>'. $arrayQuestions[$count-1]["content"] . '</span>';
                         echo '</div>';
                         echo '</td>';
                         ///////////////////////////////////////
                         
                         //displaying ANSWER field
                         echo '<td>';
                         if($count==1)
                         {
                           echo '<div id="answerBox|'.$count.'" style="display:block;">';
                         }
                         else
                         {
                           echo '<div id="answerBox|'.$count.'" style="display:none;">';
                         }
                         
                         if($arrayQuestions[$count-1]["subtype"]=="IDENTIFICATION"||$arrayQuestions[$count-1]["subtype"]=="NONE")
                         {
                            echo '<span><input type="text" name="question|'.$count.'|'.$arrayQuestions[$count-1]["id"].'|'.$arrayQuestions[$count-1]["type"].'"\></span>';
                         }
                         else if ($arrayQuestions[$count-1]["subtype"]=="MULTIPLECHOICE")
                         {
                           echo '<br><span>';
                           for($g = 0; $g < $arrayQuestions[$count-1]['choiceCount']; $g++)
                           {
                             echo '<input type="radio" name="temp" value="'.$arrayQuestions[$count-1]['choices'][$g]["value"].'" onclick=\'setAnswer(this, "question|'.$count.'|'.$arrayQuestions[$count-1]["id"].'|'.$arrayQuestions[$count-1]["type"].'")\'>&nbsp;'.$arrayQuestions[$count-1]['choices'][$g]["value"].'</input><br>';
                           
                           }
                           echo '<div id="default_holder" style="display:none;">';
                             echo '<span><input type="text" id="question|'.$count.'|'.$arrayQuestions[$count-1]["id"].'|'.$arrayQuestions[$count-1]["type"].'" name="question|'.$count.'|'.$arrayQuestions[$count-1]["id"].'|'.$arrayQuestions[$count-1]["type"].'" value="No answer" \></span>';
                             echo '</div>';
                           echo '</span>';
                         }
                        
                         echo '</div>';
                         echo '</td>';
                         ///////////////////////////////////////
                         echo '</tr>';
                         
                         // displaying links for PREVIOUS and NEXT questions
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
                         echo '<span><br><a class="btn btn-default" onclick="displayPreviousQuestion('.$count.');">PREVIOUS<br>QUESTION</a></span>';
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
                         echo '<span><br><a class="btn btn-default" onclick="displayNextQuestion('.$count.');">NEXT<br>QUESTION</a></span>';
                         echo '</div>';
                         echo '</td>';
                         
                         echo '</tr>';
                         ///////////////////////////////////////
                         
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
                    <span><button type="button" value="Submit" onclick="theFunction();"/>SUBMIT Exam</span>
                    </div>
                  </form>
                    </div>
                      </td>
                      <td>
                        
<!--       THE QUESTION NAVIGATION   [START]     -->
                        <div style="height: 500px; overflow:hidden;">
                          <?php
                                 $maxColumn = 5;
                                 $currentColumn = 1;
                          echo '<table width="100%" style="padding:15px; text-align:left;">';
                          echo '<tr><th style="text-align:center;" class="panel-heading" colspan="'.$maxColumn.'">QUESTION NAVIGATION</th></tr>';
                                 for($j = 1; $j <= count($arrayQuestions); $j++)
                                 {
                                   if($currentColumn == 1)
                                   {
                                     echo '<tr>';
                                   }
                                   if($currentColumn <= $maxColumn+1)
                                   {
                                     echo '<td width="20%">';
                                     echo '<a class="btn btn-default" onclick="displayQuestion('.($j).');"><span style="font-size:20px;">'.$j.'</span></a>';
                                     echo '</td>';
                                     $currentColumn++;
                                   }
                                   if(($currentColumn == $maxColumn+1)||$j==count($arrayQuestions))
                                   {
                                     echo '</tr>';
                                     $currentColumn = 1;
                                   }
                                 }
                          echo '</table>';
                          ?>
                        </div>
<!--       THE QUESTION NAVIGATION  [END]      -->
                        
                    </td>
                      </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  function setAnswer(obj, target) {
    console.log(obj.value);
    console.log(target);
    console.log(document.getElementById(target).value);
    document.getElementById(target).value = obj.value;
  }
  
  function goBack() {
                      window.history.back();
                  }
  function theFunction () {
//         if (swal('Are you sure you want to submit this exam?')) {
//           return true;
//         } else {
//           return false;
//         }

        swal({
  title: "Finished?",
  text: "Are you sure you want to submit exam?",
  type: "info",
  allowOutsideClick: true,
  showConfirmButton: true,
  closeOnConfirm: false,
  showCancelButton: true,
  showLoaderOnConfirm: true,
},
function(isConfirm){
          if (isConfirm == true){
             document.forms["studentExam"].submit();
          }else{
              swal("Continue your exam");
  }
        });
    
    
    
//     swal({
//   title: "Finished?",
//   text: "Are you sure you want to submit exam",
//   type: "input",
//   showCancelButton: true,
//   closeOnConfirm: false,
//   animation: "slide-from-top",
//   inputPlaceholder: "Write anything"
// },
// function(inputValue){
//   if (inputValue === false) return false;
  
//   if (inputValue === "") {
//     swal.showInputError("You need to write something!");
//   }
  
//   document.forms["studentExam"].submit();
// });
  }
  
  function hideAll() {
    var totalQuestions = "<?php echo count($arrayQuestions) ?>";
    
    for(var x = 1; x <= totalQuestions; x++)
      {
        document.getElementById('answerBox|'+(x)).style.display = "none";
        document.getElementById('qNumber|'+(x)).style.display = "none";
        document.getElementById('question|'+(x)).style.display = "none";
        document.getElementById('nextButton|'+(x)).style.display = "none";
        document.getElementById('previousButton|'+(x)).style.display = "none";
      }
  }
  
  function displayQuestion(qNum) {
        hideAll();
        document.getElementById('answerBox|'+(qNum)).style.display = "block";
        document.getElementById('qNumber|'+(qNum)).style.display = "block";
        document.getElementById('question|'+(qNum)).style.display = "block";
        document.getElementById('nextButton|'+(qNum)).style.display = "block";
        document.getElementById('previousButton|'+(qNum)).style.display = "block";
        if(qNum==<?php echo e(sizeof($arrayQuestions)); ?>)
        {
          document.getElementById('nextButton|'+(qNum)).style.display = "none";
          document.getElementById('submitAnswers').style.display = "block";
        }
        else
          {
            document.getElementById('submitAnswers').style.display = "none";
          }
        if(qNum==1)
        {
          document.getElementById('previousButton|'+(qNum)).style.display = "none";
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
  
  <script type="text/javascript">
    
       window.onload=function(){
         
        var auto = setTimeout(function(){ autoRefresh(); }, 100);
          
                  
        var durationFromDatabase = "<?php echo $duration ?>";

        // Update the count down every 1 second
        var x = setInterval(function() {
          
        durationFromDatabase = durationFromDatabase - 1000;

        // Time calculations for days, hours, minutes and seconds
        var hours = Math.floor((durationFromDatabase % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((durationFromDatabase % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((durationFromDatabase % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"
        document.getElementById("displayTime").innerHTML = "Time Left: " + hours + "h "
        + minutes + "m " + seconds + "s "; 
          
        if (durationFromDatabase == 0) {
        clearInterval(x);
        submitform();
  }
}, 1000);
          
          
        
        window.onresize=function(){
          submitform();
          swal('You have resized the window. Your form will now be submitted');
        }
        
        window.onblur=function(){
         submitform();
         swal('Anti Cheating Exception');
        }


        function submitform(){
          //alert('Time is up, Your answers have been submitted!');
          swal('Time is up. Your answers have been submitted!');
          setTimeout(function () { document.forms["studentExam"].submit(); }, 1000);
        }

        function autoRefresh(){
           clearTimeout(auto);
           auto = setTimeout(function(){ submitform(); autoRefresh(); }, durationFromDatabase);
        }  

}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>