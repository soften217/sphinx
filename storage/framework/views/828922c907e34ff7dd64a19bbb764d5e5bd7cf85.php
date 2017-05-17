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
                <div class="panel-heading">Creating an Exam for <?php echo e($id); ?></div>

                <div class="panel-body">
                     <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/formexam')); ?>">
                       <?php echo e(csrf_field()); ?>

                      <table style="border-collapse: separate; border-spacing: 10px;">
                        
                        <tr>
                          <td style="width:200px">Course</td>
                      <td><select name = "group">
                      
                        <?php
//                       $user_groups = DB::table('user_group')->where('user_id', '=', auth()->user()->id)->get();
              
//                       foreach ($user_groups as $user_group) {
//                             $groups = DB::table('groups')->where('id', '=', $user_group->group_id)->get();
              
//                               foreach ($groups as $group) {
//                                     $course = $group->course;
//                                     $isArchived = $group->isArchived;
                                
//                                     if($isArchived==0)
//                                     {
//                                       echo '<option value="'.$course.'">'.$course.'</option>';
//                                     }
//                               }
//                       }
                       ?>
                        
                        <option value = <?php echo e($id); ?> ><?php echo e($id); ?></option>
                        
                      </select></td>
                        </tr>
                        
<!--                         <tr><td>Type</td>
                         <td>
                            <input type="radio" name="type" value="subjective" onclick="displaySelectedRadio(this)" checked> Subjective &emsp;&emsp;
                            <input type="radio" name="type" value="objective" onclick="displaySelectedRadio(this)"> Objective 
                           </select>  
                         </td>
                        </tr> -->
                  
<!--                   <tr>
                    <td style="width:200px">
                      <div id="dispSelectedRadioName" style="display:none;">
                        <span>Subtype</span>
                        </div>
                    </td>
                     <td>
                      <div id="dispSelectedRadio" style="display:none;">
                        <span><select name= "subtype">
                          <option value = "identification">Identification</option>
                          </select>
                        </span>

                         <br/>
                      </div>
                      
                    </td>
                  </tr> -->
                  <tr>
                    <td>Questions</td>
                    <td>
                      
                          <form>
                      <table style="border-collapse: separate; border-spacing: 10px;">
                        <tr>
                          <td align="center">List of <br> Available Questions</td>
                          <td></td>
                          <td align="center">List of <br> Added Questions</td>
                        </tr>
                        
                        
                        
                        <tr>
                          <td>
                            <table style="border-collapse: separate; border-spacing: 10px;">
                        <tr>
                        <td>
                          <select name="cricket" id="cricket" multiple="multiple" size="10" style="width: 300px;" onchange="showpreview()">
                            <?php
                             $qArray = array();
                            
                            $groups = DB::table('groups')->where('id', '=', $id)->get();
                            
                          foreach ($groups as $group) {
                            $course = $group->course;
                          }
                    
                             $questions = DB::table('questions')->where('isArchived', '!=', '1')->where('course', '=', $course )->get();
                              foreach ($questions as $question) {
                                    $course = $question->course;
                                    $type = $question->type;
                                    $id = $question->id;
                                    $content = $question->content;
                                
                                    $qArray[$id]=$content;

                                    echo '<option value="'.$content.'" onclick="showpreview()">'.$course. '-' .$type. '-' .$id.'</option>';
                              }
                             ?>
                          </select>
                        </td>
                        </tr>
                        </table>
                            
                          </td>
                          
                          <td align="center">
                        <input type="button" value="ADD" onclick="addlist()">
<!--                             <br><br><br>
                         <input type="button" value="PREVIEW" onclick="showpreview()"/> -->
                            <br><br><br>
                          <input type="button" value="REMOVE" onclick="remove()">
                        </td>
                           
                          
                          <td>
                              <table align="center">
                        <tr>
                        <td>
                          <select name ="selecteditems[]" id="selecteditems[]" multiple="multiple" size="10" style="width: 300px;">
                        </td>
                        </tr>
