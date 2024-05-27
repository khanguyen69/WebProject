<?php
include 'dieuhuong.php';
require_once 'ketnoi.php';

// Initialize $success và $error variables
$success = '';
$error = '';
$error1 ='';
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input data
    $time_arrival = mysqli_real_escape_string($conn, $_POST['time_arrival']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);

    // Kiểm tra xem thời gian đến có lớn hơn thời gian hiện tại + 5 giờ không
    $currentTime = time();
    $fiveHoursLater = $currentTime + (5 * 3600); // 5 giờ sau
    $timeArrivalTimestamp = strtotime($time_arrival);

    if ($timeArrivalTimestamp <= $fiveHoursLater) {
        $error = 'Thời gian đến phải lớn hơn thời gian hiện tại';
    } else {
        // Kiểm tra số điện thoại trong bảng "customer"
        $customer_query = "SELECT * FROM customer WHERE PhoneNumber = '$phone_number'";
        $customer_result = mysqli_query($conn, $customer_query);

        if (mysqli_num_rows($customer_result) > 0) {
            // Insert the new booking into the database
            $sql = "INSERT INTO booking (time_arrival, phone_number, booking_status) 
                    VALUES ('$time_arrival', '$phone_number', 'Đợi')";
            
            if (mysqli_query($conn, $sql)) {
                $success = 'Đặt phòng thành công!';
                header("Location: datlichpass.php?page=$current_page");
                exit();
            } else {
                $error = 'Có lỗi khi thêm mới đặt phòng: ' . mysqli_error($conn);
                // Hiển thị hoặc ghi log thông báo lỗi
            }
        } else {
            $error1 = 'Số điện thoại này chưa được đăng ký';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đặt phòng</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
   
    <style>
        .error-message {
            color: red;
            font-size: 1em;
        }
    </style>
</head>
<body>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Đặt lịch</h3>
        </div>
        <div class="panel-body">
            <form action="" method="POST" role="form">
                <div class="form-group">
                    <label for="time_arrival">Thời gian đến</label>
                    <input type="datetime-local" class="form-control" name="time_arrival" id="time_arrival" required>
                    <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="phone_number">Số điện thoại</label>
                    <input type="text" class="form-control" name="phone_number" id="phone" placeholder="Nhập số điện thoại" required pattern="\d{10}">
                    <div style="color: red; font-size: 1em; display: none;" id="phone-error"></div>
                    <?php if ($error1): ?>
                    <div class="error-message"><?php echo $error1; ?></div>
                    <?php endif; ?>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(function(errorMessage) {
            errorMessage.style.display = 'block';
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 3000);
        });
    });
</script>
                <button type="submit" class="btn btn-primary">Lưu lại</button>
            </form>
            <?php if ($success): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="duoi">
        <?php require_once 'footer.php' ?>
    </div>
</body>
</html>
