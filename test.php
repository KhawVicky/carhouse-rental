<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['location'])) {
        $_SESSION['location'] = $_POST['location'];
    }
}
?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>导航栏带单选按钮</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown1" aria-controls="navbarNavDropdown1" aria-expanded="false" aria-label="切换导航">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown1">
        <ul class="nav navbar-nav me-auto px-2">
            <li class="nav-item">
         
                    <?php
                    $locations = ['Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Perak', 'Perlis', 'Penang', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'Kuala Lumpur'];

                    foreach ($locations as $location) {
                        $checked = isChecked($location);
                        echo "<label class='nav-link'><input type='radio' name='location' value='$location' $checked> $location</label><br>";
                    }

                    function isChecked($value) {
                        if (!empty($_SESSION['location']) && $_SESSION['location'] === $value) {
                            return 'checked';
                        } elseif (!empty($_POST['location']) && $_POST['location'] === $value) {
                            return 'checked';
                        } else {
                            return '';
                        }
                    }
                    ?>
                    <input type="submit" value="提交" class="btn btn-primary mt-2">
          
            </li>
            <li class="nav-item">
                <!-- 其他导航项目可以添加在这里 -->
            </li>
            <li class="nav-item">
                <!-- 其他导航项目可以添加在这里 -->
            </li>
        </ul>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
