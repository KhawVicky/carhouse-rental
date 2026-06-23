<?php
include 'menu.php';
include 'connection.php';
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
if (isset($_POST['clear'])) {
  // Handle the clear action here
  // For example, you can unset or reset the filter-related session variables
  unset($_SESSION['userSortOption']);
  /*header("Location: http://localhost/CNH-2/car.php?page=1");
  exit;*/
}
$pdo = pdo_connect_mysql();
$records_per_page = 3;
$error=false;
$verify="";
// 获取当前页数
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// 计算 SQL 中的 OFFSET
$offset = ($page - 1) * $records_per_page;

// 构建查询语句
if ($_SERVER['REQUEST_METHOD'] == 'POST' &&isset($_POST['recordID']) && isset($_POST['status'])){

    $recordID = $_POST['recordID'];
    $status = $_POST['status'];
    if ($status === 'Available') {
      // Execute the update query to set the record as Available.
      $stmt = $pdo->prepare('UPDATE car SET available = ? WHERE ID = ?');
      $stmt->execute([true, $recordID]);
  } elseif ($status === 'UnAvailable') {
      // Execute the update query to set the record as Unavailable.
      $stmt = $pdo->prepare('UPDATE car SET available = ? WHERE ID = ?');
      $stmt->execute([false, $recordID]);
  }

}
$baseQuery = 'SELECT * FROM car WHERE email = :email';

// Initialize the order condition
$orderCondition = ' ORDER BY verify DESC, time DESC, ID';

// Check for sorting options
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["search"])) {
    $sortOption = $_POST["sortOption"];
    $_SESSION['userSortOption'] = $sortOption;

    // Append sorting conditions based on the selected option
    switch ($sortOption) {
        case "lowest":
            $orderCondition = ' ORDER BY price ASC, ID';
            break;
        case "highest":
            $orderCondition = ' ORDER BY price DESC, ID';
            break;
            default :
            $orderCondition = ' ORDER BY verify DESC, time DESC, ID';
            break;
        // Add more cases as needed
    }
} elseif (isset($_SESSION['userSortOption'])) {
    // If sorting option is set in session, apply it
    switch ($_SESSION['userSortOption']) {
        case "lowest":
            $orderCondition = ' ORDER BY price ASC, ID';
            break;
        case "highest":
            $orderCondition = ' ORDER BY price DESC, ID';
            break;
            default :
            $orderCondition = ' ORDER BY verify DESC, time DESC, ID';
            break;
        // Add more cases as needed
    }
}

// Add order condition and pagination
$baseQuery .= $orderCondition . ' LIMIT :records_per_page OFFSET :offset';


// Prepare and execute the query
$stmt = $pdo->prepare($baseQuery);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':email', $email);
$stmt->execute();
$latestRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (empty($latestRecords)) {
 
  $error = true;
} else {
  $error = false;
}

if(!empty($latestRecords[0]['verify'])&&$latestRecords[0]['verify']==true){
  $verify="Verify";
}else{
  $verify="Non Verify";
}
$stmt_total = $pdo->prepare('SELECT COUNT(*) AS total_records FROM car WHERE email = :email');
$stmt_total->bindParam(':email', $email);
$stmt_total->execute();

$result = $stmt_total->fetch(PDO::FETCH_ASSOC);
$total_records = $result['total_records'];


// 显示分页链接
// 计算总页数
$total_pages = ceil($total_records / $records_per_page); // $total_records 是数据库中的总记录数

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
  <form action="" method="post" novalidate id="checkboxForm">
  <section id="carSection" class="carSection "  <?php if($error===true):?>style="height:75vh"<?php endif; ?>>
      <div class="container py-5">
        <div class="row">
          <div class="col-12">
            <div class="text-center">
            <h1 class="text-dark fw-bold">My AD Car</h1>
            <hr class="hr-heading" />
            </div>
          </div>
        </div>
        
         <div class="row">
           <div class="col-3">
           <nav class="navbar p-0">

<ul class="nav fw-bold">
<li class="nav-item">
  <a class="nav-link" aria-current="page" href="MyAdCar.php" style="color:#074eac;">Car</a>
</li>
<li class="nav-item">
  <a class="nav-link text-dark" href="MyAdProperty.php">Property</a>
</li>

