<?php
include 'header.php';
require_once 'connect.php';

// Xem nhận xét và đánh giá của khách hàng
$sql = "SELECT  f.IDCustomer, f.ID_service, f.point_feedback, f.comment_feedback FROM history_feedback AS f"; // Đổi bí danh bảng thành "f"
$feedbacks = mysqli_query($conn, $sql); // Đổi tên biến thành $feedbacks

// Lấy dịch vụ
$sql_services = "SELECT * FROM services";
$services_result = mysqli_query($conn, $sql_services);

// Thêm dịch vụ mới
if(isset($_POST['add_service'])) {
    $service_name = $_POST['service_name'];
    $price = $_POST['price'];
    $minute_serving = $_POST['minute_serving'];
    // Chèn dịch vụ mới vào cơ sở dữ liệu
    $insert_service_sql = "INSERT INTO services (name_service, price_service, minute_serving) VALUES ('$service_name', '$price', '$minute_serving')";
    mysqli_query($conn, $insert_service_sql);
    header("Location: phanhoidichvu.php"); // Chuyển hướng để làm mới trang
    exit();
}

// Sửa dịch vụ
if(isset($_POST['edit_service'])) {
    $service_id = $_POST['service_id'];
    $edited_service_name = $_POST['edited_service_name'];
    $edited_price = $_POST['edited_price'];
    $edited_minute_serving = $_POST['edited_minute_serving'];
    // Cập nhật thông tin dịch vụ trong cơ sở dữ liệu
    $update_service_sql = "UPDATE services SET name_service='$edited_service_name', price_service='$edited_price', minute_serving='$edited_minute_serving' WHERE ID_service='$service_id'";
    mysqli_query($conn, $update_service_sql);
    header("Location: phanhoidichvu.php"); // Chuyển hướng để làm mới trang
    exit();
}

// Xóa dịch vụ
if(isset($_POST['delete_service'])) {
    $service_id = $_POST['service_id'];
    // Xóa dịch vụ khỏi cơ sở dữ liệu
    $delete_service_sql = "DELETE FROM services WHERE ID_service='$service_id'";
    mysqli_query($conn, $delete_service_sql);
    header("Location: phanhoidichvu.php"); // Chuyển hướng để làm mới trang
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý Dịch vụ của Nhân viên</title>
    <!-- Thêm bất kỳ CSS cần thiết nào ở đây -->
</head>
<body>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Nhận xét và Đánh giá của Khách hàng</h3>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID khách hàng</th>
                    <th>ID dịch vụ</th>
                    <th>Điểm đánh giá</th>
                    <th>Bình luận</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($feedbacks)) {
                ?>
                    <tr>
                        <td><?php echo $row['IDCustomer']; ?></td>
                        <td><?php echo $row['ID_service']; ?></td>
                        <td><?php echo $row['point_feedback']; ?></td>
                        <td><?php echo $row['comment_feedback']; ?></td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Quản lý Dịch vụ</h3>
        </div>
        <div class="panel-body">
            <!-- Form thêm dịch vụ mới -->
            <h4>Thêm Dịch vụ Mới</h4>
            <form method="POST" action="">
                <label>Tên Dịch vụ:</label>
                <input type="text" name="service_name" required>
                <label>Giá:</label>
                <input type="number" name="price" required>
                <label>Số phút phục vụ:</label>
                <input type="number" name="minute_serving" required>
                <button type="submit" name="add_service">Thêm Dịch vụ</button>
            </form>

            <!-- Hiển thị dịch vụ hiện có -->
            <h4>Dịch vụ Hiện có</h4>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Dịch vụ</th>
                        <th>Giá</th>
                        <th>Số phút phục vụ</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($service_row = mysqli_fetch_assoc($services_result)) {
                    ?>
                        <tr>
                            <td><?php echo $service_row['ID_service']; ?></td>
                            <td><?php echo $service_row['name_service']; ?></td>
                            <td><?php echo $service_row['price_service']; ?></td>
                            <td><?php echo $service_row['minute_serving']; ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="service_id" value="<?php echo $service_row['ID_service']; ?>">
                                    <input type="text" name="edited_service_name" required>
                                    <input type="number" name="edited_price" required>
                                    <input type="number" name="edited_minute_serving" required>
                                    <button type="submit" name="edit_service">Lưu</button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="service_id" value="<?php echo $service_row['ID_service']; ?>">
                                    <button type="submit" name="delete_service">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php }; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
</body>
</html>
