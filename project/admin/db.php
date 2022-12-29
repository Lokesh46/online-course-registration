<?php
$connection = mysqli_connect('localhost','id20030913_lokeshadmin', 'L%jRteKEj5u^kp1%','id20030913_course_reg');
if (!$connection){
    die("Database Connection Faileddd" . mysqli_error($connection));
}
$select_db = mysqli_select_db($connection,'id20030913_course_reg');
if (!$select_db){
    die("Database Selection Failed" . mysqli_error($connection));
}
?>