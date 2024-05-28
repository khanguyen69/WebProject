<?php
require_once 'connect.php';

if (isset($_GET['IDCustomer'])) {
    $IDCustomer = mysqli_real_escape_string($conn, $_GET['IDCustomer']);
    $sql_pets = "SELECT IDpet, pet_name FROM pet WHERE IDCustomer = '$IDCustomer'";
    $result_pets = mysqli_query($conn, $sql_pets);

    $pets = [];
    while ($row_pets = mysqli_fetch_assoc($result_pets)) {
        $pets[] = $row_pets;
    }

    echo json_encode($pets);
}
?>
