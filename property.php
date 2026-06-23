<?php
include 'menu.php';
include 'connection.php';
$pdo = pdo_connect_mysql();
$records_per_page = 20;
$error = false;
$locationC = "Malaysia";
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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_POST['clearRadio'])) {
  // Handle the clear action here
  // For example, you can unset or reset the filter-related session variables
  unset($_SESSION['locationP']);
  unset($_SESSION['houseTypeP']);
  unset($_SESSION['priceP']);
  
  
  // Redirect back to the page with cleared filters
  /*header("Location: http://localhost/CNH/house.php?page=1");
  exit;*/
}

// 获取当前页数
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

// 计算 SQL 中的 OFFSET
$offset = ($page - 1) * $records_per_page;

// 构建查询语句
$stmt = $pdo->prepare('SELECT SQL_CALC_FOUND_ROWS * FROM house WHERE verify = true AND available = true ORDER BY time DESC, ID LIMIT :records_per_page OFFSET :offset');
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$latestRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($latestRecords)) {
    displayNoStockMessage($pdo);
    $error = true;
} else {
    $error = false;
}

// Retrieve the total number of records
$total_records = $pdo->query('SELECT FOUND_ROWS()')->fetchColumn();
$rowCount = $stmt->rowCount(); // Fetch the number of rows returned

// 显示分页链接
// 计算总页数
$total_pages = ceil($total_records / $records_per_page); // $total_records 是数据库中的总记录数

// Construct the query dynamically
$query = "SELECT SQL_CALC_FOUND_ROWS * FROM house WHERE verify = true AND available = true ";

// Save filter conditions in session
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
  $_SESSION['locationP'] = !empty($_POST['location']) ? $_POST['location'] : '';
  $_SESSION['houseTypeP'] = !empty($_POST['houseType']) ? $_POST['houseType'] : '';
  $_SESSION['priceP'] = !empty($_POST['price']) ? $_POST['price'] : '';
  /*header("Location: http://localhost/CNH/house.php?page=1");
  exit;*/
}


// Append filter conditions to the query
if (!empty($_SESSION['locationP'])) {
    $query .= " AND location LIKE '%" . $_SESSION['locationP'] . "%'";
    $locationC= $_SESSION['locationP'];
}

if (!empty($_SESSION['houseTypeP'])) {
 
    $query .= " AND houseType LIKE '%". $_SESSION['houseTypeP'] . "%'";
}


if (!empty($_SESSION['priceP'])) {
    switch ($_SESSION['priceP']) {
        case 'RM0-RM1000':
            $query .= " AND (price >= 1 AND price <= 1000)";
            break;
        case 'RM1001-2500':
            $query .= " AND (price >= 1001 AND price <= 2500)";
            break;
        case 'RM2501':
            $query .= " AND price >= 2501";
            break;
    }
}

$query .= ' ORDER BY time DESC, ID LIMIT :records_per_page OFFSET :offset';


// Prepare and execute the query
$stmt = $pdo->prepare($query);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$latestRecords = $stmt->fetchAll();
$rowCount = $stmt->rowCount(); // Update rowCount with the count of filtered results

// Recalculate total_records
$total_records = $pdo->query('SELECT FOUND_ROWS()')->fetchColumn(); // Fetch the number of total rows

// Recalculate total_pages
$total_pages = ceil($total_records / $records_per_page);

if (empty($latestRecords)) {
    displayNoStockMessage($pdo);
    $error = true;
} else {
    $error = false;
}

