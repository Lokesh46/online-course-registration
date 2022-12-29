<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../include/style1.css" />
    <title>Login Page</title>
</head>

<body>
    <br><br><br><br><br><br><br>
    
<form class="form-cont" id="loginForm" name="loginForm" method="post">
                    <!-- Email input -->
                    <h4> Faculty Login </h4>
                    <br>
                    <div class="input-group">
                    <input type="text" id="email" name="email" required class="input">
                    <label for="email" class="input-label">E-mail Address</label>
                    
                    </div>  
                    <br>
                    <div class="input-group">
                    <input type="password" id="password" name="password" required class="input">
                    <label for="password" class="input-label">Password</label>
                    
                    </div>
                <br>

                <div class="d-flex justify-content-between align-items-center">
                    <!-- Checkbox -->
                    <div class="form-check mb-0">
                        <input class="form-check-input me-2" type="checkbox"name="remember" value="" id="remember"/>
                        <label class="form-check-label" for="remember">
                        Remember me
                        </label>
                    </div>
                    <a href="#!" class="text-body">Forgot password?</a>
                    </div>

                    <div class="text-center mt-4 pt-2">
                        <button name="submit" id = "submit" type="submit" value="submit" class="btn btn-primary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                </form>
                <?php  
    require_once "../include/db.php";
    if  (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['password'])) {
            
        $username = $_POST['email'];
        $password = $_POST['password'];

        if (preg_match("/[a-zA-Z0-9._-]{3,}@[a-zA-Z0-9._-]{3,}[.]{1}[a-zA-Z0-9._-]{2,}/",$username)){
            $query = "SELECT * FROM faculty WHERE gmail='$username' and password='$password'";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));
            $count = mysqli_num_rows($result);
            
            
            if ($count == 1){
                $sql = "SELECT * FROM faculty where gmail='$username'";
                $res = mysqli_query($connection, $sql) or die(mysqli_error($connection));

                if ($res->num_rows > 0) {
                    // output data of each row
                    while($row = $res->fetch_assoc()) {
                        $_SESSION['fac_id'] = $row["Faculty_Id"];    
                        if(isset($_POST['remember'])){
                            setcookie('user_name',$post['gmail'],time()+(60*60*24));
                            setcookie('user_pass',$post['password'],time()+(60*60*24));
                        }           ?>
                        <script> location.replace("home.php"); </script> 
                    <?php }
                } 
            }
            else{
                echo "<p class='ec'> Wrong Username or Password </p>";
            } 
        } else {
            echo "<p style='color:red'> Enter a valid E-mail Address </p>";
        }
    }
?>

</div>
<div class='box'>
    
  <div class='wave -one'></div>
  <div class='wave -two'></div>
  <div class='wave -three'></div>
</div>


</body>
</html>
