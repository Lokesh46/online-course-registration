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
    <link rel="stylesheet" href="include/header_style.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <title>Home page</title>
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
            $result= $connection->query("SELECT * FROM students,department where Student_Name = '$name' and department.dept_id=branch");
            while ($rowObj = $result->fetch_object()) {
                $id=$rowObj->Student_ID;
                $ct= $rowObj->Creds_Taken;
                $cc= $rowObj->Creds_Completed;
                $dept= $rowObj->dept_name;
                $sem= $rowObj->currentSemester;
            }
                    
                    ?>
        

        <section class="bg-primary text-white  p-5 p-lg-0 pt-lg-5 text-center text-sm-start head">
            <div class="container">
                <div class="d-sm align-items-center justify-content-between">
                    <h1>Welcome <?php echo "${name} - "; echo $id; ?></h1>
                    <b>
                    <div class="row">
                        <div class="col-2">
                        Department: <?php echo $dept; ?><br>
                        Credits Registered: <?php echo "$ct"; ?>
                        </div>
                        <div class="col-2">
                        Current Semester: <?php echo $sem;?><br>
                        Credits Completed: <?php echo "$cc"; ?> <br><br></div>  
                    </div></b>
                </div>
            </div>     
        </section>
        <section class="p-5">
        <div class="container">
            <div class="row text-center g-4">
            <div class="col-md">
                <div class="card bg-white text-dark h-100">
                <img src="include/images/register.jpeg" class="card-img-top">
                <div class="card-body text-center">
                    <a href="register.php" class="btn btn-primary stretched-link">Register</a>
                </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card bg-white text-light h-100">
                    
                <img src="include/images/timetable.jpeg" class="card-img-top">
                <div class="card-body text-center">
                    <a href="timetable.php" class="btn btn-primary stretched-link">View</a>
                </div>
                </div>
            </div>
            <div class="col-md">
                <div class="card bg-white text-dark h-100">
                <img src="include/images/modify.jpeg" class="card-img-top">
                <div class="card-body text-center">
                    <a href="modify.php" class="btn btn-primary stretched-link">Modify</a>
                </div>
                </div>
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