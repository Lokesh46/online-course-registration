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
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <title>Home page</title>
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
            $result=($connection->query("SELECT count(reg_Id) as cnt FROM registration where fac_id='$id'"));
            while ($rowObj = $result->fetch_object()) { 
                $courses=$rowObj->cnt;
            }      
                    ?>
        <section class="bg-dark text-light p-5 p-lg-0 pt-lg-5 text-center text-sm-start head">
            <div class="container">
                <div class="d-sm-flex align-items-center justify-content-between">
                <div>
                    <h1>Welcome <?php echo $name; ?></h1>
                    <p class="card-text">
                    Department: <?php echo $dept; ?> <br>
                    Alloted Courses: <?php echo $courses; ?></br>
                    <br>
                    </p>
                    
                </div>
            </div>

        </section>

        
        
        <section class="p-5">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-4 g-4">
                <?php
                $result=$connection->query("SELECT * from registration,courses where fac_id='$id' and registration.course_Id=courses.Course_ID");
                while ($rowObj = $result->fetch_object()) { 
                    ?>
                <div class="col">
                    <div class="card bg-white text-dark h-100">
                    <img src="../include/images/image.png" class="card-img-top">
                        <div class="card-body text-center">
                            
                            <h4 class="card-title mb-3"> <?php echo "$rowObj->course_Id - "; echo ucfirst($rowObj->type); echo " - "; echo ucfirst($rowObj->slot); echo " Slot"; ?> </h4>
                            <p class="card-text">  <?php echo ucfirst($rowObj->Course_Name); ?> </p>
                            <?php echo"<a href='details.php?id={$rowObj->reg_Id}' class='btn btn-primary stretched-link'>View</a>"; ?>
                        </div>
                    </div>
                    
                </div> <?php } ?>
            <div>
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