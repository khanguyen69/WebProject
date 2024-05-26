<?php
ob_start();
include_once 'dieuhuong.php';
include_once 'ketnoi.php';
if (
    isset($_POST['dangky']) &&
    isset($_POST['name']) && $_POST['name'] != '' &&
    isset($_POST['date']) && $_POST['date'] != '' &&
    isset($_POST['diachi']) && $_POST['diachi'] != '' &&
    isset($_POST['phone']) && $_POST['phone'] != '' &&
    isset($_POST['email']) && $_POST['email'] != ''
) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $diachi = $_POST['diachi'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Prepared statement to prevent SQL injection
    // Check if phone number or email already exists
    $check_sql = "SELECT * FROM `customer` WHERE `PhoneNumber` = ? OR `email` = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $phone, $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    $phoneError = "";
    $emailError = "";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['PhoneNumber'] == $phone) {
                $phoneError = "Số điện thoại này đã được đăng ký!";
            }
            if ($row['email'] == $email) {
                $emailError = "Email này đã được đăng ký!";
            }
        }
    }

    if ($phoneError != "" || $emailError != "") {
        ob_start();
        require_once 'footer.php';
        $footer = ob_get_clean();
        echo "<div style='color: red; font-size: 2.5em; text-align: center; margin-top: 20px; margin-bottom: 200px;'><strong>$phoneError$emailError</strong></div>";
        echo "<div class='duoi'>$footer</div>";
    } else {
        // If phone number and email are not already registered, proceed with registration
        $sql = "INSERT INTO `customer`(`Name_customer`, `DateOfBirth`, `Diachi`, `PhoneNumber`, `email`) VALUES 
        (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $date, $diachi, $phone, $email);
        $dk_sql = $stmt->execute();

        if ($dk_sql) {
            ob_start();
            require_once 'footer.php';
            $footer = ob_get_clean();
            echo "<div style='color: #00008B; font-size: 2.5em; text-align: center; margin-top: 20px; margin-bottom: 200px;'><strong>Đăng ký thông tin thành công!</strong></div>";
            echo "<div class='duoi'>$footer</div>";
        } else {
            ob_start();
            require_once 'footer.php';
            $footer = ob_get_clean();
            echo "<div style='color: red; font-size: 2.5em; text-align: center; margin-top: 20px; margin-bottom: 200px;'><strong>Đăng ký thông tin thất bại!</strong></div>";
            echo "<div class='duoi'>$footer</div>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            background-image: linear-gradient(#f4d6cf, #8eccf5);
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        legend {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            width: 100%;
            padding: 10px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .login-link {
            color: #007bff;
            text-decoration: none;
        }

        .login-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
        }

        .eye-icon {
            cursor: pointer;
        }

        .error-message {
            color: red;
            font-size: 0.925em;
            display: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <form action="" method="post">
                <legend class="text-center">Đăng Ký thông tin khách hàng</legend>
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Họ và tên" required>
                </div>
                <div class="form-group">
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="text" name="diachi" id="diachi" class="form-control" placeholder="Địa chỉ" required>
                </div>
                <div class="form-group">
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Số điện thoại" required pattern="\d{10}">
                    <div class="error-message" id="phone-error">Số điện thoại chỉ được chứa các chữ số từ 0 đến 9.</div>
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                    <div class="error-message" id="email-error">Email không hợp lệ.</div>
                </div>
                <button type="submit" name="dangky" class="btn btn-primary">Đăng ký thông tin</button>
            </form>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var phoneInput = document.getElementById('phone');
        var phoneError = document.getElementById('phone-error');
        var emailInput = document.getElementById('email');
        var emailError = document.getElementById('email-error');

        phoneInput.addEventListener('input', function() {
            var phoneValue = phoneInput.value;
            var isValidPhone = /^\d*$/.test(phoneValue); // Check if only digits or empty
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

        emailInput.addEventListener('input', function() {
            var emailValue = emailInput.value;
            var isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue); // Check if valid email format

            if (!isValidEmail && emailValue !== "") {
                emailError.style.display = 'block';
            } else {
                emailError.style.display = 'none';
            }
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            var phoneValue = phoneInput.value;
            var emailValue = emailInput.value;
            var isValidPhone = /^\d+$/.test(phoneValue);
            var isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue);

            if (!isValidPhone) {
                phoneError.textContent = "Số điện thoại chỉ được chứa các chữ số từ 0 đến 9.";
                phoneError.style.display = 'block';
                event.preventDefault(); // Prevent form submission
            } else if (phoneValue.length !== 10) {
                phoneError.textContent = "Số điện thoại phải có đủ 10 số.";
                phoneError.style.display = 'block';
                event.preventDefault(); // Prevent form submission
            } else {
                phoneError.style.display = 'none';
            }

            if (!isValidEmail) {
                emailError.style.display = 'block';
                event.preventDefault(); // Prevent form submission
            } else {
                emailError.style.display = 'none';
            }
        });
    });
</script>

    <div class="duoi">
        <?php require_once 'footer.php' ?>
    </div>
</body>

</html>
