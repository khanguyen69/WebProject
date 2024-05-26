<?php
session_start();
ob_start();
require_once 'cart_function.php';
$cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petopia - Thiên đường cho thú cưng </title>

    <link rel="stylesheet" href="main.css">

    <link rel="stylesheet" href="FontAwesome.Pro.6.3.0/css/all.css">

    <!--  -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!--  -->

    <style>
        .cart {
            width: 110px;
            height: auto;
            float: right;
            padding: 5px;
        }

        .cart>.g {
            color: 	black;
            font-size: 15px;
            font-weight: bold;
            text-decoration: none;
        }

        .cart>.i {
            color: black;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
            box-sizing: border-box;
        }

        .thoat {
            width: 110px;
            height: auto;
            float: right;
            padding: 5px;
            box-sizing: border-box;
            font-weight: bold;
        }
        .contact-links {
    display: flex;
}

.contact-links {
    display: flex;
    justify-content: space-between; /* Horizontal adjustment */
    align-items: center; /* Vertical adjustment */
    margin-top: 10px; /* Adjust top margin as needed */
    margin-bottom: 10px; /* Adjust bottom margin as needed */
}

.contact-links a {
    text-decoration: none;
    color: light blue; /* Adjust color as needed */
}

.contact-links a i {
    margin-right: 10px; /* Adjust right margin of the icon */
    margin-left: 10px; /* Adjust left margin of the icon */
}
.contact-links a:last-child {
    margin-left: auto; /* Push the Zalo link to the right */
}


    </style>

</head>

<body>
    <div class="all">
        <div class="thanh">
            <!-- tiêu đề shop -->
<h1 class="header">
    <p1 class="list-unstyled"style="float: left; font-size: 50px; line-height: 50px;color: #000000;">
    <b><u><i>Petopia</i></u></b>
    </p1>
</h1>
<div class="right">
    <!-- Your other content goes here -->
</div>

            <!-- giỏ hàng -->
            <a href="view_cart.php" class="cart" style=" width: 110px;">
                <div class="i"><i class="fa-regular fa-cart-shopping"></i></div>
                <span class="g">Giỏ hàng (<?php echo total_item($cart) ?>)</span>
            </a>
            <!-- tài khoản -->
            <a href="javascript:void(0)" onclick="checkAndRedirect()" class="cart" style="width: 110px;">
                <div class="i"><i class="fa-solid fa-user"></i></div>
                <span class="g">Tài khoản</span>
            </a>

            <script>
            function checkAndRedirect() {
                <?php if (isset($_SESSION['admin']['username'])) { ?>
                    window.location.href = 'admin/index.php';
                <?php } else { ?>
                    window.location.href = 'admin/login.php';
                <?php } ?>
            }
            </script>
            <div class="thoat">
                <?php
                if (isset($_SESSION['admin']['username'])) {
                    echo "Xin chào <b>{$_SESSION['admin']['username']}</b> <br> 
                    <a href=\"logout.php\"><i class=\"fa-regular fa-right-from-bracket\"></i> Đăng xuất</a>";
                    
                } else {
                    echo "Đăng nhập <br>  <a href=\"admin/login.php\"><i class=\"fa-solid fa-hippo\" style=\"color:black;\"></i> Tại đây</a>";
                }
                ?>
             <br>
            </div>
        </div>

        <div>
            <nav class="navbar navbar-expand-sm bg-primary navbar-dark">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="sanpham.php">Trang chủ</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="petshop.php">Tìm kiếm thú cưng</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="dkuser.php">Đăng ký thông tin</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="dichvu.php">Dịch vụ</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="dkpet.php">Đăng ký theo dõi Thú cưng</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="datlich.php">Đặt lịch</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="skpet.php">Theo dõi tình hình sức khỏe thú cưng</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="phanhoi.php">Đánh giá</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="display.php">Xem đánh giá trước</a>
                    </li>
                </ul>
               
            </nav>
        </div>
    </div>
</body>

</html>
