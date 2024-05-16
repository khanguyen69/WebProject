<?php
include 'dieuhuong.php';
require_once 'ketnoi.php';

// Initialize $success variable
$success = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input data
    $time_arrival = mysqli_real_escape_string($conn, $_POST['time_arrival']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $booking_status = mysqli_real_escape_string($conn, $_POST['booking_status']);

    // Insert the new booking into the database
    $sql = "INSERT INTO booking (time_arrival, phone_number, booking_status) 
            VALUES ('$time_arrival', '$phone_number', 'Đợi')";
    
    if (mysqli_query($conn, $sql)) {
        $success = 'Đặt phòng thành công!';
        header("Location: datlich.php?page=$current_page");
        exit();
    } else {
        $error = 'Có lỗi khi thêm mới đặt phòng: ' . mysqli_error($conn);
        // Display or log the error message
    }
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đặt phòng</title>
    <!-- Thêm bất kỳ CSS cần thiết nào ở đây -->
</head>
<body>
    

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Đặt lịch</h3>
        </div>
        <div class="panel-body">
            <form action="" method="POST" role="form">
                <div class="form-group">
                    <label for="time_arrival">Thời gian đến</label>
                    <input type="datetime-local" class="form-control" name="time_arrival" id="time_arrival">
                </div>
                <div class="form-group">
                    <label for="phone_number">Số điện thoại</label>
                    <input type="text" class="form-control" name="phone_number" id="phone_number">
                </div>
                <!-- <div class="form-group">
                    <label for="booking_status">Trạng thái đặt phòng</label>
                    <select name="booking_status" id="booking_status" class="form-control">
                        <option value="Đã đến">Đã đến</option>
                        <option value="Đợi">Đợi</option>
                        <option value="Hủy">Hủy</option>
                    </select>
                </div> -->
                <button type="submit" class="btn btn-primary">Lưu lại</button>
            </form>
            <?php if ($success): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $success; ?>
    </div>
<?php endif; ?>

        </div>
    </div>
    <BR></BR>
 <div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
</body>
</html>
