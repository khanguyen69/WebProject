<?php
include 'dieuhuong.php';
require_once 'ketnoi.php';

if (isset($_GET['service_id'])) {
    $serviceID = $_GET['service_id'];
    
    $query_service_name = "SELECT name_service FROM services WHERE ID_service = $serviceID";
    $result_service_name = mysqli_query($conn, $query_service_name);
    $row_service_name = mysqli_fetch_assoc($result_service_name);
    $service_name = $row_service_name['name_service'];

    $query_feedback = "
        SELECT 
            hf.IDCustomer, 
            c.Name_customer, 
            hf.ID_service, 
            s.name_service, 
            hf.point_feedback, 
            hf.comment_feedback 
        FROM 
            history_feedback hf
        JOIN 
            customer c ON hf.IDCustomer = c.IDCustomer
        JOIN 
            services s ON hf.ID_service = s.ID_service
        WHERE 
            hf.ID_service = $serviceID
    ";
    $result_feedback = mysqli_query($conn, $query_feedback);
} else {
    header("Location: display.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đánh giá dịch vụ</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        .star-rating {
            color: gold;
        }
        .empty-star {
            color: black;
        }
    </style>
</head>
<body>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Đánh giá cho dịch vụ <?php echo htmlspecialchars($service_name); ?></h3>
            </div>
            <div class="panel-body">
                <a href="display.php" class="btn btn-success" style="margin-bottom: 15px;"><i class="glyphicon glyphicon-arrow-left"></i> Quay lại</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tên khách hàng</th>
                            <th>Đánh giá</th>
                            <th>Nhận xét</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result_feedback) > 0) {
                            while ($row = mysqli_fetch_assoc($result_feedback)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['Name_customer']) . "</td>";
                                echo "<td>";
                                $rating = intval($row['point_feedback']);
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo "<span class='glyphicon glyphicon-star star-rating'></span>";
                                    } else {
                                        echo "<span class='glyphicon glyphicon-star-empty empty-star'></span>";
                                    }
                                }
                                echo " (" . htmlspecialchars($row['point_feedback']) . ")";
                                echo "</td>";
                                echo "<td>" . htmlspecialchars($row['comment_feedback']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>Không có đánh giá nào cho dịch vụ này</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div >
            <?php require_once 'footer.php' ?>
        </div>
</body>
</html>
