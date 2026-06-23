<?php
ob_start(); // 开启输出缓冲
error_reporting(E_ALL);
ini_set('display_errors', 1);
    include 'connection.php';
    include 'menu.php';
    $pdo = pdo_connect_mysql();
    $stmt= $pdo->prepare('SELECT * FROM user WHERE email = :email');
    $stmt->execute(['email'=> $email]);
    $details = $stmt->fetch(PDO::FETCH_ASSOC); 
    $error="";
    $error1="";
    $error2="";
    $error3=""; 
    $error4=""; 
  
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])){
      $name=$_POST['name'];
      $phone=$_POST['phone'];
      $password=$_POST['CurrPass'];
      $password1=$_POST['NewPass'];
      $password2=$_POST['RetyPass'];
      $file = $_FILES['file'];
      $fileName = $file['name'];
      $fileTmpName = $file['tmp_name'];

      if(empty($name)){
        $error4 = "Name is required";
      }
      else{
        $name=$_POST['name'];
      }
      function validatePhoneNumber($phone) {
        // 使用正则表达式检查电话号码格式
        $pattern = '/^01\d{1}\d{7}|01\d{1}\d{6}$/';
    
        if (preg_match($pattern, $phone)||empty($phone)) {
            return true; // 电话号码格式正确
        } else {
            return false; // 电话号码格式不正确
        }
    }

    // 测试函数
  
    if (validatePhoneNumber($phone)) {
        $error="";
    } else {
        $error="Invalid Phone Number";
    } 

    // 验证当前密码
    if (empty($password)) 
    {  
      $password2 = $details['password'];
        $error1 = "";
      } else {
          // 如果密码非空，检查它是否与数据库中的密码匹配
            if ($password !== $details['password']) {
              $error1 = "Current Password Incorrect";
              } else {
                $error1 = "";
            }
      
      // 继续验证新密码和确认密码
      if (empty($password1)) {
        $error2 = "New Password is required";
    } elseif (!preg_match('/^(?=.*[~`!@#$%^&*()_\-+={}|:"\';<>?,.\/])[A-Za-z\d~`!@#$%^&*()_\-+={}|:"\';<>?,.\/]{7,}$/', $password1)) {
        $error2 = "Password should be at least 7 characters and include at least one of the specified special characters";
    } else {
        $error2 = "";
    }
    
       if (empty($password2)) {
    $error3 = "Retype Password is required";
  } elseif ($password2 !== $password1) {
        $error3 = "Confirm Password does not match with Password";
      }
}

$uploadPath = 'uploads/' . $fileName;


  if($error == "" &&$error1 == "" && $error2 == "" && $error3 == ""&& $error4 == ""){
    $gender=$_POST['gender'];
    $stmt = $pdo->prepare('UPDATE user SET name=?,password = ?,gender = ?,phone = ? where ID = ?');
    $stmt->execute([$name,$password2,$gender,$phone,$details['ID']]);

  
  if (move_uploaded_file($fileTmpName, $uploadPath)) {
      $stmt = $pdo->prepare('UPDATE user SET UserPhoto = ? WHERE ID = ?');
      $stmt->execute([$fileName, $details['ID']]);             
  } 
  
    header("location:profile.php");
    //session_start();
    $_SESSION['success'] = true;
    exit();
  }
}
ob_end_flush(); // 发送输出缓冲区内容
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
  <body>
  <form action="editProfile.php" method="post" enctype="multipart/form-data" novalidate>
    <section id="profile" class="py-5 text-center d-flex align-items-center">
      <div class="container border py-6 shadow-lg rounded-5">
          <div class="row">
              <div class="col-lg-3 offset-lg-2 d-flex flex-column mt-5">
                <div class="row">
                  <div class="ContainerPit">
          <?php
          if (!empty($fileName)) {
               echo '<img  src="uploads/' . $fileName . '" alt="' . $fileName . ' " class="img-fluid rounded-circle" style="height: 280px; width: 280px;">';
             } elseif (!empty($details['UserPhoto'])) {
                echo '<img src="uploads/' . $details['UserPhoto'] . '" alt="' . $details['UserPhoto'] . '" class="img-fluid rounded-circle" style="height: 280px; width: 280px;">';
             }else{
               echo '<img src="Picture/user.jpg" alt="Picture/user.jpg" class="img-fluid rounded-circle" style="height: 280px; width: 280px;">';
             }
         ?>
         </div>
          <img id="imagePreview" style="display: none;"  class="img-fluid rounded-circle ContainerPitPreview" style="height: 280px; width: 280px;">
      
        </div>
        <div class="row ">
        <input type="hidden" name="hasImageSelected" id="hasImageSelected" value="false">
          <input type="file" name="file" id="file" class="d-none">
        <label for="file" class="custom-file-upload btn btn-primary mt-3 ">Upload Picture</label>
        </div>
              </div>
              <div class="col-lg-5 mx-3">
                  <div class="text-container">
                      <h2 class="text-dark mb-4">Profile Info</h2>
                      <form>
                        <p class="text-dark text-start fs-5 fw-bold mb-0">Change Password</p>
                        <div class="input-group <?php echo empty($error1) ? 'mt-4' : ''; ?>">
                            <span class="input-group-text text-dark "><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="CurrPass" class="form-control form-control-lg text-dark" placeholder="&nbsp;Current Password" value="<?php if(!empty($_POST['CurrPass'])){echo $password;}?>">
                            <span class="input-group-text text-dark toggle-password"><i class="fa-solid fa-eye-slash"></i></span>
                          </div>
                          <p class="text-danger px-3"><?php echo $error1; ?></p>
                        <div class="input-group <?php echo empty($error2) ? 'mt-4' : ''; ?>">
                            <span class="input-group-text text-dark "><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="NewPass" class="form-control form-control-lg text-dark" placeholder="&nbsp;New Password" value="<?php if(!empty($_POST['NewPass'])){echo $password1;}?>">
                            <span class="input-group-text text-dark toggle-password"><i class="fa-solid fa-eye-slash"></i></span>
                          </div>
                          <p class="text-danger px-3"><?php echo $error2; ?></p>
                          <div class="input-group <?php echo empty($error3) ? 'mt-4' : ''; ?>">
                            <span class="input-group-text text-dark "><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="RetyPass" class="form-control form-control-lg text-dark" placeholder="&nbsp;Confirmation Password" value="<?php if(!empty($_POST['RetyPass'])){echo $password2;}?>">
                            <span class="input-group-text text-dark toggle-password"><i class="fa-solid fa-eye-slash"></i></span>
                          </div>
                          <p class="text-danger px-3"><?php echo $error3; ?></p>


                          <p class="text-dark text-start fs-5 fw-bold mb-0">Edit Profile</p>
                          <div class="mb-3">
                              <input
                                  type="text"
                                  class="form-control form-control-lg text-dark"
                                  placeholder="Enter name"
                                  name="name" value="<?= $details['name'] ?>"
                              />
                          </div>
                          <div class="mb-3">
                              <input
                                  type="email"
                                  class="form-control form-control-lg text-dark"
                                  placeholder="Enter email"
                                  name="email" value="<?= $details['email'] ?>" disabled required
                              />
                          </div>
                          <div class="mb-3 text-dark form-control-lg text-start">
                            <label for="gender" id="gender">Gender:</label>
                            <input type="radio" name="gender" value="Male" id="maleRadio" <?php if ($details['gender'] == 'Male') echo 'checked'; ?> />
                            <span><label for="maleRadio">Male</label></span>
                            <input type="radio" name="gender" value="Female" id="femaleRadio" <?php if ($details['gender'] == 'Female') echo 'checked'; ?> />
                            <span><label for="femaleRadio">Female</label></span>
                          </div>
                          <div class="mb-3 ">
                        
                              <input
                                  type="text"
                                  class="form-control form-control-lg text-dark"
                                  placeholder="Enter phone"
                                  name="phone"
                                  value="<?= $details['phone'] ?>"
                              />
                          </div>
                          <div class="d-grid gap-2">
                          <input class="btn btn-primary btn-block" name="edit" type="submit" value="Save Changes">
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </section>
            </form>
  <?php include 'footer.php'; ?>

    <script src="js/replaceme.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

  document.addEventListener("DOMContentLoaded", function () {
    // Get references to the input and image elements
    const fileInput = document.getElementById("file");
    const imagePreview = document.getElementById("imagePreview");
    const ContainerPit = document.querySelector(".ContainerPit");
    const ContainerPitPreview = document.querySelector(".ContainerPitPreview");
    const hasImageSelectedInput = document.getElementById("hasImageSelected");

    // Add an event listener to the input element
    fileInput.addEventListener("change", function () {
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = "block";
                hasImageSelectedInput.value = "true";
                ContainerPit.style.display = "none";
                ContainerPitPreview.style.display = "flex";
            };

            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = "none";
            ContainerPit.style.display = "block";
            ContainerPitPreview.style.display = "none";
            hasImageSelectedInput.value = "false";
        }
    });
});

</script>
    
  </body>
</html>