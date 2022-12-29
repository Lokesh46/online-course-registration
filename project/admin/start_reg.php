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
<?php  
    require_once "db.php";
    if (isset($_POST['start'])){
        $query = "CREATE TABLE registration (
            reg_Id int NOT NULL AUTO_INCREMENT,
            course_Id varchar(10),
            fac_Id varchar(10),
            slot varchar(5),
            no_of_Seats int,
            free_Seats int,
            type varchar(10),
            primary key(reg_Id)
        );";
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        $query = "CREATE TABLE enrolls(
            id int NOT NULL auto_increment,
            reg_id int,
            course_Id varchar(10),
            primary key(id)
        );";
        
        $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
        ?>
<script language="javascript">
document.location="reg.php";
</script>
                 <?php
        
    }

    if (isset($_POST['end'])){
        $query = "Drop table registration;";
        
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));

            $query = "Drop table enrolls;";
        
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
           ?>
<script language="javascript">
document.location="reg.php";
</script>
                 <?php
    }

    if(isset($_GET['id'])) {
        $reg_id=$_GET['id'];
        $connection->query("update registration set no_of_Seats = (select no_of_Seats from registration where reg_Id='$reg_id')+1 where reg_Id='$reg_id'");
        $connection->query("update registration set free_Seats = (select free_Seats from registration where reg_Id='$reg_id')+1 where reg_Id='$reg_id'");
        ?>
<script language="javascript">
document.location="reg.php";
</script>
                 <?php
    }
    
?>
