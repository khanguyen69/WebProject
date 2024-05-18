<?php require_once 'header.php';
require_once 'connect.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Quản lý hóa đơn</title>
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
    <!-- Header -->
    <header></header>

    <?php
    $page = 0;
    if (isset($_GET["page"])) {
        $page = $_GET["page"] - 1;
    }

    // Calculate total pages
    $sql = "SELECT CEIL(COUNT(*) / 12) AS totalpage FROM history_transaction";
    $result = mysqli_query($conn, $sql);
    $totalpage = 0;
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $totalpage = $row["totalpage"];
    }

    // Calculate OFFSET
    $sql = "SELECT " . $page . " * (COUNT(*) / CEIL(COUNT(*) / 12)) AS offset FROM history_transaction";
    $result = mysqli_query($conn, $sql);
    $offset = 0;
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $offset = (int)$row["offset"];
    }

    // Retrieve transactions for current page
    $sql = "SELECT * FROM history_transaction LIMIT " . $offset . ", 12";
    $result = mysqli_query($conn, $sql);

    // Display pagination
    if (mysqli_num_rows($result) > 0) {
    ?>
        <ul class="phan-trang">
            <?php
            for ($i = 1; $i <= $totalpage; $i++) {
                echo "<li><a href='?page=" . $i . "'>" . $i . "</a></li>";
            }
            ?>
        </ul>

        <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">Lịch sử dịch vụ Khách hàng</h3>
        </div>
        <table class="table table-bordered table-hover">
            <thead>

                <tr>
                    <th>ID giao dịch</th>
                    <th>ID khách hàng</th>
                    <th>ID dịch vụ</th>
                    <th>ID thú cưng</th>
                    <th>Thời gian giao dịch</th>
                    <th>Tổng giá tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $row['IDtrans']; ?></td>
                        <td><?php echo $row['IDCustomer']; ?></td>
                        <td><?php echo $row['ID_service']; ?></td>
                        <td><?php echo $row['IDpet']; ?></td>
                        <td><?php echo $row['time_trans']; ?></td>
                        <td><?php echo number_format($row['total_price']); ?></td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    <?php } ?>

    <!-- Footer -->
    <footer style="height: 50px; min-height: 50px; line-height: 50px; text-align: center">
        
    </footer>
    <div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
</body>

</html>
