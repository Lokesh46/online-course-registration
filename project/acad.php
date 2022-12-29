<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="include/table.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <title>Academic history</title>
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
                $id=$rowObj->Student_ID;
                $ct= $rowObj->Creds_Taken;
                $cc= $rowObj->Creds_Completed;
                
            }
        ?>
        <br>

        <div class="container">
            <div class="content">
            <div class="table-wrapper">
                <form method="POST">
                    <div class="user-details">
                        
                        <div style='padding-left:30px' class="input-box">
                            <span class="details">Select Semester</span>  
                            
                                    <select class='own' id='sem' name='sem'>
                                        <option value="" > Select </option>
                                        <?php
                                            if ($result=$connection->query("SELECT distinct(Semester) from courses_history where Student_Id='$id' order by Semester DESC")) {
                                                while($rowObj = $result->fetch_object()) {
                                                    echo "<option value='{$rowObj->Semester}'> Semester {$rowObj->Semester}</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                        </div> 
                    </div>
                </form>           
            <div class="sh">
                

                
                <table name ="reg" id="reg" class="fl-table">
                    <thead>
                        <tr>
                            <th>Course Id</th>
                            <th> Course Name</th>
                            <th> Credits</th>
                            <th>Theory Faculty</th>
                            <th>Lab Faculty</th>
                        </tr>
                    </thead>
                    <tr>
                    <td colspan="8">No data found</td>
                    </tr>
                </table>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
            
            $('#sem').on('change', function(){
                var semid=$(this).val();
                console.log(semid);
                if(semid){
                    $.ajax({
                        
                        type:'POST',
                        url:'ajax.php',
                        data: 'sem='+semid,
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