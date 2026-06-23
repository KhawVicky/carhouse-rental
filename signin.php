<?php
    $error1 = "";
    $error = "";
    $failed="";
    $goVerify="";
    
    include 'connection.php';
    session_start();
    $pdo = pdo_connect_mysql();
$_SESSION['Goverify']="";

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))
    {
      $email = $_POST['email'];
      if(empty($email)){
        $error = "Email Address is required";
      }
      else
      {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
          $error = "Invalid email address";
        }
        else
        {
            $email = $_POST['email'];
            
        }
      }
       
        $password = $_POST['password'];
        if(empty($password)){
          $error1 = "Password is required";
        }
        else{
          if (!preg_match('/^(?=.*[~`!@#$%^&*()_\-+={}|:"\';<>?,.\/])[A-Za-z\d~`!@#$%^&*()_\-+={}|:"\';<>?,.\/]{7,}$/', $password)) {
            $error1 = "Password should be at least 7 characters and include at least one of the specified special characters";
        }
        else
        {
            $password = $_POST['password'];
            $error1 = "";    
        }
      }
        if($error == "" && $error1 == "")
        {     
            $email = $_POST['email'];
            $password = $_POST['password'];
            $stmt = $pdo->prepare('SELECT * FROM user WHERE email=:email AND password=:password');

            $stmt->bindParam(":email",$email);
            $stmt->bindParam(":password",$password);

            $stmt->execute();
            $personalDetails = $stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowcount() == 1)
            {
              if ($personalDetails['banned'] == 2) {
                $failed="Please check your email to verify email";
              }elseif ($personalDetails['banned'] == 1) {
               $failed="Your Account Has Been Block";
             } else {
              if($password==$personalDetails['password']){
                $_SESSION['email'] = $email;
                header("location: home.php");
              }else
              {
                  $failed=" Invalid email or password";
              }
            }
            }
            else
            {
                $failed=" Invalid email or password";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="css/font-awesome.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="icon" href="Picture/logo7.svg" />
    <title>Rent House</title>
  </head>
  <body class="bg-primary ">
    <section class=" login overflow-hidden" id="login">
        <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="row bg-light rounded-5 align-items-center shadow-lg" style="height: 80vh; width: 80%;">

                <div class="col-lg-6 d-flex justify-content-center">
                    <img src="https://colorlib.com/etc/lf/Login_v1/images/img-01.png" alt="" class="img-fluid px-3">
                </div>
                <div class="col-lg-5 ">
                  <h2 class="text-center text-dark <?php echo empty($failed) ? 'mt-3' : ''; ?>">Login</h2>
                  <div class="w-100 text-center align-items-center mb-2">
                  <span class="badge rounded-pill text-bg-danger p-2 fs-7"><?php echo $failed; ?></span>
                  <span class="badge rounded-pill text-bg-success p-2 fs-7"><?php echo $_SESSION['Goverify']; ?></span>
                  </div>
                    <form action="" method="post" novalidate>
                      <div class="input-group">
                        <span class="input-group-text text-dark "><i class="fa-solid fa-envelope"></i></span>
                        <input type="text" name="email" class="form-control form-control-lg text-dark"  placeholder="&nbsp;Email" >
                      </div>
                      <p class="text-danger px-3"><?php echo $error; ?></p>
                      <div class="input-group <?php echo empty($error1) ? 'mt-4' : ''; ?>">
                        <span class="input-group-text text-dark "><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control form-control-lg text-dark" placeholder="&nbsp;Enter Password">
                        <span class="input-group-text text-dark toggle-password"><i class="fa-solid fa-eye-slash"></i></span>
                      </div>
                      <p class="text-danger px-3"><?php echo $error1; ?></p>
                      <div class="d-grid <?php echo empty($error1) ? 'mt-4' : ''; ?>">
                        <input type="submit" name="submit" class="btn btn-outline-dark rounded-5" value="Login">
                      </div>
                      <p class="text-center link mt-2" style="font-size: 15px;">
                        <span style="color: #6f6f6f;">Forgot</span> 
                        <a href="forgetPass.php" class="link">Username / Password?</a><br>
                        <span class="fw-3 text-dark">Don't have an account?</span> 
                        <a href="signup.php" class="link2 text-decoration-none">Start Here</a>
                      </p>
                      
                    </form>
                  </h2>
            </div>
        </div>
    </section>

  </body>
  <!-- Link jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/replaceme.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</html>