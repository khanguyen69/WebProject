<?php
// nếu gặp lỗi khi kết nối cở sơ dữ liệu hãy check đúng tên database 
$conn = mysqli_connect('localhost', 'root', '', 'petshop1'); // database Name

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Hàm định dạng tiền tệ
function formatCurrency($curr)
{
    return number_format($curr, 0, ',', '.') . ' VND';
}

// Hàm định dạng số
function formatNumber($num, $decimal)
{
    return number_format($num, $decimal, ',', '.');
}
?>
