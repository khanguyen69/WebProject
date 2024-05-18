<?php
include 'header.php';
require_once 'connect.php';
require_once 'uploadfiles.php';

$error = '';
if (isset($_POST['pet_name'])) {
    $pet_type = $_POST['Pet_type'];
    $pet_name = $_POST['pet_name'];
    $phone_number = $_POST['PhoneNumber_owner'];
    $id_customer = $_POST['customer_name']; 

    if (empty($pet_name)) {
        $error = 'Tên sản phẩm không được để trống';
    }

    // Check if file was uploaded successfully
    if ($_FILES["pet_img"]["error"] == UPLOAD_ERR_OK) {
        // Get the file name
        $pet_img_name = $_FILES["pet_img"]["name"];
        
        // Move the uploaded file to the uploads directory
        $upload_directory = "../uploads/";
        $pet_img_path = $upload_directory . $pet_img_name;
        if (move_uploaded_file($_FILES["pet_img"]["tmp_name"], $pet_img_path)) {
            echo "Upload file thành công";
        } else {
            echo "Upload file thất bại";
            $error = 'Không thể lưu ảnh thú cưng';
        }
    } else {
        $error = 'Lỗi khi tải lên ảnh';
    }

    // If no error, proceed to insert new record into the 'pet' table
    if (!$error) {
        $sql = "INSERT INTO `pet`(`Pet_type`, `pet_name`, `pet_img`, `PhoneNumber_owner`, `IDCustomer`) 
        VALUES ('$pet_type','$pet_name','$pet_img_path','$phone_number','$id_customer')"; // Use $pet_img_path instead of $pet_img

        if (mysqli_query($conn, $sql)) {
            header('location: petshop.php');
        } else {
            $error = 'Có lỗi, vui lòng thử lại';
        }
    }
}
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Thêm mới thú cưng</h3>
    </div>
    <div class="panel-body">
        <form action="" method="POST" enctype="multipart/form-data" role="form">
            <div class="form-group">
                <label for="">Loại thú cưng</label>
                <input type="text" class="form-control" name="Pet_type" placeholder="Nhập loại thú cưng">
            </div>
            <div class="form-group">
                <label for="">Tên thú cưng</label>
                <input type="text" class="form-control" name="pet_name" placeholder="Nhập tên thú cưng">
            </div>
            <div class="form-group">
                <label for="">Ảnh thú cưng</label>
                <input type="file" class="form-control" name="pet_img"> <!-- Assuming "pet_img" is the name attribute -->
            </div>
            <div class="form-group">
                <label for="">Số điện thoại chủ</label>
                <input type="text" class="form-control" name="PhoneNumber_owner" placeholder="Nhập số điện thoại chủ">
            </div>
            <div class="form-group">
                <label for="">Chọn khách hàng</label>
                <select name="customer_name" class="form-control">
                    <option value="">Chọn khách hàng</option>
                    <?php 
                    // Fetch customer data from the database
                    $customers = mysqli_query($conn, "SELECT * FROM customer");
                    
                    // Loop through each customer and create an option element
                    foreach ($customers as $row) : ?>
                        <option value="<?php echo $row['IDCustomer']; ?>"><?php echo $row['Name_customer']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </form>
    </div>
</div>
