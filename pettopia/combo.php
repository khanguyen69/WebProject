<?php
include 'dieuhuong.php';
require_once 'ketnoi.php';

// Khởi tạo mảng để lưu trữ ID_service đã chọn
$selected_services = [];

// Nếu có ID_service được gửi từ form, thêm chúng vào mảng
if (isset($_GET['id'])) {
    $selected_services = $_GET['id'];
}

// Fetch combo packages from the database
$sql = "SELECT s.ID_service, s.name_service, s.price_service, s.minute_serving FROM services AS s";
$services_result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combo</title>
    <style>
        .container {
            width: 80%;
            margin: 0 auto;
            padding-top: 50px;
        }
        /* .header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 50px;
            font-size: 25px;
            color: #626a67;
            text-transform: uppercase;
        } */
        .service-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }
        .service-box {
            width: 45%;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #ebebeb;
            border-radius: 5px;
            padding: 0;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s ease, background 0.3s ease;
            background-image: url('https://img.freepik.com/free-vector/flat-design-black-white-halftone-background_23-2150607369.jpg');
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }
        .service-box:hover {
            box-shadow: 20px 20px 20px rgba(0, 0, 0, 0.2);
        }
        .service-box-header {
            padding: 20px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .service-box-header:nth-child(1) {
            background-color: #67c23a;
        }
        .service-box-header:nth-child(2) {
            background-color: #ff4d7d;
        }
        .service-box-header:nth-child(3) {
            background-color: #6a5acd;
        }
        .service-box-header:nth-child(4) {
            background-color: #ff8c00; /* Màu thứ tư bạn tự chọn */
        }
        .service-box-header h3 {
            margin: 0;
            font-size: 30px;
            color: #fff;
        }
        .service-box-body {
            font-size: 20px;
            padding: 20px;
        }
        .service-box-footer {
            background-color: #ADD8E6; 
            padding: 10px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .service-box-footer button {
            background-color: #fff;
            color: #000; 
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            text-transform: uppercase;
        }
        .service-box-footer button:hover {
            background-color: #000;
            color: #fff;
        }
    </style>
</head>
<body>
    <div style="text-align: center;margin-top: 20px;margin-bottom:10px; font-size:25px;color:#626a67;text-transform: uppercase;">
        <h2>Các gói dịch vụ </h2>
    </div>
    <div class="container">
        <div class="service-grid">
            <?php 
            $services = [
                1 => "Dịch vụ làm đẹp cho thú cưng của bạn một vẻ ngoài lộng lẫy với các dịch vụ chuyên nghiệp.",
                2 => "Dịch vụ tiêm phòng vắc xin để bảo vệ thú cưng khỏi các bệnh truyền nhiễm.",
                3 => "Dịch vụ chăm sóc toàn diện, đảm bảo sức khỏe và hạnh phúc cho thú cưng của bạn.",
                4 => "Dịch vụ cung cấp thức ăn chất lượng cao, đầy đủ dinh dưỡng cho thú cưng."
            ];
            $colors = ['#67c23a', '#ff4d7d', '#6a5acd', '#ff8c00']; // Các màu sắc khác nhau cho các gói dịch vụ
            $i = 1;
            while ($service_row = mysqli_fetch_assoc($services_result)) { ?>
                <div class="service-box">
                    <div class="service-box-header" style="background-color: <?php echo $colors[$i - 1]; ?>;">
                        <h3><?php echo $service_row['name_service']; ?></h3>
                    </div>
                    <div class="service-box-body">
                        <p>Thời gian phục vụ: <?php echo $service_row['minute_serving']; ?> phút</p>
                        <div class="description"><?php echo $services[$i]; ?></div>
                        <div class="price">Giá: <?php echo number_format($service_row['price_service'], 0, ',', '.'); ?> VND</div>
                    </div>
                    <div class="service-box-footer">
                        <!-- Form để gửi ID_service -->
                        <form action="combo.php" method="GET">
                            <!-- Sử dụng [] trong tên để gửi nhiều ID_service -->
                            <input type="hidden" name="id[]" value="<?php echo $service_row['ID_service']; ?>">
                            <button type="submit">Thêm vào giỏ hàng</button>
                        </form>
                    </div>
                </div>
            <?php 
            $i++;
            } ?>
            <!-- Nút thanh toán dẫn đến trang pay.php -->
            <div class="service-box-footer">
                <form action="pay.php" method="GET">
                    <?php 
                    // Lặp qua các ID_service đã chọn và thêm vào form
                    foreach ($selected_services as $service_id) { ?>
                        <input type="hidden" name="id[]" value="<?php echo $service_id; ?>">
                    <?php } ?>
                    <button type="submit">Thanh toán</button>
                </form>
            </div>
        </div>
    </div>
    <br/><br/><br/>
    <div class="duoi">
        <?php require_once 'footer.php' ?>
    </div>
    <script>
        function addToCart(serviceId) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var cartContent = this.responseText;
                    var cartElement = document.getElementById("cart");
                    cartElement.innerHTML += cartContent;
                }
            };
            xhttp.open("GET", "cart.php?id=" + serviceId, true);
            xhttp.send();
        }
    </script>
</body>
</html>
