<?php
session_start();    
date_default_timezone_set('Asia/Kuala_Lumpur');
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    if($email ==true){
    $emails=$_SESSION['email'] ;
    }
//session_destroy();
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
  
  <nav class="navbar navbar-expand-lg sticky-top">
      <div class="container ">
        <a class="navbar-brand" href="home.php">
          <img src="Picture/logo7.svg" alt="" width="150" />
        </a>


        <button class="navbar-toggler" 
           type="button" 
           data-toggle="collapse" 
           data-target="#navbarNavDropdown" 
           aria-controls="navbarNavDropdown" 
           aria-expanded="false" 
           aria-label="toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse " id="navbarNavDropdown">
          <ul class="nav navbar-nav me-auto fw-bold">
            <li class="nav-item">
              <a class="nav-link text-dark" aria-current="page" href="home.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="car.php">Car</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="property.php">Property</a>
            </li>
            
          </ul>
          <ul class="navbar-nav gap-2 fw-bold">
            <li class="nav-item text-primary d-flex align-items-center">
            <?php if (!empty($emails)): ?>
                <a class="nav-link p-0" style="cursor: default;"><strong><?php echo $email ?></strong></a>
             
              <?php else: ?>
               <a class="nav-link text-dark p-0" href="signin.php">Login</a>
              <?php endif; ?>
            </li>
            
            

              <?php if (empty($emails)): ?>
              <li class="nav-item d-none d-md-block">
                <span class="fa-stack fa-lg">
               <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fa fa-user fa-stack-1x text-white"></i>
           </span>
              </li>
              <?php else: ?>
                <li class="nav-item dropdown d-none d-md-block">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="fa-stack fa-lg">
               <i class="fas fa-circle fa-stack-2x text-primary"></i>
            <i class="fa fa-user fa-stack-1x text-white"></i>
           </span>
                </a>
                <ul class="dropdown-menu fs-5" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user"></i>&nbsp;Profile</a></li>
                  <li><a class="dropdown-item" href="MyAdCar.php"><i class="fas fa-ad"></i>&nbsp;My Ad</a></li>
                  <li><a class="dropdown-item" href="feedback.php"><i class="fas fa-comment"></i>&nbsp;Feedback</a></li>
                  <li><a class="dropdown-item" href="MyFavouriteCar.php"><i class="fas fa-heart"></i>&nbsp;Favourite</a></li>
                  <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</a></li>
                </ul>
              </li>
              <?php endif; ?>

            <li class="nav-item  d-flex align-items-center">
            <?php if (!empty($emails)): ?>
            <a href="post.php" class="btn btn-secondary text-center px-4 text-dark fw-normal">
             POST
            </a>
            <?php else: ?>
              <a href="signin.php" class="btn btn-secondary text-center px-4 text-dark fw-normal">
              POST
            </a>
            <?php endif; ?>
            </a>
            </li>
          </ul>

        </div>
      </div>
    </nav>

  
    
    <script src="js/replaceme.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>