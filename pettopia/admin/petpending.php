<?php
include 'header.php';
require_once 'connect.php';

$page = 1; // Default page
if (isset($_GET["page"]) && is_numeric($_GET["page"])) {
    $page = intval($_GET["page"]);
}

$limit = 6; // Entries per page

// Calculate offset
$offset = ($page - 1) * $limit;

// Query to get total number of pets pending
$sql = "SELECT CEIL(COUNT(*) / $limit) AS totalpage FROM `pet_pending`";
$result = mysqli_query($conn, $sql);

$totalpage = 0;
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $totalpage = $row["totalpage"];
}

// Query to fetch pets pending for the current page
$sql = "SELECT pet_pending.IDpet, pet_pending.time_coming, pet_pending.healt_status, pet_pending.ID_service, pet_pending.note, pet_pending.IDCustomer, pet_pending.work_status, customer.Name_customer 
        FROM pet_pending 
        INNER JOIN customer ON pet_pending.IDCustomer = customer.IDCustomer 
        LIMIT $offset, $limit";

$result = mysqli_query($conn, $sql);

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
        <h3 class="panel-title">Danh sách chủ thú cưng</h3>
    </div>
    <?php
    // Display pet list and pagination
    if (mysqli_num_rows($result) > 0) {
    ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID thú cưng</th>
                    <th>Thời gian đến</th>
                    <th>Tình trạng sức khỏe</th>
                    <th>ID dịch vụ</th>
                    <th>Ghi chú của nhân viên</th>
                    <th>ID khách hàng</th>
                    <th>Tình trạng</th>
                    <th><a href="thempetpending.php" class="btn btn-primary btn-lg">Thêm thú cưng</a></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo $row['IDpet']; ?></td>
                        <td><?php echo $row['time_coming']; ?></td>
                        <td><?php echo $row['healt_status']; ?></td>
                        <td><?php echo $row['ID_service']; ?></td>
                        <td><?php echo $row['note']; ?></td>
                        <td><?php echo $row['IDCustomer']; ?></td>
                        <td><?php echo $row['work_status']; ?></td>
                        <td>
                            <a href="suapetpending.php?IDpet=<?php echo $row['IDpet']; ?>" class="btn btn-xs btn-primary">Sửa</a>
                            <a href="xoapetpending.php?IDpet=<?php echo $row['IDpet']; ?>" class="btn btn-xs btn-danger">Xóa</a>
                        </td>
                    </tr>
                    
                <?php }; ?>
            </tbody>
        </table>
    <?php 
    } else {
        echo "<p>No pets pending.</p>";
        echo "<a href=thempetpending.php class=btn btn-primary btn-lg>Thêm thú cưng</a>";
    }
    ?>
    <ul class="phan-trang">
        <?php
        // Pagination links
        for ($i = 1; $i <= $totalpage; $i++) {
            echo "<li><a href='?page=$i'>$i</a></li>";
        }
        ?>
    </ul>
</div>
<div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
