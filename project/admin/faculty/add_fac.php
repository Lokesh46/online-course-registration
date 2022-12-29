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
                <li class=""><a href="../admin_home.php" class="text-decoration-none px-3 py-2 d-block"><em class="far fa-registered">&nbsp;</em>Manage users</a></li>
                <li class=""><a href="../courses/courses.php" class="text-decoration-none px-3 py-2 d-block"><i class="fas fa-table"></i>&nbsp;Courses</a></li>
                <li class="active"><a href="../faculty/faculty.php" class="text-decoration-none px-3 py-2 d-block"><i class="far fa-exchange"></i>&nbsp;Faculty</a></li>
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
                    <a class="nav-link active" aria-current="page" href="faculty.php">Faculty</a>
                    </li>
                    <li class="active">
                    <a class="nav-link active" aria-current="page" href="add_fac.php">Add Faculty</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="delete_fac.php">Delete Faculty</a>
                    </li>
                    
                </ul>

                </div>
            </div>
        </nav>
        
        <div class="container">
    <div class="title">Add Faculty</div>
    <div class="content">
        <form method="POST">
        <div class="user-details">
            <div class="input-box">
            <span class="details">Faculty Id</span>
            <input type="text" name="id" placeholder="Enter Faculty Id" required>
        </div>
            <div class="input-box">
            <span class="details">Name</span>
            <input type="text" name="name" placeholder="Enter Faculty Name" required>
        </div>
        
            <div class="input-box">
            <span class="details">G-Mail</span>
            <input type="text" name="mail" placeholder="Enter Faculty G-Mail" required>
        
        </div>
            <div class="input-box">
            <span class="details">Password</span>
            <input type="text" name="pass" placeholder="Enter Password" required>
        </div>
        <div class="input-box">       
                <span class="details">Department</span>
                <?php
                    include "../db.php"; 
                    if($r_set = $connection->query("SELECT dept_Id,dept_name from department")){
                    ?>
                    <select class="own" id="dept" name="dept">
                    <option value="none" selected disabled hidden>Select Department Name</option>
                    <?php
                    while ($row = $r_set->fetch_assoc()) { 
                        echo "<option value=$row[dept_Id]>$row[dept_name]</option>";
                    }?>
                    </select>
                    <?php
                    }else{
                        echo $connection->error;
                    }
                ?>
        </div>
            
    </div>
        
        <div class="button">
            <input type="submit" name="submit" value="Insert">
        </div>
        <div class="details">
        <?php
	include_once '../db.php';
        if (isset($_POST['submit'])) {	 
			$id = $_POST['id'];
			$name = $_POST['name'];
            $dept = $_POST['dept'];
            $mail= $_POST['mail'];
            $pass= $_POST['pass'];
			$sql = "Insert into faculty(Faculty_Id,Name,dept_id,gmail,password) 
            VALUES ('$id','$name','$dept','$mail','$pass')";
            
            try {
                $connection->query($sql);
                $msg="Faculty Added Successfully";    
                echo "<p class='ec'>" . $msg . "</p>";          
            } catch (Exception $e) {
                $e="Faculty is already present";
                echo "<p class='ec'>" . $e . "</p>";
            }
            
            $connection->close();
        }
    ?>
        </div>
    </form>
    </div>
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