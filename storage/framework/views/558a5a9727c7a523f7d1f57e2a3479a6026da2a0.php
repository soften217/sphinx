<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><?php echo e($id); ?></div>

                <div class="panel-body">
                    This is a sample FACULTY Group page.
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
                         <th width=20%>ID</th> 
                        <th width=25%>View</th>
                        <th width=25%>Delete</th>
                      </tr>
                        
                    
                     <?php
                      $exams = DB::table('exams')->where('group_id', '=', $id)->get();
                  
                              foreach ($exams as $exam) {
                                
                                if($exam->isArchived==0)
                                {
                                  $exam_id = $exam->id;
                                    echo '<tr> 
                                    <td> '.$exam_id .' </td>
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
>>>>>>> 2122ce65bcb88e274b35a1b6670bd7a117a259ea
                </div>
            </div>
          
        </div>
                
    </div>
  
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>