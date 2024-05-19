<?php
include 'header.php';
require_once 'connect.php';
// lấy id trên tham số url đã gửi tù nút xóa
$id = !empty($_GET['IDpet']) ? (int)$_GET['IDpet'] : 0;
$deleted = mysqli_query($conn, "DELETE FROM pet WHERE IDpet = $id");
if ($deleted) {
    header('location: petshop.php');
} else {
    echo 'Có lỗi, vui lòng kiểm tra lại';
}
?>