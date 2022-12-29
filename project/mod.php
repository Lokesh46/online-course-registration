<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="include/table.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <title>Home Page</title>
</head>
<body>
    
<?php include('header.php'); 
            include 'include/db.php';
            if(!empty($_SESSION['stname']))
                $name=$_SESSION['stname'];
            else {
                ?> <script language="javascript">
                document.location="index.php";
                </script>
                <?php
            }
            $val = $_GET['id'];
            $exploded= explode('_', $val);
            $course_Id=$exploded[0];
            $type=$exploded[1];
            $enroll_id=$exploded[2];
            $curr_rg_id=$exploded[3];
            $name=$_SESSION['stname'];
            
            $result= $connection->query("SELECT * FROM students where Student_Name = '$name'");
            while ($rowObj = $result->fetch_object()) {
                $id=$rowObj->Student_ID;
                $ct= $rowObj->Creds_Taken;
                $cc= $rowObj->Creds_Completed;
                
            }
        ?>
        <br>
    <div class=container>
        

        <div class="content">            
            <div class="sh">
                <div class="title">
                    <?php
                        
                        $query =("select * from courses where course_id= '$course_Id'");
                        $result = $connection->query($query);
                        if (mysqli_num_rows($result) > 0) {
                            while($data = mysqli_fetch_assoc($result)) {
                        
                        echo $data['Course_Name'];
                            }
                        }
                    ?>
                </div><br>
                <h5> General Description </h5>
            </div>
            
            <div class="sh">
                
                    <?php
                    echo "<div class='title'> Current </div>";
                    ?>
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                                <tr>
                                    <th>Faculty Name</th>
                                    <th>Slot</th>
                                    <th>Course Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                        if ($result=$connection->query("select * from registration,enrolls,faculty where registration.reg_Id=enrolls.rg_id and faculty.faculty_id=registration.fac_id and student_id='$id' and course_Id='$course_Id' and type='$type'")) {
                                            while($rowObj=$result->fetch_object()) {
                                                echo "<tr><td>{$rowObj->Name}</td>
                                                <td>{$rowObj->slot}</td>
                                                <td>{$rowObj->type}</td></tr> ";
                                            }
                                        }
                                    ?>
                            </tbody>

                    </table>
                    </div>

                    <div class='title'> <?php echo ucfirst($type)?> Slots </div>
                    <form method='post'>
                        <div class="table-wrapper">
                            <table class="fl-table">
                                <thead>
                                    <tr>
                                        <th>Faculty Name</th>
                                        <th>Slot</th>
                                        <th>Total Seats</th>
                                        <th>Available Seats</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php
                                            if ($result=$connection->query("select * from registration,faculty where course_id ='$course_Id' and fac_Id = Faculty_ID and type='$type' order by slot asc ")) {
                                                while ($rowObj= $result->fetch_object()) {
                                                    $fs=$rowObj->free_Seats;
                                                    echo "<tr><td>{$rowObj->Name}</td>
                                                    <td>{$rowObj->slot}</td>
                                                    <td>{$rowObj->no_of_Seats}</td>";
                                                    if($type=='lab'){
                                                    $sl= substr($rowObj->slot,-2);
                                                    } else {
                                                        $sl= substr($rowObj->slot,-1);
                                                    }
                                                    if ($rowObj->free_Seats ==0) {
                                                        echo "<td>0</td>";
                                                    } elseif (mysqli_num_rows($connection->query("select * from enrolls,registration where registration.reg_id=enrolls.rg_id and student_id='$id' and registration.slot like '%$sl%' "))>0) {
                                                        
                                                        echo "<div class='form-check'> <td><input type='checkbox' class='form-check-input' value={$rowObj->slot} disabled><label>&nbsp;{$fs} &nbsp; No Free Slot</label></td></div>";
                                                                    }else {
                                                                        echo "<div class='form-check'><td> <input type='checkbox' class='form-check-input' name='cb' value={$rowObj->slot}#{$rowObj->Faculty_Id}#{$rowObj->reg_Id}><label>&nbsp; {$rowObj->free_Seats} </label></td></div>";
                                                                    
                                                    } echo "</tr>";
                                                }
                                            }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                        
                    <div class="text-center">
                        <input class="btn btn-primary" type="submit" name="submit" value="Update">
                    </div>

                </from>
                <?php
                    if(isset($_POST['submit']) && !isset($_POST['cb'])) {
                        echo "<p class='ecBad'> Please Select a Slot</p>";
                    }
                    elseif (isset($_POST['submit'])) {
                        $val=$_POST['cb'];
                        $exploded= explode('#', $val);
                        $fac_id=$exploded[1];
                        $slot=$exploded[0];
                        $rg_id=$exploded[2];
                        
                    
                
                        if (mysqli_num_rows($connection->query("select * from enrolls,registration where enrolls.rg_id=registration.reg_id and registration.slot='$slot' and enrolls.student_id=(select Student_id from students where Student_Name = '$name')"))==0) {
                            if ($res=$connection->query("update enrolls set rg_id='$rg_id' where id='$enroll_id'")) {
                                $connection->query("update registration set free_Seats=(select free_Seats from registration where reg_id='$rg_id')-1 where reg_id='$rg_id'");
                                $connection->query("update registration set free_Seats=(select free_Seats from registration where reg_id='$curr_rg_id')+1 where reg_id='$curr_rg_id'");
                                echo "<p class='ecGood'> Updated Successfully</p>";
                                ?>
                                <script type="text/javascript">
                                function Alert(title, msg, $true, $link) { /*change*/
                                    var $content =  "<div class='dialog-ovelay'>" +
                                    "<div class='dialog'><header>" +
                                    " <h3> " + title + " </h3> " +
                                    "<i class='fa fa-close'></i>" +
                                    "</header>" +
                                    "<div class='dialog-msg'>" +
                                        " <p> " + msg + " </p> " +
                                    "</div>" +
                                    "<footer>" +
                                        "<div class='controls'>" +
                                            " <button class='button button-danger doAction'>" + $true + "</button> " +
                                        "</div>" +
                                    "</footer>" +
                                    "</div>" +
                                    "</div>";
                                    $('body').prepend($content);
                                    $('.doAction').click(function () {
                                        window.open($link, "_blank"); /*new*/
                                        window. close();
                                        $(this).parents('.dialog-ovelay').fadeOut(500, function () {
                                        $(this).remove();
                                        });
                                    });
                                }
                
                                Alert('Update status', 'Updated Successfully', 'Ok', "modify.php");
                                </script>
                            <?php
                            }
                        } else {
                            echo "<p class='ecBad'> You have already a course registered in this slot</p>";
                        }
                    }
                ?>
        </div>
    </div>
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        
        </script>
    <script>
        $('input[type="checkbox"]').on('change', function() {
            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
        });
    </script>

</body>
</html> 