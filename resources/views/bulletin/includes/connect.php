<?php
    $server = "localhost";
    $db_user = "sphinx";
    $db_pass = "password";
    $db_name = "sphinx";

    $con = new mysqli($server, $db_user, $db_pass);
    mysqli_connect($server, $db_user, $db_pass) or die("Could not connect to server!");
    mysqli_select_db($con, $db_name) or die("Could not connect to database!");
?>