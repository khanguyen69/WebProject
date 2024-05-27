<?php
include 'header.php';
require_once 'connect.php';
require_once 'uploadfiles.php';

$id = !empty($_GET['Proid']) ? (int)$_GET['Proid'] : 0;
$result = mysqli_query($conn, "SELECT p.IDpet, p.Pet_type, p.pet_name, p.pet_img, p.PhoneNumber_owner, p.IDCustomer 
                    FROM pet p WHERE p.IDpet = $id");
$rowPet = mysqli_fetch_assoc($result);

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_type = $_POST['Pet_type'];
    $pet_name = $_POST['pet_name'];
    $phone_number = $_POST['PhoneNumber_owner'];

    // Fetch customer ID based on phone number
    $customer_query = mysqli_query($conn, "SELECT IDCustomer FROM customer WHERE PhoneNumber = '$phone_number'");
    $customer_data = mysqli_fetch_assoc($customer_query);

    if ($customer_data) {
        $customer_id = $customer_data['IDCustomer'];

        // Check if image file is uploaded
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
        }

        // If no errors, update the record
        if (!$error) {
            // Perform the database update with the new image path
            $sql = "UPDATE pet SET Pet_type ='$pet_type', pet_name='$pet_name', PhoneNumber_owner='$phone_number', IDCustomer='$customer_id'";
            if (!empty($pet_img_path)) { // Chỉ cập nhật đường dẫn ảnh nếu có ảnh mới được tải lên
                $sql .= ", pet_img='$pet_img_path'";
            }
            $sql .= " WHERE IDpet = $id";

            if (mysqli_query($conn, $sql)) {
                // If database update is successful, redirect to petshop.php
                header('Location: petshop.php');
                exit();
            } else {
                $error = 'Error updating record.';
            }
        }
    } else {
        $error = 'Không tìm thấy khách hàng với số điện thoại này';
    }
}

?>
<?php $customers = mysqli_query($conn, "SELECT * FROM customer"); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Chỉnh sửa thông tin thú cưng</h3>
    </div>
    <div class="panel-body">
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data" role="form">
            <div class="form-group">
                <label for="Pet_type">Loại thú cưng</label>
                <input type="text" class="form-control" name="Pet_type"  placeholder="Nhập loại thú cưng" required value="<?php echo isset($rowPet['Pet_type']) ? $rowPet['Pet_type'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="pet_name">Tên thú cưng</label>
                <input type="text" class="form-control" name="pet_name" placeholder="Nhập tên thú cưng" required value="<?php echo isset($rowPet['pet_name']) ? $rowPet['pet_name'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="pet_img">Ảnh thú cưng</label>
                <input type="file" class="form-control" name="pet_img" id="pet_img" accept=".jpg, .jpeg, .png, .gif, .bmp, .tiff, .tif, .webp" >
                <div style="color: red; font-size: 0.925em; display: none;" id="img-error"></div>
                <?php if (!empty($rowPet['pet_img'])): ?>
                    <img width="200" height="200" src="<?php echo "../uploads/".$rowPet['pet_img'] ?>" alt="Image">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="PhoneNumber_owner">Số điện thoại chủ</label>
                <input type="text" class="form-control" name="PhoneNumber_owner" id="phone" placeholder="Nhập số điện thoại chủ" required pattern="\d{10}" value="<?php echo isset($rowPet['PhoneNumber_owner']) ? $rowPet['PhoneNumber_owner'] : ''; ?>">
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
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </form>
    </div>
</div>
<div class="duoi">
    <?php require_once 'footer.php' ?>
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
