<?php 
    include 'connection.php';
    $error="";
    $error2="";
    $error3="";
    $error4="";
    $success="a";
    $success2=false;
    $pdo = pdo_connect_mysql();
    session_start();
    function generateRandomCode() {
      $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // 可以根据需要添加更多字母
      $numbers = '0123456789';
      
      $randomString = '';
  
      // 随机选择两个字母
      for ($i = 0; $i < 2; $i++) {
          $randomString .= $letters[rand(0, strlen($letters) - 1)];
      }
  
      // 随机选择四个数字
      for ($i = 0; $i < 4; $i++) {
          $randomString .= $numbers[rand(0, strlen($numbers) - 1)];
      }
  
      return $randomString;
  }
    if (isset($_POST['RecoveryBtn'])) {
    $email = $_POST['email'];
    if(empty($email)){
      $error = "Invalid email address";
    }
      elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
      {
          $error = "Invalid email address";
      }else{
        $stmt = $pdo->prepare('SELECT * FROM user WHERE Email=:email');
        $stmt->bindParam(":email",$email);
        $stmt->execute();

        if($stmt->rowcount() == 1)
        {
          $success="b";
          $_SESSION['email1'] = $email;
          $randomCode = generateRandomCode();
            $_SESSION['ResetOTP'] = $randomCode; // 存储 OTP 到会话
            //echo $randomCode;
              $receiver = $_POST['email'];
              $subject = "Verify OTP to Reset Your Password";
              $message = "<html>
              <head>
              <style>
                  /* Inline CSS styles */
                  *{
                    font-family: 'Franklin Gothic Medium', 'Arial', sans-serif; /* Set font-family */
                  }
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
              <h1>Hi, <span style='text-decoration: underline;'>$email</span>.Here is your OTP to reset your password:</h1>
                  <h1 class='otp'>$randomCode</h1>
              </div>
          </body>
          </html>";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
              
        if(mail($receiver, $subject, $message,$headers)){
          $notificationSuccess = "Registeration successful please check your gmail";
          $verifys=true; 
        }else{
          $notificationFail = "Sorry, failed while sending mail!";
        }
        }else{
          $error = "This email has not been registered. Please sign up first.";
        }
      }
    }
    if (isset($_POST['RecoveryBtnOTP'])){
      $success="b";
      
      $mailOTP = $_SESSION['ResetOTP'];
      $verifyOTP = $_POST['verifyOTP']; 
      //echo $mailOTP;
      if ($verifyOTP == $mailOTP) {
        $success="c";
      }else {

        if (!isset($_SESSION['errorCountFor'])) {
          $_SESSION['errorCountFor'] = 1;
        } else {
          $_SESSION['errorCountFor']++;
        }
    
        if ($_SESSION['errorCountFor'] >= 3) {
          $success="a";
          unset($_SESSION['errorCountFor']);
          
        }
        $error2 = "Invalid OTP";
      }
    }
    if (isset($_POST['RecoveryPassword'])){
      $success="c";
      $password=$_POST['NewPass'];
      $password2=$_POST['RetyPass'];
      
    if(empty($password)){
      $error3 = "Password is required.";
    }
      
      elseif (!preg_match('/^(?=.*[~`!@#$%^&*()_\-+={}|:"\';<>?,.\/])[A-Za-z\d~`!@#$%^&*()_\-+={}|:"\';<>?,.\/]{7,}$/', $password)) 
        {
            $error3 = "Password should be at least 7 characters and include at least one of the specified special characters";
        }
        else
        {
            $error3 = "";    
        }
    
        if(empty($password2)){
          $error4 = "Password is required.";
        }
          
          elseif( ($password2!=$password))
        {
            $error4 = "Confirm Password does not match with Password";
        }
        else
        {
            $error4 = "";    
        }

        if($error3 == "" && $error4 == ""){
          if (isset($_SESSION['email1'])) {
            $email = $_SESSION['email1'];
            $stmt= $pdo->prepare('SELECT * FROM user WHERE email = :email');
          $stmt->execute(['email'=> $email]);
          $details = $stmt->fetch(PDO::FETCH_ASSOC); 
            // Your code to use $email goes here
            $stmt = $pdo->prepare('UPDATE user SET name=? ,password = ?,email=?,gender = ?,phone = ? where ID = ?');
            $stmt->execute([$details['name'],$password2,$details['email'],$details['gender'],$details['phone'],$details['ID']]);
            header("location:signin.php");
            $_SESSION['successChange']=true;
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
  <body class="bg-primary d-flex justify-content-center align-items-center vh-100">

    <section class="forgetPass overflow-hidden " >
        <div class="container rounded-5 shadow-lg bg-light d-flex justify-content-center align-items-center" style="height: 80vh; width: 80%;position:relative;">
        <div class="p-4" style="position:absolute;top:0;left:0;">
        <a href="signin.php" class="btn text-dark back"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
            <div class="row align-items-center " >

                <div class="col-lg-6 d-flex justify-content-center">
                    <img src="images/forget.jpg" alt="" class="img-fluid rounded-circle px-3">
                </div>
                <div class="col-lg-5 ">
                  <h2 class="text-center text-dark <?php echo empty($failed) ? 'mt-3' : ''; ?>">Forget Password</h2>
                  <div class="w-100 text-center align-items-center mb-2">
                  </div>
                    <form action="" method="post" novalidate>
                        <p class="text-center text-dark" style="font-size: 15px;">
                            Please enter your email, we will send you
                            a tac to Reset your password.
                      </p>
                      <?php if ($success=="a"): ?>
                      <div class="input-group">
                        <span class="input-group-text text-dark "><i class="fa-solid fa-envelope"></i></span>
                        <input type="text" name="email" class="form-control form-control-lg text-dark"  placeholder="&nbsp;Email" value = "<?php if(!empty($_POST['email'])){echo $email;}?>" required>
                      </div>
                      <p class="text-danger px-3"><?php echo $error; ?></p>
                      <div class="d-grid <?php echo empty($error1) ? 'mt-4' : ''; ?>">
                        <input type="submit" name="RecoveryBtn" class="btn btn-outline-dark rounded-5" value="Recovery Password">
                      </div>
                      <?php elseif($success=="b"): ?>
                      <div class="input-group">
                        <span class="input-group-text text-dark "><i class="fa-solid fa-lock"></i></span>
                        <input type="text" name="verifyOTP" class="form-control form-control-lg text-dark" placeholder="&nbsp;Please enter your OTP">
                      </div>
                      <p class="text-danger px-3"><?php echo $error2; ?></p>
                      <div class="d-grid <?php echo empty($error2) ? 'mt-4' : ''; ?>">
                      <input type="submit" name="RecoveryBtnOTP" class="btn btn-outline-dark rounded-5" value="Recovery Password">
                      </div>
                     <?php else: ?>
                      <div class="input-group <?php echo empty($error3) ? 'mt-4' : ''; ?>">
                        <span class="input-group-text text-dark "><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="NewPass" class="form-control form-control-lg text-dark" placeholder="&nbsp;Enter Password" value="<?php if(!empty($_POST['NewPass'])){echo $_POST['NewPass'];}?>" required>
                        <span class="input-group-text text-dark toggle-password"><i class="fa-solid fa-eye-slash"></i></span>
                      </div>
                      <p class="text-danger px-3"><?php echo $error3; ?></p>
                      <div class="input-group <?php echo empty($error4) ? 'mt-4' : ''; ?>">
                        <span class="input-group-text text-dark "><i class="fa-solid fa-lock"></i></span>
                        <input type="password" name="RetyPass" class="form-control form-control-lg text-dark" placeholder="&nbsp;Confirmation Password" value="<?php if(!empty($_POST['RetyPass'])){echo $_POST['RetyPass'];}?>" required> 
                        <span class="input-group-text text-dark toggle-password"><i class="fa-solid fa-eye-slash"></i></span>
                      </div>
                      <p class="text-danger px-3"><?php echo $error4; ?></p>
                      <div class="d-grid <?php echo empty($error4) ? 'mt-4' : ''; ?>">
                      <input type="submit" name="RecoveryPassword" class="btn btn-outline-dark rounded-5" value="Recovery Password">
                      </div>
                      <?php endif; ?>
                    </form>
                  </h2>
            </div>
        </div>
    </section>
  
    
    <script src="js/replaceme.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>