</ul>
</nav>
            <!--Sort By-->
            <div class="row bg-light py-3 shadow-lg mb-4 rounded-3">
              <div class="border border-5 border-end-0 border-top-0 border-bottom-0 border-primary d-flex align-items-center">
              <button
                class="navbar-toggler w-100"
                type="button"
                data-toggle="collapse"
                data-target="#navbarNavDropdown1"
                aria-controls="navbarNavDropdown"
                aria-expanded="false"
                aria-label="toggle navigation"
                 >
               <p class="text-dark fw-bold py-2 m-0 text-start">Sort By</p>
              </button>
              </div>
                <div class="collapse  " id="navbarNavDropdown1">
                  <ul class="nav navbar-nav me-auto px-2">
                  <?php
                $sorts = ['lowest','highest'];

                foreach ($sorts as $sort) {
                    $checked = (!empty($_SESSION['userSortOption']) && $_SESSION['userSortOption'] === $sort) ? 'checked' : '';
                    echo "
                    <li class='nav-item text-dark'>
                    <label class='nav-link px-3 filterBar' style='cursor:pointer;'>
                    <input type='radio' name='sortOption' style='cursor:pointer;' value='$sort' $checked> $sort</label>
                    </li>";
                }

                ?>
                         
                  </ul>
                  </div>
            </div>

            <!---Submit Button-->
            <div class="mt-3">
            <input type="submit" class="btn btn-primary" id="search" name="search" value="SEARCH">
            <input type="submit" name="clear" class="btn" id="clear" value="Clear All Filters">
           </div>
          </div>
          <div class="col-9">
            <div class="row">

            <?php if($error===true):?>
          <p class="text-dark fw-bold fs-4 mx-3">Sorry, You no have your own Ad Yet!</p>
         <?php endif; ?>
              <?php foreach ($latestRecords as $record): ?>  
           <div class="col-md-4 pb-5">
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

                    <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                    <span class="py-2">
                     <strong> <i class="fa-solid fa-circle-info"></i>
                        Status :</strong>
                      </span>
                      <span class="py-2">
                      <?php if ($record['verify']==1): ?>
                <span class="text-success">Verify</span>
                <?php elseif ($record['verify']==0): ?>
                <span class="text-danger">Non Verify</span>
                <?php elseif ($record['verify']==3 ||$record['verify']==4): ?>
                <span class="text-danger">Rejected-<br><?= $record['reason'] ?></span>
                <?php elseif ($record['verify']==2 ): ?>
                <span class="text-danger">Your Ad has been banned </span>
                <?php endif; ?>
                      </span>
                    </li>

                    <li class="px-3 d-flex justify-content-end">
                    <div class="mx-2">
            <?php if ($record['available']==0): ?>
            <button class="btn btn-danger btn-md mt-2" id="Available_<?= $record['ID'] ?>" onclick="updateAvailability(<?= $record['ID'] ?>, 'Available')" >Unavailable</button>
            <?php elseif ($record['available']==1): ?>
            <button class="btn btn-success btn-md mt-2" id="UnAvailable_<?= $record['ID'] ?>" onclick="updateAvailability(<?= $record['ID'] ?>, 'UnAvailable')" >Available</button>
            <?php endif; ?>

            </div>
                     <a href="editCar.php?ID=<?= $record['ID'] ?>" class="btn btn-primary btn-md mt-2">Edit Ad</a>
                    </li>

                </ul>
                </div>
              </div>
              </div>
             
             <?php endforeach; ?>
             </div>
            </div>
        </div>
      </div>
    </section> 

   </form>
    <?php include 'footer.php'; ?>
    <script src="js/replaceme.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script>

function updateAvailability(recordID, status) {
    
    // AJAX call to update record in the database
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
             
                // You may want to update the UI or perform other actions here
            } else {
                
            }
        }
    };

    xhr.open("POST", "MyAdCar.php"); // Point to the correct PHP file
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("recordID=" + recordID + "&status=" + status);
}

document.getElementById("clear").addEventListener("click", function() {

// Add a hidden input to the form to indicate the clear action
var clearInput = document.createElement("input");
clearInput.type = "hidden";
clearInput.name = "clearRadio";
clearInput.value = "1";
document.getElementById("checkboxForm").appendChild(clearInput);

// Submit the form after unchecking all radio buttons
document.getElementById("checkboxForm").submit();
});
</script>
  </body>
</html>