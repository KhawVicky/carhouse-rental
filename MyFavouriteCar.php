<?php
    include 'menu.php';
    include 'connection.php';

    $pdo = pdo_connect_mysql();
    $records_per_page = 3;
    $error=false;
    $location="Malaysia";
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
if (isset($_POST['clear'])) {
  // Handle the clear action here
  // For example, you can unset or reset the filter-related session variables
  unset($_SESSION['userSortOptionMyAdF']);
  /*header("Location: http://localhost/CNH-2/car.php?page=1");
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
    $email=$_SESSION['email'] ;
    $stmt = $pdo->prepare('SELECT * FROM bookmark WHERE email = :email AND category = "car"');
    $stmt->bindParam(':email', $email, PDO::PARAM_STR); // Assuming email is a string
    $stmt->execute(); // Execute the query
    $latest = $stmt->fetchAll(PDO::FETCH_ASSOC);    
    
    if (empty($latest)) {
      displayNoStockMessage($pdo);
      $error = true;
    } else {
      $error = false;
    }

    // 使用 array_column 函数提取关联数组中的 relatedId 列
    $relatedIds = array_column($latest, 'relatedId');
  
    // 使用 implode 连接成字符串
    $implodedIds = implode(',', $relatedIds);


// Check if $implodedIds is not empty before preparing the second query
if (!empty($implodedIds)) {
  $baseQuery = 'SELECT * FROM car WHERE ID' ;

// Initialize the order condition
  $orderCondition = ' ORDER BY time DESC, ID';
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["search"])) {
    $sortOption = $_POST["sortOption"];
    $_SESSION['userSortOptionMyAdF'] = $sortOption;

    // Append sorting conditions based on the selected option
    switch ($sortOption) {
        case "lowest":
            $orderCondition = ' ORDER BY price ASC, ID';
            break;
        case "highest":
            $orderCondition = ' ORDER BY price DESC, ID';
            break;
            default :
            $orderCondition = ' ORDER BY time DESC, ID';
            break;
        // Add more cases as needed
    }
} elseif (isset($_SESSION['userSortOptionMyAdF'])) {
    // If sorting option is set in session, apply it
    switch ($_SESSION['userSortOptionMyAdF']) {
        case "lowest":
            $orderCondition = ' ORDER BY price ASC, ID';
            break;
        case "highest":
            $orderCondition = ' ORDER BY price DESC, ID';
            break;
            default :
            $orderCondition = ' ORDER BY time DESC, ID';
            break;
        // Add more cases as needed
    }
}

$baseQuery .= " IN ($implodedIds)" . $orderCondition . ' LIMIT :records_per_page OFFSET :offset';

// Prepare and execute the query
$stmt2 = $pdo->prepare($baseQuery);
$stmt2->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
$stmt2->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt2->execute();


$latestRecords = $stmt2->fetchAll(PDO::FETCH_ASSOC);

  $stmt_total = $pdo->prepare("SELECT COUNT(*) AS total_records FROM car WHERE ID IN ($implodedIds)");
    $stmt_total->execute();
    $result = $stmt_total->fetch(PDO::FETCH_ASSOC);
    $total_records = $result['total_records'];
    $rowCount = $stmt->rowCount(); // Fetch the number of rows returned
    
    // 显示分页链接
    // 计算总页数
    $total_pages = ceil($total_records / $records_per_page); // $total_records 是数据库中的总记录数
} else {
  // Handle the case when $implodedIds is empty, e.g., no related records
  $latestRecords = array();
}

 
    
    function displayNoStockMessage($pdo) {
        $error = true;
        $stmt = $pdo->prepare('SELECT * FROM car');
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
  <section id="carSection" class="carSection" <?php if($error===true):?>style="height:75vh"<?php endif; ?>>
      <div class="container py-5">
        <div class="row">
          <div class="col-12">
            <div class="text-center">
            <h1 class="text-dark fw-bold">My Favourite Car</h1>
            <hr class="hr-heading" />
            </div>
          </div>
        </div>
        
         <div class="row">
           <div class="col-3">
           <nav class="navbar p-0">

<ul class="nav fw-bold">
<li class="nav-item">
  <a class="nav-link" aria-current="page" href="MyFavouriteCar.php" style="color:#074eac;">Car</a>
</li>
<li class="nav-item">
  <a class="nav-link text-dark" href="MyFavouriteProperty.php">Property</a>
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
                    $checked = (!empty($_SESSION['userSortOptionMyAdF']) && $_SESSION['userSortOptionMyAdF'] === $sort) ? 'checked' : '';
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
          <p class="text-dark fw-bold fs-4 mx-3">Sorry, You no have favourite Ad Yet!</p>
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
        document.getElementById('carBrand').value = "";
        document.getElementById('location').value = "";
        document.getElementById('price').value = "";
        document.getElementById('carCategory').value = "";
        // Submit the form after unchecking all radio buttons
        document.getElementById("checkboxForm").submit();
    });

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