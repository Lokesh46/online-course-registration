

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
<form class="form-cont" id="loginForm" name="loginForm" method="post" action="admin_authen.php">
                    <!-- Email input -->
                    <h4>Admin</h4><br>
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

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button name="submit" id="submit" type="submit" value="submit" class="btn btn-primary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                        
                    </div>
                </form>
<div class='box'>
    
  <div class='wave -one'></div>
  <div class='wave -two'></div>
  <div class='wave -three'></div>
</div>


</body>
</html>
