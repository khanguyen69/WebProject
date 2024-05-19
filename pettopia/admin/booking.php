<?php
include 'header.php';
require_once 'connect.php';

// Calculate total pages
$rows_per_page = 10; // Adjust as needed
$total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT IDbooking FROM booking"));
$total_pages = ceil($total_rows / $rows_per_page);

// Determine current page
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting row for the query
$start_row = ($current_page - 1) * $rows_per_page;

// Get bookings for the current page
$sql = "SELECT IDbooking, time_arrival, phone_number, booking_status FROM booking LIMIT $start_row, $rows_per_page";
$bookings = mysqli_query($conn, $sql);

// Handle appointment actions
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $booking_id = $_GET['IDbooking'];

    if ($action == 'delete') {
        // Delete appointment
        $delete_sql = "DELETE FROM booking WHERE IDbooking='$booking_id'";
        mysqli_query($conn, $delete_sql);
        header("Location: booking.php?page=$current_page");
        exit();
    } elseif ($action == 'update') {
        // Update appointment status
        $status = $_GET['status'];
        $update_sql = "UPDATE booking SET booking_status='$status' WHERE IDbooking='$booking_id'";
        mysqli_query($conn, $update_sql);
        header("Location: booking.php?page=$current_page");
        exit();
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input data
    $time_arrival = mysqli_real_escape_string($conn, $_POST['time_arrival']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $booking_status = mysqli_real_escape_string($conn, $_POST['booking_status']);

    // Insert the new booking into the database
    $sql = "INSERT INTO booking (time_arrival, phone_number, booking_status) 
            VALUES ('$time_arrival', '$phone_number', '$booking_status')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: booking.php?page=$current_page");
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
    <style>
    .phan-trang {
        width: 100%;
        text-align: center;
        list-style: none;
        font-weight: bold;
        font-size: 1.5em;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .phan-trang li {
        display: inline;
    }

    .phan-trang a {
        padding: 10px;
        border: 1px solid #ebebeb;
        text-decoration: none;
    }
</style>
</head>
<body>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Danh sách tất cả các đặt phòng</h3>
        </div>

        <?php
        // Display appointments
        if (mysqli_num_rows($bookings) > 0) {
        ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID đặt phòng</th>
                        <th>Thời gian đến</th>
                        <th>Số điện thoại</th>
                        <th>Trạng thái đặt phòng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($bookings)) {
                    ?>
                        <tr>
                            <td><?php echo $row['IDbooking']; ?></td>
                            <td><?php echo $row['time_arrival']; ?></td>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php echo $row['booking_status']; ?></td>
                            <td>
                                <?php
                                // Check if appointment status is not 'Đã đến'
                                if ($row['booking_status'] != 'Đã đến') {
                                ?>
                                    <a href="booking.php?action=update&IDbooking=<?php echo $row['IDbooking']; ?>&status=Hủy" class="btn btn-xs btn-warning">Hủy</a>
                                    <a href="booking.php?action=update&IDbooking=<?php echo $row['IDbooking']; ?>&status=Đã đến" class="btn btn-xs btn-success">Đến</a>
                                    <a href="booking.php?action=update&IDbooking=<?php echo $row['IDbooking']; ?>&status=Đợi" class="btn btn-xs btn-info">Đợi</a>
                                <?php
                                }
                                ?>
                                <a href="booking.php?action=delete&IDbooking=<?php echo $row['IDbooking']; ?>&page=<?php echo $current_page; ?>" class="btn btn-xs btn-danger">Xóa</a>
                            </td>
                        </tr>
                    <?php }; ?>
                </tbody>
            </table>

            <ul class="phan-trang">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li><a href='?page=" . $i . "'>" . $i . "</a></li>";
            }
            ?>
        </ul>
        <?php } else {
            echo "<p>Không có cuộc hẹn nào.</p>";
        } ?>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Thêm mới đặt phòng</h3>
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
                <div class="form-group">
                    <label for="booking_status">Trạng thái đặt phòng</label>
                    <select name="booking_status" id="booking_status" class="form-control">
                        <option value="Đã đến">Đã đến</option>
                        <option value="Đợi">Đợi</option>
                        <option value="Hủy">Hủy</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Lưu lại</button>
            </form>
        </div>
    </div>
    <div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
</body>
</html>


