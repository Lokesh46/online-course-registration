<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="include/table.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <title>Register</title>
</head>
<body>
<?php 
include('header.php'); 
            
            include 'include/db.php';
            if(!empty($_SESSION['stname']))
                $name=$_SESSION['stname'];
            else {
                ?> <script language="javascript">
                document.location="index.php";
                </script>
                <?php
            }
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
                        $course_Id=$_GET["id"];
                        $query =("select * from courses where course_id= '$course_Id'");
                        $result = $connection->query($query);
                        if (mysqli_num_rows($result) > 0) {
                            while($data = mysqli_fetch_assoc($result)) {
                        
                        echo $data['Course_Name'];
                            }
                        }
                    ?>
                </div><br>
                
            </div>
            <div class="sh">
                
                    <?php
                        $query = "SELECT distinct(type) as type from registration where course_id = '$course_Id'";
                        $result = $connection->query($query);
                        if (mysqli_num_rows($result) == 1) {
                            while ($data = mysqli_fetch_assoc($result)) {
                                echo "<h5>";
                                if ($data['type']=="theory") {
                                    echo "Theory Slots";
                                } else {
                                    echo "Lab Slots";
                                }
                                $type=$data['type'];
                                echo "</h5>";
                            }
                            ?>
                            <form method="post">
                                <div class="table-wrapper">
                                    <table class= "fl-table">
                                        <thead>
                                            <tr>
                                                <th>Faculty Name</th>
                                                <th>Slot</th>
                                                <th> total Seats</th>
                                                <th> Available Seats</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr>
                                                <?php 
                                                    $query=("select reg_Id,Name,slot,no_of_Seats,free_Seats,Faculty_Id from registration,faculty where course_id ='$course_Id' and fac_Id = Faculty_ID order by slot asc");
                                                    $result=$connection->query($query);
                                                    if ($result === false) {
                                                        echo "<p>Query failed: ".$connection->error."</p>\n";
                                                        exit;
                                                    } else {
                                                        if ($result->num_rows > 0) {
                                                            while ($rowObj = $result->fetch_object()) {
                                                                $fs=$rowObj->free_Seats;
                                                                echo "<tr>
                                                                    <td>{$rowObj->Name}</td>";
                                                                    echo "<td>{$rowObj->slot}</td>";
                                                                    echo "<td>{$rowObj->no_of_Seats}</td>";
                                                                    $sl= substr($rowObj->slot,-1);
                                                                    
                                                                    if ($rowObj->free_Seats ==0) {
                                                                        echo "<td>0</td>";
                                                                    } elseif (mysqli_num_rows($connection->query("select * from enrolls,registration where registration.reg_id=enrolls.rg_id and student_id='$id' and registration.slot like '%$sl%' "))>0) {
                                                                        
                                                                        echo "<div class='form-check'> <td><input type='checkbox' class='form-check-input' value={$rowObj->slot} disabled><label>&nbsp;{$fs} &nbsp; No Free Slot</label></td></div>";
                                                                    }else {
                                                                        echo "<div class='form-check'><td> <input type='checkbox' class='form-check-input' name='cb' value={$rowObj->slot}#{$rowObj->Faculty_Id}#{$rowObj->reg_Id}><label>&nbsp; {$rowObj->free_Seats} </label></td></div>";
                                                                    }
                                                            }
                                                        }
                                                    }
                                                    
                                                ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div>
                                <div class="text-center">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Register">
                                </div>
                                <?php
                                    if (isset($_POST['submit'])) {
                                        if (isset($_POST['cb'])) {
                                            $val= $_POST['cb'];
                                            $exploded= explode('#', $val);

                                            $fac_id=$exploded[1];
                                            $slot=$exploded[0];
                                            $rg_id=$exploded[2];
                                            $slot=substr($slot,-1);
                                            $credits=0;
                                            if ($r=$connection->query("select Credits from courses where Course_ID='$course_Id'")) {
                                                while ($c = $r->fetch_object()) {
                                                    $credits=$c->Credits;
                                                }
                                            }
                                            if($ct+$credits > 24 ) {
                                                echo "<p class='ecBad'> Credits Limit Reached</p>";
                                            }
                                            elseif (mysqli_num_rows($connection->query("select * from enrolls,registration where enrolls.rg_id=registration.reg_id and registration.slot like '%$slot%' and enrolls.student_id=(select Student_id from students where Student_Name = '$name')"))==0) {
                                                if ($res=$connection->query("select * from enrolls,registration where enrolls.rg_id=registration.reg_id and registration.course_id ='$course_Id' and Student_id=(select Student_id from students where Student_Name = '$name')")) {
                                                    if (mysqli_num_rows($res)>0) {
                                                        echo "<p class='ecBad'> you have already registered this Course </p>";
                                                    } else {

                                                        if ($result=$connection->query("insert into enrolls (rg_id,Student_id) values('$rg_id',(select Student_Id from students where Student_Name = '$name'))")) {
                                                            $connection->query("update registration set free_Seats=(select free_seats from registration where reg_id='$rg_id')-1 where reg_id='$rg_id'");
                                                            $connection->query("update students set Creds_Taken = '$ct'+(select credits from courses where Course_ID='$course_Id') where Student_ID= '$id'");
                                                            
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
                                            
                                                            Alert('Registration status', 'Registered Successfully', 'Ok', "register.php");
                                                            </script>
                                                        <?php
                                                        } else {
                                                            echo $connection->error();
                                                        }
                                                    } 
                                                    
                                                } 
                                            } else {
                                                echo "<p class='ecBad'> You have already a course registered in this slot</p>";
                                            }
                                        } else {
                                            echo "<p class='ecBad'> please select a slot </p>";
                                        }


                                    }
                                ?>
                            </form>
                            <?php
                        }
                        else if(mysqli_num_rows($result)==2){
                            echo "<h5>";
                            echo "Theory Slots";
                            echo "</h5>";
                            ?>
                            <form method="post">
                                <div class="table-wrapper">
                                    <table class= "fl-table">
                                        <thead>
                                            <tr>
                                                <th>Faculty Name</th>
                                                <th>Slot</th>
                                                <th> total Seats</th>
                                                <th> Available Seats</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr>
                                                <?php 
                                                $type="theory";
                                                    $query=("select reg_Id,Name,slot,no_of_Seats,free_Seats,Faculty_Id from registration,faculty where course_id ='$course_Id' and fac_Id = Faculty_ID and type='theory' order by slot asc");
                                                    $result=$connection->query($query);
                                                    if ($result === false) {
                                                        echo "<p>Query failed: ".$connection->error."</p>\n";
                                                        exit;
                                                    } else {
                                                        if ($result->num_rows > 0) {
                                                            while ($rowObj = $result->fetch_object()) {
                                                                $fs=$rowObj->free_Seats;
                                                                echo "<tr>
                                                                    <td>{$rowObj->Name}</td>
                                                                    <td>{$rowObj->slot}</td>
                                                                    <td>{$rowObj->no_of_Seats}</td>";
                                                                    $sl = substr($rowObj->slot,-1);
                                                                    if ($rowObj->free_Seats ==0) {
                                                                        echo "<td>0</td>";
                                                                    } elseif (mysqli_num_rows($connection->query("select * from enrolls,registration where registration.reg_id=enrolls.rg_id and student_id='$id' and registration.slot like '%$sl%' "))>0) {
                                                                        
                                                                        echo "<div class='form-check'> <td><input type='checkbox' class='form-check-input' value={$rowObj->slot} disabled><label>&nbsp;{$fs} &nbsp;No Free Slot</label></td></div>";
                                                                    }else {
                                                                        echo "<div class='form-check'><td> <input type='checkbox' class='form-check-input' name='cb' value={$rowObj->slot}#{$rowObj->Faculty_Id}#{$rowObj->reg_Id}><label>&nbsp; {$rowObj->free_Seats} </label></td></div>";
                                                                    }
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php echo "<h5>";
                                echo "Lab Slots";
                                echo "</h5>"; ?>
                                <div class="table-wrapper">
                                    <table class= "fl-table">
                                        <thead>
                                            <tr>
                                                <th>Faculty Name</th>
                                                <th>Slot</th>
                                                <th> total Seats</th>
                                                <th> Available Seats</th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody>
                                            <tr>
                                                <?php 
                                                    $query=("select reg_Id,Name,slot,no_of_Seats,free_Seats,Faculty_Id from registration,faculty where course_id ='$course_Id' and fac_Id = Faculty_ID and type='lab' order by slot asc");
                                                    $result=$connection->query($query);
                                                    if ($result === false) {
                                                        echo "<p>Query failed: ".$connection->error."</p>\n";
                                                        exit;
                                                    } else {
                                                        if ($result->num_rows > 0) {
                                                            while ($rowObj = $result->fetch_object()) {
                                                                $fs=$rowObj->free_Seats;
                                                                echo "<tr>
                                                                    <td>{$rowObj->Name}</td>
                                                                    <td>{$rowObj->slot}</td>
                                                                    <td>{$rowObj->no_of_Seats}</td>";
                                                                    $sl = $sl= substr($rowObj->slot,-2);
                                                                    if ($fs ==0) {
                                                                        echo "<td>0</td>";
                                                                    } elseif (mysqli_num_rows($connection->query("select * from enrolls,registration where registration.reg_id=enrolls.rg_id and student_id='$id' and registration.slot like '%$sl%' "))>0) {
                                                                        
                                                                        echo "<div class='form-check'> <td><input type='checkbox' class='form-check-input' value={$rowObj->slot} disabled><label>&nbsp;{$fs} &nbsp; No Free Slot</label></td></div>";
                                                                    }else {
                                                                        echo "<div class='form-check'><td> <input type='checkbox' class='form-check-input' name='cb1' value={$rowObj->slot}#{$rowObj->Faculty_Id}#{$rowObj->reg_Id}><label>&nbsp; {$rowObj->free_Seats} </label></td></div>";
                                                                    }
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div >
                                <div class="text-center">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Register">
                                </div>
                                <?php
                                    if (isset($_POST['submit'])) {
                                        if (isset($_POST['cb']) && $_POST['cb1']) {
                                            $val= $_POST['cb'];
                                            $exploded= explode('#', $val);
                                            $fac_id=$exploded[1];
                                            $slot=substr($exploded[0],-1);
                                            $rg_id=$exploded[2];

                                            $val2=$_POST['cb1'];
                                            $exp2=explode('#', $val2);
                                            $fac_id2=$exp2[1];
                                            $lab_slot=$exp2[0];
                                            $rg_id2=$exp2[2];
                                            $credits=0;
                                            if ($r=$connection->query("select Credits from courses where Course_ID='$course_Id'")) {
                                                while ($c = $r->fetch_object()) {
                                                    $credits=$c->Credits;
                                                }
                                            }
                                            if ($ct+$credits > 24 ) {
                                                echo "<p class='ecBad'> Credits Limit Reached</p>";
                                            } elseif (mysqli_num_rows($connection->query("select * from enrolls,registration where enrolls.rg_id=registration.reg_id and registration.course_Id='$course_Id' and student_id=(select Student_Id from students where Student_Name = '$name') and registration.slot like '%$sl%'and registration.slot in ('$lab_slot') "))==0) {
                                                if ($res=$connection->query("select * from enrolls,registration where enrolls.rg_id=registration.reg_id and registration.course_id ='$course_Id' and Student_id=(select Student_id from students where Student_Name = '$name')")) {
                                                    if (mysqli_num_rows($res)>0) {
                                                        echo "<p class='ecBad'> You have already registered this course</p>";
                                                    } else {

                                                        if ($result=$connection->query("insert into enrolls (rg_id,Student_id) values('$rg_id',(select Student_Id from students where Student_Name = '$name'))") && $result=$connection->query("insert into enrolls (rg_id,Student_id) values('$rg_id2',(select Student_Id from students where Student_Name = '$name'))")) {
                                                            $connection->query("update registration set free_Seats=(select free_seats from registration where reg_id='$rg_id')-1 where reg_id='$rg_id'");
                                                            $connection->query("update registration set free_Seats=(select free_seats from registration where reg_id='$rg_id2')-1 where reg_id='$rg_id2'");
                                                            $connection->query("update students set Creds_Taken = '$ct'+(select credits from courses where Course_ID='$course_Id') where Student_ID= '$id'");
                                                            
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
                                            
                                                            Alert('Registration status', 'Registered Successfully', 'Ok', "register.php");
                                                            </script>
                                                        <?php
                                                        } else {
                                                            echo $connection->error();
                                                        }
                                                    } 
                                                    
                                                }
                                            } else {
                                                echo "<p class='ecBad'> You have already a course registered in this slot</p>";
                                            }
                                        } else {
                                            echo "<p class='ecBad'> please select a slot </p>"; 
                                        }
                                    }
                                ?>
                            </form>
                            <?php
                        }
                    ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $('input[type="checkbox"]').on('change', function() {
            $('input[name="' + this.name + '"]').not(this).prop('checked', false);
        });
    </script>
</body>
</html> 