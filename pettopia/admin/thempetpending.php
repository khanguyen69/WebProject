<?php
include 'header.php';
require_once 'connect.php';

// Initialize variables
$error = '';

// Query to fetch data from the pet_pending table
$pet_pending = mysqli_query($conn, "SELECT * FROM pet_pending");

// Get the next available IDs for pet and service
$max_pet_id_query = mysqli_query($conn, "SELECT MAX(IDpet) AS max_pet_id FROM pet_pending");
$max_service_id_query = mysqli_query($conn, "SELECT MAX(ID_service) AS max_service_id FROM pet_pending");

// Fetch the maximum ID values
$max_pet_id_row = mysqli_fetch_assoc($max_pet_id_query);
$max_service_id_row = mysqli_fetch_assoc($max_service_id_query);

// Increment the maximum ID values by one to get the next available ID
$next_pet_id = $max_pet_id_row['max_pet_id'] + 1;
$next_service_id = $max_service_id_row['max_service_id'] + 1;

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data and sanitize
    $time_coming = mysqli_real_escape_string($conn, $_POST['time_coming']);
    $IDpet = mysqli_real_escape_string($conn, $_POST['IDpet']);
    $healt_status = mysqli_real_escape_string($conn, $_POST['healt_status']);
    $ID_service = mysqli_real_escape_string($conn, $_POST['ID_service']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $IDCustomer = mysqli_real_escape_string($conn, $_POST['IDCustomer']);
    $work_status = mysqli_real_escape_string($conn, $_POST['work_status']);

    // Validate form data if necessary

    // Construct the SQL query
    $sql = "INSERT INTO pet_pending(time_coming, IDpet, healt_status, ID_service, note, IDCustomer, work_status) 
            VALUES ('$time_coming', '$IDpet', '$healt_status', '$ID_service', '$note', '$IDCustomer', '$work_status')";

    // Execute the SQL query
    if (mysqli_query($conn, $sql)) {
        // If insertion is successful, redirect to the pet_pending page
        header('location: pending.php');
        exit();
    } else {
        // If an error occurs, store the error message
        $error = 'Có lỗi, vui lòng thử lại: ' . mysqli_error($conn);
    }
}
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Thêm mới thú cưng đợi</h3>
    </div>
    <div class="panel-body">
        <form action="" method="POST" role="form">
            <div class="form-group">
                <label for="time_coming">Thời gian đến</label>
                <input type="datetime-local" class="form-control" name="time_coming" id="time_coming" required>
            </div>
            <div class="form-group">
                <label for="IDpet">ID thú cưng</label>
                <input type="text" class="form-control" name="IDpet" id="IDpet" value="<?php echo $next_pet_id; ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="healt_status">Trạng thái sức khỏe</label>
                <input type="text" class="form-control" name="healt_status" id="healt_status" placeholder="Nhập trạng thái sức khỏe" required>
            </div>
            <div class="form-group">
                <label for="ID_service">ID dịch vụ</label>
                <input type="text" class="form-control" name="ID_service" id="ID_service" value="<?php echo $next_service_id; ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="note">Ghi chú nhân viên</label>
                <input type="text" class="form-control" name="note" id="note" placeholder="Nhập ghi chú" required>
            </div>
            <div class="form-group">
                <label for="IDCustomer">ID khách hàng</label>
                <input type="text" class="form-control" name="IDCustomer" id="IDCustomer" placeholder="Nhập ID khách hàng" required>
            </div>
            <div class="form-group">
                <label for="work_status">Trạng thái</label>
                <input type="text" class="form-control" name="work_status" id="work_status" placeholder="Nhập trạng thái công việc" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </form>
    </div>
</div>
