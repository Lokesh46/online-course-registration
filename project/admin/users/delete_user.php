<?php session_start();
if(!empty($_SESSION['uname']))
                $name=$_SESSION['uname'];
            else {
                ?> <script language="javascript">
                document.location="../admin.php";
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
    <link rel="stylesheet" href="../../include/style.css?v=<?php echo time(); ?>" />
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
                <li class="active"><a href="../admin_home.php" class="text-decoration-none px-3 py-2 d-block"><em class="far fa-registered">&nbsp;</em>Manage users</a></li>
                <li class=""><a href="../courses/courses.php" class="text-decoration-none px-3 py-2 d-block"><i class="fas fa-table"></i>&nbsp;Courses</a></li>
                <li class=""><a href="../faculty/faculty.php" class="text-decoration-none px-3 py-2 d-block"><i class="far fa-exchange"></i>&nbsp;Faculty</a></li>
                <li class=""><a href="../reg.php" class="text-decoration-none px-3 py-2 d-block"><i class="fab fa-discourse">&nbsp;</i>Registration</a></li>
                <li class=""><a href="../logout.php"class="text-decoration-none px-3 py-2 d-block" onclick="return confirm('Are you sure you want to log out?');"><i class="far fa-sign-out"></i>&nbsp;Log Out</a></li>
            </ul>
            <hr class="h-color mx-2">
        </div>
        <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../admin_home.php">Users</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="add_user.php">Add User</a>
                    </li>
                    <li class="active">
                    <a class="nav-link active" aria-current="page" href="#">Delete User</a>
                    </li>
                    
                </ul>

                </div>
            </div>
        </nav>
        <div class="table-wrapper">
            <table class="fl-table">
                <thead>
                <tr>
                <th>Student ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Delete</th>
                </tr>
                </thead>

            <?php
            include '../db.php';      // makes db connection

            $sql = "SELECT Student_ID,Student_Name,Student_Email,dept_name,Creds_Taken,Creds_Completed,Password FROM students,department where dept_id=branch";
            $queryResult = $connection->query($sql);

            // Check for and handle query failure
            if($queryResult === false) {
                echo "<p>Query failed: ".$dbConn->error."</p>\n";
                exit;
            }
            // Otherwise fetch all the rows returned by the query one by one
            else {
                if ($queryResult->num_rows > 0) {
                    while ($rowObj = $queryResult->fetch_object()) {
                        echo "<tr>
                            <td>{$rowObj->Student_ID}</td>
                            <td>{$rowObj->Student_Name}</td>
                            <td>{$rowObj->dept_name}</td>
                            <td><a style='color: black' id='delete' href=del.php?id={$rowObj->Student_ID}><i class='far fa-user-minus'></i></a></td>";
                    }
                }
            }
            ?>

            </tr>
            </table>
        </div>

    
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