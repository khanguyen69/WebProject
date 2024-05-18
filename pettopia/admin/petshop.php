<?php
include 'header.php';
require_once 'connect.php';

// Function to delete a pet from the database
function deletePet($conn, $petId) {
    $deleted = mysqli_query($conn, "DELETE FROM pet WHERE IDpet = $petId");
    return $deleted;
}

// Process search form submission
if(isset($_POST['search_customer'])) {
    $search_term = mysqli_real_escape_string($conn, $_POST['search_term']);
    // Search query for pet name, owner name, and phone number
    $sql = "SELECT s.IDpet, s.pet_name, s.pet_img, s.Pet_type, s.PhoneNumber_owner, s.IDCustomer FROM pet AS s WHERE s.pet_name LIKE '%$search_term%' OR s.PhoneNumber_owner LIKE '%$search_term%' OR s.IDCustomer IN (SELECT IDCustomer FROM customer WHERE Name_customer LIKE '%$search_term%')";
} else {
    // Default query to fetch all pets
    $sql = "SELECT s.IDpet, s.pet_name, s.pet_img, s.Pet_type, s.PhoneNumber_owner, s.IDCustomer FROM pet AS s";
}
$pet = mysqli_query($conn, $sql);
$rows_per_page = 10; 
$total_rows = mysqli_num_rows($pet);
$total_pages = ceil($total_rows / $rows_per_page);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_index = ($current_page - 1) * $rows_per_page;
$sql .= " LIMIT $start_index, $rows_per_page";
$pet = mysqli_query($conn, $sql);
?>
<style>
    .phan-trang {
        width: 100%;
        text-align: center;
        list-style: none;
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
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Danh sách sản phẩm</h3>
    </div>
    <div class="panel-body">
        <form method="POST" action="">
            <div class="form-group">
                <label for="search_term">Tìm kiếm thú cưng:</label>
                <input type="text" name="search_term" id="search_term" class="form-control" placeholder="Nhập tên hoặc số điện thoại hoặc email">
            </div>
            <button type="submit" name="search_customer" class="btn btn-primary">Tìm kiếm</button>
            <th><a href="/pettopia/admin/thempet.php" class="btn btn-primary btn-sm">Thêm thú cưng</a></th>
        </form>
    </div>
    <?php
    $page = 0;
    if (isset($_GET["page"])) {
        $page = $_GET["page"] - 1;
    }

    $sql = "SELECT CEIL((SELECT COUNT(*) FROM `pet`) / 6) AS 'totalpage'";
    $result = mysqli_query($conn, $sql);
    $totalpage = 0;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $totalpage = $row["totalpage"];
        }
    }

    $sql = "SELECT " . $page . " * (SELECT (SELECT COUNT(*) FROM `pet`) / (SELECT CEIL((SELECT COUNT(*) FROM `pet`) / 6))) AS 'offset'";
    $result = mysqli_query($conn, $sql);
    $offset = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $offset = (int) $row["offset"];
    }

    $sql = "SELECT * FROM `pet` LIMIT " . $offset . ", 6";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    ?>
        
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID thú cưng</th>
                    <th>Loại thú cưng</th>
                    <th>Tên thú cưng</th>
                    <th>Ảnh thú cưng</th>
                    <th>Số điện thoại chủ</th>
                    <th>ID Khách hàng</th>
                    <th>Thao tác</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = mysqli_fetch_assoc($pet)) {
                ?>
                    <tr>
                        <td><?php echo $row['IDpet']; ?></td>
                        <td><?php echo $row['Pet_type']; ?></td>
                        <td><?php echo $row['pet_name']; ?></td>
                        <td><?php echo "<img width=\"100px\" height=\"auto\" src=\"/shop/uploads/" . $row["pet_img"] . "\" alt=\"" . $row["pet_name"] . "\">" ?></td>
                        <td><?php echo $row['PhoneNumber_owner']; ?></td>
                        <td><?php echo $row['IDCustomer']; ?></td>
                       
                        <td>
                            <a href="/pettopia/admin/suapet.php?Proid=<?php echo $row['IDpet']; ?>" class="btn btn-xs btn-primary">Sửa</a>
                            <a href="/pettopia/admin/xoapet.php?Proid=<?php echo $row['IDpet']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Bạn có chắc muốn xóa thú cưng này không?')">Xóa</a>
                        </td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    <?php } ?>
    <ul class="phan-trang">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li><a href='?page=" . $i . "'>" . $i . "</a></li>";
            }
            ?>
        </ul>
</div>
<div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
