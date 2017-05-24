<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo e($id); ?></div>

                <div class="panel-body">
<<<<<<< HEAD
                  
                  List of Students Enrolled in this Group: <br><br>
                  
                 
                  <?php
                  $countlist = 1;
                  
                  echo '<table width="100%" style="padding:15px; text-align:left; border: 1px solid black;"><tr>';
                  echo '<th style="padding:15px; text-align:left; border: 1px solid black;"> Student Name </th>';
                  
                  $arranged_exam = array();
                  
                  foreach($exams as $exam)
                  {
                    echo '<th style="text-align:center;"> '. $exam->id .' </th>';
                  }
                  
                  echo '</tr>';
                  
                  if(count($members)==1){
                      echo '<td style="padding:15px; text-align:left; border: 1px solid black;">';
                      echo 'There are no students enrolled in this group.';
                      echo '</td>';
                    
                    foreach($exams as $exam)
                    {
                      echo '<td style="padding:15px; text-align:left; border: 1px solid black;"></td>';
                    }
                      echo '</tr>';
                  }
                  else
                  {
                
                  
                      for($var = 0; $var < count($members); $var++)
                      {
                        echo '<tr>';

                        if($members[$var]['isFaculty'] != 1)
                        {
                          echo '<td style="padding:15px; text-align:left; border: 1px solid black;">';
                          echo $countlist . '. ';
                          echo $members[$var]['name'];
                          echo '</td>';

                          $exam_users = DB::table('exam_user')->where('user_id', '=', $members[$var]['id'])->get();

                          if((empty($exam_users)))
                          {
                            foreach($exams as $exam)
                            {
                              echo '<td style="padding:15px; text-align:left; border: 1px solid black;"> NA </td>'; 
                            }

                          }
                          else
                          {
                            foreach($exams as $exam)
                            {
                              $found = false;
                              foreach($exam_users as $exam_user)
                              {

                                    if($exam->id == $exam_user->exam_id)
                                    {
                                      echo '<td style="padding:15px; text-align:left; border: 1px solid black;"><a href="/getstudentresult/'.$exam_user->user_id.'/'.$exam->id.'">'.$exam_user->rawScore.'</a> </td>'; 
                                      $found = true;
                                    }
                              }
                              if($found == false)
                              {
                                echo '<td style="padding:15px; text-align:left; border: 1px solid black;"> NA </td>'; 
                              }
                              else {
                                $found = false;
                              }

                                }
                              }


                          $countlist++;
                          echo '</tr>';
                        }


                      }
                  }
                  
                  echo '</table>';
                  
                  ?>
                  
=======
                    This is a sample FACULTY Group page.
>>>>>>> b8dbc83003d74bbcad6f42be6a4a3550a5946e15
                    <br><br><br><br><br>
                    JOIN CODE: <b><u><?php echo e($code); ?></u></b>.
                </div>
                <div class="panel-body" style="text-align:right">
<<<<<<< HEAD
                  
                  <script>
                  function deletearchive(){
                    var r = confirm("Are you sure you want to delete this?");
                    
                    if(r){
                      window.location = "/archive/<?php echo e($id); ?>";
                    }else{
//                       document.write("OKAY.");
                    }
                  }
                      function confirmDelete () {
                        if (confirm('Are you sure you want to delete this exam?')) {
                          return true;
                        } else {
                          return false;
                        }
                    }
                    
                  </script>
                  
                  <button onclick="deletearchive()" value="DELETE">DELETE</button>
                  
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
                    <table>
                      <tr>
                         <th width=5%>ID</th>
                        <th width =25%> Topic</th>
                        <th width =25%> Duration</th>
                        <th width =25%> Date</th>
                        <th width=10%>View</th>
                        <th width=10%>Delete</th>

                      </tr>
                        
                    
                     <?php
                      $exams = DB::table('exams')->where('group_id', '=', $id)->get();
                  
                              foreach ($exams as $exam) {
                                
                                if($exam->isArchived==0)
                                {
                                  $exam_id = $exam->id;
                                  
                                  if($exam->duration < 60000) {
                                    $duration = $exam->duration / 1000 ; 
                                    $time = 'Seconds';
                                  }
                                  else if($exam->duration < 3600000){
                                  $duration = $exam->duration / 60000 ; 
                                  $time = 'Minutes';
                                  } else {
                                  $duration = $exam->duration / 3600000 ; 
                                  $time = 'Hours';
                                  }
                                  
                               
                                  $availabledate = $exam->schedule;
                                  $topic = $exam->topic;
                                    echo '<tr> 
                                    <td> '.$exam_id .' </td>
                                    <td> '.$topic.'</td>
                                    <td> '.$duration. ' '.$time.' </td>
                                    <td> '.$availabledate.' </td>
                                    <td><a href="/viewexam/'.$exam_id.'">VIEW</a></td>
                                    <td><a href="/deleteexam/'.$id.'/'.$exam_id.'" onclick="return confirmDelete();">DELETE</a></td>
                                    </tr>';
                                }
                              }
                  ?>
                   </table>
                </div>
              
              <div class="panel-body">
                  
                  <script>
                  function createQuiz(){
                    var r = confirm("You will now be redirected to Questionnaire Creation Page. \nDo you want to continue?");
                    
                    if(r){
                      window.location = "/createquiz/<?php echo e($id); ?>";
                    }else{
//                       document.write("OKAY.");
                    }
                  }
                  </script>
                  
                  <button onclick="createQuiz()" value="CREATE">Create New Questionnaire</button>
                  
=======
                    
                  <?php
                    echo '<a href="/archive/'.$id.'"><i class="fa fa-btn fa-trash"></i>Archive this group</a>';
                  ?>
>>>>>>> b8dbc83003d74bbcad6f42be6a4a3550a5946e15
                </div>
            </div>
          
        </div>
                
    </div>
  
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>