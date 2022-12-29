<?php session_start();
if(!empty($_SESSION['uname']))
                $name=$_SESSION['uname'];
            else {
                ?> <script language="javascript">
                document.location="admin.php";
                </script>
                <?php
            }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../include/style.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <title>Home Page</title>
</head>
<body>
    <div class="main-container d-flex">
        <div class="sidebar" id ="side_nav">
            <div class="header-box px-2 pt-3 pb-4">
                <h1 class="fs-4"><span class="bg-white text-dark rounded shadow px-2 me-2"><i class="fas fa-user-tie"></i></span><span class="text-white"><?php
                echo " ".$_SESSION['uname'];
                ?></a></span></h1>
                <button class="btn d-mb-none d-block close-btn px-1 py-0 text-white"><em class="fal fa-stream"></em></button>
            </div>
            <ul class="list-unstyled px-2">
                <li class=""><a href="admin_home.php" class="text-decoration-none px-3 py-2 d-block"><em class="far fa-registered">&nbsp;</em>Manage users</a></li>
                <li class=""><a href="courses/courses.php" class="text-decoration-none px-3 py-2 d-block"><i class="fas fa-table"></i>&nbsp;Courses</a></li>
                <li class=""><a href="faculty/faculty.php" class="text-decoration-none px-3 py-2 d-block"><i class="far fa-exchange"></i>&nbsp;Faculty</a></li>
                <li class="active"><a href="reg.php" class="text-decoration-none px-3 py-2 d-block"><i class="fab fa-discourse">&nbsp;</i>Registration</a></li>
                <li class=""><a href="logout.php" class="text-decoration-none px-3 py-2 d-block" onclick="return confirm('Are you sure you want to log out?');" ><i class="far fa-sign-out"></i>&nbsp;Log Out</a></li>
            </ul>
            <hr class="h-color mx-2">
        </div>
        
        <div class="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="active">
                        <a class="nav-link active" aria-current="page" href="reg.php">Registration</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="add_reg.php">Add Courses</a>
                        </li>
                        
                        
                    </ul>

                    </div>
                </div>
            </nav>
            <div class="container">
                <div class="title">Registration Status</div><br>
                <form method="post">
                    <?php
                    include "db.php";
                        $result=$connection->query("select * from registration_status where semester=1");
                        while ($rowObj=$result->fetch_object()) {
                            if ($rowObj->status ==0 ) {
                                echo "<input type='checkbox' class='btn-check' name='check1' id='check1' autocomplete='off'>
                                        <label class='btn btn-outline-success' for='check1'>Semester 1</label> &nbsp;";
                            } else {
                                echo "<input type='checkbox' class='btn-check' name='check1' id='check1' autocomplete='off' checked>
                                <label class='btn btn-outline-success' for='check1'>Semester 1</label> &nbsp;";
                            }
                            
                        }
                        echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
                        $result=$connection->query("select * from registration_status where semester=2");
                        while ($rowObj=$result->fetch_object()) {
                            if ($rowObj->status ==0 ) {
                                echo "<input type='checkbox' class='btn-check' name='check2' id='check2' autocomplete='off'>
                                        <label class='btn btn-outline-success' for='check2'>Semester 2</label> &nbsp;";
                            } else {
                                echo "<input type='checkbox' class='btn-check' name='check2' id='check2' autocomplete='off' checked>
                                <label class='btn btn-outline-success' for='check2'>Semester 2</label> &nbsp;";
                            }
                            
                        }
                        echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
                        $result=$connection->query("select * from registration_status where semester=3");
                        while ($rowObj=$result->fetch_object()) {
                            if ($rowObj->status ==0 ) {
                                echo "<input type='checkbox' class='btn-check' name='check3' id='check3' autocomplete='off'>
                                        <label class='btn btn-outline-success' for='check3'>Semester 3</label> &nbsp;";
                            } else {
                                echo "<input type='checkbox' class='btn-check' name='check3' id='check3' autocomplete='off' checked>
                                <label class='btn btn-outline-success' for='check3'>Semester 3</label> &nbsp;";
                            }
                            
                        }
                        echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
                        $result=$connection->query("select * from registration_status where semester=4");
                        while ($rowObj=$result->fetch_object()) {
                            if ($rowObj->status ==0 ) {
                                echo "<input type='checkbox' class='btn-check' name='check4' id='check4' autocomplete='off'>
                                        <label class='btn btn-outline-success' for='check4'>Semester 4</label> &nbsp;";
                            } else {
                                echo "<input type='checkbox' class='btn-check' name='check4' id='check4' autocomplete='off' checked>
                                <label class='btn btn-outline-success' for='check4'>Semester 4</label> &nbsp;";
                            }
                            
                        }
                        echo "<br><br>";
                        $result=$connection->query("select * from registration_status where semester=5");
                        while ($rowObj=$result->fetch_object()) {
                            if ($rowObj->status ==0 ) {
                                echo "<input type='checkbox' class='btn-check' name='check5' id='check5' autocomplete='off'>
                                        <label class='btn btn-outline-success' for='check5'>Semester 5</label> &nbsp;";
                            } else {
                                echo "<input type='checkbox' class='btn-check' name='check5' id='check5' autocomplete='off' checked>
                                <label class='btn btn-outline-success' for='check5'>Semester 5</label> &nbsp;";
                            }
                            
                        }
                        echo "&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;";
                        $result=$connection->query("select * from registration_status where semester=6");
                        while ($rowObj=$result->fetch_object()) {
                            if ($rowObj->status ==0 ) {
                                echo "<input type='checkbox' class='btn-check' name='check6' id='check6' autocomplete='off'>
                                        <label class='btn btn-outline-success' for='check6'>Semester 6</label> &nbsp;";
                            } else {
                                echo "<input type='checkbox' class='btn-check' name='check6' id='check6' autocomplete='off' checked>
                                <label class='btn btn-outline-success' for='check6'>Semester 6</label> &nbsp;";
                            }
                            
                        }
                    ?>
                    <br><br>
                    <div class="text-center">
                        <input class="btn btn-primary" type="submit" name="status" value="Update">
                    </div>
                    
                </form>
            </div>
            <?php
                if (isset($_POST['status'])) {

                    if (!empty($_POST['check1'])) {
                        $connection->query("update registration_status set status = 1 where semester =1 ");
                    } else {
                        $connection->query("update registration_status set status = 0 where semester =1 ");
                    }

                    if (!empty($_POST['check2'])) {
                        $connection->query("update registration_status set status = 1 where semester =2 ");
                    } else {
                        $connection->query("update registration_status set status = 0 where semester =2 ");
                    }

                    if (!empty($_POST['check3'])) {
                        $connection->query("update registration_status set status = 1 where semester =3 ");
                    } else {
                        $connection->query("update registration_status set status = 0 where semester =3 ");
                    }

                    if (!empty($_POST['check4'])) {
                        $connection->query("update registration_status set status = 1 where semester =4 ");
                    } else {
                        $connection->query("update registration_status set status = 0 where semester =4 ");
                    }

                    if (!empty($_POST['check5'])) {
                        $connection->query("update registration_status set status = 1 where semester =5 ");
                    } else {
                        $connection->query("update registration_status set status = 0 where semester =5 ");
                    }

                    if (!empty($_POST['check6'])) {
                        $connection->query("update registration_status set status = 1 where semester =6 ");
                    } else {
                        $connection->query("update registration_status set status = 0 where semester =6 ");
                    }

                    echo "<meta http-equiv='refresh' content='0'>";
                    /*if (isset($_POST['check1']) && isset($_POST['status'])) {
                        $connection->query("update registration_status set status = 1 where semester =1 ");
                    } else {
                        $connection->query("update registration_status set status = 0 where semester =1 ");
                    }
                    if (isset($_POST['check2']) && isset($_POST['status'])) {
                        $var =$_POST['check2'];
                        echo $var;
                    }
                    if (isset($_POST['check3']) && isset($_POST['status'])) {
                        echo "good";
                    }
                    if (isset($_POST['check4']) && isset($_POST['status'])) {
                        echo "good";
                    }
                    if (isset($_POST['check5']) && isset($_POST['status'])) {
                        echo "good";
                    }
                    if (isset($_POST['check6']) && isset($_POST['status'])) {
                        echo "good";
                    }*/
                }
            ?>
                <?php
                $var = true;
                    include_once 'db.php';
                    try{
                        $connection->query("select * from registration");
                        ?>
                        
                        <form class="button" method="post" action="start_reg.php" onclick="return confirm('Are you sure you want to end this registration?');">
                        <input type="submit" name="end" value="End Registration">
                        
                    </form>

                        <?php
                    }
                    catch(exception $msg){
                        ?>  
                            
                            <form class="button" method="post" action="start_reg.php">
                        <input type="submit" name="start" value="Start Registration">
                        
                        <?php
                        $var=false;
                        $msg="There is no ongoing registration";
                        echo "<p class='ec'>" . $msg . "</p>";
                        ?>
                        </form>
                        <?php
                    }
                    if ($var) {
                        ?>
                        

                        <div class='table-wrapper'>
                            <div style="padding:20px;">
                                <form class="form-search" method="post">
                                    <input type="search" placeholder="Enter" name="search" id="search">
                                    <button type="submit" name="s" id="s"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                        <?php
                        if(isset($_POST['s'])) {
                            if(!empty($_POST['search'])) {
                                $search_id= $_POST['search'];
                            }
                        }
                        if(isset($search_id)){
                            $query="SELECT reg.reg_Id, c.course_Name,fac.Name,reg.slot,reg.no_of_Seats,reg.free_Seats,type 
                            FROM registration reg,courses c,faculty fac
                            where reg.course_Id = c.course_Id and reg.fac_Id=fac.faculty_Id  and (c.course_Name like '%$search_id%' or Name like '%$search_id%' or c.course_Id like '%$search_id%')";
                        } else{
                        $query = "SELECT reg.reg_Id, c.course_Name,fac.Name,reg.slot,reg.no_of_Seats,reg.free_Seats,type 
                        FROM registration reg,courses c,faculty fac
                        where reg.course_Id = c.course_Id and reg.fac_Id=fac.faculty_Id ";
                        }
                        $result = mysqli_query($connection, $query);
                        ?>
                        
                        <table class="fl-table"><thead>
                        <tr>
                            <th>Reg ID</th>
                            <th>Course Name</th>
                            <th>Faculty Name</th>
                            <th>Slot</th>
                            <th>Type</th>
                            <th>Total number of seats</th>
                            <th>Free seats</th>
                            <th>Add Seats</th>
                            
                        </tr>
                        </thead>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                        while($data = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                        <td><?php echo $data['reg_Id']; ?> </td>
                        <td><?php echo $data['course_Name']; ?> </td>
                        <td><?php echo $data['Name']; ?> </td>
                        <td><?php echo $data['slot']; ?> </td>
                        <td><?php echo ucfirst($data['type']); ?> </td>
                        <td><?php echo $data['no_of_Seats']; ?> </td>
                        <td><?php echo $data['free_Seats']; ?> </td>
                        <td><a  href="start_reg.php?id=<?php echo $data['reg_Id']; ?>"><i class="fas fa-plus"></i></a>
                        </td>
                        
                        <tr>
                        <?php
                        }} else { ?>
                            <tr>
                            <td colspan="8">No data found</td>
                            </tr>
                        <?php } ?>
                        </table>
                        </div>
                        <?php
                    }
            ?>            
        </div>
        
    </div>
    
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