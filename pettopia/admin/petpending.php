<?php
include 'header.php';
require_once 'connect.php';

$page = 1;
if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
    $page = intval($_GET["page"]);
}

$limit = 10;
$offset = ($page - 1) * $limit;

// Calculate total pages
$sql = "SELECT CEIL(COUNT(*) / $limit) AS totalpage FROM `pet_pending`";
$result = mysqli_query($conn, $sql);

$totalpage = 0;
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalpage = $row["totalpage"];
}

// Retrieve transactions based on selected status
$status = isset($_GET['status']) ? $_GET['status'] : '';

if ($status == 'Toàn bộ') {
    $sql = "SELECT pet_pending.IDpet, pet_pending.time_coming, pet_pending.healt_status, pet_pending.ID_service, pet_pending.note, pet_pending.IDCustomer, pet_pending.work_status, customer.Name_customer 
            FROM pet_pending 
            INNER JOIN customer ON pet_pending.IDCustomer = customer.IDCustomer 
            LIMIT $offset, $limit";
} elseif ($status == 'Đang tại shop' || $status == 'Đã xong' || $status == 'Chưa đến') {
    $sql = "SELECT pet_pending.IDpet, pet_pending.time_coming, pet_pending.healt_status, pet_pending.ID_service, pet_pending.note, pet_pending.IDCustomer, pet_pending.work_status, customer.Name_customer 
            FROM pet_pending 
            INNER JOIN customer ON pet_pending.IDCustomer = customer.IDCustomer 
            WHERE LOWER(pet_pending.work_status) = LOWER('$status')
            LIMIT $offset, $limit";
} else {
    // Default query for unknown status
    $sql = "SELECT pet_pending.IDpet, pet_pending.time_coming, pet_pending.healt_status, pet_pending.ID_service, pet_pending.note, pet_pending.IDCustomer, pet_pending.work_status, customer.Name_customer 
            FROM pet_pending 
            INNER JOIN customer ON pet_pending.IDCustomer = customer.IDCustomer 
            LIMIT $offset, $limit";
}

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý hóa đơn</title>
    <style>
        #status {
            padding: 8px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 8px 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
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
        <h3 class="panel-title">Danh sách thú cưng tại shop</h3>
    </div>
    <!-- Combo box for status selection -->
    <form action="" method="GET" style="margin-top:10px;margin-bottom:10px;">
        <label for="status">Tình trạng:</label>
        <select name="status" id="status">
            <option value="Toàn bộ" <?php if($status == 'Toàn bộ') echo 'selected'; ?>>Toàn bộ</option>
            <option value="Đang tại shop" <?php if($status == 'Đang tại shop') echo 'selected'; ?>>Đang tại shop</option>
            <option value="Đã xong" <?php if($status == 'Đã xong') echo 'selected'; ?>>Đã xong</option>
            <option value="Chưa đến" <?php if($status == 'Chưa đến') echo 'selected'; ?>>Chưa đến</option>            
        </select>
        <input type="submit" value="Lọc">
    </form>
    <?php
    if (mysqli_num_rows($result) > 0) {
    ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID khách hàng</th>
                    <th>ID thú cưng</th>
                    <th>ID dịch vụ</th>
                    <th>Thời gian đến</th>
                    <th>Tình trạng sức khỏe</th>
                    <th>Ghi chú của nhân viên</th>
                    <th>Tình trạng</th>
                    <th><a href="testpending.php" class="btn btn-primary btn-lg" style="font-size:15px;">Thêm thú cưng</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $row['IDCustomer']; ?></td>
                        <td><?php echo $row['IDpet']; ?></td>
                        <td><?php echo $row['ID_service']; ?></td>
                        <td><?php echo $row['time_coming']; ?></td>
                        <td><?php echo $row['healt_status']; ?></td>
                        <td><?php echo $row['note']; ?></td>
                        <td><?php echo $row['work_status']; ?></td>
                        <td>
                        <a href="suapetpending.php?IDpet=<?php echo $row['IDpet']; ?>&ID_service=<?php echo $row['ID_service']; ?>&IDCustomer=<?php echo $row['IDCustomer']; ?>&time_coming=<?php echo $row['time_coming']; ?>" class="btn btn-xs btn-primary">Sửa</a>
                        <a href="xoapetpending.php?IDpet=<?php echo $row['IDpet']; ?>&ID_service=<?php echo $row['ID_service']; ?>&IDCustomer=<?php echo $row['IDCustomer']; ?>&time_coming=<?php echo $row['time_coming']; ?>" class="btn btn-xs btn-danger">Xóa</a>
                        </td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    <?php
    } else {
        echo "<p>Không có thú cưng đang chờ.</p>";
    }
    ?>
    <ul class="phan-trang">
        <?php
        for ($i = 1; $i <= $totalpage; $i++) {
            $active_class = ($i == $page) ? 'class="active"' : '';
            echo "<li><a href='?page=$i&status=$status' $active_class>$i</a></li>";
        }
        ?>
    </ul>
</div>
<div class="duoi">
    <?php require_once 'footer.php' ?>
</div>
</body>
</html>
