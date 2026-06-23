<?php
    include 'connection.php';
    include 'menu.php';
    $pdo = pdo_connect_mysql();
    $success="";
    $error="";
    $error1="";
    $currentDateTime = date('Y-m-d H:i:s');
    if (isset($_SESSION['userSortOptionMyAdF'])) {
      unset($_SESSION['userSortOptionMyAdF']);
    }
    if (isset($_SESSION['userSortOptionMyAdFP'])) {
      unset($_SESSION['userSortOptionMyAdFP']);
    }
    if (isset($_SESSION['userSortOption'])) {
      unset($_SESSION['userSortOption']);
  }
  if (isset($_SESSION['userSortOptionP'])) {
    unset($_SESSION['userSortOptionP']);
}
if (isset($_SESSION['location'])) {
  unset($_SESSION['location']);
}
if (isset($_SESSION['carBrand'])) {
  unset($_SESSION['carBrand']);
}
if (isset($_SESSION['carCategory'])) {
  unset($_SESSION['carCategory']);
}
if (isset($_SESSION['price'])) {
  unset($_SESSION['price']);
}

if (isset($_SESSION['locationP'])) {
  unset($_SESSION['location']);
}
if (isset($_SESSION['houseTypeP'])) {
  unset($_SESSION['houseTypeP']);
}
if (isset($_SESSION['priceP'])) {
  unset($_SESSION['priceP']);
}
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))
    {
      $email = $_POST['email'];
      if(empty($email)){
        $error = "Email address is required";
      }else{
      if(!filter_var($email, FILTER_VALIDATE_EMAIL))
      {
          $error = "Invalid email address";
          $success=false;
      }
        else
        {
            $email = $_POST['email'];
            
        }
      }
        $description = $_POST['description'];
        if(empty($description)){
          $error1 = "Description is required";
        }else{
       
            $description = $_POST['description'];
            $error1 = "";    
        
      }
        if($error == "" && $error1 == "")
        {         
            $email = $_POST['email'];
            $description = $_POST['description'];
            $id=isset($_POST['id']) && ($_POST['id']!='auto' ? $_POST['id'] : NULL);    
            $stmt=$pdo->prepare('INSERT INTO feedback values(?,?,?,?,?)');
            $stmt->execute([$id,$email,$description,$currentDateTime,false]);
            header("location:home.php");
            $_SESSION['successFeedback'] = true;
           
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
  <body >

    <section class="d-flex justify-content-center align-items-center vh-100" >
        <div class="container rounded-5 shadow-lg bg-light d-flex justify-content-center align-items-center" style="height: 80vh; width: 80%;position:relative;">

            <div class="row align-items-center " >

                <div class="col-lg-6 d-flex justify-content-center">
                    <img src="images/feedback.png" alt="" class="img-fluid rounded-circle px-3">
                </div>
                <div class="col-lg-5 ">
                  <h2 class="text-center text-dark <?php echo empty($failed) ? 'mt-3' : ''; ?>">Feedback and Support</h2>
                  <div class="w-100 text-center align-items-center mb-2">
                  </div>
                    <form action="" method="post" novalidate>

                      <div class="input-group">
                        <span class="input-group-text text-dark "><i class="fa-solid fa-envelope"></i></span>
                        <input type="text" name="email" class="form-control form-control-lg text-dark"  placeholder="&nbsp;Email" value="<?=$email;?>" required>
                      </div>
                      <p class="text-danger px-3"><?php echo $error; ?></p>

                      <div class="input-group">
                        <textarea id="description" class="form-controlD text-dark" name="description" rows="5" cols="40" required></textarea>
                      </div>
                      <p class="text-danger px-3"><?php echo $error1; ?></p>
                      <div class="d-grid <?php echo empty($error1) ? 'mt-4' : ''; ?>">
                        <input type="submit" name="submit" class="btn btn-outline-dark rounded-5" value="Submit">
                      </div>

                    </form>
                  </h2>
            </div>
        </div>
    </section>
    <?php include 'footer.php'; ?>
    
    <script src="js/replaceme.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>