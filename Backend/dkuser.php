<?php
ob_start();
include_once 'dieuhuong.php';
include_once 'ketnoi.php';
if (isset($_POST['dangky']) &&
    isset($_POST['name']) && $_POST['name'] !='' &&
    isset($_POST['date']) && $_POST['date'] !='' &&
    isset($_POST['diachi']) && $_POST['diachi'] !='' &&
    isset($_POST['phone']) && $_POST['phone'] !='' &&
    isset($_POST['email']) && $_POST['email'] !='') {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $diachi = $_POST['diachi'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    // Prepared statement to prevent SQL injection
    $sql = "INSERT INTO `customer`(`Name_customer`, `DateOfBirth`, `Diachi`, `PhoneNumber`, `email`) VALUES 
    (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $date, $diachi, $phone, $email);
    $dk_sql = $stmt->execute();

    if ($dk_sql) {
        echo "đăng ký tài khoản thành công";
    } else {
        echo "đăng ký tài khoản thất bại";
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
            font-family: Arial, sans-serif;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <form action="register.php" method="post">
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
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Số điện thoại" required>
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                </div>
                <button type="submit" name="dangky" class="btn btn-primary">Đăng ký thông tin</button>

               
            </form>
        </div>
    </div>

    <!-- JavaScript for password validation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var passwordInput = document.getElementById('password');
            var passwordError = document.getElementById('password-error');
            var passwordToggleBtn = document.getElementById('show-password-toggle');

            passwordInput.addEventListener('input', function () {
                var passwordValue = passwordInput.value;

                if (passwordValue.length < 4 || /[^A-Za-z0-9]/.test(passwordValue)) {
                    passwordError.style.display = 'block';
                } else {
                    var numericCount = (passwordValue.match(/\d/g) || []).length;
                    if (numericCount < 4) {
                        passwordError.style.display = 'block';
                    } else {
                        passwordError.style.display = 'none';
                    }
                }
            });

            passwordToggleBtn.addEventListener('click', function () {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordToggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    passwordInput.type = 'password';
                    passwordToggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    </script>
    <div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
</body>

</html>
