<?php
require_once 'ketnoi.php';

if (isset($_GET['phone'])) {
    $phone = mysqli_real_escape_string($conn, $_GET['phone']);

    $query = "SELECT IDpet, pet_name FROM pet WHERE PhoneNumber_owner = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $options = '<option value="">Chọn tên thú cưng</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        $options .= "<option value='{$row['IDpet']}'>{$row['pet_name']}</option>";
    }

    echo $options;
}
?>
