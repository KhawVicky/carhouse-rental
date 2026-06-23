<?php
    include 'connection.php';
    include 'menu.php';
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
if (isset($_SESSION['userSortOptionMyAdF'])) {
  unset($_SESSION['userSortOptionMyAdF']);
}
if (isset($_SESSION['userSortOptionMyAdFP'])) {
  unset($_SESSION['userSortOptionMyAdFP']);
}
    $pdo = pdo_connect_mysql();
    $stmt= $pdo->prepare('SELECT * FROM user WHERE email = :email');
    $stmt->execute(['email'=> $email]);
    $details = $stmt->fetch(PDO::FETCH_ASSOC); 

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])){
      header("location:editProfile.php");
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
    
    <section id="profile" class="py-5 text-center d-flex align-items-center">
      <div class="container border py-6 shadow-lg rounded-5">
      <?php
        
        if (isset($_SESSION['success']) && $_SESSION['success'] === true) {
       // 显示成功通知
        echo '<h3 class="text-bg-success badge fs-5">Successfully Edit Profile</h3>';
    
        // 销毁成功标志的会话变量
        unset($_SESSION['success']);
       } 
       ?>
          <div class="row">
              <div class="col-lg-3 offset-lg-2 d-flex justify-content-end mt-5">
              <?php
          if (!empty($details['UserPhoto'])) {
            
            echo '<img src="uploads/' . $details['UserPhoto'] . '" alt="' . $details['UserPhoto'] . '" class="img-fluid rounded-circle" style="height: 280px; width: 280px;">';
            }else{
              echo '<img src="Picture/user.jpg" alt="Picture/user.jpg" class="img-fluid rounded-circle" style="height: 280px; width: 280px;">';
            }
            
          ?>
                
              </div>
              <div class="col-lg-5 mx-3">
                  <div class="text-container">
                      <h2 class="text-dark mb-4">Profile Info</h2>
                      <form>
                          <div class="mb-3">
                              <input
                                  type="text"
                                  class="form-control rounded-0 text-dark"
                                  placeholder="Enter name"
                                  name="name" value="<?= $details['name'] ?>" disabled
                              />
                          </div>
                          <div class="mb-3">
                              <input
                                  type="email"
                                  class="form-control rounded-0 text-dark"
                                  placeholder="Enter email"
                                  name="email" value="<?= $details['email'] ?>" disabled
                              />
                          </div>
                          <div class="mb-3">
                              <input
                                  type="text"
                                  class="form-control rounded-0 text-dark"
                                  placeholder="Gender"
                                  name="gender" value="<?= $details['gender'] ?>" disabled
                              />
                          </div>
                          <div class="mb-3">
                              <input
                                  type="text"
                                  class="form-control rounded-0 text-dark"
                                  placeholder="Enter phone"
                                  value="<?= $details['phone'] ?>" disabled
                              />
                          </div>
                          <div class="d-grid gap-2">
                             
                              <a href="editProfile.php" class="btn btn-primary btn-block rounded-0">Edit Profile</a>
                          </div>
                      </form>
                  </div>
              </div>
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