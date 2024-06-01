<?php
include 'header.php';
require_once 'connect.php';

$success = '';
$error = '';
$error1 = '';

$rows_per_page = 10; 
$total_rows = mysqli_num_rows(mysqli_query($conn, "SELECT IDbooking FROM booking"));
$total_pages = ceil($total_rows / $rows_per_page);


$current_page = isset($_GET['page']) ? $_GET['page'] : 1;


$start_row = ($current_page - 1) * $rows_per_page;

$sql = "SELECT IDbooking, time_arrival, phone_number, booking_status FROM booking LIMIT $start_row, $rows_per_page";
$bookings = mysqli_query($conn, $sql);


if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $booking_id = $_GET['IDbooking'];

    if ($action == 'delete') {

        $delete_sql = "DELETE FROM booking WHERE IDbooking='$booking_id'";
        mysqli_query($conn, $delete_sql);
        header("Location: booking.php?page=$current_page");
        exit();
    } elseif ($action == 'update') {
  
        $status = $_GET['status'];
        $update_sql = "UPDATE booking SET booking_status='$status' WHERE IDbooking='$booking_id'";
        mysqli_query($conn, $update_sql);
        header("Location: booking.php?page=$current_page");
        exit();
    }
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $time_arrival = mysqli_real_escape_string($conn, $_POST['time_arrival']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $booking_status = mysqli_real_escape_string($conn, $_POST['booking_status']);

 
    $currentTime = time();
    $fiveHoursLater = $currentTime + 11*3600; 
    $timeArrivalTimestamp = strtotime($time_arrival);

    if ($timeArrivalTimestamp <= $fiveHoursLater) {
        $error = 'Thời gian đến phải lớn hơn thời gian hiện tại';
    } else {
        $customer_query = "SELECT * FROM customer WHERE PhoneNumber = '$phone_number'";
        $customer_result = mysqli_query($conn, $customer_query);

        if (mysqli_num_rows($customer_result) > 0) {
            $sql = "INSERT INTO booking (time_arrival, phone_number, booking_status) 
                    VALUES ('$time_arrival', '$phone_number', '$booking_status')";

            if (mysqli_query($conn, $sql)) {
                $success = 'Đặt phòng thành công!';
                header("Location: booking.php?page=$current_page");
                exit();
            } else {
                $error = 'Có lỗi khi thêm mới đặt phòng: ' . mysqli_error($conn);
            }
        } else {
            $error1 = 'Số điện thoại này chưa được đăng ký';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Đặt lịch</title>
    <style>
        .error-message {
            color: red;
            font-size: 1em;
            display: block; 
        }
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
        .phan-trang a.active {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Danh sách lịch hẹn</h3>
        </div>

        <?php
        if (mysqli_num_rows($bookings) > 0) {
        ?>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID đặt lịch</th>
                        <th>Thời gian đến</th>
                        <th>Số điện thoại</th>
                        <th>Trạng thái lịch hẹn</th>
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
                                if ($row['booking_status'] != 'Đã đến') {
                                ?>
                                   <a href="booking.php?page=<?php echo $current_page; ?>&action=update&IDbooking=<?php echo $row['IDbooking']; ?>&status=Hủy" class="btn btn-xs btn-warning">Hủy</a>
                                   <a href="booking.php?page=<?php echo $current_page; ?>&action=update&IDbooking=<?php echo $row['IDbooking']; ?>&status=Đợi" class="btn btn-xs btn-info">Đợi</a>
                                   <a href="booking.php?page=<?php echo $current_page; ?>&action=update&IDbooking=<?php echo $row['IDbooking']; ?>&status=Đã đến" class="btn btn-xs btn-success">Đến</a>
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
                if ($i == $current_page) {
                    echo "<li><a href='?page=" . $i . "' class='active'>" . $i . "</a></li>";
                } else {
                    echo "<li><a href='?page=" . $i . "'>" . $i . "</a></li>";
                }
            }
            ?>
            </ul>
        <?php } else {
            echo "<p>Không có cuộc hẹn nào.</p>";
        } ?>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Thêm mới lịch hẹn</h3>
        </div>
        <div class="panel-body">
            <form action="" method="POST" role="form">
                <div class="form-group">
                    <label for="time_arrival">Thời gian đến</label>
                    <input type="datetime-local" class="form-control" name="time_arrival" id="time_arrival" required>
                    <?php if ($error): ?>
                    <div class="error-message"><?php echo $error; ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="phone_number">Số điện thoại</label>
                    <input type="text" class="form-control" name="phone_number" id="phone" placeholder="Nhập số điện thoại" required pattern="\d{10}">
                    <div style="color: red; font-size: 1em; display: none;" id="phone-error"></div>
                    <?php if ($error1): ?>
                    <div class="error-message"><?php echo $error1; ?></div>
                    <?php endif; ?>
                </div>
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
                            event.preventDefault(); 
                        } else if (phoneValue.length !== 10) {
                            phoneError.textContent = "Số điện thoại phải có đủ 10 số.";
                            phoneError.style.display = 'block';
                            event.preventDefault(); 
                        } else {
                            phoneError.style.display = 'none';
                        }
                    });
                });
                </script>
                <div class="form-group">
                    <label for="booking_status">Trạng thái đặt phòng</label>
                    <select name="booking_status" id="booking_status" class="form-control">
                        <option value="Đợi">Đợi</option>
                        <option value="Đã đến">Đã đến</option>
                        <option value="Hủy">Hủy</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Thêm</button>
            </form>
            <?php if ($success): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $success; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="duoi">
        <?php require_once 'footer.php' ?>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(function(errorMessage) {
                errorMessage.style.display = 'block';
                setTimeout(function() {
                    errorMessage.style.display = 'none';
                }, 3000);
            });
        });
    </script>
</body>
</html>
