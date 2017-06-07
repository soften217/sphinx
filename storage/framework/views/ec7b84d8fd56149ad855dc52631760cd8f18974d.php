<?php $__env->startSection('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
          <a href="/group/<?php echo e($group_id); ?>" class="btn btn-default">Go Back</a><br>
           <br>
            <div class="panel panel-default">
                <div class="panel-heading">Viewing Exam ID number <?php echo e($id); ?></div>

                <div class="panel-body">
                  <table width="40%">
                    <tr>
                      <td width="20%">Duration : </td>
                      <?php
                            if($duration < 60000) {
                              $durationNew = round(($duration / 1000), 2) ; 
                              $time = ' Seconds';
                            }
                            else if($duration < 3600000){
                            $durationNew = round(($duration / 60000), 2) ; 
                            $time = ' Minutes';
                            } else {
                            $durationNew = round(($duration / 3600000), 2) ; 
                            $time = ' Hours';
                            }
                      
                      ?>
                      <td width="20%"><?php echo $durationNew . ' ' . $time; ?> </td>
                    </tr>
                    <tr>
                      <td width="20%">Availability : </td>
                      <td width="20%"><?php echo $availabledate; ?></td>
                    </tr>
                    <tr>
                      <td width="20%"></td>
                      <td width="20%"><a onclick="makeAvailable()">Make this available today</a></td>
                    </tr>
                  </table>
                  
                  <script>
                  function makeAvailable(){
                    var r = confirm("Make this exam/quiz available today?");
                    
                    if(r){
                      window.location = "/makeAvailable/<?php echo e($id); ?>";
                    }else{
//                       document.write("OKAY.");
                    }
                  }
                  </script>
                  <br>
                  
                  
                     <table>
                   
                       <tr id="list">
                       <th width="50px">No.</th>
                       <th width= "600px">Question</th>
                       <th width= "200px">Answer</th>
                       </tr>
                       
                       <?php
                       
                       $count=1;
                       
                       foreach($arrayQuestions as $arrayQuestion)
                       {
                         echo '<tr id="list">';
                         echo '<td>' . $count . '</td>';
                         echo '<td>' . $arrayQuestions[$count-1]["content"] . '</td>';
                         echo '<td>' . $arrayQuestions[$count-1]["answer"] . '</td>';
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>