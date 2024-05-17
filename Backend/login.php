<?php
session_start();
ob_start();
include_once 'connect.php';
if (isset($_POST['username']) && isset($_POST['password'])) {
    $use = $_POST['username'];
    $pass = $_POST['password'];

    // Check if the password is empty
    // No need
    // if (empty($pass)) {
    //     echo "Mật khẩu không được để trống.";
    //     exit;
    // }

    // Check if the password contains at least 4 numeric characters and no special characters
    // No need
    // if (!preg_match('/^[0-9]{4,}$/', $pass) || preg_match('/[^A-Za-z0-9]/', $pass)) {
    //     header('location: login.php');
    //     exit;
    // }

    // $pass = md5($pass);
     // truy vấn cơ sở dữ liệu tìm xem có username hay password không
    $sql = "SELECT * FROM `admin` WHERE username = '$use' AND `password` = '$pass'";
    $use_sql = mysqli_query($conn, $sql);

    if (mysqli_num_rows($use_sql) > 0) {
        $alert_message = "Đăng nhập thành công";
        $_SESSION['admin']['username'] = $use;
    } else {
        $alert_message = "Thông tin tài khoản hoặc mật khẩu không chính xác";
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
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
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        /* Additional styles for login and logout links */
        .login-link,
        .logout-link {
            color: #007bff;
            text-decoration: none;
        }

        .login-link:hover,
        .logout-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="form-container">
            <form action="login.php" method="post">
                <legend class="text-center">Đăng Nhập</legend>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="Nhập tài khoản" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" placeholder="Nhập mật khẩu" class="form-control" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="show-password-toggle">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit" name="dangnhap" class="btn btn-primary btn-block">Đăng Nhập</button>

                <!-- <div class="form-group text-center">
                    Bạn chưa có tài khoản? <a href="register.php" class="btn btn-primary">Đăng Ký</a>
                </div> -->
            </form>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

    <!-- JavaScript for password visibility toggle -->
    <script> // thông báo để xem đăng nhập thành công hay đăng nhập thất bại 
        document.addEventListener('DOMContentLoaded', function() {
            var passwordInput = document.getElementById('password');
            var passwordToggleBtn = document.getElementById('show-password-toggle');
            var alertMessage = "<?php echo isset($_POST['username']) && isset($_POST['password']) ? $alert_message : ''; ?>";


            if (alertMessage !== "") {
                alert(alertMessage);
                <?php
                if ($alert_message === "Đăng nhập thành công") {
                    echo "window.location.href = 'index.php';";
                }
                ?>}
            passwordToggleBtn.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordToggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>'; // Change the icon to an eye slash when password is visible
                } else {
                    passwordInput.type = 'password';
                    passwordToggleBtn.innerHTML = '<i class="fas fa-eye"></i>'; // Change the icon back to an eye when password is hidden
                }
            });
        });
    </script>
</body>

</html>
