<?php
session_start();
    require_once "db.php";
    
    if  (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['password'])) {
            
        $username = $_POST['email'];
        $password = $_POST['password'];

        if (preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/",$username)){
            $query = "SELECT * FROM admin WHERE Email='$username' and Password='$password'";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
            $count = mysqli_num_rows($result);
            
            
            if ($count == 1){
                $sql = "SELECT Name FROM admin where Email='$username'";
                $res = mysqli_query($connection, $sql) or die(mysqli_error($connection));

                if ($res->num_rows > 0) {
                    // output data of each row
                    while($row = $res->fetch_assoc()) {
                        $_SESSION['uname'] = $row["Name"];    
                        if(isset($_POST['remember'])){
                            setcookie('user_name',$post['email'],time()+(60*60*24));
                            setcookie('user_pass',$post['password'],time()+(60*60*24));
                        }           
                        ?>
<script language="javascript">
document.location="admin_home.php";
</script>
                 <?php   }
                } 
            }
            else{ ?>
                
<script language="javascript">
document.location="admin.php";
</script> <?php
            }
        }
    }
?>
