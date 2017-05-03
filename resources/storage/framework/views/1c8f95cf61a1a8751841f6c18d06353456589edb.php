<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    This is the FACULTY home page after logging in.
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Calendar</div>

                <div class="panel-body">
                      
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

                    <?php
                    /* Set the default timezone */
                    date_default_timezone_set("America/Montreal");

                    /* Set the date */
                    $date = strtotime(date("Y-m-d"));

                    $day = date('d', $date);
                    $month = date('m', $date);
                    $year = date('Y', $date);
                    $firstDay = mktime(0,0,0,$month, 1, $year);
                    $title = strftime('%B', $firstDay);
                    $dayOfWeek = date('D', $firstDay);
                    $daysInMonth = cal_days_in_month(0, $month, $year);
                    /* Get the name of the week days */
                    $timestamp = strtotime('next Sunday');
                    $weekDays = array();
                    for ($i = 0; $i < 7; $i++) {
                      $weekDays[] = strftime('%a', $timestamp);
                      $timestamp = strtotime('+1 day', $timestamp);
                    }
                    $blank = date('w', strtotime("{$year}-{$month}-01"));
                    ?>
                    <table class='table table-bordered' style="table-layout: fixed;">
                      <tr>
                        <th colspan="7" class="text-center"> <?php echo $title ?> <?php echo $year ?> </th>
                      </tr>
                      <tr>
                        <?php foreach($weekDays as $key => $weekDay) : ?>
                          <td class="text-center"><?php echo $weekDay ?></td>
                        <?php endforeach ?>
                      </tr>
                      <tr>
                        <?php for($i = 0; $i < $blank; $i++): ?>
                          <td></td>
                        <?php endfor; ?>
                        <?php for($i = 1; $i <= $daysInMonth; $i++): ?>
                          <?php if($day == $i): ?>
                            <td><strong><?php echo $i ?></strong></td>
                          <?php else: ?>
                            <td><?php echo $i ?></td>
                          <?php endif; ?>
                          <?php if(($i + $blank) % 7 == 0): ?>
                            </tr><tr>
                          <?php endif; ?>
                        <?php endfor; ?>
                        <?php for($i = 0; ($i + $blank + $daysInMonth) % 7 != 0; $i++): ?>
                          <td></td>
                        <?php endfor; ?>
                      </tr>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Bulletin</div>

                <div class="panel-body">
                      
                    <div class="wrap">
  <div class="task-list">
     <ul>
<?php
    $server = "localhost";
    $db_user = "sphinx";
    $db_pass = "password";
    $db_name = "sphinx";

    $con = new mysqli($server, $db_user, $db_pass);
    mysqli_connect($server, $db_user, $db_pass) or die("Could not connect to server!");
    mysqli_select_db($con, $db_name) or die("Could not connect to database!");
       
    $query = mysqli_query($con, "SELECT * FROM tasks ORDER BY date ASC, time ASC");
    $numrows = mysqli_num_rows($query);

    if($numrows>0){
      echo '<table width="600">';
  while( $row = mysqli_fetch_assoc( $query ) ){

      $task_id = $row['id'];
      $task_name = $row['task'];
      $task_date = $row['date'];
      $task_time = $row['time'];

      echo '<tr>
                    <td>'.$task_name.'</td>
                    <td>'.$task_date.'</td>
                    <td>'.$task_time.'</td>
        
     </tr>';
  }
      echo '</table>';
    }
?>
     </ul>
 </div><table width="600">
                      
                      
  <tr><td><form class="add-new-task" autocomplete="off">
      <input type="text" name="new-task" placeholder="Add a new item..." />
    </form></td></tr>
       </table>
    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>