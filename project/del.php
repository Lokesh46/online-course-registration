<?php
    include 'include/db.php';

    $val = $_GET["id"];
    $exploded= explode('_', $val);
    $table_name=$exploded[1];
    $row=$exploded[0];
    $course_id=$exploded[2];
    $std_id=$exploded[3];
    if ($table_name=='enrolls') {
        if ($result=$connection->query("select * from enrolls,registration where enrolls.rg_id=registration.reg_Id and student_id='$std_id' and registration.course_Id='$course_id'")) {
            if ($result->num_rows > 0) {
                while ($rowObj = $result->fetch_object()) { 
                    $id=$rowObj->id;
                    $rg_id=$rowObj->rg_id;
                    $connection->query("delete from enrolls where id='$id'");
                    $connection->query("update registration set free_Seats=(select free_seats from registration where reg_id='$rg_id')+1 where reg_id='$rg_id'");
                    
                }
                $connection->query("update students set Creds_Taken = (select Creds_Taken from students where Student_ID='$std_id')-(select credits from courses where Course_ID='$course_id') where Student_ID= '$std_id'");
            }
        } else {
            echo "Error deleting record: " . $connection->error;
        }
    }
    $connection->close();
    
header("Location:modify.php");
?>