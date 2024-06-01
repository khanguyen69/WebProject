<?php
session_start();
ob_start();
if (!isset($_SESSION['admin']['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petopia - Thiên đường cho thú cưng</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <style>
        .navbar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        .navbar-brand {
            font-size: 50px;
            line-height: 50px;
            color: #000000;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <p class="navbar-brand" >
                    <i>Petopia</i>
    </p>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="index.php">Trang chủ</a></li>
                <li><a href="booking.php">Trang quản lý lịch hẹn</a></li>
                <li><a href="customer.php">Trang quản lý thông tin khách hàng</a></li>
                <li><a href="petshop.php">Trang quản lý thông tin thú cưng</a></li>
                <li><a href="petpending.php">Trang quản lý các thú cưng tại shop </a></li>
                <li><a href="order.php">Trang quản lý lịch sử khách hàng</a></li>
                <li><a href="phanhoidichvu.php">Trang quản lý các dịch vụ</a></li>
                <br>
                <?php
                if (isset($_SESSION['admin']['username'])) {
                    echo "<li style=\"font-size: 20px; margin-top: 10px; color:white;\">Xin chào <b style=\"font-weight: bold; color:blue;\">{$_SESSION['admin']['username']}</b></li> 
                    <li><a href=\"logout.php\" style=\"font-size: 20px;\">Đăng xuất</a></li>";
                } else {
                    echo "<li style=\"font-size: 18px; margin-top: 12px; color:white;\">AD Đăng nhập</li><li><a href=\"login.php\" style=\"font-size: 20px; \">Tại đây</a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>
    <div class="container"></div> <!-- Thẻ mở .container -->