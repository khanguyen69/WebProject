<?php
include 'header.php';
require_once 'connect.php';

$success = '';
$error = '';
$phoneError = '';
$emailError = '';
$dobError = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['Name_customer']);
    $dob = mysqli_real_escape_string($conn, $_POST['DateOfBirth']);
    $address = mysqli_real_escape_string($conn, $_POST['Diachi']);
    $phone = mysqli_real_escape_string($conn, $_POST['PhoneNumber']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Convert the current time to a date without time part
    $currentDate = date('Y-m-d');
    $dobDate = date('Y-m-d', strtotime($dob));

    if ($dobDate >= $currentDate) {
        $dobError = 'Ngày sinh không được lớn hơn hoặc bằng ngày hiện tại';
    } else {
        // Check if phone number or email already exists
        $check_sql = "SELECT * FROM customer WHERE PhoneNumber = '$phone' OR email = '$email'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            while ($row = mysqli_fetch_assoc($check_result)) {
                if ($row['PhoneNumber'] == $phone) {
                    $phoneError = "Số điện thoại này đã được đăng ký!";
                }
                if ($row['email'] == $email) {
                    $emailError = "Email này đã được đăng ký!";
                }
            }
        } else {
            $sql = "INSERT INTO customer (Name_customer, DateOfBirth, Diachi, PhoneNumber, email) VALUES ('$name', '$dob', '$address', '$phone', '$email')";
            if (mysqli_query($conn, $sql)) {
                $success = 'Thêm khách hàng thành công!';
                header('Location: customer.php');
                exit();
            } else {
                $error = 'Có lỗi, vui lòng thử lại: ' . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm khách hàng</title>
    <style>
        .error-message {
            color: red;
            font-size: 1em;
        }
        .success-message {
            color: green;
            font-size: 1em;
        }
    </style>
</head>
<body>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Thêm khách hàng</h3>
    </div>
    <div class="panel-body">
        <form action="" method="POST" role="form" id="customerForm">
            <div class="form-group">
                <label for="Name_customer">Tên khách hàng</label>
                <input type="text" class="form-control" name="Name_customer" id="Name_customer" required>
            </div>
            <div class="form-group">
                <label for="DateOfBirth">Ngày sinh</label>
                <input type="date" class="form-control" name="DateOfBirth" id="DateOfBirth" required>
                <div style="color: red; font-size: 1em; display: none;" id="dob-error"></div>
                <?php if ($dobError): ?>
                    <div class="error-message"><?php echo $dobError; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="Diachi">Địa chỉ</label>
                <input type="text" class="form-control" name="Diachi" id="Diachi" required>
            </div>
            <div class="form-group">
                <label for="PhoneNumber">Số điện thoại</label>
                <input type="text" class="form-control" name="PhoneNumber" id="PhoneNumber" required pattern="\d{10}">
                <div style="color: red; font-size: 1em; display: none;" id="phone-format-error"></div>
                <div style="color: red; font-size: 1em; display: none;" id="phone-length-error"></div>
                <?php if ($phoneError): ?>
                    <div class="error-message"><?php echo $phoneError; ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
                <div style="color: red; font-size: 1em; display: none;" id="email-format-error"></div>
                <?php if ($emailError): ?>
                    <div class="error-message"><?php echo $emailError; ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </form>
        <?php if ($success): ?>
            <div class="alert alert-success success-message">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var dobInput = document.getElementById('DateOfBirth');
    var dobError = document.getElementById('dob-error');
    var phoneInput = document.getElementById('PhoneNumber');
    var phoneFormatError = document.getElementById('phone-format-error');
    var phoneLengthError = document.getElementById('phone-length-error');
    var emailInput = document.getElementById('email');
    var emailFormatError = document.getElementById('email-format-error');

    dobInput.addEventListener('input', function() {
        var dobValue = dobInput.value;
        var currentDate = new Date().toISOString().split('T')[0];

        if (dobValue >= currentDate) {
            dobError.textContent = 'Ngày sinh không được lớn hơn hoặc bằng ngày hiện tại';
            dobError.style.display = 'block';
        } else {
            dobError.style.display = 'none';
        }
    });

    phoneInput.addEventListener('input', function() {
        var phoneValue = phoneInput.value;
        var isValidPhone = /^\d*$/.test(phoneValue);
        var isPhoneNumberValidLength = phoneValue.length === 10;

        if (!isValidPhone) {
            phoneFormatError.textContent = "Số điện thoại chỉ được chứa các chữ số từ 0 đến 9.";
            phoneFormatError.style.display = 'block';
        } else {
            phoneFormatError.style.display = 'none';
        }

        if (phoneValue !== "" && !isPhoneNumberValidLength) {
            phoneLengthError.textContent = "Số điện thoại phải có đủ 10 số.";
            phoneLengthError.style.display = 'block';
        } else {
            phoneLengthError.style.display = 'none';
        }
    });

    emailInput.addEventListener('input', function() {
        var emailValue = emailInput.value;
        var isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue);

        if (!isValidEmail && emailValue !== "") {
            emailFormatError.textContent = "Email không hợp lệ.";
            emailFormatError.style.display = 'block';
        } else {
            emailFormatError.style.display = 'none';
        }
    });
});
</script>
</body>
</html>
