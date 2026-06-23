<?php
    include 'menu.php';
    include 'connection.php';
    $pdo = pdo_connect_mysql();
    $loginFirst=false;
    
      $id = $_GET['ID'];
      $stmt = $pdo->prepare('SELECT * FROM house WHERE ID = :id');
      
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      
      // Fetch the data
      $latestRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
      $email=$latestRecords[0]['email'];

 
      if (isset($_SESSION['email'])) {
        $emailBookMark = $_SESSION['email'];
        // 然后可以在这里使用 $emailBookMark 进行其他操作
    } else {
       
    }
      $stmt = $pdo->prepare('SELECT * FROM bookmark WHERE email = :email AND relatedId	=:relatedId AND category="property"');
      $stmt->bindParam(':email', $emailBookMark, PDO::PARAM_STR);
      $stmt->bindParam(':relatedId', $id, PDO::PARAM_INT);
      
      $stmt->execute();
    
      if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        if (isset($_SESSION['email'])) {
        if (isset($_POST['recordID']) && isset($_POST['status'])) {
          $recordID = $_POST['recordID'];
          $status = $_POST['status'];
          if ($status === 'Available') {
            $id=isset($_POST['id']) && ($_POST['id']!='auto' ? $_POST['id'] : NULL);    
            $stmt=$pdo->prepare('INSERT INTO bookmark values(?,?,?,?)');
            $stmt->execute([$id,$emailBookMark,"property",$recordID]);
        } elseif ($status === 'UnAvailable') {
          $stmt = $pdo->prepare('DELETE FROM bookmark WHERE relatedID = ? AND email=? AND category="property"');

            $stmt->execute([$recordID,$emailBookMark]);
        }
         
        }}
        else{
          
          $loginFirst=true;
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@100..900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="css/font-awesome.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/lightbox.min.css" />
    <link rel="icon" href="Picture/logo7.svg" />
    <title>Rent House</title>
</head>
<body>
  <style>
    /* 自定义样式 */
    .tab-content > .tab-pane {
      background-color: white; /* 内容背景变为白色 */
      border-left: 1px solid #dee2e6; /* 左边框 */
      border-right: 1px solid #dee2e6; /* 右边框 */
      border-bottom: 1px solid #dee2e6; /* 下边框 */
      border-bottom-left-radius: 10px; /* 左下角圆角 */
      border-bottom-right-radius: 10px; /* 右下角圆角 */
     
    }

    .nav-tabs.nav-link.active {
      background-color: white; /* 活跃标签页变为蓝色 */
      color: #074eac !important; /* 活跃标签页文字变为白色 */
    }
    
    .nav-tabs .nav-link {
      color: #000; /* 未选中标签页的颜色 */
    }

    .nav-tabs .nav-link:hover {
      color: white; /* 未选中标签页悬停时文字变为白色 */
      background-color: #074face8; /* 悬停时背景颜色变为浅蓝色 */
    }
  </style>
<form action="" method="post" novalidate >
  <section id="imagesbox " class="bg-light">
    <div class="container pb-5 ">
       <div class="row">
          <div class="col-12">
            <div class="text-center">
            <hr class="hr-heading" />
            <p class="text-dark fs-3"><?= $latestRecords[0]['tittle']?></p>
            <?php
        if (isset($loginFirst) && $loginFirst === true) {
       // 显示成功通知
        echo '<div class="badge bg-danger text-white fs-5 mb-2 p-1">Please Login Your Account First!</div>';
       } 
       ?>
            </div>
          </div>
          </div>
        <div class="row">
            <div class="col-lg-7 offset-1">
                <div class="row">
                    <div class="col-12">
                      <div class="projectM shadow-lg text-center">
                        <a href="uploads/<?= $latestRecords[0]['picture1']?>" data-lightbox="gallery" data-title="Image 1">
                            <img src="uploads/<?= $latestRecords[0]['picture1']?>" alt="" class="img-fluid" style="height:400px">
                        </a>
                      </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-3">
                      <div class="project shadow-lg">
                        <a href="uploads/<?= $latestRecords[0]['picture2']?>" data-lightbox="gallery" data-title="Image 2">
                            <img src="uploads/<?= $latestRecords[0]['picture2']?>" alt="" class="img-fluid">
                        </a>
                    </div>
                  </div>
                    <div class="col-3">
                      <div class="project shadow-lg">
                        <a href="uploads/<?= $latestRecords[0]['picture3']?>" data-lightbox="gallery" data-title="Image 3">
                            <img src="uploads/<?= $latestRecords[0]['picture3']?>" alt="" class="img-fluid">
                        </a>
                    </div>
                  </div>
                    <div class="col-3">
                      <div class="project shadow-lg">
                        <a href="uploads/<?= $latestRecords[0]['picture4']?>" data-lightbox="gallery" data-title="Image 4">
                            <img src="uploads/<?= $latestRecords[0]['picture4']?>" alt="" class="img-fluid">
                        </a>
                    </div>
                  </div>
                    <div class="col-3">
                      <div class="project shadow-lg">
                        <a href="uploads/<?= $latestRecords[0]['picture5']?>" data-lightbox="gallery" data-title="Image 5">
                            <img src="uploads/<?= $latestRecords[0]['picture5']?>" alt="" class="img-fluid">
                        </a>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-3 details p-0">
  
                <div class="card text-dark border-0 details">
                  <div class="card-body p-0">
                    <ul class="nav nav-tabs" id="myTabs" role="tablist">
                      <li class="nav-item w-50">
                        <button class="nav-link active w-100 px-0" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">Description</button>
                      </li>
                      <li class="nav-item w-50">
                        <button class="nav-link w-100 px-0" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false" >Additional Information</button>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
  
                      <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <ul class="list-unstyled">
                          <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                            <span class="py-2">
                              <strong> <i class="fa-solid fa-tag"></i> Price :</strong>
                            </span>
                            <span class="py-2">RM<?=$latestRecords[0]['price'] ?>/Day</span>
                          </li>
                          <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                            <span class="py-2">
                              <strong> <i class="fa-solid fa-tags"></i></i> Deposite :</strong>
                            </span>
                            <span class="py-2"><?=$latestRecords[0]['deposite']?></span>
                          </li>
                          <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                            <span class="py-2">
                              <strong> <i class="fa-solid fa-house-chimney-window"></i> Property Type :</strong>
                            </span>
                            <span class="py-2"><?=$latestRecords[0]['houseType']?></span>
                          </li>
                          <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                            <span class="py-2">
                              <strong> <i class="fas fa-bed"></i> Bedroom :</strong>
                            </span>
                            <span class="py-2"><?=$latestRecords[0]['bedroom']?></span>
                          </li>
                          <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                            <span class="py-2">
                              <strong> <i class="fa-sharp fa-solid fa-shower"></i> Bathroom :</strong>
                            </span>
                            <span class="py-2"><?=$latestRecords[0]['bathroom']?></span>
                          </li>
                          <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                            <span class="py-2">
                              <strong> <i class="fa-sharp fa-solid fa-ruler"></i> sq.ft :</strong>
                            </span>
                            <span class="py-2"><?=$latestRecords[0]['size']?></span>
                          </li>
                          <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                            <span class="py-2">
                              <strong> <i class="fa-solid fa-location-dot"></i> Location :</strong>
                            </span>
                            <span class="py-2"><?= $latestRecords[0]['location']?></span>
                          </li>
                          <li class="border-bottom px-3 py-2 d-flex justify-content-between">
                            <span class="py-2">
                              <strong> <i class="fa-solid fa-user"></i> User :</strong>
                            </span>
                            <span class="py-2"><?=$latestRecords[0]['name']?></span>
                          </li>
                          <li class="px-3 d-flex justify-content-end align-items-center">
    <?php if ($stmt->rowCount() == 1): ?>
        <button class="btn b-0 text-danger mt-2 mx-2 mb-0" id="UnAvailable_<?= $latestRecords[0]['ID'] ?>" onclick="updateAvailability(<?= $latestRecords[0]['ID'] ?>, 'UnAvailable')">
        <i class="fa-sharp fa-solid fa-heart"></i>
        </button>
    <?php elseif ($stmt->rowCount() == 0): ?>
        <button class="btn  mt-2 mx-2 bg-danger " id="Available_<?= $latestRecords[0]['ID'] ?>" onclick="updateAvailability(<?= $latestRecords[0]['ID'] ?>, 'Available')" >
        <i class="fa-sharp fa-regular fa-heart" ></i>
</button>

    <?php endif; ?>

    <a href="#" class="btn btn-primary btn-md mt-2">Book Now</a>
</li>

                        </ul>
                      </div>
                      <div class="tab-pane fade p-2" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <textarea class="textArea text-container" id="autoHeightTextarea" oninput="autoHeight(this)" disabled><?= $latestRecords[0]['description']?></textarea>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
            </div>
        </div>
    </div>

    </section>
    </form>
    <?php include 'footer.php'; ?>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/lightbox-plus-jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
function updateAvailability(recordID, status) {
    
    // AJAX call to update record in the database
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
            console.log(1);
            } else {
                
            }
        }
    };

    xhr.open("POST", "detailsHouse.php"); // Point to the correct PHP file
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("recordID=" + recordID + "&status=" + status);
}

      var tabs = new bootstrap.Tab(document.getElementById('tab1-tab'));
      tabs.show();
      
      function autoHeight(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
  }

  document.getElementById('tab2-tab').addEventListener('shown.bs.tab', function (event) {
    var textarea = document.getElementById('autoHeightTextarea');
    autoHeight(textarea); // 手动触发高度调整
  });
    </script>
    
</body>
</html>
