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
        <div class="content" id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../admin_home.php">Users</a>
                    </li>
                    <li class="active">
                    <a class="nav-link active" aria-current="page" href="add_user.php">Add Users</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="delete_user.php">Delete Users</a>
                    </li>
                    
                </ul>

                </div>
            </div>
        </nav>
        
        <div class="container">
    <div class="title">Add User</div>
    <div class="content">
        <form method="post">
        <div class="user-details">
            <div class="input-box">
            <span class="details">Student Id</span>
            <input type="text" name="id" placeholder="Enter Studnet Id" required>
          </div>
          <div class="input-box">
            <span class="details">Name</span>
            <input type="text" name="name" placeholder="Enter Name" required>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="text" name="email" placeholder="Enter email" required>
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
          <div class="input-box">
            <span class="details">Credits_Taken(Ongoing)</span>
            <input type="text" name="credt" placeholder="Enter CreditsTaken" required>
          </div>
          <div class="input-box">
            <span class="details">Credits Completed</span>
            <input type="text" name="credc" placeholder="Enter Credits Completed" required>
          </div>
          <div class="input-box">
            <span class="details">Enter Password</span>
            <input type="text" name="pass" placeholder="Enter password" required>
          </div>
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="text" name="cpass" placeholder="Enter password" required>
          </div>
        </div>
        
        <div class="button">
          <input type="submit" name="submit" value="Insert">
        </div>
        <div class="details">
        <?php
	include_once '../db.php';
        if(isset($_POST['submit']))
		{	 
			$id = $_POST['id'];
			$name = $_POST['name'];
            $creditt = $_POST['credt'];
            $creditc = $_POST['credc'];
            $dept = $_POST['dept'];
            $email = $_POST['email'];
            
            $password = $_POST['pass'];
            $cpassword = $_POST['cpass'];

            if($cpassword==$password){
                $sql = "Insert into students(Student_ID,Student_Name,Student_Email,Branch,Creds_Taken,Creds_Completed,password) 
                VALUES ('$id','$name','$email','$dept','$creditt','$creditc','$password')";
                try {
                  $connection->query($sql);
                  echo "<p class='ec'>" . "User Added Successfully" . "</p>";         
                  } catch (Exception $e) {
                      $e="User is already present";
                      echo "<p class='ec'>" . $e . "</p>";
                  }
              
            } else {
              echo "<p class='ec'>" . "Please check password" . "</p>";
                
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