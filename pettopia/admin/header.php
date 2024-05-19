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
</head>

<body>
<div>
    <h1 class="header">
        <p1 style="text-align: center; font-size: 50px; line-height: 50px; color: #000000;">
        <b><u><i>Petopia</i></u></b>
        </p1>
    </h1>
</div>


    <nav class="navbar navbar-inverse">
        <div class="container">
            <ul class="nav navbar-nav">
                <li><a href="/shop/backend/index.php">Trang chủ</a></li>
                <li><a href="/shop/backend/booking.php">Trang quản lý lịch hẹn</a></li>
                <li><a href="/shop/backend/customer.php">Trang tra cứu chỉnh sửa thêm thông tin khách hàng</a></li>
                <li><a href="/shop/backend/petshop.php">Trang tra cứu chỉnh sửa thêm thông tin thú cưng</a></li>
                <li><a href="/shop/backend/petpending.php">Trang quản lý các thú cưng tại shop </a></li>
                <li><a href="/shop/backend/order.php">Trang quản lý lịch sử khách hàng</a></li>
                <li><a href="/shop/backend/phanhoidichvu.php">Trang quản lý các dịch vụ dành cho nhân viên</a></li>
                <br>
                <?php
                if (isset($_SESSION['admin']['username'])) {
                    echo "<li style=\"font-size: 20px; margin-top: 10px; color:white;\">Xin chào Admin <b style=\"font-weight: bold; color:blue;\">{$_SESSION['admin']['username']}</b></li> 
                    <li><a href=\"logout.php\" style=\"font-size: 20px;\">Đăng xuất</a></li>";
                } else {
                    echo "<li style=\"font-size: 18px; margin-top: 12px; color:white;\">AD Đăng nhập</li><li><a href=\"login.php\" style=\"font-size: 20px; \">Tại đây</a></li>";
                }
                ?>
            </ul>
        </div>
    </nav>
    <div class="container"> <!-- Thẻ mở .container -->