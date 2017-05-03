<html>
<head>
    <title>Bulletin Board</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
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
 </div>
  <form class="add-new-task" autocomplete="off">
      <input type="text" name="new-task" placeholder="Add a new item..." />
 </form>
    </div>
</body>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
    add_task(); // Call the add_task function
    delete_task(); // Call the delete_task function

    function add_task() {
        $('.add-new-task').submit(function(){
     var new_task = $('.add-new-task input[name=new-task]').val();

     if(new_task != ''){
   $.post('includes/add-task.php', { task: new_task }, function( data ) {
        $('.add-new-task input[name=new-task]').val('');
        $(data).appendTo('.task-list ul').hide().fadeIn();
                    delete_task();
                });
     }
     return false; // Ensure that the form does not submit twice
        });
    }

    function delete_task() {
        $('.delete-button').click(function(){
      var current_element = $(this);
      var id = $(this).attr('id');

      $.post('includes/delete-task.php', { task_id: id }, function() {
    current_element.parent().fadeOut("fast", function() { $(this).remove(); });
     });
        });
    }
</script>
</html>