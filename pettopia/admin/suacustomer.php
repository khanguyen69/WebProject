<?php
include 'header.php';
require_once 'connect.php';

$id = !empty($_GET['IDCustomer']) ? (int)$_GET['IDCustomer'] : 0;
$result = mysqli_query($conn, "SELECT IDCustomer, Name_customer, DateOfBirth, Diachi, PhoneNumber, email FROM customer WHERE IDCustomer = $id");
$rowCustomer = mysqli_fetch_assoc($result);

$error = '';
if (isset($_POST['Name_customer'])) {
    $name = $_POST['Name_customer'];
    $dob = $_POST['DateOfBirth'];
    $address = $_POST['Diachi'];
    $phone = $_POST['PhoneNumber'];
    $email = $_POST['email'];

    // Validate input fields if needed

    // Update the customer information
    $sql = "UPDATE customer SET Name_customer = '$name', DateOfBirth = '$dob', Diachi = '$address', PhoneNumber = '$phone', email = '$email' WHERE IDCustomer = $id";
    if (mysqli_query($conn, $sql)) {
        header('location: customer.php');
    } else {
        $error = 'Có lỗi, vui lòng thử lại';
    }
}
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Chỉnh sửa thông tin khách hàng</h3>
    </div>
    <div class="panel-body">
        <form action="" method="POST" role="form">
            <div class="form-group">
                <label for="">Tên khách hàng</label>
                <input type="text" class="form-control" name="Name_customer" value="<?php echo isset($rowCustomer['Name_customer']) ? $rowCustomer['Name_customer'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="">Ngày sinh</label>
                <input type="date" class="form-control" name="DateOfBirth" value="<?php echo isset($rowCustomer['DateOfBirth']) ? $rowCustomer['DateOfBirth'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="">Địa chỉ</label>
                <input type="text" class="form-control" name="Diachi" value="<?php echo isset($rowCustomer['Diachi']) ? $rowCustomer['Diachi'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="">Số điện thoại</label>
                <input type="text" class="form-control" name="PhoneNumber" value="<?php echo isset($rowCustomer['PhoneNumber']) ? $rowCustomer['PhoneNumber'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo isset($rowCustomer['email']) ? $rowCustomer['email'] : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </form>
    </div>
</div>
<div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>