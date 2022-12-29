<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="include/table.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <title>Modify</title>
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
            <div class ="content">
                <div class="sh">
                    
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <div style='padding-left:30px' >
                                <div  class="title">Modify</div>
                            </div>
                            <div style='padding-left:800px'>
                                <p class="text-left text-success" > Note: &nbsp;&nbsp;<i class='far fa-edit'></i>  ->  Modify Slot</p>
                            </div>

                            <div style='padding-left:856px'>
                            <p class="text-left text-success font-weight-bold" ><i class='far fa-trash'></i>  ->  Delete Course</p>
                            </div>
                            <thead>
                                <tr>
                                <th>Course ID</th>
                                <th>Course Name</th>
                                <th>Faculty Name</th>
                                <th>Course Type</th>
                                <th>Slot</th>
                                <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            <?php
                                include 'include/db.php';
                                $result = $connection->query("SELECT * from enrolls inner join registration on enrolls.rg_id=registration.reg_id and student_id=(select student_id from students where student_name='$name') order by registration.course_Id");
                                if ($result === false) {
                                    echo "<p>Query failed: ".$connection->error."</p>\n";
                                    exit;
                                } else {
                                    if ($result->num_rows > 0) {
                                        if (mysqli_num_rows($result)==0) {
                                            echo "<tr><td colspan='8'>No data found</td></tr>";
                                        }
                                        while ($rowObj = $result->fetch_object()) {
                                            echo "<tr>
                                            <td>{$rowObj->course_Id}</td>
                                            <td>"; $cn=$connection->query("SELECT distinct(course_name) from courses where course_id = '$rowObj->course_Id '");
                                                while ($rj=$cn->fetch_object()) {
                                                    echo "$rj->course_name";
                                                } echo "</td>
                                            <td>"; $cn=$connection->query("SELECT distinct(Name) from faculty where faculty_id = '$rowObj->fac_Id '");
                                            while ($rj=$cn->fetch_object()) {
                                                echo "$rj->Name";
                                            } echo " </td>
                                            <td>";echo ucfirst($rowObj->type); echo "</td>
                                            <td>{$rowObj->slot}</td>
                                            <td>
                                                <a style='color: black' id='mod' href=mod.php?id={$rowObj->course_Id}_{$rowObj->type}_{$rowObj->id}_{$rowObj->rg_id}><i class='far fa-edit'></i></a>&nbsp;&nbsp;&nbsp;
                                                <a style='color: black' id='delete' href=del.php?id={$rowObj->id}_enrolls_{$rowObj->course_Id}_{$id}><i class='far fa-trash'></i></a></td></tr>";
                                            
                                        }
                                    }
                                    else {
                                        echo "<tr>
                                        <td colspan='8'>No data found</td>
                                        </tr>";
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
</body>
</html>