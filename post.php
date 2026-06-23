<?php
    include 'connection.php';
    include 'menu.php';
    $error1="";
    $error2="";
    $error3="";
    $error4="";
    $error5="";
    $error6="";
    $error7="";
    $error8="";
    $error9="";
    $errorP1="";
    $errorP2="";
    $errorP3="";
    $errorP4="";
    $errorP5="";
    $errorBQ="";
    $errorDP="";
    $errorPS="";
    $errorsPicture="";
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $pdo = pdo_connect_mysql();
    $stmt= $pdo->prepare('SELECT * FROM user WHERE email = :email');
    $stmt->execute(['email'=> $email]);
    $details = $stmt->fetch(PDO::FETCH_ASSOC); 
    
    if(empty($_SESSION['type'] )){
      $_SESSION['type']=""; 
    }
    
    if(isset($_POST['submitFirst'])){
      if (empty($_POST["type"])) {
        $error1="Please select a Type ";
    } else {
      $error1="";
      $selectedType = $_POST["type"];
      $_SESSION["type"]=$_POST["type"];

        if($selectedType==="car"){
          
        }/**************************** */
        elseif($selectedType==="house"){
          
        }
    }

}
if(isset($_POST['back'])){
  $_SESSION['type']=""; 
}
if(isset($_POST['submit'])){    
    
  $currentDateTime = date('Y-m-d H:i:s');
  $CarBrand=$_POST["carBrand"];
  $carCategory=$_POST["carCategory"];
  $name=$_POST['name'];
  $adTitle=$_POST["tittle"];
  $price = $_POST["price"];
  $description=$_POST["description"];
  $location=$_POST["location"];
  $phone=$_POST["phone"];
  $file1 = $_FILES['files1'];
  $file2 = $_FILES['files2'];
  $file3 = $_FILES['files3'];
  $file4 = $_FILES['files4'];
  $file5 = $_FILES['files5'];

  $fileName1 = $file1['name'];
  $fileName2 = $file2['name'];
  $fileName3 = $file3['name'];
  $fileName4 = $file4['name'];
  $fileName5 = $file5['name'];
 
  $fileTmpName1 = $file1['tmp_name'];
  $fileTmpName2 = $file2['tmp_name'];
  $fileTmpName3 = $file3['tmp_name'];
  $fileTmpName4 = $file4['tmp_name'];
  $fileTmpName5 = $file5['tmp_name'];
  
  $uploadPath1 = 'uploads/' . $fileName1;
  $uploadPath2 = 'uploads/' . $fileName2;
  $uploadPath3 = 'uploads/' . $fileName3;
  $uploadPath4 = 'uploads/' . $fileName4;
  $uploadPath5 = 'uploads/' . $fileName5;
 
  $fileExtension1 = strtolower(pathinfo($fileName1, PATHINFO_EXTENSION));
  $fileExtension2 = strtolower(pathinfo($fileName2, PATHINFO_EXTENSION));
  $fileExtension3 = strtolower(pathinfo($fileName3, PATHINFO_EXTENSION));
  $fileExtension4 = strtolower(pathinfo($fileName4, PATHINFO_EXTENSION));
  $fileExtension5 = strtolower(pathinfo($fileName5, PATHINFO_EXTENSION));
  $errors = [];  // 用于保存所有错误消息的数组
  $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
  
  // 检查每个文件的文件扩展名和是否为空
  if (!empty($fileName1)) {
      if (!in_array($fileExtension1, $allowedExtensions)) {
          $errors[] = 'Photo 1 has an invalid format';
          $errorP1="error";
      }
  } else {
      $errors[] = 'Photo 1 is empty';
      $errorP1="error";
  }
  
  if (!empty($fileName2)) {
      if (!in_array($fileExtension2, $allowedExtensions)) {
          $errors[] = 'Photo 2 has an invalid format';
          $errorP2="error";
      }
  } else {
      $errors[] = 'Photo 2 is empty';
      $errorP2="error";
  }
  
  if (!empty($fileName3)) {
      if (!in_array($fileExtension3, $allowedExtensions)) {
          $errors[] = 'Photo 3 has an invalid format';
          $errorP3="error";
      }
  } else {
      $errors[] = 'Photo 3 is empty';
      $errorP3="error";
  }
  
  if (!empty($fileName4)) {
      if (!in_array($fileExtension4, $allowedExtensions)) {
          $errors[] = 'Photo 4 has an invalid format';
          $errorP4="error";
      }
  } else {
      $errors[] = 'Photo 4 is empty';
      $errorP4="error";
  }
  
  if (!empty($fileName5)) {
      if (!in_array($fileExtension5, $allowedExtensions)) {
          $errors[] = 'Photo 5 has an invalid format';
          $errorP5="error";
      }
  } else {
      $errors[] = 'Photo 5 is empty';
      $errorP5="error";
  }
  
  // 构建包含所有错误的消息
  if (!empty($errors)) {
    $errorsPicture = implode(', ', $errors);
   
  } else {
      $errorsPicture="";
      $errorP1="";
      $errorP2="";
      $errorP3="";
      $errorP4="";
      $errorP5="";
  }
  
    
  
    if($CarBrand==""){
      $error2="Please select car brand ";
    }else{
    $error2="";
    $CarBrand=$_POST["carBrand"];
    }
  
 
    if($carCategory==""){
      $error3="Please select the car category";
    }else{
      $carCategory=$_POST["carCategory"];
      $error3="";
    }

    if($location==""){
      $error4="Please select the location";
    }else{
      $location=$_POST["location"];
      $error4="";
    }
  
  if(empty($adTitle)){
    $error5 = "Tittle is required";
  }
  elseif (preg_match("/^[a-zA-Z0-9. ]+$/", $adTitle)) {
    // 输入合法，可以继续处理
    $error5="";
    $adTitle=$_POST["tittle"];
} else {
    // 输入包含特殊字符，显示错误消息
    $error5= "Ad Title contains special characters. Only letters, numbers, spaces, and dot are allowed.";
}
if($description==""){
  $error9="Please enter description and other terms if available. ";
}else{
$error9="";
$description=$_POST["description"];
}
if(empty($price)){
$error6 = "Price is required";
}
elseif (isset($_POST["price"])) {
    // Use a regular expression to validate the input
    if (preg_match('/^\d{1,5}$/', $price)) {
        // Input is a number with no more than 5 digits, continue processing
        $error6="";
        $price = $_POST["price"];
    } else {
        // Input is not a valid number or exceeds 5 digits, display an error message
        $error6= "Price should be a number with no more than 5 digits.";
    }
}

if(empty($_POST['name'])){
  $error7 = "Username is required";
}
elseif(!preg_match("/^[a-zA-Z-' ]*$/",$_POST['name']))
{
    $name=$_POST['name'];
    $error7 = "Valid username is required";
}
else
{
     $error7 = ""; 
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
if(empty($phone)){
$error8 = "Phone Number is required";
}
elseif (validatePhoneNumber($phone)) {
  $error8="";
} else {
  $error8="Invalid Phone Number";
} 
if($errorsPicture == "" &&$error1 == "" &&$error2 == "" && $error3 == "" && $error4 == ""&&$error5 == ""&&$error6 == ""&&$error7 == ""
&&$error8 == ""&&$error9 == ""){
  $emails=$_SESSION['email'] ;
  if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}
  move_uploaded_file($fileTmpName1, $uploadPath1);
  move_uploaded_file($fileTmpName2, $uploadPath2);
  move_uploaded_file($fileTmpName3, $uploadPath3);
  move_uploaded_file($fileTmpName4, $uploadPath4);
  move_uploaded_file($fileTmpName5, $uploadPath5);

  $id=isset($_POST['id']) && ($_POST['id']!='auto' ? $_POST['id'] : NULL);    
  $stmt=$pdo->prepare('INSERT INTO car values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
  $stmt->execute([$id,$name,$emails,$adTitle,$fileName1,$fileName2,$fileName3,$fileName4,$fileName5,$CarBrand,$carCategory,$description,$price,$location,$phone,$currentDateTime,false,true,""]);
  $_SESSION['type']="";  
  $_SESSION['successPostAd'] = true;
  header("location:MyAdCar.php");
    
}
}
/****************************************************************/
if(isset($_POST['submit2'])){    
    
  $currentDateTime = date('Y-m-d H:i:s');
  $houseType=$_POST["houseType"];
  $bedroomQuantity=$_POST["bedroomQuantity"];
  $bathroomQuantity=$_POST["bathroomQuantity"];
  $name=$_POST['name'];
  $adTitle=$_POST["tittle"];
  $price = $_POST["price"];
  $deposit=$_POST["deposit"];
  $description=$_POST["description"];
  $location=$_POST["location"];
  $phone=$_POST["phone"];

  $file1 = $_FILES['files1'];
  $file2 = $_FILES['files2'];
  $file3 = $_FILES['files3'];
  $file4 = $_FILES['files4'];
  $file5 = $_FILES['files5'];

  $fileName1 = $file1['name'];
  $fileName2 = $file2['name'];
  $fileName3 = $file3['name'];
  $fileName4 = $file4['name'];
  $fileName5 = $file5['name'];
 
  $fileTmpName1 = $file1['tmp_name'];
  $fileTmpName2 = $file2['tmp_name'];
  $fileTmpName3 = $file3['tmp_name'];
  $fileTmpName4 = $file4['tmp_name'];
  $fileTmpName5 = $file5['tmp_name'];
  
  $uploadPath1 = 'uploads/' . $fileName1;
  $uploadPath2 = 'uploads/' . $fileName2;
  $uploadPath3 = 'uploads/' . $fileName3;
  $uploadPath4 = 'uploads/' . $fileName4;
  $uploadPath5 = 'uploads/' . $fileName5;
  // Store the selected file's information in the session

// 获取文件扩展名
$fileExtension1 = strtolower(pathinfo($fileName1, PATHINFO_EXTENSION));
$fileExtension2 = strtolower(pathinfo($fileName2, PATHINFO_EXTENSION));
$fileExtension3 = strtolower(pathinfo($fileName3, PATHINFO_EXTENSION));
$fileExtension4 = strtolower(pathinfo($fileName4, PATHINFO_EXTENSION));
$fileExtension5 = strtolower(pathinfo($fileName5, PATHINFO_EXTENSION));
$errors = [];  // 用于保存所有错误消息的数组
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

// 检查每个文件的文件扩展名和是否为空
if (!empty($fileName1)) {
    if (!in_array($fileExtension1, $allowedExtensions)) {
        $errors[] = 'Photo 1 has an invalid format';
        $errorP1="error";
    }
} else {
    $errors[] = 'Photo 1 is empty';
    $errorP1="error";
}

if (!empty($fileName2)) {
    if (!in_array($fileExtension2, $allowedExtensions)) {
        $errors[] = 'Photo 2 has an invalid format';
        $errorP2="error";
    }
} else {
    $errors[] = 'Photo 2 is empty';
    $errorP2="error";
}

if (!empty($fileName3)) {
    if (!in_array($fileExtension3, $allowedExtensions)) {
        $errors[] = 'Photo 3 has an invalid format';
        $errorP3="error";
    }
} else {
    $errors[] = 'Photo 3 is empty';
    $errorP3="error";
}

if (!empty($fileName4)) {
    if (!in_array($fileExtension4, $allowedExtensions)) {
        $errors[] = 'Photo 4 has an invalid format';
        $errorP4="error";
    }
} else {
    $errors[] = 'Photo 4 is empty';
    $errorP4="error";
}

if (!empty($fileName5)) {
    if (!in_array($fileExtension5, $allowedExtensions)) {
        $errors[] = 'Photo 5 has an invalid format';
        $errorP5="error";
    }
} else {
    $errors[] = 'Photo 5 is empty';
    $errorP5="error";
}

// 构建包含所有错误的消息
if (!empty($errors)) {
  $errorsPicture = implode(', ', $errors);

} else {
    $errorsPicture="";
    $errorP1="";
    $errorP2="";
    $errorP3="";
    $errorP4="";
    $errorP5="";
}


  
    if($houseType==""){
      $error2="Please select House Types";
    }else{
    $error2="";
    $houseType=$_POST["houseType"];
    }
  
 
    if($bedroomQuantity==""){
      $error3="Please select the BedRoom Quantity";
    }else{
      $bedroomQuantity=$_POST["bedroomQuantity"];
      $error3="";
    }

    if($bathroomQuantity==""){
      $errorBQ="Please select the BathRoom Quantity";
    }else{
      $bathroomQuantity=$_POST["bathroomQuantity"];
      $errorBQ="";
    }

    if (empty($_POST['size'])) {
      $errorPS = "Property Size is required";
  } else {
      $size = $_POST['size'];
      // Regular expression to validate the input
      if (!preg_match('/^\d{1,5}$/', $size)) {
          $errorPS = "Please enter a number with a maximum of 5 digits for Property Size";
      } else {
          // Processing when the size is validated
          $errorPS = ""; // Reset the error message if the size is valid
      }
  }

    if($location==""){
      $error4="Please select the location";
    }else{
      $location=$_POST["location"];
      $error4="";
    }
  
  if(empty($adTitle)){
    $error5 = "Tittle is required";
  }
  elseif (preg_match("/^[a-zA-Z0-9. ]+$/", $adTitle)) {
    // 输入合法，可以继续处理
    $error5="";
    $adTitle=$_POST["tittle"];
} else {
    // 输入包含特殊字符，显示错误消息
    $error5= "Ad Title contains special characters. Only letters, numbers, spaces, and dot are allowed.";
}
if($description==""){
  $error9="Please enter description and other terms if available. ";
}else{
$error9="";
$description=$_POST["description"];
}
if(empty($price)){
$error6 = "Price is required";
}
elseif (isset($_POST["price"])) {
    // Use a regular expression to validate the input
    if (preg_match('/^\d{1,5}$/', $price)) {
        // Input is a number with no more than 5 digits, continue processing
        $error6="";
        $price = $_POST["price"];
    } else {
        // Input is not a valid number or exceeds 5 digits, display an error message
        $error6= "Price should be a number with no more than 5 digits.";
    }
}
if(empty($deposit)){
  $errorDP = "Deposit is required";
  }
  elseif (isset($_POST["deposit"])) {
      // Use a regular expression to validate the input
      if (preg_match('/^\d{1,6}$/', $deposit)) {
          // Input is a number with no more than 5 digits, continue processing
          $errorDP="";
          $$deposit = $_POST["deposit"];
      } else {
          // Input is not a valid number or exceeds 5 digits, display an error message
          $errorDP= "Deposit should be a number with no more than 6 digits.";
      }
  }
if(empty($_POST['name'])){
  $error7 = "Username is required";
}
elseif(!preg_match("/^[a-zA-Z-' ]*$/",$_POST['name']))
{
    $name=$_POST['name'];
    $error7 = "Valid username is required";
}
else
{
     $error7 = ""; 
}

function validatePhoneNumber($phone) {
  // 使用正则表达式检查电话号码格式
  $pattern = '/^01\d{1}\d{7}|01\d{1}\d{6}$/';

  if (preg_match($pattern, $phone) || empty($phone)) {
      return true; // 电话号码格式正确
  } else {
      return false; // 电话号码格式不正确
  }
}


// 测试函数
if(empty($phone)){
$error8 = "Phone Number is required";
}
elseif (validatePhoneNumber($phone)) {
  $error8="";
} else {
  $error8="Invalid Phone Number";
} 
if($errorPS == "" &&$errorDP == "" &&$errorsPicture=="" &&$error1 == "" &&$error2 == "" && $error3 == "" && $error4 == ""&&$error5 == ""&&$error6 == ""&&$error7 == ""
&&$error8 == ""&&$error9 == ""){
  $emails=$_SESSION['email'] ;
  if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}
  move_uploaded_file($fileTmpName1, $uploadPath1);
  move_uploaded_file($fileTmpName2, $uploadPath2);
  move_uploaded_file($fileTmpName3, $uploadPath3);
  move_uploaded_file($fileTmpName4, $uploadPath4);
  move_uploaded_file($fileTmpName5, $uploadPath5);

  $id=isset($_POST['id']) && ($_POST['id']!='auto' ? $_POST['id'] : NULL);    
  $stmt=$pdo->prepare('INSERT INTO house values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
  $stmt->execute([$id,$name,$emails,$adTitle,$fileName1,$fileName2,$fileName3,$fileName4,$fileName5,$houseType,$bedroomQuantity,$bathroomQuantity,$size,$description,$price,$deposit,$location,$phone,$currentDateTime,false,true,""]);
  $_SESSION['type']="";
  $_SESSION['successPostAd'] = true;
  header("location:MyAdProperty.php");
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
  <body>
    <style>
      .nav-item:hover{
        background-color: rgba(114, 114, 114, 0.179);
      }
      input[type="file"] {
    /* Hide the default text next to the file input */
    display: none;
}
.custom-file-upload{
    width: 100%;
    -webkit-box-pack: center;
    justify-content: center;
    position: relative;
    display: flex;
    border: 1px solid var(--black-a12);
    background-size:contain;
    background-repeat: no-repeat;
    background-position: center center;
    
}
img{
  cursor: pointer;
}
    </style>
    <form action="" method="post" novalidate enctype="multipart/form-data">
    <section class="d-flex justify-content-center align-items-center mt-5 text-dark" >
        <div class="container py-5">
            <div class="row">
              <!--Information-->
                <div class="col-4 mx-4 ">
                <div class="row shadow-lg  py-3 bgColor rounded-4 text-center d-flex justify-content-center" >
                      <p class="fw-bold fs-3">Became Our Partner?</p>
                      <a href="#" class="btn btn-primary btn-md" style="width: 30%;">Click Here!</a>
                </div>
                    
                    <div class="row shadow-lg mt-4 py-3 bg-light rounded-4 ">
                      <p class="m-0 fw-bold fs-5">Basic Information</p>
                      <p class="m-0 fw-bold fs-5">Ad Details</p>
                      <div class="collapse fade" id="multiCollapse1">
                        <div class="container bgCar">
                        <div class="text-dark">
                        <ul class="list-unstyled">
                          <li class="nav-item"><a class="nav-link text-dark" href="#sectionC1">- Photo for Your Ad</a></li>
                          <li class="nav-item"><a class="nav-link text-dark" href="#sectionC2">- Insert Your <span class="fw-bold">Car</span> Specifaction</a></li>
                          <li class="nav-item"><a class="nav-link text-dark" href="#sectionC3">- Describe Your <span class="fw-bold">Car</span></a></li>
                          <li class="nav-item"><a class="nav-link text-dark" href="#sectionC4">- Contact</a></li>
                        </ul>
                        </div>
                        </div>
                      </div>
                      <div class="collapse fade" id="multiCollapse2">
                        <div class="text-dark">
                          <div class="container bgProperty">
                          <ul class="list-unstyled">
                            <li class="nav-item"><a class="nav-link text-dark" href="#section1">- Photo for Your Ad</a></li>
                            <li class="nav-item"><a class="nav-link text-dark" href="#section2">- Insert Your <span class="fw-bold">Property</span> Specifaction</a></li>
                            <li class="nav-item"><a class="nav-link text-dark" href="#section3">- Describe Your <span class="fw-bold">Property</span></a></li>
                            <li class="nav-item"><a class="nav-link text-dark" href="#section4">- Contact</a></li>
                          </ul>
                        </div>
                      </div>
                      </div>
                    </div>
                    <!--Personal Information-->
                    <section id="sectionC4" class="mt-4 collapse fade multiCollapse3">
                <div class="row shadow-lg py-4 bg-light rounded-4">
                  <h4 class="m-0 mb-3">Personal Information</h4>
                  
                  <div class="input-group">
                      <span class="input-group-text text-dark " style="font-size:15px;">Name</span>
                      <input type="text" name="name" class="form-control text-dark"  placeholder="&nbsp;Full Name" value = "<?php if(!empty($_POST['name'])){echo $name;}?>">
                  </div>

                
                  <div class="input-group mt-3">
                      <span class="input-group-text text-dark " style="font-size:15px; padding-left:40px"><i class="fa-solid fa-phone"></i></span>
                      <input type="text"  name="phone" class="form-control text-dark"  placeholder="&nbsp;&nbsp;Phone Number" value = "<?php if(!empty($details['phone'])){echo $details['phone'];} elseif(!empty($_POST['phone'])){echo $phone;}?>">
                  </div>               

                </div>
              </section>

              <div class="row mt-4 d-flex justify-content-end">
                
              <div class="col-5">
              <input name="submit" class="btn btn-primary w-100" type="submit" value="POST" > 
              </div>
                </div>
                </div>

                <!--Details Need to fillup-->
                <div class="col-7 mx-4">
                    <div class="row shadow-lg pt-3 bg-light rounded-4">
               
                    <div class="fw-bold" id="myTabs" role="tablist" style="border: 0;">
                        <h4 class="m-0">What Would You Like To Post</h4>
                        <div class="form-control-lg p-0 px-3">
                            <input type="radio" name="cate" value="Car" id="carRadio" id="tab1-tab" 
                            data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="false" 
                            <?php if(!empty($_POST['cate'])) echo $_POST['cate'] == 'Car' ? 'checked' : ''; ?> />
                            <span style="margin-right: 3rem;"><label for="carRadio">Car</label></span>
                            <input type="radio" name="cate" value="Property" id="propertyRadio" id="tab2-tab" 
                            data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false" 
                            <?php if(!empty($_POST['cate'])) echo $_POST['cate'] == 'Property' ? 'checked' : ''; ?>/>
                            <span><label for="propertyRadio">Property</label></span>
                        </div>
                      
                    </div>
                </div>
                
          <!--Fade Out When Category Have been choosing-->
          <div class="tab-content" id="myTabContent">
            <!--Car Category-->
            <div class="tab-pane fade mt-3" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
              <section id="sectionC1">
              <div class="row shadow-lg py-3 bg-light rounded-4">
                <h4 class="m-0 mb-3">Photo for your Ad</h4>
                <div class="row mb-3">
                <div class="col-3" style="height: 200px;">
                  <label for="file1" class="custom-file-upload img-fluid" id="uploadLabel1" style="background-image: url(https://mcdn.mudah.my/static-assets/images/image_placeholder/placeholder_car_cover_photo_v4.png);">
                  </label>
                  <input type="file" name="files1" id="file1" class="custom-file-input" >
                  <img id="preview1" src="" alt="" class="img-fluid " style="height: 200px;" data-bs-toggle="modal" data-bs-target="#modal1">
                </div>
                <div class="col-3" style="height: 200px;">
                  <label for="file2" class="custom-file-upload" id="uploadLabel2" style="background-image: url(https://mcdn.mudah.my/static-assets/images/image_placeholder/placeholder_car_front_v4.png);"></label>
                  <input type="file" name="files2" id="file2" class="custom-file-input" >
                  <img id="preview2" src="" alt="" class="img-fluid" style="height: 200px;" data-bs-toggle="modal" data-bs-target="#modal2">
                </div>
                <div class="col-3" style="height: 200px;">
                  <label for="file3" class="custom-file-upload" id="uploadLabel3" style="background-image: url(https://mcdn.mudah.my/static-assets/images/image_placeholder/placeholder_car_back_v4.png);"></label>
                  <input type="file" name="file3" id="file3" class="custom-file-input" >
                  <img id="preview3" src="" alt="" class="img-fluid" style="height: 200px;" data-bs-toggle="modal" data-bs-target="#modal3">
                </div>
                <div class="col-3 " style="height: 200px;">
                  <label for="file4" class="custom-file-upload" id="uploadLabel4" style="background-image: url(https://mcdn.mudah.my/static-assets/images/image_placeholder/placeholder_car_interior_f_v4.png);"></label>
                  <input type="file" name="files4" id="file4" class="custom-file-input" >
                  <img id="preview4" src="" alt="" class="img-fluid" style="height: 200px;" data-bs-toggle="modal" data-bs-target="#modal4">
                </div>
              </div>
              <div class="row">
                <div class="col-3" style="height: 200px;">
                  <label for="file5" class="custom-file-upload" id="uploadLabel5" style="background-image: url(https://mcdn.mudah.my/static-assets/images/image_placeholder/placeholder_car_interior_b_v4.png);"></label>
                  <input type="file" name="files5" id="file5" class="custom-file-input" >
                  <img id="preview5" src="" alt="" class="img-fluid" style="height: 200px;" data-bs-toggle="modal" data-bs-target="#modal5">
                </div>
              </div>
              </div>
              </section>

              <section id="sectionC2" class="mt-3">
                <div class="row shadow-lg py-3 bg-light rounded-4">
                  <h4 class="m-0 mb-3">Insert Your Car Specifactions</h4>
                  <div class="input-group">
                  <span class="input-group-text text-dark fw-bold" style="font-size:15px;">Brand Model</span>
                    <select name="carBrand" id="carBrand" class="form-control text-dark">
                        <option value="" >Please Choose your Car Model</option>
                        <?php
                        $brands = ['Audi', 'BMW', 'Chevrolet', 'Ford', 'Honda', 'Hyundai', 'Jeep', 'Kia', 'Lexus', 'Mazda', 'Mercedes-Benz', 'Nissan','Proton','Peroduo', 'Subaru', 'Toyota', 'Volkswagen', 'Volvo'];
                    
                        foreach ($brands as $brand) {
                          $checkedBrand = (!empty($_POST['carBrand']) && $_POST['carBrand'] === $brand) ? 'selected' : '';
                          echo "<option value=\"$brand\" $checkedBrand>$brand</option>";
                        }
                        ?>
                    </select>
                 </div>
                 <div class="input-group mt-3">
                  <span class="input-group-text text-dark fw-bold" style="font-size:15px;">Car Category</span>
                    <select name="carCategory" id="carCategory" class="form-control text-dark">
                        <option value="" >Please Choose your Car Category</option>
                        <?php
                         $categoryCars = ['Small', 'SUV', 'Luxury'];
                    
                        foreach ($categoryCars as $categoryCar) {
                          $checkedCategory = (!empty($_POST['carCategory']) && $_POST['carCategory'] === $categoryCar) ? 'selected' : '';
                          echo "<option value=\"$categoryCar\" $checkedCategory>$categoryCar</option>";
                        }
                        ?>
                    </select>
                 </div>
                </div>
              </section>

              <section id="sectionC3" class="mt-3">
                <div class="row shadow-lg py-3 bg-light rounded-4">
                  <h4 class="m-0 mb-3">Describe Your Car</h4>
                  
                  <div class="input-group">
                      <span class="input-group-text text-dark " style="font-size:15px;">@</span>
                      <input type="text" id="name" name="tittle" class="form-control text-dark"  placeholder="&nbsp;Title" value = "<?php if(!empty($_POST['tittle'])){echo $adTitle;}?>">
                  </div>

                 <div class="input-groupD mt-3">           
                      <textarea id="description" class="form-controlD text-dark" name="description" placeholder="&nbsp;Describe Your Car Here" rows="5" cols="40" required><?php if (!empty($_POST['description'])) { echo $description; } ?></textarea>
                  </div>
                  <div class="input-group mt-2">
                      <span class="input-group-text text-dark " style="font-size:15px;">Price</span>
                      <input type="text"  name="price" class="form-control text-dark"  placeholder="&nbsp;Price" value = "<?php if(!empty($_POST['price'])){echo $price;}?>">
                  </div>               

                  <div class="input-group mt-3">
                  <span class="input-group-text text-dark fw-bold" style="font-size:15px;">Location</span>
                    <select name="location" id="location" class="form-control text-dark">
                        <option value="" >Please Choose your Location</option>
                        <?php
                         $locations = ['Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Perak', 'Perlis', 'Penang', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur'];
                    
                        foreach ($locations as $location) {
                          $checkedLocation = (!empty($_POST['location']) && $_POST['location'] === $location) ? 'selected' : '';
                          echo "<option value=\"$location\" $checkedLocation>$location</option>";
                        }
                        ?>
                    </select>
                 </div>
                </div>
              </section>
           </div>

           <!--Property Category-->
            <div class="tab-pane fade mt-3" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
            <section id="sectionC1">
              <div class="row shadow-lg py-3 bg-light rounded-4">
                <h4 class="m-0 mb-3">Photo for your Ad</h4>
                <div class="row mb-3">
                <div class="col-3" style="height: 200px;">
                  <label for="file6" class="custom-file-upload img-fluid" id="uploadLabel6" style="background-image: url(https://mcdn.mudah.my/static-assets/images/image_placeholder/placeholder_property_apartment_cover_v4.png);">
                  </label>
                  <input type="file" name="files1" id="file6" class="custom-file-input" >
                  <img id="preview6" src="" alt="" class="img-fluid " style="height: 200px;" data-bs-toggle="modal" data-bs-target="#modal6">
                </div>
                <div class="col-3" style="height: 200px;">
                  <label for="file7" class="custom-file-upload" id="uploadLabel7" style="background-image: url(https://mcdn.mudah.my/static-assets/images/image_placeholder/placeholder_property_bedroom_v4.png);"></label>
                  <input type="file" name="files2" id="file7" class="custom-file-input" >
                  <img id="preview7" src="" alt="" class="img-fluid" style="height: 200px;" data-bs-toggle="modal" data-bs-target="#modal7">
                </div>
                <div class="col-3" style="height: 200px;">
                  <label for="file8" class="custom-file-upload" id="uploadLabel8" style="background-image: url(https://mcdn.mudah.my/static-assets/images/image_placeholder/placeholder_property_livingroom_v4.png);"></label>
                  <input type="file" name="file3" id="file8" class="custom-file-input" >
                  <img id="preview8" src="" alt="" class="img-fluid" style="height: 200px;" data-bs-toggle="modal" data-bs-target="#modal8">
                </div>
                <div class="col-3 " style="height: 200px;">
                  <label for="file9" class="custom-file-upload" id="uploadLabel9" style="background-image: url(https://mcdn.mudah.my/static-assets/images/image_placeholder/placeholder_property_shower_v4.png);"></label>
                  <input type="file" name="files4" id="file9" class="custom-file-input" >
                  <img id="preview9" src="" alt="" class="img-fluid" style="height: 200px;" data-bs-toggle="modal" data-bs-target="#modal9">
                </div>
              </div>
              <div class="row">
                <div class="col-3" style="height: 200px;">
                  <label for="file10" class="custom-file-upload" id="uploadLabel10" style="background-image: url(https://mcdn.mudah.my/static-assets/images/image_placeholder/placeholder_property_kitchen_v4.png);"></label>
                  <input type="file" name="files5" id="file10" class="custom-file-input" >
                  <img id="preview10" src="" alt="" class="img-fluid" style="height: 200px;" data-bs-toggle="modal" data-bs-target="#modal10">
                </div>
              </div>
              </div>
              </section>

              <section id="sectionC2" class="mt-3">
                <div class="row shadow-lg py-3 bg-light rounded-4">
                  <h4 class="m-0 mb-3">Insert Your Property Specifactions</h4>
                  <div class="input-group">
                  <span class="input-group-text text-dark fw-bold" style="font-size:15px;">Property Type</span>
                    <select name="houseType" id="houseType" class="form-control text-dark">
                        <option value="" >Please Choose your Property Type</option>
                        <?php
                        $houseTypes = ['Apartment', 'Bungalow', 'Condominum', 'Flat', 'Semi-D', 'Room'];
                    
                        foreach ($houseTypes as $houseType) {
                          $checkedhouseType = (!empty($_POST['houseType']) && $_POST['houseType'] === $houseType) ? 'selected' : '';
                          echo "<option value=\"$houseType\" $checkedhouseType>$houseType</option>";
                        }
                        ?>
                    </select>
                 </div>
                 <div class="input-group mt-3">
                  <span class="input-group-text text-dark fw-bold" style="font-size:15px;">Bedroom Quantity</span>
                    <select name="bedroomQuantity" id="bedroomQuantity" class="form-control text-dark">
                        <option value="" >Bedroom Quantity</option>
                        <?php for ($i = 1; $i <= 9; $i++) : ?>
                          <option value="<?php echo $i; ?>" <?php if (!empty($_POST['bedroomQuantity']) && $_POST['bedroomQuantity'] == $i) echo 'selected'; ?>>
                        <?php echo $i; ?>
                       </option>
                   <?php endfor; ?>
                    </select>
                 </div>
                 <div class="input-group mt-3">
                  <span class="input-group-text text-dark fw-bold" style="font-size:15px;">Bathroom Quantity</span>
                    <select name="bathroomQuantity" id="bathroomQuantity" class="form-control text-dark">
                        <option value="" >Bathroom Quantity</option>
                        <?php for ($i = 1; $i <= 9; $i++) : ?>
                          <option value="<?php echo $i; ?>" <?php if (!empty($_POST['bathroomQuantity']) && $_POST['bathroomQuantity'] == $i) echo 'selected'; ?>>
                        <?php echo $i; ?>
                       </option>
                   <?php endfor; ?>
                    </select>
                 </div>
                 <div class="input-group mt-3">
                      <span class="input-group-text text-dark " style="font-size:15px;">Property Size(sq.ft)</span>
                      <input type="text"  name="size" class="form-control text-dark"  placeholder="&nbsp;Property Size(sq.ft)" value="<?php echo !empty($_POST['size']) ? $_POST['size'] : ''; ?>" required>
                  </div>   
                </div>
              </section>

              <section id="sectionC3" class="mt-3">
                <div class="row shadow-lg py-3 bg-light rounded-4">
                  <h4 class="m-0 mb-3">Describe Your Property</h4>
                  
                  <div class="input-group">
                      <span class="input-group-text text-dark " style="font-size:15px;">@</span>
                      <input type="text" id="name" name="tittle" class="form-control text-dark"  placeholder="&nbsp;Title" value = "<?php if(!empty($_POST['tittle'])){echo $adTitle;}?>">
                  </div>

                 <div class="input-groupD mt-3">           
                      <textarea id="description" class="form-controlD text-dark" name="description" placeholder="&nbsp;Describe Your Car Here" rows="5" cols="40" required><?php if (!empty($_POST['description'])) { echo $description; } ?></textarea>
                  </div>
                  <div class="input-group mt-2">
                      <span class="input-group-text text-dark " style="font-size:15px;">Price</span>
                      <input type="text"  name="price" class="form-control text-dark"  placeholder="&nbsp;Price" value = "<?php if(!empty($_POST['price'])){echo $price;}?>">
                  </div>               
                  <div class="input-group mt-3">
                      <span class="input-group-text text-dark " style="font-size:15px;">Rental Deposit</span>
                      <input type="text"  name="deposite" class="form-control text-dark"  placeholder="&nbsp;Rental Deposit" value = "<?php if(!empty($_POST['deposit'])){echo $deposit;}?>">
                  </div> 
                  <div class="input-group mt-3">
                  <span class="input-group-text text-dark fw-bold" style="font-size:15px;">Location</span>
                    <select name="location" id="location" class="form-control text-dark">
                        <option value="" >Please Choose your Location</option>
                        <?php
                         $locations = ['Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Perak', 'Perlis', 'Penang', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur'];
                    
                        foreach ($locations as $location) {
                          $checkedLocation = (!empty($_POST['location']) && $_POST['location'] === $location) ? 'selected' : '';
                          echo "<option value=\"$location\" $checkedLocation>$location</option>";
                        }
                        ?>
                    </select>
                 </div>
                </div>
              </section>
            </div>

          </div>

        </div>
        </div>

        
    </section>
<div class="project-modals">
          <!-- Modal 1 -->
          <div id="modal1" class="modal fade">
            <div class="modal-dialog modal-lg mt-7">
              <div class="modal-content bg-light shadow-lg p-5">
                <div class="row">
                  <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <img id="previewEdit1" src="" alt="" class="img-fluid" style="height: 250px;">
                  </div>
                  <div class="row ">
                  <div class="col-4">
                    <label for="file1" class="btn btn-primary mt-3 w-100" id="uploadLabel1">Edit</label>
                    <input type="file" name="files1" id="file1" class="custom-file-input" >
                  </div>
                    <div class="col-4">
                    <button id="delete1" type="button" class="btn btn-danger mt-3 w-100">Delete</button>                      
                    </div>
                    <div class="col-4">
                      <button class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal 2 -->
          <div id="modal2" class="modal fade">
            <div class="modal-dialog modal-lg mt-7">
              <div class="modal-content bg-light shadow-lg p-5">
                <div class="row">
                  <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <img id="previewEdit2" src="" alt="" class="img-fluid" style="height: 250px;">
                  </div>
                  <div class="row ">
                  <div class="col-4">
                    <label for="file2" class="btn btn-primary mt-3 w-100" id="uploadLabel2">Edit</label>
                    <input type="file" name="files2" id="file2" class="custom-file-input" >
                  </div>
                    <div class="col-4">
                    <button id="delete2" type="button" class="btn btn-danger mt-3 w-100">Delete</button>                       
                    </div>
                    <div class="col-4">
                      <button class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                  </div>
              </div>
            </div>
          </div>
          <!-- Modal 3 -->
          <div id="modal3" class="modal fade">
            <div class="modal-dialog modal-lg mt-7">
              <div class="modal-content bg-light shadow-lg p-5">
                <div class="row">
                  <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <img id="previewEdit3" src="" alt="" class="img-fluid" style="height: 250px;">
                  </div>
                  <div class="row ">
                  <div class="col-4">
                    <label for="file3" class="btn btn-primary mt-3 w-100" id="uploadLabel3">Edit</label>
                    <input type="file" name="files3" id="file3" class="custom-file-input" >
                  </div>
                    <div class="col-4">
                    <button id="delete3" type="button" class="btn btn-danger mt-3 w-100">Delete</button>                       
                    </div>
                    <div class="col-4">
                      <button class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                  </div>
              </div>
            </div>
          </div>
          <!-- Modal 4 -->
          <div id="modal4" class="modal fade">
            <div class="modal-dialog modal-lg mt-7">
              <div class="modal-content bg-light shadow-lg p-5">
                <div class="row">
                  <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <img id="previewEdit4" src="" alt="" class="img-fluid" style="height: 250px;">
                  </div>
                  <div class="row ">
                  <div class="col-4">
                    <label for="file4" class="btn btn-primary mt-3 w-100" id="uploadLabel4">Edit</label>
                    <input type="file" name="files4" id="file4" class="custom-file-input" >
                  </div>
                    <div class="col-4">
                    <button id="delete4" type="button" class="btn btn-danger mt-3 w-100">Delete</button>                       
                    </div>
                    <div class="col-4">
                      <button class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                  </div>
              </div>
            </div>
          </div>
          <!-- Modal 5 -->
          <div id="modal5" class="modal fade">
            <div class="modal-dialog modal-lg mt-7">
              <div class="modal-content bg-light shadow-lg p-5">
                <div class="row">
                  <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <img id="previewEdit5" src="" alt="" class="img-fluid" style="height: 250px;">
                  </div>
                  <div class="row ">
                  <div class="col-4">
                    <label for="file5" class="btn btn-primary mt-3 w-100" id="uploadLabel5">Edit</label>
                    <input type="file" name="files5" id="file5" class="custom-file-input" >
                  </div>
                    <div class="col-4">
                    <button id="delete5" type="button" class="btn btn-danger mt-3 w-100">Delete</button>                       
                    </div>
                    <div class="col-4">
                      <button class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                  </div>
              </div>
            </div>
          </div>
           <!-- Modal 6 -->
           <div id="modal6" class="modal fade">
            <div class="modal-dialog modal-lg mt-7">
              <div class="modal-content bg-light shadow-lg p-5">
                <div class="row">
                  <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <img id="previewEdit6" src="" alt="" class="img-fluid" style="height: 250px;">
                  </div>
                  <div class="row ">
                    <div class="col-4">
                    <label for="file6" class="custom-file-upload btn btn-danger" id="uploadLabel6">Edit</label>
                    <input type="file" name="files6" id="file6" class="custom-file-input" >
                    </div>
                    <div class="col-4">
                    <button id="delete6" type="button" class="btn btn-danger mt-3 w-100">Delete</button>                       
                    </div>
                    <div class="col-4">
                      <button class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal 7 -->
          <div id="modal7" class="modal fade">
            <div class="modal-dialog modal-lg mt-7">
              <div class="modal-content bg-light shadow-lg p-5">
                <div class="row">
                  <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <img id="previewEdit7" src="" alt="" class="img-fluid" style="height: 250px;">
                  </div>
                  <div class="row ">
                  <div class="col-4">
                    <label for="file7" class="btn btn-primary mt-3 w-100" id="uploadLabel7">Edit</label>
                    <input type="file" name="files7" id="file7" class="custom-file-input" >
                  </div>
                  <div class="col-4">
                    <button id="delete7" type="button" class="btn btn-danger mt-3 w-100">Delete</button>                    
                  </div>
                  <div class="col-4">
                      <button class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Close</button>
                  </div>
                  </div>
                  </div>
              </div>
            </div>
          </div>
          <!-- Modal 8 -->
          <div id="modal8" class="modal fade">
            <div class="modal-dialog modal-lg mt-7">
              <div class="modal-content bg-light shadow-lg p-5">
                <div class="row">
                  <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <img id="previewEdit8" src="" alt="" class="img-fluid" style="height: 250px;">
                  </div>
                  <div class="row ">
                  <div class="col-4">
                    <label for="file8" class="btn btn-primary mt-3 w-100" id="uploadLabel8">Edit</label>
                    <input type="file" name="files8" id="file8" class="custom-file-input" >
                  </div>
                    <div class="col-4">
                    <button id="delete8" type="button" class="btn btn-danger mt-3 w-100">Delete</button>                       
                    </div>
                    <div class="col-4">
                      <button class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                  </div>
              </div>
            </div>
          </div>
          <!-- Modal 9 -->
          <div id="modal9" class="modal fade">
            <div class="modal-dialog modal-lg mt-7">
              <div class="modal-content bg-light shadow-lg p-5">
                <div class="row">
                  <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <img id="previewEdit9" src="" alt="" class="img-fluid" style="height: 250px;">
                  </div>
                  <div class="row ">
                  <div class="col-4">
                    <label for="file9" class="btn btn-primary mt-3 w-100" id="uploadLabel9">Edit</label>
                    <input type="file" name="files9" id="file9" class="custom-file-input" >
                  </div>
                    <div class="col-4">
                    <button id="delete9" type="button" class="btn btn-danger mt-3 w-100">Delete</button>                       
                    </div>
                    <div class="col-4">
                      <button class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                  </div>
              </div>
            </div>
          </div>
          <!-- Modal 10 -->
          <div id="modal10" class="modal fade">
            <div class="modal-dialog modal-lg mt-7">
              <div class="modal-content bg-light shadow-lg p-5">
                <div class="row">
                  <div class="col-12 d-flex flex-column align-items-center justify-content-center">
                    <img id="previewEdit10" src="" alt="" class="img-fluid" style="height: 250px;">
                  </div>
                  <div class="row ">
                  <div class="col-4">
                    <label for="file10" class="btn btn-primary mt-3 w-100" id="uploadLabel10">Edit</label>
                    <input type="file" name="files10" id="file10" class="custom-file-input" >
                  </div>
                    <div class="col-4 offset-2">
                    <button id="delete10" type="button" class="btn btn-danger mt-3 w-100">Delete</button>                       
                    </div>
                    <div class="col-4">
                      <button class="btn btn-secondary mt-3 w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                  </div>
              </div>
            </div>
          </div>
</div>
</form>
  </body>
    <script src="js/replaceme.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/post.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
            $('#carRadio').click(function() {
                $('#multiCollapse2').collapse('hide');
                $('#multiCollapse1').collapse('show');
                $('.multiCollapse3').collapse('show');
                $('.bgColor').addClass('bgImage1');
                $('.bgColor').removeClass('bgImage2');
            });

            $('#propertyRadio').click(function() {
                $('#multiCollapse1').collapse('hide');
                $('#multiCollapse2').collapse('show');
                $('.multiCollapse3').collapse('show');
                $('.bgColor').addClass('bgImage2');
                $('.bgColor').removeClass('bgImage1');
            });
        });
</script>
  </body>
</html>