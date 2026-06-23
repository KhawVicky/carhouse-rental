<?php
include'menu.php';
    include 'connection.php';
    if (isset($_SESSION['userSortOption'])) {
      unset($_SESSION['userSortOption']);
  }
  if (isset($_SESSION['userSortOptionP'])) {
    unset($_SESSION['userSortOptionP']);
}
if (isset($_SESSION['userSortOptionMyAdF'])) {
  unset($_SESSION['userSortOptionMyAdF']);
}
if (isset($_SESSION['userSortOptionMyAdFP'])) {
  unset($_SESSION['userSortOptionMyAdFP']);
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
    $pdo = pdo_connect_mysql();
    $stmt = $pdo->prepare('SELECT * FROM car WHERE verify = true AND available = true ORDER BY time DESC LIMIT 5');
    $stmt2 = $pdo->prepare('SELECT * FROM house WHERE verify = true AND available = true ORDER BY time DESC LIMIT 5');
    $stmt2->execute();
    $stmt->execute();
    $latestRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $latestRecords2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
  <script src="https://kit.fontawesome.com/ba2ac43aae.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/font-awesome.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="icon" href="images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    
  </head>
  <body>

 <!-- Header -->
 <header class="header ">
      <div class="container">
        <div class="row">
          <div class="col-md-6 pt-5">
            <h1 class="xl-text mt-5 text-dark">
            Renting Made
              <span class="text-primary fw-bold"
                >Easy,<br>Affordable and Convenient</span>
              
            </h1>
            <p class="lead text-dark">
            Looking for the perfect car and home? Look no further.<br>Our hassle-freerental solutions make finding your ideal ride<br>and residence a breeze.</p>
            <a href="car.php" class="btn btn-primary btn-lg text-white">Rent Now!</a>
            <a href="post.php" class="text-dark mx-4 partner">Become Our Partner</a>
          </div>
        </div>
      </div>
    </header>

    <!--Car Section-->
    <section id="carSection" class="carSection">
      <div class="container py-5">
        <div class="row">
          <div class="col-12">
            <div class="text-center">
            <h1 class="text-dark fw-bold">Vechicles Available</h1>
            <hr class="hr-heading" />
            </div>
          </div>
        </row>

         <div class="row">
            <div class="slick-carousel">
              <?php foreach ($latestRecords as $record): ?>  
            <div class="testimonial-item">
           
             <div class="card text-dark rounded-5">
         <a href="detailsCar.php?ID=<?= $record['ID'] ?>">
         <img src="uploads/<?= $record['picture1'] ?>" alt="<?= $record['picture1'] ?>" class="card-img-top img-fluid " style="height:200px;border-radius: 2rem 2rem 0rem 0rem;">
        </a>
              <div class="card-body p-0">
                <h5 class="card-title fw-bold px-3"><?= $record['tittle'] ?></h5>
 
                <ul class="list-unstyled">
                  <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                    <span class="py-2">
                     <strong> <i class="fa-solid fa-font-awesome"></i>
                        Brands :</strong>
                      </span>
                      <span class="py-2"><?= $record['brand'] ?></span>
                    </li>

                    <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                    <span class="py-2">
                     <strong> <i class="fa-solid fa-list"></i>
                        Category :</strong>
                      </span>
                      <span class="py-2"><?= $record['category'] ?></span>
                    </li>

                    <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                    <span class="py-2">
                     <strong> <i class="fa-solid fa-tag"></i>
                        Price :</strong>
                      </span>
                      <span class="py-2">RM<?= $record['price'] ?></span>
                    </li>

                    <li class="px-3 d-flex justify-content-between">
                    
                     <a href="detailsCar.php?ID=<?= $record['ID'] ?>" class="btn btn-primary btn-md mt-2">Book Now</a>
                    </li>

                </ul>
                </div>
              </div>
             </div>
             <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section> 

    <!--House Section-->
    <section id="houseSection" class="houseSection">
      <div class="container py-5 ">
        <div class="row">
          <div class="col-12">
            <div class="text-center">
            <h1 class="text-dark fw-bold">Property Available</h1>
            <hr class="hr-heading" />
            </div>
          </div>
          </div>
         <div class="row">
            <div class="slick-carousel">
              <?php foreach ($latestRecords2 as $record): ?>  
            <div class="testimonial-item">
             <div class="card text-dark rounded-5">
             <a href="detailsHouse.php?ID=<?= $record['ID'] ?>">
              <img src="uploads/<?= $record['picture1'] ?>" alt="<?= $record['picture1'] ?>" class="card-img-top img-fluid " style="height:200px;border-radius: 2rem 2rem 0rem 0rem;">
              </a>
              <div class="card-body p-0">
                <h5 class="card-title fw-bold px-3"><?= $record['tittle'] ?></h5>
 
                <ul class="list-unstyled">
                  <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                    <span class="py-2">
                     <strong> <i class="fa-solid fa-font-awesome"></i>
                        House Type :</strong>
                      </span>
                      <span class="py-2"><?= $record['houseType'] ?></span>
                    </li>

                    <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                    <span class="py-2">
                     <strong> <i class="fa-solid fa-location-dot"></i>
                        Location :</strong>
                      </span>
                      <span class="py-2"><?= $record['location'] ?></span>
                    </li>

                    <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                    <span class="py-2">
                     <strong> <i class="fa-solid fa-tag"></i>
                        Price :</strong>
                      </span>
                      <span class="py-2">RM<?= $record['price'] ?></span>
                    </li>

                    <li class="px-3 d-flex justify-content-between">
                    
                     <a href="detailsHouse.php?ID=<?= $record['ID'] ?>" class="btn btn-primary btn-md mt-2">Book Now</a>
                    </li>

                </ul>
                </div>
              </div>
             </div>
             <?php endforeach; ?>
          </div>
        </div>
      </div>
    </section> 
    <?php include 'footer.php'; ?>
<!-- Link jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Link Slick Carousel JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
$(document).ready(function(){
  $('.slick-carousel').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
    dots: true,
    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-right"></i></button>',
    draggable: true, // Make carousel draggabl
  });
});
</script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="js/replaceme.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>
