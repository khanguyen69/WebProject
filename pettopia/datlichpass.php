<?php
require_once 'dieuhuong.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Petopia - Thiên đường cho thú cưng </title>
    <style>
    .btn-return {
        margin-bottom: 180px;
        display: inline-block;
        padding: 10px 20px;
        background-color: blue;
        color: #FFFFFF;
        text-decoration: none;
        font-size: 1.2em;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s; 
    }

    .btn-return:hover {
        font-weight: bold;
        background-color: black; 
        color: white;
    }
    </style>
</head>
<div style="color: #00008B; font-size: 2.5em; text-align: center; margin-top: 20px; margin-bottom: 20px;"><strong>Đặt lịch hẹn thành công!</strong></div>
<div style="text-align: center;">
    <a href="datlich.php" class="btn-return">Quay về trang đặt lịch</a>
</div>
<body>



    <div class="duoi">
        <?php require_once 'footer.php' ?>
    </div>
</body>

</html>
