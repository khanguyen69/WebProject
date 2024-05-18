<?php
require_once 'dieuhuong.php';
require_once 'ketnoi.php';
require_once 'cart_function.php';
date_default_timezone_set('Asia/Ho_Chi_Minh');

$cart = $_SESSION['cart'] ?? [];

if (isset($_SESSION['login']['username']) && isset($_POST['checkout'])) {
    $username = $_SESSION['login']['username'];
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    $note = $_POST['note'] ?? '';

    // Fetch user data from the database using prepared statements
    $stmt = $conn->prepare("SELECT * FROM khachang WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    // File content generation
    $filename = 'order_details.txt';
    $fileContent = " \n\t\tExpensix Store - Minh Kiên\n";
    $fileContent .= "TP HCM\n";
    $fileContent .= "\nThông Tin Đơn Hàng\n";
    $fileContent .= "-----------------------------------------------------------------------------\n";

    // Add customer information
    $fileContent .= "Họ & Tên: " . $res['username'] . "\n";
    $fileContent .= "Email: " . $res['email'] . "\n";
    $fileContent .= "Số Điện Thoại: " . $res['phone'] . "\n";
    $fileContent .= "Địa Chỉ: " . $res['address'] . "\n";
    $fileContent .= "Ngày Mua Hàng: " . date("d-m-Y H:i:s") . "\n";
    $fileContent .= "-----------------------------------------------------------------------------\n";

    $fileContent .= "Tên Sản Phẩm\t\t\tSố Lượng\tĐơn Giá\t\tThành Tiền\n";

    $maxLength = max(array_map('mb_strlen', array_column($cart, 'name')));

    function amountToWords($amount) {
        // ... (no changes here)
    }

    foreach ($cart as $value) {
        // ... (no changes here)
    }

    $totalAmountInWords = amountToWords(total_price($cart));

    $fileContent .= "-----------------------------------------------------------------------------\n";
    $fileContent .= "Tổng Tiền\t\t\t" . number_format(total_price($cart)) . " VNĐ\n";
    $fileContent .= "Tổng Tiền (bằng chữ)\t" . $totalAmountInWords . "\n\n";
    $fileContent .= "Cảm ơn quý khách đã tin tưởng mua sản phẩm của Expensix Store!\n";

    file_put_contents($filename, $fileContent);

    // Force download the text file
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    readfile($filename);
    unlink($filename); // Remove the file after download

    // Clear the cart after checkout
    unset($_SESSION['cart']); // Remove cart items from the session

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển thị giỏ hàng</title>
    <style>
        .container {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .flex-1,
        .flex-2 {
            flex: 1;
            padding: 10px;
            box-sizing: border-box;
        }

        .k {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['login']['username'])) { ?>
        <!-- nút thanh toán -->
        <div class="container">
            <div class="flex-1">
                <?php $sql = mysqli_query($conn, "SELECT * FROM khachang"); ?>
                <?php if ($res = mysqli_fetch_assoc($sql)) { ?>
                    <form action="" method="post">

                        <!-- ... (your existing form fields) -->

                        <div class="form-group">
                            <label for="note">Ghi Chú</label>
                            <textarea name="note" id="note" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        <button type="submit" name="checkout" class="btn btn-info">Thanh Toán </button>
                    </form>
                <?php } ?>

            </div>

            <div class="flex-2">
                <h2>Thông Tin Đơn Hàng</h2>
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Tên Sản Phẩm</th>
                            <th>Số Lượng</th>
                            <th>Đơn Giá</th>
                            <th>Thành Tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $value) {  ?>
                            <tr>
                                <td><?php echo $value['name'] ?></td>
                                <td style="width: 30px;"><?php echo $value['quantity'] ?></td>
                                <td><?php echo $value['price'] ?></td>
                                <td><?php echo number_format($value['price'] * $value['quantity']) ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="4"><strong>Thông Tin Khách Hàng</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Họ & Tên:</strong> <?php echo $res['username'] ?></td>
                            <td colspan="2"><strong>Email:</strong> <?php echo $res['email'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Số Điện Thoại:</strong> <?php echo $res['phone'] ?></td>
                            <td colspan="2"><strong>Địa Chỉ:</strong> <?php echo $res['address'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="4"><strong>Tổng Tiền:</strong> <?php echo number_format(total_price($cart)) ?> VNĐ</td>
                        </tr>
                       
                    </tbody>
                </table>
            </div>
        </div>
    <?php } else { ?>
        <div class="k">
            <h1>Vui lòng ĐĂNG NHẬP để mua hàng </h1> <a href="login.php?action=check-out">Tại Đây</a>
        </div>
    <?php } ?>
</body>

</html>
