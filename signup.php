<?php
    $error1 = "";
    $error2 = "";
    $error3 = "";
    $error4 = "";
    $error5 = "";
    $verifys=false;
    $randomCode ="";
    $_SESSION['errorCounter'] = 0;

    include('connection.php');

     $pdo = pdo_connect_mysql();


    if(isset($_POST['submit']))
    {
      
      $password=$_POST['password'];
      $password2=$_POST['password2'];
    
      if(empty($_POST['name'])){
        $error1 = "Username is required";
      }
      elseif(!preg_match("/^[a-zA-Z-' ]*$/",$_POST['name']))
      {
          $error1 = "Valid username is required";
      }
      else
      {
           $name=$_POST['name'];
           $error1 = ""; 
      }

      
        if(empty($_POST['email'])){
        $error2 = "Email address is required";
       }
      elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
      {
          $error2 = "Invalid email address";
      }
       else
      {
        $email = $_POST['email'];
         
          $stmt = $pdo->prepare('SELECT*FROM user WHERE email = :email');
          $stmt->bindParam(":email",$email);

          $stmt->execute();

          if($stmt->rowcount() == 1)
          {
              $error2 = "Email Address has been already registered";
          }
          else
          {
              $error2 = ""; 
          }

        }

        if (empty($password)) {
          $error3 = "Password is required";
      } else {
          // Use a regular expression to check for at least 7 characters and at least one of the specified special characters
          if (!preg_match('/^(?=.*[~`!@#$%^&*()_\-+={}|:"\';<>?,.\/])[A-Za-z\d~`!@#$%^&*()_\-+={}|:"\';<>?,.\/]{7,}$/', $password)) {
              $error3 = "Password should be at least 7 characters and include at least one of the specified special characters";
          } else {
              // Password meets the criteria
              $error3 = "";
          }
      }
      if(empty($_POST['password2']))  {
        $error4 = "Confirm Password is required.";
      }
      elseif( ($password2!=$password))
        {
            $error4 = "Confirm Password does not match with Password";
        }
        else
        {
            $password2 = $_POST['password2'];
            $error4 = "";    
        }

        if($error1 == "" && $error2 == "" && $error3 == ""&& $error4 == "")
        {          

          //echo $randomCode;
            $receiver = $_POST['email'];
			      $subject = "Email Confirmation Required: Verify Your Email Address";
            $message = "<html>
            <head>
            <style>
                /* Inline CSS styles */
                *{
                  font-family: 'Franklin Gothic Medium', 'Arial', sans-serif; /* Set font-family */
                }
                body {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    max-height:150vh;
                    margin: 0;
                    font-family: 'Franklin Gothic Medium', 'Arial', sans-serif; /* Set font-family */
                }
                .container {
                    box-shadow: 0px 6px 12px #000000b7;
                    border-radius:4px;
                    background-color:#F6F6F6 ; /* Background color for the container */
                    text-align: center;
                    padding: 20px;
                    max-width: 400px; /* Added max-width */
                    margin: 0 auto; /* Center container horizontally */
                    font-family: 'Franklin Gothic Medium', 'Arial', sans-serif; /* Set font-family */
                }
                h1 {
                    color: black;
                    font-size: 24px;
                    text-align:left;
                }
               
                .otp {
                    border-radius:4px;
                    font-size: 32px;
                    color: black;
                    border: 4px solid #cbfdf7; /* Border for OTP */
                    box-shadow: 0px 6px 12px #000000b7;
                    padding: 10px;
                    margin: 10px;
                    text-align:center;
                }
                img{
                  width: 150px;
                  height: 50px;
                  display: flex;
                  align-items: left;
              }
                  .h6 {
                    margin-top:-20px;
                    padding:-20px;
                    font-size: 12px;
                    color: black;
                    font-weight: bold;
                    text-align:left;
                      }
            </style>
        </head>
        <body>
            
            <div class='container'>
            <img src='https://i.ibb.co/TMTLq6b/logo4.png' alt='logo4' >
            <h1>Hi <span style='text-decoration: underline;'>$name</span>,<br> Here is your OTP to validate your email:</h1>
            <div class='h6'> You can use this OTP to complete your registration process.</div>
            <a href='http://localhost/CNH-2/verifyEmail.php'>Verify Here!</a>
            
            
           
            </div>
        </body>
        </html>";
          $headers = "MIME-Version: 1.0" . "\r\n";
             $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            

			if(mail($receiver, $subject, $message,$headers)){
				$notificationSuccess = "Registeration successful please check your gmail";
        $name=$_POST['name'];
        $email=$_POST['email'];
        $password=$_POST['password'];
        session_start(); 
        $_SESSION['verifymail'] = $email;
        $_SESSION['Goverify']="Please check your email to verify email";

        $id=isset($_POST['id']) && ($_POST['id']!='auto' ? $_POST['id'] : NULL);    
      $stmt=$pdo->prepare('INSERT INTO user values(?,?,?,?,?,?,?,?)');
      $stmt->execute([$id,$name,"",$password,$email,"","",2]);
      header("location:signin.php");

			}else{
				$notificationFail = "Sorry, failed while sending mail!";
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
        <div class="container d-flex justify-content-center align-items-center " style="height: 100vh;">
            <div class="row bg-light rounded-5 align-items-center shadow-lg" style="height: 90vh; width: 80%;">
                <div class="col-lg-5 offset-1">
                  <h2 class="text-center text-dark pb-4">Register</h2>
                    <form action="" method="post" novalidate>
                      <div class="input-group">
                        <span class="input-group-text text-dark ">@</span>
                        <input type="text" name="name" class="form-control form-control-lg text-dark"  placeholder="&nbsp;User Name" >
                      </div>
                      <p class="text-danger px-3"><?php echo $error1; ?></p>
                      <div class="input-group <?php echo empty($error2) ? 'mt-4' : ''; ?>">
                        <span class="input-group-text text-dark "><i class="fa-solid fa-envelope"></i></span>
                        <input type="text" name="email" class="form-control form-control-lg text-dark"  placeholder="&nbsp;Email" >
                      </div>
                      <p class="text-danger px-3"><?php echo $error2; ?></p>
                      <div class="input-group <?php echo empty($error3) ? 'mt-4' : ''; ?>">
                        <span class="input-group-text text-dark "><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password" class="form-control form-control-lg text-dark" placeholder="&nbsp;Enter Password">
                        <span class="input-group-text text-dark toggle-password"><i class="fa-solid fa-eye-slash"></i></span>
                      </div>
                      <p class="text-danger px-3"><?php echo $error3; ?></p>
                      <div class="input-group <?php echo empty($error4) ? 'mt-4' : ''; ?>">
                        <span class="input-group-text text-dark "><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="password2" class="form-control form-control-lg text-dark" placeholder="&nbsp;Confirmation Password">
                        <span class="input-group-text text-dark toggle-password"><i class="fa-solid fa-eye-slash"></i></span>
                      </div>
                      <p class="text-danger px-3"><?php echo $error4; ?></p>
                      <div class="d-grid <?php echo empty($error4) ? 'mt-4' : ''; ?>">
                        <input type="submit" name="submit" class="btn btn-outline-dark rounded-5" value="Register">
                      </div>
                      <p class="text-center link mt-2" style="font-size: 15px;">
                        <span class="fw-3 text-dark">Already have an account?</span> 
                        <a href="signin.php" class="link2 text-decoration-none">Login Here</a>
                      </p>
                    </form>
                  </div>
                  <div class="col-lg-6 d-flex justify-content-center">
                    <img src="https://colorlib.com/etc/lf/Login_v1/images/img-01.png" alt="" class="img-fluid px-3">
                </div>
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