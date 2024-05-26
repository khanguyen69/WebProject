<?php
// Include necessary files
include 'dieuhuong.php';
require_once 'ketnoi.php';

// Initialize variables
$error = '';
$ID_service = '';
$name_service = '';
$total_price = '';
$phone_number = '';
$pet_name = '';

// Kiểm tra và lấy ID_service từ trang trước thông qua yêu cầu GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $ID_service = $_GET['id'];

    // Lấy chi tiết dịch vụ dựa trên ID_service
    $query = "SELECT name_service, price_service FROM services WHERE ID_service = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $ID_service);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $name_service = $row['name_service'];
        $total_price = $row['price_service'];
    } else {
        $error = 'Dịch vụ không tồn tại';
    }
} else {
    $error = 'Không có ID dịch vụ hoặc ID không hợp lệ';
}

// Lấy thời gian giao dịch hiện tại
$current_time = time();
$new_time = $current_time + (5 * 3600); // Điều chỉnh cho múi giờ nếu cần
$new_time_formatted = date('Y-m-d H:i:s', $new_time);

// Lấy IDtrans tiếp theo
$query = "SELECT MAX(IDtrans) AS maxID FROM history_transaction";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$IDtrans = $row['maxID'] ? $row['maxID'] + 1 : 1;

// Xử lý khi form được gửi đi
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $phone_number = mysqli_real_escape_string($conn, $_POST['PhoneNumber']);
    $pet_name = mysqli_real_escape_string($conn, $_POST['pet_name']);
    $query_check_customer = "SELECT IDCustomer FROM customer WHERE PhoneNumber = ?";
    $stmt = mysqli_prepare($conn, $query_check_customer);
    mysqli_stmt_bind_param($stmt, "s", $phone_number);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $IDCustomer = $row['IDCustomer'];

        // Chèn chi tiết giao dịch vào cơ sở dữ liệu
        $sql = "INSERT INTO history_transaction (IDtrans, IDCustomer, ID_service, IDpet, time_trans, total_price) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiissd", $IDtrans, $IDCustomer, $ID_service, $pet_name, $new_time_formatted, $total_price);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: confirm.php');
            exit();
        } else {
            $error = 'Có lỗi xảy ra, vui lòng thử lại: ' . mysqli_error($conn);
        }
    } else {
        $error = 'Không tìm thấy khách hàng với số điện thoại này';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Điền thông tin giao dịch</h3>
        <a href="dichvu.php" style="color: lime;"><i class="fas fa-arrow-left"></i> Quay lại</a>
    </div>
    <div class="panel-body">
        <form action="" method="POST" role="form">
            <div class="form-group">
                <label for="time_trans">Thời điểm giao dịch</label>
                <input type="text" class="form-control" name="time_trans" id="time_trans" value="<?= $new_time_formatted ?>" readonly>
            </div>
            <div class="form-group">
                <label for="name_service">Tên dịch vụ</label>
                <input type="text" class="form-control" name="name_service" id="name_service" value="<?= $name_service ?>" readonly>
            </div>
            <div class="form-group">
                <label for="PhoneNumber">Số điện thoại</label>
                <input type="text" class="form-control" name="PhoneNumber" id="phone" placeholder="Nhập số điện thoại" value="<?= $phone_number ?>" required pattern="\d{10}">
                <div style="color: red; font-size: 0.925em; display: none;" id="phone-error"></div>
            </div>
            <div class="form-group">
                <label for="pet_name">Tên thú cưng</label>
                <select class="form-control" name="pet_name" id="pet_name" required>
                    <!-- Options will be populated via AJAX -->
                </select>
            </div>
            <div class="form-group">
                <label for="total_price">Tổng tiền</label>
                <input type="text" class="form-control" name="total_price" id="total_price" value="<?= $total_price ?>" readonly>
            </div>
            <button type="submit" name="submit_transaction" class="btn btn-primary">Xác nhận thanh toán</button>
        </form>
        <?php
        if ($error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var phoneInput = document.getElementById('phone');
        var phoneError = document.getElementById('phone-error');

        phoneInput.addEventListener('input', function() {
            var phoneValue = phoneInput.value;
            var isValidPhone = /^\d*$/.test(phoneValue); 
            var isPhoneNumberValidLength = phoneValue.length === 10;

            if (!isValidPhone && phoneValue !== "") {
                phoneError.textContent = "Số điện thoại chỉ được chứa các chữ số từ 0 đến 9.";
                phoneError.style.display = 'block';
            } else if (phoneValue === "") {
                phoneError.style.display = 'none';
            } else if (!isPhoneNumberValidLength) {
                phoneError.textContent = "Số điện thoại phải có đủ 10 số.";
                phoneError.style.display = 'block';
            } else {
                phoneError.style.display = 'none';
            }
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            var phoneValue = phoneInput.value;
            var isValidPhone = /^\d+$/.test(phoneValue);

            if (!isValidPhone) {
                phoneError.textContent = "Số điện thoại chỉ được chứa các chữ số từ 0 đến 9.";
                phoneError.style.display = 'block';
                event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu
            } else if (phoneValue.length !== 10) {
                phoneError.textContent = "Số điện thoại phải có đủ 10 số.";
                phoneError.style.display = 'block';
                event.preventDefault(); // Ngăn chặn việc gửi biểu mẫu
            } else {
                phoneError.style.display = 'none';
            }
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#phone').on('keyup', function() {
            var phoneNumber = $(this).val();
            if (phoneNumber.length > 0) {
                $.ajax({
                    url: 'fetch_pets.php',
                    method: 'GET',
                    data: { phone: phoneNumber },
                    success: function(response) {
                        $('#pet_name').html(response);
                    }
                });
            } else {
                $('#pet_name').html('<option value="">Chọn tên thú cưng</option>');
            }
        });
    });
</script>

<br/>
<div class="duoi">
    <?php require_once 'footer.php' ?>
</div>
</body>
</html>
