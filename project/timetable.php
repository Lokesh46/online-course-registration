<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="include/table.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <title>Time Table</title>
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
            $id = $rowObj->Student_ID;
            $ct= $rowObj->Creds_Taken;
            $cc= $rowObj->Creds_Completed;
            
        }
    ?>
    <br>
    <div class="container">
        <div class="content">
        
            <div class="sh">
                <div class="title">Registered Courses</div>
                <div class="table-wrapper">
                    <table class="fl-table">
                        <thead>
                            <tr>
                                <th>Course ID</th>
                                <th>Course Name</th>
                                <th>Faculty Name</th>
                                <th>Course Type</th>
                                <th>Slot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $result = $connection->query("SELECT * from enrolls inner join registration on enrolls.rg_id=registration.reg_id and student_id=(select student_id from students where student_name='$name') order by registration.course_Id");
                                if ($result === false) {
                                    echo "<p>Query failed: ".$connection->error."</p>\n";
                                    exit;
                                } else {
                                    if ($result->num_rows > 0) {
                                        while ($rowObj = $result->fetch_object()) {
                                            echo "<tr>
                                            <td>{$rowObj->course_Id}</td>
                                            <td>"; $cn=$connection->query("SELECT distinct(course_name) from courses where course_id = '$rowObj->course_Id '");
                                                while ($rj=$cn->fetch_object()) {
                                                    echo "$rj->course_name";
                                                } echo "</td>
                                            <td>"; $cn=$connection->query("SELECT distinct(Name) from faculty where faculty_id = '$rowObj->fac_Id '");
                                            while ($rj=$cn->fetch_object()) {
                                                echo "$rj->Name";
                                            } echo " </td>
                                            <td>"; echo ucfirst($rowObj->type);  echo"</td>
                                            <td>{$rowObj->slot}</td></tr>";
                                        }
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="sh">
                <div class="title">Time Table</div>
                <div class="table-wrapper">
                    <table class="fl-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>9:00 - 9:50</th>
                                <th>10:00 - 10:50</th>
                                <th>11:00 - 11:50</th>
                                <th>12:00 - 12:50</th>
                                <th>Lunch</th>
                                <th>2:00 - 2:50</th>
                                <th>3:00 - 3:50</th>
                                <th>4:00 - 4:50</th>
                                <th>5:00 - 5:50</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Monday</th>
                                <td colspan='4'>Extra Activities</td>
                                <td></td>
                                <td colspan='4'>Extra Activities</td>

                            </tr>
                            <tr>
                                <th>Tuesday</th>
                                <td><?php checking("A",$connection,$id,'t') ?></td>
                                <td><?php checking("TBB",$connection,$id,'t') ?></td>
                                <td colspan='2'><?php checking("L5+L6",$connection,$id,'l') ?></td>
                                <td></td>
                                <td><?php checking("TE",$connection,$id,'t') ?></td>
                                <td><?php checking("F",$connection,$id,'t') ?></td>
                                <td colspan='2'><?php checking("L7+L8",$connection,$id,'l') ?></td>
                            </tr>

                            <tr>
                                <th>Wednesday</th>
                                <td><?php checking("B",$connection,$id,'t') ?></td>
                                <td><?php checking("TA",$connection,$id,'t') ?></td>
                                <td><?php checking("F",$connection,$id,'t') ?></td>
                                <td><?php checking("C",$connection,$id,'t') ?></td>
                                <td></td>
                                <td colspan='2'><?php checking("L11+L12",$connection,$id,'l') ?></td>
                                <td><?php checking("TDD",$connection,$id,'t') ?></td>
                                <td><?php checking("TEE",$connection,$id,'t') ?></td>
                            </tr>

                            <tr>
                                <th>Thursday</th>
                                <td><?php checking("TB",$connection,$id,'t') ?></td>
                                <td><?php checking("TFF",$connection,$id,'t') ?></td>
                                <td><?php checking("D",$connection,$id,'t') ?></td>
                                <td><?php checking("E",$connection,$id,'t') ?></td>
                                <td></td>
                                <td><?php checking("A",$connection,$id,'t') ?></td>
                                <td><?php checking("C",$connection,$id,'t') ?></td>
                                <td colspan='2'><?php checking("L9+L10",$connection,$id,'l') ?></td>
                            </tr>

                            <tr>
                                <th>Friday</th>
                                <td><?php checking("TAA",$connection,$id,'t') ?></td>
                                <td><?php checking("TCC",$connection,$id,'t') ?></td>
                                <td><?php checking("E",$connection,$id,'t') ?></td>
                                <td><?php checking("TF",$connection,$id,'t') ?></td>
                                <td></td>
                                <td><?php checking("B",$connection,$id,'t') ?></td>
                                <td><?php checking("TD",$connection,$id,'t') ?></td>
                                <td colspan='2'><?php checking("L13+L14",$connection,$id,'l') ?></td>
                            </tr>

                            <tr>
                                <th>Saturday</th>
                                <td colspan='2'><?php checking("L1+L2",$connection,$id,'l') ?></td>
                                <td><?php checking("TC",$connection,$id,'t') ?></td>
                                <td><?php checking("D",$connection,$id,'t') ?></td>
                                <td></td>
                                <td colspan='2'><?php checking("L3+L4",$connection,$id,'l') ?></td>
                                <td colspan='2'>Extra Activities</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    
        function checking($slot,$connection,$id,$type) 
        {
            $result = $connection->query("SELECT * from enrolls, registration where enrolls.rg_id= registration.reg_id and student_id='$id'");
            if ($type=='l') {
                
                while ($row = $result->fetch_object()) {
                    $regslot = $row->slot;
                    if ($regslot == $slot) {
                        echo "<div style='color:white; background-color:#DE603A'>";
                        echo "{$row->course_Id} - ";
                    }
                }
                echo $slot;
            } else {
                while ($row = $result->fetch_object()) {
                    $regslot = $row->slot;
                    if (strlen($regslot) == 4) {
                        $var= explode('+', $regslot);
                        $s1=$var[0];
                        $s2=$var[1];
                        
                        if ($s1 == $slot || $s2 == $slot) {
                            echo "<div style='color:white; background-color:#04F585'>";
                            echo "{$row->course_Id} - ";
                        }
                    } elseif (strlen($regslot) == 8) {
                        [$s1,$s2,$s3]= explode('+', $regslot);
                        
                        if ($s1 == $slot || $s2 == $slot || $s3 == $slot) {
                            echo "<div style='color:white; background-color:#04F585'>";
                            echo "{$row->course_Id} - ";
                        }
                    } elseif (strlen($regslot) == 1) {
                        if($regslot == $slot) {
                            echo "<div style='color:white; background-color:#04F585'>";
                            echo "{$row->course_Id} - ";
                        }
                    } else {
                        if($regslot == $slot) {
                            echo "<div style='color:white; background-color:#04F585'>";
                            echo "{$row->course_Id} - ";
                        }
                    }

                }
                echo $slot;
            }
        }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
        $(".sidebar ul li").on("click", function(){
            $(".sidebar ul li.active").removeClass("active");
            $(this).addClass("active");
        })
    </script>
</body>
</html>