<!--                         <tr>
                        <td align="center">
                        <br>
                        <br>
                          <input type="button" value="TOTAL" onclick="total()">
                        </td>
                          </tr>
                        <tr>
                        <td>
                          <input type="text" id="t1">
                        </td>
                          </tr> -->
                        </table>
                          </td>
                        </tr>
                      </table>
                      
                      </form>
                      
                      
                    </td>
                  </tr>
                  
                   <tr>
                     <td style="width:200px">
                    <div id="dispAnswerName" style="display:none;">
                    <span>Answer</span>
                    </div>
                  </td>
                  <td>
                    <div id="dispAnswer" style="display:none;">
                      <span><input type="text" name = "answer"></input></span>
                    </div>
                  </td>
                  </tr>
          
                  <tr>
                    <td>
                    Preview
                    </td>
                    <td>
                      <div id="questionPreview" style="display:block;">
                        <span>Question Preview will be displayed here.</span>
                       </div>
                      <br><br>
                      <div>
                        <?php $myNumber = 4 ?>
                        <a href="/editquestion/<?php echo e($myNumber); ?>">Edit</a>
                       </div>
                    </td>
          
                  </tr>
  
                  <script>
                    function displaySelectedRadio(id) {
                      //  To validate, check first if subjective is ticked true. If subjective != true && objective == true, then pass the values inside the dispSelectedRadio.div
                      // BUT if subjective == true and the inputs inside the div have values, DO NOT PASS.
                      
                      console.log(id.value);
                      if(id.value == 'objective')
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
                        }
                       
                    }
                    
                  </script>
          
          <script>
          
            function showpreview() {
                    var num = document.getElementById('cricket').value;
//                     var res = num.split("|");
                   document.getElementById("questionPreview").innerHTML = num;
                    }
          
          </script>
          
                <script language="javascript" type="text/javascript">
                  
                    function addlist() {
                          var flag = 0;
                          var l1 = document.getElementById('cricket');
                          var l4 = document.getElementById('selecteditems[]');
                      
                          var question = document.getElementById('cricket').value;
                      
                          for (var i = l1.length - 1; i >= 0; i--) {
                            if (l1.options[i].selected) {
                              var newcricket = document.createElement('option');
                              
                              newcricket.text = l1.options[i].text;
                              newcricket.value = l1.options[i].value;
                              newcricket.onclick = function () {
                    var num = document.getElementById('selecteditems[]').value;
                   document.getElementById("questionPreview").innerHTML = num;
                    };
                              l4.add(newcricket);
                              flag = 1;
                              l1.options[i].selected = false;
                            }
                          }
                          if (flag == 0)
                            alert("Cannot Add Without Selection");

                    }
                  
                    function remove() {
                      var flag = 0;
                      var l4 = document.getElementById('selecteditems[]');

                      for (var i = l4.length - 1; i >= 0; i--) {
                        if (l4.options[i].selected) {
                          l4.remove(i);
                          flag = 1;
                        }
                      }
                      if (flag == 0)
                        alert("Cannot Remove Without Selection");
                    }

                    function total() {
                      var flag = 0;
                      var tot = parseInt(0);
                      var l4 = document.getElementById('selecteditems[]');

                      for (var i = l4.length - 1; i >= 0; i--) {
                        tot = tot + parseInt(l4[i].value);
                        flag = 1;
                      }

                      if (flag == 0)
                        alert("List Is Empty");
                      else {
                        document.getElementById('t1').value = tot + ' $ ';
                      }
                    }
                  
                  
                  function selectAll() 
                  { 
                      var selectBox = document.getElementById("selecteditems[]");

                      for (var i = 0; i < selectBox.options.length; i++) 
                      { 
                           selectBox.options[i].selected = true; 
                      } 
                  }
                  
                  function goBack() {
                      window.history.back();
                  }
                    </script>
                    <tr>
                      <td><br><br></td>
          
                    </tr>
                      <tr><td>
                      <input type="submit" value="Submit" onclick="selectAll()">
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