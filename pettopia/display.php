<?php
// Include necessary files
include 'dieuhuong.php';
require_once 'ketnoi.php';

// Query to fetch all feedbacks
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
";
$result_feedback = mysqli_query($conn, $query_feedback);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback List</title>
    <link rel="stylesheet" href="path_to_your_css_file.css">
</head>
<body>
    <div class="container">
        <h3 class="panel-title">Các đánh giá trước:</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tên khách hàng</th>
                    <th>Dịch vụ</th>
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
                        echo "<td>" . htmlspecialchars($row['name_service']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['point_feedback']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['comment_feedback']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Không có đánh giá nào</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="duoi">
        <?php require_once 'footer.php' ?>
    </div>
</body>
</html>
