<?php
include 'dieuhuong.php';
require_once 'ketnoi.php';

$sql = "SELECT pet_pending.IDpet, pet_pending.time_coming, pet_pending.healt_status, pet_pending.ID_service, pet_pending.note, pet_pending.IDCustomer, pet_pending.work_status, customer.Name_customer FROM pet_pending INNER JOIN customer ON pet_pending.IDCustomer = customer.IDCustomer";
$pet_owners = mysqli_query($conn, $sql);

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
        <h3 class="panel-title">Danh sách thú cưng tại shop</h3>
    </div>
    <?php
    $page = 0;
    if (isset($_GET["page"])) {
        $page = $_GET["page"] - 1;
    }

    $sql = "SELECT CEIL((SELECT COUNT(*) FROM `pet_pending`) / 6) AS totalpage";
    $result = mysqli_query($conn, $sql);
    $totalpage = 0;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $totalpage = $row["totalpage"];
        }
    }

    $offset = $page * $totalpage;

    $sql = "SELECT pet_pending.IDpet, pet_pending.time_coming, pet_pending.healt_status, pet_pending.ID_service, pet_pending.note, pet_pending.IDCustomer, pet_pending.work_status, customer.Name_customer FROM pet_pending INNER JOIN customer ON pet_pending.IDCustomer = customer.IDCustomer LIMIT " . $offset . ", 6";

    $result = mysqli_query($conn, $sql);

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
                    
                    </tr>
                    
                <?php }; ?>
            </tbody>
        </table>
    <?php }; ?>
    <ul class="phan-trang">
            <?php
            for ($i = 1; $i <= $totalpage; $i++) {
                echo "<li><a href='?page=" . $i . "'>" . $i . "</a></li>";
            }
            ?>
            
        </ul>
        <div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
</div>

