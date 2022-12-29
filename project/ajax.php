<?php
session_start();
    include_once 'include/db.php';
    $name=$_SESSION['stname'];
    if (!empty($_POST['dept_id'])) {
        $dept = $_POST["dept_id"];
        
        ?>
        <table>
            <thead>
                <tr>
                    <th>Course ID</th>
                    <th>Course Name</th>
                    <th>credits</th>
                    <th>Pre-Requisite</th> 
                    <th>Register</th> 
                </tr>
                </thead>

                <?php
                $sql = "SELECT distinct(reg.course_Id),(c.Course_Name),c.PreReqID,c.Credits
                FROM registration reg,courses c
                where reg.course_Id = c.course_Id and c.dept_id='$dept' ";
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
                    }
                }
                ?>
        </table>

        <?php } elseif (!empty($_POST['sem'])) {
            $sem = $_POST['sem'];
            ?> 
            <table>
                <thead>
                    <tr>
                        <th>Course Id</th>
                        <th> Course Name</th>
                        <th>credits</th>
                        <th>Theory Faculty</th>
                            <th>Lab Faculty</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            if (mysqli_num_rows($result=$connection->query("
                            select distinct(enr.Course_ID),Course_Name,credits
                            from courses c,courses_history enr
                            where c.course_ID=enr.course_Id and enr.Student_Id= (select Student_ID from students where Student_Name='$name') and enr.Semester='$sem' order by enr.course_ID"))) {
                                while ($rowObj = $result->fetch_object()) {
                                    echo "<tr>
                                    <td>{$rowObj->Course_ID}</td>
                                    <td>{$rowObj->Course_Name}</td>
                                    <td>{$rowObj->credits}</td>";
                                    
                                    if (mysqli_num_rows($res= $connection->query("select * from courses_history,faculty where 
                                    Student_Id= (select Student_ID from students where Student_Name='$name') and course_id= '$rowObj->Course_ID' and type='theory' and faculty.faculty_id=courses_history.fac_id") ) >0) {
                                        while ($row = $res->fetch_object()) {
                                            echo "<td>{$row->Name}</td>";
                                        }
                                    } else {
                                        echo "<td> --- </td>";
                                    }

                                    if (mysqli_num_rows($res= $connection->query("select * from courses_history,faculty where 
                                    Student_Id= (select Student_ID from students where Student_Name='$name') and course_id= '$rowObj->Course_ID' and type='lab' and faculty.faculty_id=courses_history.fac_id") ) >0) {
                                        while ($row = $res->fetch_object()) {
                                            echo "<td>{$row->Name}</td>";
                                        }
                                    } else {
                                        echo "<td> --- </td>";
                                    }
                                    
                                }
                            }
                        ?>
                    </tr>
                </tbody>
            </table>
            <?php
        }
        
        ?>

