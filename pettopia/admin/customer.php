<?php
include 'header.php';
require_once 'connect.php';

// Handle search for customer information
if(isset($_POST['search_customer'])) {
    $search_term = $_POST['search_term'];
    // Query to search for customer information
    $search_query = "SELECT * FROM customer WHERE Name_customer LIKE '%$search_term%' OR PhoneNumber LIKE '%$search_term%' OR email LIKE '%$search_term%'";
    $customers = mysqli_query($conn, $search_query);
} else {
    // If no search term is provided, fetch all customers
    $sql = "SELECT IDCustomer, Name_customer, DateOfBirth, Diachi, PhoneNumber, email FROM customer";
    $customers = mysqli_query($conn, $sql);
}

// Pagination
$rows_per_page = 10; // Number of records to display per page
$total_rows = mysqli_num_rows($customers);
$total_pages = ceil($total_rows / $rows_per_page);

// Check current page number
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_index = ($current_page - 1) * $rows_per_page;

// Modify the SQL query to include LIMIT
if(isset($_POST['search_customer'])) {
    $search_query = "SELECT * FROM customer WHERE Name_customer LIKE '%$search_term%' OR PhoneNumber LIKE '%$search_term%' OR email LIKE '%$search_term%' LIMIT $start_index, $rows_per_page";
    $customers = mysqli_query($conn, $search_query);
} else {
    $sql .= " LIMIT $start_index, $rows_per_page";
    $customers = mysqli_query($conn, $sql);
}

?>
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
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Danh sách khách hàng</h3>
    </div>
    <div class="panel-body">
        <form method="POST" action="">
            <div class="form-group">
                <label for="search_term">Tìm kiếm khách hàng:</label>
                <input type="text" name="search_term" id="search_term" class="form-control" placeholder="Nhập tên hoặc số điện thoại hoặc email">
            </div>
            <button type="submit" name="search_customer" class="btn btn-primary">Tìm kiếm</button>
            <th><a href="/shop/backend/themcustomer.php" class="btn btn-primary btn-sm">Thêm khách hàng</a></th>
        </form>
    </div>
    <?php
    if(mysqli_num_rows($customers) > 0) {
        ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID khách hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày sinh</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                // Loop through customer data
                while ($row = mysqli_fetch_assoc($customers)) {
                    ?>
                    <tr>
                        <td><?php echo $row['IDCustomer']; ?></td>
                        <td><?php echo $row['Name_customer']; ?></td>
                        <td><?php echo $row['DateOfBirth']; ?></td>
                        <td><?php echo $row['Diachi']; ?></td>
                        <td><?php echo $row['PhoneNumber']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td>
                            <a href="/shop/backend/suacustomer.php?IDCustomer=<?php echo $row['IDCustomer']; ?>" class="btn btn-xs btn-primary">Sửa</a>
                            <!-- <a href="/shop/backend/xoacustomer.php?IDCustomer=<?php echo $row['IDCustomer']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Bạn có chắc muốn xóa khách hàng này không?')">Xóa</a> -->
                        </td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    <?php 
    } else {
        echo "<p>Không tìm thấy khách hàng nào.</p>";
    }
    ?>
    <ul class="phan-trang">
    <?php
    // Generate pagination links
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<li><a href='?page=" . $i . "'> " . $i . "</a></li>";
    }
    ?>
    </ul>
</div>
<div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>