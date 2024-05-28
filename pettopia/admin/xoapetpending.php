<?php
include 'header.php';
require_once 'connect.php';

// Lấy các tham số từ URL
$id_pet = !empty($_GET['IDpet']) ? $_GET['IDpet'] : '';
$id_service = !empty($_GET['ID_service']) ? $_GET['ID_service'] : '';
$id_customer = !empty($_GET['IDCustomer']) ? $_GET['IDCustomer'] : '';
$time_coming = !empty($_GET['time_coming']) ? $_GET['time_coming'] : '';

// Kiểm tra các tham số có đầy đủ không
if ($id_pet && $id_service && $id_customer && $time_coming) {
    // Thực hiện câu lệnh DELETE
    $sql = "DELETE FROM pet_pending 
            WHERE IDpet = ? AND ID_service = ? AND IDCustomer = ? AND time_coming = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'siss', $id_pet, $id_service, $id_customer, $time_coming);
    $deleted = mysqli_stmt_execute($stmt);

    if ($deleted) {
        header('location: petpending.php');
    } else {
        echo 'Có lỗi, vui lòng kiểm tra lại';
    }
} else {
    echo 'Thiếu tham số, không thể xóa.';
}
?>
