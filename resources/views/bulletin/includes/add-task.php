<?php 
    $task = strip_tags( $_POST['task'] );
    $date = date('Y-m-d'); // Today%u2019s date
    $time = date('H:i:s'); // Current time

    $server = "localhost";
    $db_user = "sphinx";
    $db_pass = "password";
    $db_name = "sphinx";

    $con = new mysqli($server, $db_user, $db_pass);
    mysqli_connect($server, $db_user, $db_pass) or die("Could not connect to server!");
    mysqli_select_db($con, $db_name) or die("Could not connect to database!");

    mysqli_query($con, "INSERT INTO tasks VALUES ('', '$task', '$date', '$time')");

    $query = mysqli_query($con, "SELECT * FROM tasks WHERE task='$task' and date='$date' and time='$time'");

    while( $row = mysqli_fetch_assoc($query) ){
 $task_id = $row['id'];
  $task_name = $row['task'];
    }

    mysqli_close();

    echo '<li><span>'.$task_name.'</span><img id="'.$task_id.'" class="delete-button" width="10px" src="images/close.svg" /></li>';
?>