function displayNoStockMessage($pdo)
{
    $error = true;
    $stmt = $pdo->prepare('SELECT * FROM house');
    $stmt->execute();
    $latestRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <form action="" method="post" novalidate id="checkboxForm">
  <section id="propertySection" class="propertySection ">
      <div class="container py-5">
        <div class="row">
          <div class="col-12">
            <div class="text-center">
            <h1 class="text-dark fw-bold">Properties Available</h1>
            <hr class="hr-heading" />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-3">
          <p class="text-dark ">Property For Rent In <?=$locationC?> |<br>Found <b><?=$total_records?></b> Results.</p>  
           <!--Location-->
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
              <p class="text-dark fw-bold py-2 m-0 text-start">Location</p>
             </button>
             </div>
               <div class="collapse " id="navbarNavDropdown1">
                 <ul class="nav navbar-nav me-auto px-2">
                 <?php
               $locations = ['Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Perak', 'Perlis', 'Penang', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur'];

               foreach ($locations as $location) {
                   $checked = (!empty($_SESSION['locationP']) && $_SESSION['locationP'] === $location) ? 'checked' : '';
                   echo "
                   <li class='nav-item text-dark'>
                   <label class='nav-link px-3 filterBar' style='cursor:pointer;'>
                   <input type='radio' name='location' style='cursor:pointer;' value='$location' $checked> $location</label>
                   </li>";
               }

               function isChecked($value) {
                   if (!empty($_SESSION['locationP']) && $_SESSION['locationP'] === $value) {
                       return 'checked';
                   } elseif (!empty($_POST['location']) && $_POST['location'] === $value) {
                       return 'checked';
                   } else {
                       return '';
                   }
               }
               ?>
                        
                 </ul>
                 </div>
           </div>
            <!--House Type-->
           <div class="row bg-light py-3 shadow-lg mb-4 rounded-3">
             <div class="border border-5 border-end-0 border-top-0 border-bottom-0 border-primary d-flex align-items-center">
             <button
               class="navbar-toggler w-100"
               type="button"
               data-toggle="collapse"
               data-target="#navbarNavDropdown2"
               aria-controls="navbarNavDropdown"
               aria-expanded="false"
               aria-label="toggle navigation"
                >
              <p class="text-dark fw-bold py-2 m-0 text-start">House Type</p>
             </button>
             </div>
             <div class="collapse  " id="navbarNavDropdown2">
               <ul class="nav navbar-nav me-auto px-2">
               <?php
       $houseType = [
        'Apartment' => 'Apartment',
        'Bungalow' => 'Bungalow',
        'Condo' => 'Condominium',
        'Flat' => 'Flat',
        'Semi-D' => 'Semi-D',
        'Room' => 'Room'
     ];
     foreach ($houseType as $value => $label) {
       $checkedhouseType = (!empty($_SESSION['houseTypeP']) && $_SESSION['houseTypeP'] === $value) ? 'checked' : '';
       echo "<li class='nav-item text-dark'>
               <label class='nav-link px-3 filterBar' style='cursor:pointer;'>
                   <input type='radio' name='houseType' style='cursor:pointer;' value='$value' $checkedhouseType> $label
               </label>
           </li>";
   }
      
   ?>
                      
               </ul>
               </div>
           </div>

           <!--Price-->
           <div class="row bg-light py-3 shadow-lg rounded-3">
             <div class="border border-5 border-end-0 border-top-0 border-bottom-0 border-primary d-flex align-items-center">
             <button
               class="navbar-toggler w-100"
               type="button"
               data-toggle="collapse"
               data-target="#navbarNavDropdown4"
               aria-controls="navbarNavDropdown"
               aria-expanded="false"
               aria-label="toggle navigation"
                >
              <p class="text-dark fw-bold py-2 m-0 text-start">Price</p>
             </button>
             </div>
             <div class="collapse  " id="navbarNavDropdown4">
               <ul class="nav navbar-nav me-auto px-2">
               <?php
       $priceRanges = [
        'RM0-RM1000' => 'RM0-RM1000',
        'RM1001-2500' => 'RM1001-2500',
        'RM2501' => 'RM2501 and above'
     ];
     foreach ($priceRanges as $value => $label) {
       $checkedPrice = (!empty($_SESSION['priceP']) && $_SESSION['priceP'] === $value) ? 'checked' : '';
       echo "<li class='nav-item text-dark'>
               <label class='nav-link px-3 filterBar' style='cursor:pointer;'>
                   <input type='radio' name='price' style='cursor:pointer;' value=\"$value\" $checkedPrice> $label
               </label>
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
          <p class="text-dark fw-bold fs-4 mx-3">Sorry, No Results Found!</p>
         <?php endif; ?>
              <?php foreach ($latestRecords as $record): ?>  
           <div class="col-md-4 pb-5">
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
    </section> 
    </form>
    <?php include 'footer.php'; ?>
    <script src="js/replaceme.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script>

document.getElementById("clear").addEventListener("click", function() {

        // Add a hidden input to the form to indicate the clear action
        var clearInput = document.createElement("input");
        clearInput.type = "hidden";
        clearInput.name = "clearRadio";
        clearInput.value = "1";
        document.getElementById("checkboxForm").appendChild(clearInput);
        document.getElementById('locationP').value = "";
        document.getElementById('priceP').value = "";
        document.getElementById('houseType').value = "";
        // Submit the form after unchecking all radio buttons
        document.getElementById("checkboxForm").submit();
    });

</script>
  </body>
</html>