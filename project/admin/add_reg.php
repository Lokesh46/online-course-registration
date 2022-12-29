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
                        <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="reg.php">Registration</a>
                        </li>
                        <li class="active">
                        <a class="nav-link active" aria-current="page" href="#">Add Courses</a>
                        </li>
                        
                        
                    </ul>

                    </div>
                </div>
            </nav>
            <div class="container">
    <div class="title">Add Course</div>
    <div class="content">
        <form method="POST">
        <div class="user-details">

            <div class="input-box">       
                    <span class="details">Department</span>
                    <?php
                        include "db.php"; 
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
            <span class="details">Course Name</span>
            <select class="own" id="cou" name="cou">
                    <option value="none">Select Department first</option>
                    </select>
                
                </div>

            <div class="input-box">       
                <span class="details">Faculty Name</span>
                
                    <select class="own" id="fac" name="fac">
                    <option value="none">Select Department first</option>
                    </select>
                </div>            

            <div class="input-box">   
                <span class="details">Number of Seats</span>
                <input type="text" name="nos" placeholder="Enter Number of Seats" required>
            </div>  

            <div class="input-box">   
                <span class="details"> Theory/Lab </span>
                <select class="own" name="type" id="type" required>
                <option value="none">Select Course first</option>
                    </select>
                </div>

            <div class="input-box">   
                <span class="details"> Slot </span>
                <select class="own" name="slot" id="slot" required>
                <option value="none">Select Course type first</option>
                    </select>
                </div>
        </div>
        
        <div class="button">
            <input type="submit" name="submit" value="Insert">
        </div>
        <div class="details">
        <?php
	include_once 'db.php';
        if (isset($_POST['submit'])) {
            $fac_name = $_POST['fac'];
			$cid = $_POST['cou'];
            $slot = $_POST['slot'];
            $lastSlot=substr($slot,-1);
            $no = $_POST['nos'];
            $type=$_POST['type'];
            $que = "select * from registration where fac_Id ='$fac_name' and slot like '%$lastSlot%'";
            $result = mysqli_query($connection, $que);
            if (mysqli_num_rows($result) == 0) {
                $sql = "Insert into registration(course_Id,fac_Id,slot,no_of_Seats,free_Seats,type) 
                VALUES ('$cid',$fac_name,'$slot','$no','$no','$type')";
                
                try {
                    $connection->query($sql);
                    $msg="Course Added Successfully";  
                    echo "<p class='ec'>" .$cid." " .$msg . "</p>";          
                } catch (Exception $e) {
                    $e="Course is already present";
                    echo "<p class='ec'>" . $e . "</p>";
                }
            }
            else {
                echo "<p class='ec'>" . "Faculty has a course already alloted at this slot" . "</p>";
            }
            
            
            $connection->close();
        }
    ?>
        
        </div>
    </form>
    </div>
            
            
                
        </div>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    <script>
        
        $(document).ready(function(){
            $('#dept').on('change', function(){
                
            
                
                var deptid=$(this).val();
                
                if(deptid){
                    $.ajax({
                        
                        type:'POST',
                        url:'ajax.php',
                        data: 'dept_id_fac='+deptid,
                        success:function(html){
                            $('#fac').html(html);
                        }
                        
                    });
                }
                else{
                    
                    $('#fac').html('<option value="">Select Department First</option>');
                }

                if(deptid){
                    $.ajax({
                        
                        type:'POST',
                        url:'ajax.php',
                        data: 'dept_id_course='+deptid,
                        success:function(html){
                            $('#cou').html(html);
                        }
                        
                    });
                }
                else{
                    
                    $('#cou').html('<option value="">Select Department First</option>');
                }
            });

            $('#type').on('change', function(){
                
                var type=$(this).val()+'#'+$('#cou').val();
                console.log(type);
                
                if(type){
                    $.ajax({
                        
                        type:'POST',
                        url:'ajax.php',
                        data: 'type='+type,
                        success:function(html){
                            $('#slot').html(html);
                        }
                        
                    });
                }
                else{
                    
                    $('#slot').html('<option value="">Select Course Type First</option>');
                }
            });

            $('#cou').on('change', function(){
                
                var id=$(this).val();
                
                if(id){
                    $.ajax({
                        
                        type:'POST',
                        url:'ajax.php',
                        data: 'c_type='+id,
                        success:function(html){
                            $('#type').html(html);
                        }
                        
                    });
                }
                else{
                    
                    $('#type').html('<option value="">Select Course First</option>');
                }
            });
        });
    </script>
    <script>
        $(".sidebar ul li").on("click", function(){
            $(".sidebar ul li.active").removeClass("active");
            $(this).addClass("active");
        })
    </script>
</body>
</html>