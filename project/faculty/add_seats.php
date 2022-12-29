<?php
include '../include/db.php';
    $reg_id =$_GET['id'];
    $connection->query("update registration set no_of_Seats = (select no_of_Seats from registration where reg_Id='$reg_id')+1 where reg_Id='$reg_id'");
    $connection->query("update registration set free_Seats = (select free_Seats from registration where reg_Id='$reg_id')+1 where reg_Id='$reg_id'");
    header("Location:details.php?id=$reg_id");
?>