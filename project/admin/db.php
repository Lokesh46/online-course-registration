<?php
$connection = mysqli_connect('localhost','root', '','course_reg');
if (!$connection){
    die("Database Connection Faileddd" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection,'course_reg');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
?>
