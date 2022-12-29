<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" rel="stylesheet" />
    <link rel="stylesheet" href="../include/header_style.css" />
    <link rel="stylesheet" href="../include/table.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <title>Details</title>
    </head>
    <body>
        <?php 
            include('header.php'); 
            include '../include/db.php';
            if(!empty($_SESSION['fac_id'])) {
                $id=$_SESSION['fac_id'];
            } else {
                ?> <script language="javascript">
                document.location="index.php";
                </script>
                <?php
            }
            $result= $connection->query("SELECT * FROM faculty,department where Faculty_Id = '$id' and department.dept_id=faculty.dept_id");
            while ($rowObj = $result->fetch_object()) {
                $name=$rowObj->Name;
                $dept= $rowObj->dept_name;
            }
        ?>
        <br>
        <div class="container">
            <div class="content">
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
                                <th style="background-color:#0e6cc4; color:#ffffff">Monday</th>
                                <td colspan='4'>Extra Activities</td>
                                <td></td>
                                <td colspan='4'>Extra Activities</td>

                            </tr>
                            <tr>
                                <th style="background-color:#324960; color:#ffffff">Tuesday</th>
                                <td><?php checking("A",$connection,$id,'t') ?></td>
                                <td><?php checking("TBB",$connection,$id,'t') ?></td>
                                <td colspan='2'><?php checking("L5+L6",$connection,$id,'l') ?></td>
                                <td></td>
                                <td><?php checking("TE",$connection,$id,'t') ?></td>
                                <td><?php checking("F",$connection,$id,'t') ?></td>
                                <td colspan='2'><?php checking("L7+L8",$connection,$id,'l') ?></td>
                            </tr>

                            <tr>
                                <th style="background-color:#0e6cc4; color:#ffffff">Wednesday</th>
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
                                <th style="background-color:#324960; color:#ffffff">Thursday</th>
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
                                <th style="background-color:#0e6cc4; color:#ffffff">Friday</th>
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
                                <th style="background-color:#324960; color:#ffffff">Saturday</th>
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

        <?php
    
        function checking($slot,$connection,$id,$type) 
        {
            $result = $connection->query("SELECT * from registration where fac_Id='$id'");
            if ($type=='l') {
                
                while ($row = $result->fetch_object()) {
                    $regslot = $row->slot;
                    if ($regslot == $slot) {
                        echo "<div style='color:white; background-color:#DE603A'>";
                        echo $row->course_Id;
                        echo " - ";
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
                            echo $row->course_Id;
                            echo " - ";
                        }
                    } elseif (strlen($regslot) == 8) {
                        [$s1,$s2,$s3]= explode('+', $regslot);
                        
                        if ($s1 == $slot || $s2 == $slot || $s3 == $slot) {
                            echo "<div style='color:white; background-color:#04F585'>";
                            echo $row->course_Id;
                            echo " - ";
                        }
                    } elseif (strlen($regslot) == 1) {
                        if($regslot == $slot) {
                            echo "<div style='color:white; background-color:#04F585'>";
                            echo $row->course_Id;
                            echo " - ";
                        }
                    } else {
                        if($regslot == $slot) {
                            echo "<div style='color:white; background-color:#04F585'>";
                            echo $row->course_Id;
                            echo " - ";
                        }
                    }

                }
                echo $slot;
            }
        }
    ?>
    </body>
</html>