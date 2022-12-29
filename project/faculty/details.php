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
            $course_Id=$_GET["id"];
        ?>

        <section class="bg-light text-dark p-5 p-lg-0 pt-lg-5 text-center text-sm-start head">
            <div class="container">
                <div class="content">
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                                <tr>
                                    <th>Course ID</th>
                                    <th>Course Name</th>
                                    <th>Type</th>
                                    <th>Slot</th>
                                    <th>Total Capacity</th>
                                    <th>Registered Students</th>
                                    <th>Add Seats</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $result=$connection->query("SELECT * from registration,courses where courses.Course_ID=registration.course_Id and registration.fac_Id='$id' and reg_Id='$course_Id'");
                                    while ($rowObj=$result->fetch_object()) {
                                        $var=$rowObj->no_of_Seats-$rowObj->free_Seats;
                                        echo "<tr>
                                            <td>{$rowObj->Course_ID}</td>
                                            <td>{$rowObj->Course_Name}</td>
                                            <td>{$rowObj->type}</td>
                                            <td>{$rowObj->slot}</td>
                                            <td>{$rowObj->no_of_Seats}</td>
                                            <td>{$var}</td>";
                                            $reg_id=$rowObj->reg_Id;?>

                                            <td><a href="add_seats.php?id=<?php echo $rowObj->reg_Id; ?>"><i class="fas fa-plus"></i></a></td>
                                            <?php
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                        
                    <div  class="title">Student Details</div>
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Student Name</th>
                                    <th>Current Semester</th>
                                    <th>Department</th>
                                    <th>Registered Date</th>
                                    <th>Registered Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $result=$connection->query("SELECT * from enrolls,students,department where rg_Id='$course_Id' and enrolls.student_id=students.Student_ID and department.dept_id = students.Branch");
                                    while ($rowObj=$result->fetch_object()) {
                                        echo "<tr>
                                            <td>{$rowObj->student_id}</td>
                                            <td>{$rowObj->Student_Name}</td>
                                            <td>{$rowObj->currentSemester}</td>
                                            <td>{$rowObj->dept_name}</td>
                                            <td>#</td>
                                            <td>#</td>
                                        </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>

        <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"
        ></script>
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>

        
    </body>
    </html>