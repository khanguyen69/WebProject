<?php
include 'header.php';
require_once 'connect.php';
require_once 'uploadfiles.php';

$error = '';
$success = '';

if (isset($_POST['pet_name'])) {
    $pet_type = $_POST['Pet_type'];
    $pet_name = $_POST['pet_name'];
    $phone_number = $_POST['PhoneNumber_owner'];

    // Fetch customer data from the database based on phone number
    $customer_query = mysqli_query($conn, "SELECT * FROM customer WHERE PhoneNumber = '$phone_number'");
    $customer = mysqli_fetch_assoc($customer_query);

    // If customer exists, get their name and ID
    if ($customer) {
        $customer_name = $customer['Name_customer'];
        $id_customer = $customer['IDCustomer'];

        // Check if file was uploaded successfully
        if ($_FILES["pet_img"]["error"] == UPLOAD_ERR_OK) {
            // Get the file name
            $pet_img_name = $_FILES["pet_img"]["name"];
            
            // Move the uploaded file to the uploads directory
            $upload_directory = "../uploads/";

            // Ensure the uploads directory exists and is writable
            if (!is_dir($upload_directory)) {
                mkdir($upload_directory, 0777, true);
            }

            $pet_img_path = $upload_directory . $pet_img_name;
            if (move_uploaded_file($_FILES["pet_img"]["tmp_name"], $pet_img_path)) {
                $success = "Upload file thành công";
                // Update $upload_directory to be used for storing the path in the database
                $upload_directory = "../uploads/";
                $pet_img_path = $upload_directory . $pet_img_name;
            } else {
                $error = 'Không thể lưu ảnh thú cưng';
            }
        } else {
            $error = 'Lỗi khi tải lên ảnh';
        }

        // If no error, proceed to insert new record into the 'pet' table
        if (!$error) {
            $sql = "INSERT INTO `pet`(`Pet_type`, `pet_name`, `pet_img`, `PhoneNumber_owner`, `IDCustomer`) 
                    VALUES ('$pet_type','$pet_name','$pet_img_path','$phone_number','$id_customer')";

            if (mysqli_query($conn, $sql)) {
                $success = 'Đăng ký thú cưng thành công';
                header('location: petshop.php');
            } else {
                $error = 'Có lỗi, vui lòng thử lại';
            }
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thú cưng</title>
</head>
<body>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Thêm mới thú cưng</h3>
        </div>
        <div class="panel-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form action="" method="POST" enctype="multipart/form-data" role="form">
                <div class="form-group">
                    <label for="">Loại thú cưng</label>
                    <input type="text" class="form-control" name="Pet_type" placeholder="Nhập loại thú cưng" required>
                </div>
                <div class="form-group">
                    <label for="">Tên thú cưng</label>
                    <input type="text" class="form-control" name="pet_name" placeholder="Nhập tên thú cưng" required>
                </div>
                <div class="form-group">
                    <label for="">Ảnh thú cưng</label>
                    <input type="file" class="form-control" name="pet_img" id="pet_img" accept=".jpg, .jpeg, .png, .gif, .bmp, .tiff, .tif, .webp" required>
                    <div style="color: red; font-size: 0.925em; display: none;" id="img-error"></div>
                </div>
                <div class="form-group">
                    <label for="">Số điện thoại chủ</label>
                    <input type="text" class="form-control" name="PhoneNumber_owner" id="phone" placeholder="Nhập số điện thoại chủ" required pattern="\d{10}">
                    <div style="color: red; font-size: 0.925em; display: none;" id="phone-error"></div>
                </div>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var imgInput = document.getElementById('pet_img');
                    var imgError = document.getElementById('img-error');

                    imgInput.addEventListener('change', function() {
                        var imgFileName = imgInput.value;
                        var acceptedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.bmp|\.tiff|\.tif|\.webp)$/i;

                        if (!acceptedExtensions.exec(imgFileName)) {
                            imgError.textContent = "Vui lòng chọn một file ảnh có định dạng hợp lệ (.jpg, .jpeg, .png, .gif, .bmp, .tiff, .tif, .webp).";
                            imgError.style.display = 'block';
                            imgInput.value = ''; // Clear the input
                        } else {
                            imgError.style.display = 'none';
                        }
                    });
                });
                </script>

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
                            event.preventDefault(); // Prevent form submission
                        } else if (phoneValue.length !== 10) {
                            phoneError.textContent = "Số điện thoại phải có đủ 10 số.";
                            phoneError.style.display = 'block';
                            event.preventDefault(); // Prevent form submission
                        } else {
                            phoneError.style.display = 'none';
                        }

                    });
                });
                </script>   
                <div>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div> 
        <div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    var errorAlert = document.querySelector('.alert-danger');
        if (errorAlert) {
            setTimeout(function() {
                errorAlert.style.display = 'none';
            }, 3000);
        }
    });
    </script>
</body>
</html>