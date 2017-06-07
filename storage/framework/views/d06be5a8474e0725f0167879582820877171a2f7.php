<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Question Bank</div>

                <div class="panel-body">
                     <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/formquestion')); ?>">
                       <?php echo e(csrf_field()); ?>

                      <table style="border-collapse: separate; border-spacing: 10px;">
                        
                        <tr>
                          <td style="width:200px">Course</td>
                      <td><select name = "course">
                      
                        <?php
                      $user_groups = DB::table('user_group')->where('user_id', '=', auth()->user()->id)->get();
                      $coursesList = array();
                        
                      foreach ($user_groups as $user_group) {
                            $groups = DB::table('groups')->where('id', '=', $user_group->group_id)->get();
              
                               foreach ($groups as $group) {
                                    $done=false;
                                    $course = $group->course;
                                    $isArchived = $group->isArchived;
                                    
                                    foreach($coursesList as $courseList)
                                    {
                                      if($course==$courseList)
                                      {
                                        $done=true;
                                      }
                                    }
                                    if($isArchived==0 && $done==false)
                                    {
                                      
                                        echo '<option value="'.$course.'">'.$course.'</option>';
                                    }
                                    $coursesList[]=$course;
                              }
                      }
                       ?>
                        
                      </select></td>
                        </tr>
                        
                        <tr><td>Topic</td>
                         <td>
                            <input type="text" name = "topic" placeholder="Topic"></input>
                         </td>
                        </tr>
                        
                        <tr><td>Type</td>
                         <td>
                            <input type="radio" name="type" value="SUBJECTIVE" onclick="displaySelectedRadio(this)" checked> Subjective &emsp;&emsp;
                            <input type="radio" name="type" value="OBJECTIVE" onclick="displaySelectedRadio(this)"> Objective 
                           </select>  
                         </td>
                        </tr>
                  
                  <tr>
                    <td style="width:200px">
                      <div id="dispSelectedRadioName" style="display:none;">
                        <span>Subtype</span>
                        </div>
                    </td>
                    
                     <td>
                      <div id="dispSelectedRadio" style="display:none;">
                        <span><select name= "subtype" id= "subtype" onchange="showHideOther();">
                          <option value = "IDENTIFICATION">Identification</option>
                          <option value = "MULTIPLECHOICE">Multiple Choice</option>
<!--                           <option value="trueorfalse">True or False</option> -->
                          </select>
                        </span>
                      </div>
                      
                    </td>
                  </tr>
                  <tr>
                    <td>Question</td>
                    <td><textarea name = "content" rows="6" cols="80" placeholder="Enter your question here." required></textarea>
                    </td>
                  </tr>
                  
                   <tr>
                     <td style="width:200px">
                    <div id="dispAnswerName" style="display:none;">
                    <span>Answer</span>
                    </div>
                    <div id="dispChoiceName" style="display:none;">
                    <span>Choices</span>
                    </div>
                  </td>
                  <td>
                     <div id="dispAnswer" style="display:none;">
                      <span><input type="text" name = "answer" placeholder="Enter the correct answer here."></input></span>
                    </div>
                  
                  
                    <div id="numOfChoices" style="display:none;">
                          <span style="padding: 12px 8px 12px 20px;"># of choices</span>
                        <span><input type="number" id ="choiceCount" name = "choiceCount" value='2' min="2" max="10" onchange="checkNumChoices()"></input>&nbsp;(Max: 10)</span>
                    <br><br>
                    </div>
                    <?php
                      for($counterChoice = 1; $counterChoice <= 10; $counterChoice++)
                      {
                        echo '<div id="dispChoice'.$counterChoice.'" style="display:none;"><br>
                              <span><input type="text" name = "choice'.$counterChoice.'" placeholder="Option #'.$counterChoice.'"></input>&nbsp;&nbsp;
                              <input type="radio" name="correctAnswers[]" value="'.$counterChoice.'"> Correct Answer</input></span>
                              <br><br></div>';
                      }
                    ?>
                  </td>
                  </tr>
  
                  <script>
                    function checkNumChoices(){
                      
                      var numberOfChoices = document.getElementById('choiceCount').value;
                      
                      for(var p = 2; p <= numberOfChoices; p++)
                        {
                          hideAllChoices();
                          
                          if (document.getElementById('choiceCount').value == p) {
                            
                            for(var q = 1; q <= p; q++)
                              {
                                document.getElementById("dispChoice" + q).style.display = "block";
                                console.log("dispChoice" + q);
                              }
                          } 
                        }
                      
                    }
                    
                    function hideAllChoices(){
                      for(var c = 1; c <= 10; c++)
                        {
                          document.getElementById("dispChoice" + c).style.display = "none";
                        }
                    }
                    function showHideOther(){
                        if (document.getElementById('subtype').value == 'IDENTIFICATION') {
                             console.log("IDENTIFICATION");    
                             document.getElementById("numOfChoices").style.display = "none";
                             document.getElementById("dispChoiceName").style.display = "none";
                             document.getElementById("dispAnswerName").style.display = "block";
                             document.getElementById("dispAnswer").style.display = "block";
                             hideAllChoices();
                        } else if (document.getElementById('subtype').value == 'MULTIPLECHOICE') {
                             console.log("MULTIPLE CHOICE"); 
                             document.getElementById("numOfChoices").style.display = "block";
                              document.getElementById("dispChoiceName").style.display = "block";
                              document.getElementById("dispAnswerName").style.display = "none";
                             document.getElementById("dispAnswer").style.display = "none";
                             document.getElementById("dispChoice1").style.display = "block";
                             document.getElementById("dispChoice2").style.display = "block";
                        } else {
                             console.log("TRUE OR FALSE"); 
                            document.getElementById("numOfChoices").style.display = "none";
                        }
                    }
                    
                    function displaySelectedRadio(id) {
                      //  To validate, check first if subjective is ticked true. If subjective != true && objective == true, then pass the values inside the dispSelectedRadio.div
                      // BUT if subjective == true and the inputs inside the div have values, DO NOT PASS.
                      
                      console.log(id.value);
                      if(id.value == 'OBJECTIVE')
                        {
                          document.getElementById("dispSelectedRadioName").style.display = "block";
                          document.getElementById("dispSelectedRadio").style.display = "block";
                          document.getElementById("dispAnswerName").style.display = "block";
                          document.getElementById("dispAnswer").style.display = "block";
                         
                        }
                      else
                        {
                          document.getElementById("dispSelectedRadioName").style.display = "none";
                           document.getElementById("dispSelectedRadio").style.display = "none";
                          document.getElementById("dispAnswerName").style.display = "none";
                           document.getElementById("dispAnswer").style.display = "none";
                          document.getElementById("numOfChoices").style.display = "none";
                          document.getElementById("dispChoiceName").style.display = "none";
                          hideAllChoices();
                        }
                       
                    }
                  </script>
                    <tr>
                      <td><br><br></td>
          
                    </tr>
                      <tr><td>
                      <input type="submit" value="Submit">
                        </td></tr>
                      </table>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>