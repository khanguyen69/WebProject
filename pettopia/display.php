<?php
include 'dieuhuong.php';
require_once 'ketnoi.php';

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

function calculateAverageRating($serviceID, $conn)
{
    $query = "SELECT AVG(point_feedback) AS avg_rating FROM history_feedback WHERE ID_service = $serviceID";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return round($row['avg_rating'], 2);
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
        .half-star {
            position: relative;
            display: inline-block;
            color: black;
        }
        .half-star::before {
            content: "\2605"; 
            position: absolute;
            clip: rect(0, 0.43em, 1.2em, 0);
            color: gold;
        }
    </style>
</head>
<body>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Các đánh giá trước</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Dịch vụ</th>
                            <th>Đánh giá trung bình</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $previousServiceName = ''; 
                        if (mysqli_num_rows($result_feedback) > 0) {
                            while ($row = mysqli_fetch_assoc($result_feedback)) {
                                $serviceID = $row['ID_service'];
                                $serviceName = $row['name_service'];
                                $averageRating = calculateAverageRating($serviceID, $conn);
                                
                                if ($serviceName != $previousServiceName) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($serviceName) . "</td>";
                                    echo "<td>";
                                    
                                    $fullStars = floor($averageRating);
                                    $halfStar = $averageRating - $fullStars;
                                    $emptyStars = 5 - ceil($averageRating);
                                    
                                    for ($i = 0; $i < $fullStars; $i++) {
                                        echo "<span style='color: gold;'>&#9733;</span>";
                                    }
                                    
                                    if ($halfStar > 0 && $halfStar < 1) {
                                        echo "<span class='half-star'>&#9733;</span>";
                                    }
                                    
                                    for ($i = 0; $i < $emptyStars; $i++) {
                                        echo "<span style='color: black;'>&#9733;</span>";
                                    }
                                    
                                    echo " ($averageRating)";
                                    
                                    echo "</td>";
                                    echo "<td class='text-right'>";
                                    echo "<a href='chitiet.php?service_id=$serviceID' class='btn btn-info btn-sm'>Chi tiết hơn</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                    
                                    $previousServiceName = $serviceName; 
                                }
                            }
                        } else {
                            echo "<tr><td colspan='3'>Không có đánh giá nào</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div >
            <?php require_once 'footer.php' ?>
        </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>
</html>
