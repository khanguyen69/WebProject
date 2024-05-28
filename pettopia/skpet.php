<?php
include 'dieuhuong.php';
require_once 'ketnoi.php';

$page = 1; // Mặc định trang đầu tiên là trang 1
if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
    $page = intval($_GET["page"]);
}

$limit = 10;
$offset = ($page - 1) * $limit;

// Calculate total pages
$sql = "SELECT CEIL(COUNT(*) / $limit) AS totalpage FROM `pet_pending` WHERE work_status = 'Đang tại shop'";
$result = mysqli_query($conn, $sql);

$totalpage = 0;
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalpage = $row["totalpage"];
}

// Retrieve data for current page
$sql = "SELECT customer.Name_customer, pet.pet_name, services.name_service, pet_pending.time_coming, pet_pending.healt_status, pet_pending.note, pet_pending.work_status 
        FROM pet_pending 
        INNER JOIN customer ON pet_pending.IDCustomer = customer.IDCustomer 
        INNER JOIN pet ON pet_pending.IDpet = pet.IDpet 
        INNER JOIN services ON pet_pending.ID_service = services.ID_service 
        WHERE pet_pending.work_status = 'Đang tại shop' 
        LIMIT $offset, $limit";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Petopia - Thiên đường cho thú cưng</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
    <?php
    if (mysqli_num_rows($result) > 0) {
    ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Tên khách hàng</th>
                    <th>Tên thú cưng</th>
                    <th>Tên dịch vụ</th>
                    <th>Thời gian đến</th>
                    <th>Tình trạng sức khỏe</th>
                    <th>Ghi chú của nhân viên</th>
                    <th>Tình trạng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $row['Name_customer']; ?></td>
                        <td><?php echo $row['pet_name']; ?></td>
                        <td><?php echo $row['name_service']; ?></td>
                        <td><?php echo $row['time_coming']; ?></td>
                        <td><?php echo $row['healt_status']; ?></td>
                        <td><?php echo $row['note']; ?></td>
                        <td><?php echo $row['work_status']; ?></td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Không có dữ liệu.</p>
    <?php } ?>
    <ul class="phan-trang">
        <?php
        for ($i = 1; $i <= $totalpage; $i++) {
            $active_class = ($i == $page) ? 'class="active"' : '';
            echo "<li><a href='?page=$i' $active_class>$i</a></li>";
        }
        ?>
    </ul>
</div>

<div class="duoi">
    <?php require_once 'footer.php' ?>
</div>
</body>
</html>
