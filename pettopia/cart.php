<?php
// Include necessary files
include 'dieuhuong.php';
require_once 'ketnoi.php';

// Table definition
/*
CREATE TABLE history_transaction (
    IDtrans INT PRIMARY KEY,
    IDCustomer INT,
    ID_service INT,
    IDpet INT,
    time_trans DATETIME,
    total_price DECIMAL(10,2)
);
*/

// Initialize variables
$error = '';

// Check if an ID is provided in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare and execute the query to fetch data for the given ID from the history_transaction table
    $query = "SELECT * FROM history_transaction WHERE IDtrans = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    // Check if a record is found for the given ID
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $IDtrans = $row['IDtrans'];
        $IDCustomer = $row['IDCustomer']; 
        $ID_service = $row['ID_service']; 
        $IDpet = $row['IDpet'];
        $time_trans = $row['time_trans'];
        $total_price = $row['total_price'];
    } else {
        // Handle if no record found for the given ID
        $error = 'Không tìm thấy giao dịch với ID này';
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data and sanitize
    $time_trans = mysqli_real_escape_string($conn, $_POST['time_trans']);
    $IDpet = mysqli_real_escape_string($conn, $_POST['IDpet']);
    $ID_service = mysqli_real_escape_string($conn, $_POST['ID_service']);
    $IDtrans = mysqli_real_escape_string($conn, $_POST['IDtrans']);
    $IDCustomer = mysqli_real_escape_string($conn, $_POST['IDCustomer']);
    $total_price = mysqli_real_escape_string($conn, $_POST['total_price']);

    // Construct the SQL query
    $sql = "UPDATE history_transaction SET time_trans=?, IDpet=?, ID_service=?, IDCustomer=?, total_price=? WHERE IDtrans=?";

    // Prepare and execute the SQL query
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssdi", $time_trans, $IDpet, $ID_service, $IDCustomer, $total_price, $IDtrans);
    
    if (mysqli_stmt_execute($stmt)) {
        // If update is successful, redirect to the suitable page
        header('location: petshop.php');
        exit();
    } else {
        // If an error occurs, store the error message
        $error = 'Có lỗi, vui lòng thử lại: ' . mysqli_error($conn);
    }
}
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Chỉnh sửa giao dịch</h3>
    </div>
    <div class="panel-body">
        <form action="" method="POST" role="form">
            <div class="form-group">
                <label for="time_trans">Thời gian giao dịch</label>
                <input type="datetime-local" class="form-control" name="time_trans" id="time_trans" value="<?= isset($time_trans) ? $time_trans : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="IDpet">ID thú cưng</label>
                <input type="text" class="form-control" name="IDpet" id="IDpet" value="<?= isset($IDpet) ? $IDpet : ''; ?>" placeholder="Nhập ID thú cưng" required>
            </div>
            <div class="form-group">
                <label for="ID_service">ID dịch vụ</label>
                <input type="text" class="form-control" name="ID_service" id="ID_service" value="<?= isset($ID_service) ? $ID_service : ''; ?>" placeholder="Nhập ID dịch vụ" required>
            </div>
            <div class="form-group">
                <label for="IDtrans">ID giao dịch</label>
                <input type="text" class="form-control" name="IDtrans" id="IDtrans" value="<?= isset($IDtrans) ? $IDtrans : ''; ?>" placeholder="Nhập ID giao dịch" required readonly>
            </div>
            <div class="form-group">
                <label for="IDCustomer">ID khách hàng</label>
                <input type="text" class="form-control" name="IDCustomer" id="IDCustomer" value="<?= isset($IDCustomer) ? $IDCustomer : ''; ?>" placeholder="Nhập ID khách hàng" required>
            </div>
            <div class="form-group">
                <label for="total_price">Tổng giá trị</label>
                <input type="text" class="form-control" name="total_price" id="total_price" value="<?= isset($total_price) ? $total_price : ''; ?>" placeholder="Nhập tổng giá trị" required>
            </div>
            <button type="submit" name="submit_transaction" class="btn btn-primary">Lưu lại</button>
        </form>
        <?php
        // Display error message if there's any
        if ($error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
    </div>
</div>
