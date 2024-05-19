<?php
include 'header.php';
require_once 'connect.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $time = mysqli_real_escape_string($conn, $_POST['time_coming']);
    $idpet = mysqli_real_escape_string($conn, $_POST['IDpet']);
    $healt = mysqli_real_escape_string($conn, $_POST['healt_status']);
    $idservice = mysqli_real_escape_string($conn, $_POST['ID_service']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $idcustomer = mysqli_real_escape_string($conn, $_POST['IDCustomer']);
    $work = mysqli_real_escape_string($conn, $_POST['work_status']);

    // Prepare the SQL statement using prepared statements
    $sql = "INSERT INTO pet_pending (time_coming, IDpet, healt_status, ID_service, note, IDCustomer, work_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sississ", $time, $idpet, $healt, $idservice, $note, $idcustomer, $work);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // If insertion is successful, redirect to the petpending.php page
        header('location: petpending.php');
        exit(); // Always exit after redirection
    } else {
        // If an error occurs during execution, set the error message
        $error = 'Có lỗi, vui lòng thử lại: ' . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Thêm mới tình trạng thú cưng</h3>
    </div>
    <div class="panel-body">
        <form action="" method="POST" role="form">
            <div class="form-group">
                <label for="time_coming">Thời gian đến</label>
                <input type="datetime-local" class="form-control" name="time_coming" required>
            </div>
            <div class="form-group">
                <label for="IDpet">ID thú cưng</label>
                <input type="text" class="form-control" name="IDpet" required>
            </div>
            <div class="form-group">
                <label for="healt_status">Trạng thái sức khỏe</label>
                <input type="text" class="form-control" name="healt_status" required>
            </div>
            <div class="form-group">
                <label for="ID_service">ID dịch vụ</label>
                <input type="text" class="form-control" name="ID_service" required>
            </div>
            <div class="form-group">
                <label for="note">Ghi chú nhân viên</label>
                <input type="text" class="form-control" name="note" required>
            </div>
            <div class="form-group">
                <label for="IDCustomer">ID khách hàng</label>
                <input type="text" class="form-control" name="IDCustomer" required>
            </div>
            <div class="form-group">
                <label for="work_status">Trạng thái</label>
                <input type="text" class="form-control" name="work_status" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </form>
    </div>
</div>
