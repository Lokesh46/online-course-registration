<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="include/table.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <title>Register</title>
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
        
        $ct= $rowObj->Creds_Taken;
        $cc= $rowObj->Creds_Completed;
        $st_dept= $rowObj->Branch;
        
    }
?>
    
    
    <div class="container">              
            <br><?php
                if (isset($_GET['search'])) {
                    if (empty($_GET['search'])){
                        header('Location:home.php');
                    } else {
                        $search_id=$_GET['search'];
                    }
                }
            ?>
        <?php
            $var = true;
            try{
                $connection->query("select * from registration");
            }
            catch(exception $msg){
            ?>                          
                <?php
                    $var=false;
                    $msg="There is no ongoing registration";
                    echo "<p class='ec'>" . $msg . "</p>";
            }
        if ($var) {
            ?>
        <div class="content">      
            <div class="table-wrapper">
            <form method="POST">
                <div class="user-details">
                    <div style='padding-left:30px'  class="input-box">
                    
                    <h6> Filter: Select Department </h6>                    
                    <?php
                        if ($r_set = $connection->query("SELECT dept_Id,dept_name from department")) {
                        echo "<select class='own' name='dept_dd' id='dept_dd'>";
                            echo "<option value='none' selected disabled hidden>---select---</option>";
                        while ($row = $r_set->fetch_assoc()) { 
                            echo "<option value=$row[dept_Id]>$row[dept_name]</option>";
                        }echo "</select>";
                        
                        } else {
                            echo $connection->error;
                        }
                        
                    ?>
                    
                    </div>
                    <p style='padding-right:100px' class="text-left text-primary"><br> Note: &nbsp;&nbsp;<i class="fas fa-times"></i> -> Pre Requisite Course Needs to be Completed<br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fas fa-check"></i> -> Already Registered </p>
                    
                </div>
            </form>
            
                    
            <table name="reg" id="reg" class="fl-table">
                <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>Credits</th>
                    <th>Course Type</th>
                    <th>Pre-Requisite</th> 
                    <th>Register</th> 
                </tr>
                </thead>

                <?php
                if (isset($search_id)) {
                    $sql = "SELECT distinct(reg.course_Id),(c.Course_Name),c.PreReqID,c.Credits,c.CourseType
                    FROM registration reg,courses c,faculty fac
                    where reg.course_Id = c.course_Id and (reg.course_Id like '%$search_id%' or c.Course_Name like '%$search_id%' or credits like '%$search_id%') order by course_id";
                } else {
                    $sql = "SELECT distinct(reg.course_Id),(c.Course_Name),c.PreReqID,c.Credits,c.CourseType
                    FROM registration reg,courses c
                    where reg.course_Id = c.course_Id order by course_id";
                }
                $queryResult = $connection->query($sql);

                
                if ($queryResult === false) {
                    echo "<p>Query failed: ".$dbConn->error."</p>\n";
                    exit;
                } else {
                    if ($queryResult->num_rows > 0) {
                        while ($rowObj = $queryResult->fetch_object()) {
                            echo "<tr>
                            <td>{$rowObj->course_Id}</td>
                            <td>{$rowObj->Course_Name}</td>
                            <td>{$rowObj->Credits}</td>
                            <td>{$rowObj->CourseType}</td>
                            <td>{$rowObj->PreReqID}</td>
                            <td>";
                            if (mysqli_num_rows($connection->query("select * from enrolls,registration where enrolls.rg_id = registration.reg_id and registration.course_Id = '$rowObj->course_Id' and student_id =(select student_id from students where student_name= '$name')")) > 0) {
                                echo  "<i class='fas fa-check'></i>";
                            } elseif (mysqli_num_rows($connection->query("SELECT * from courses_history where student_id = (select student_id from students where student_name = '$name') and Course_ID ='$rowObj->PreReqID'")) == 0 && strlen($rowObj->PreReqID)!=0) {
                                echo '<i class="fas fa-times"></i>';
                            } elseif (mysqli_num_rows($connection->query("SELECT * from courses_history where student_id = (select student_id from students where student_name = '$name') and  Course_ID='$rowObj->course_Id'"))>0) {
                                

                                echo"<a href='course_reg.php?id={$rowObj->course_Id}' class='btn btn-primary'>Register</a>";
                            }else { 
                                echo"<a href='course_reg.php?id={$rowObj->course_Id}' class='btn btn-primary'>Register</a>";
                            } echo "</td> 
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan=5>No relavent matches found</td></tr>";
                    }
                }
                ?>

            </table></div>
            <br>
        
    <?php } ?>                    
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        
        $(document).ready(function(){
            
            $('#dept_dd').on('change', function(){
                var deptid=$(this).val();
                console.log(deptid);
                if(deptid){
                    $.ajax({
                        
                        type:'POST',
                        url:'ajax.php',
                        data: 'dept_id='+deptid,
                        success:function(html){
                            $('#reg').html(html);
                        }
                        
                    });
                }                
            });
            
        });
        </script>
</body>
</html>