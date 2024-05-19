<?php
include 'header.php';
require_once 'connect.php';

// Get the ID from the query string
$id = !empty($_GET['IDpet']) ? (int)$_GET['IDpet'] : 0;

// Retrieve pet_pending data based on the ID
$result = mysqli_query($conn, "SELECT time_coming, IDpet, healt_status, ID_service, note, IDCustomer, work_status FROM pet_pending WHERE IDpet = $id");
$rowPending = mysqli_fetch_assoc($result);

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the posted data
    $time = $_POST['time_coming'];
    $idpet = $_POST['IDpet'];
    $healt = $_POST['healt_status'];
    $idservice = $_POST['ID_service'];
    $note = $_POST['note'];
    $IDCustomer = $_POST['IDCustomer'];
    $work = $_POST['work_status'];

    // $time = mysqli_real_escape_string($conn, $_POST['time_coming']);
    // $idpet = mysqli_real_escape_string($conn, $_POST['IDpet']);
    // $healt = mysqli_real_escape_string($conn, $_POST['healt_status']);
    // $idservice = mysqli_real_escape_string($conn, $_POST['ID_service']);
    // $note = mysqli_real_escape_string($conn, $_POST['note']);
    // $IDCustomer = mysqli_real_escape_string($conn, $_POST['IDCustomer']);
    // $work = mysqli_real_escape_string($conn, $_POST['work_status']);

    // Update the pet_pending information
    $sql = "UPDATE pet_pending SET time_coming = '$time', IDpet = '$idpet', healt_status = '$healt', ID_service = '$idservice', note = '$note', IDCustomer = '$IDCustomer', work_status = '$work' WHERE IDpet = $id";
    
    if (mysqli_query($conn, $sql)) {
        header('location: petpending.php');
    } else {
        // If there's an error, display the error message
        $error = 'Có lỗi khi cập nhật dữ liệu, vui lòng thử lại.';
    }
}
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Chỉnh sửa thông tin tình trạng thú cưng</h3>
    </div>
    <div class="panel-body">
        <form action="" method="POST" role="form">
            <div class="form-group">
                <label for="">Thời gian đến</label>
                <input type="datetime-local" class="form-control" name="time_coming" value="<?php echo isset($rowPending['time_coming']) ? $rowPending['time_coming'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="">ID thú cưng</label>
                <input type="text" class="form-control" name="IDpet" value="<?php echo isset($rowPending['IDpet']) ? $rowPending['IDpet'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="">Tình trạng sức khỏe</label>
                <input type="text" class="form-control" name="healt_status" value="<?php echo isset($rowPending['healt_status']) ? $rowPending['healt_status'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="">ID dịch vụ</label>
                <input type="text" class="form-control" name="ID_service" value="<?php echo isset($rowPending['ID_service']) ? $rowPending['ID_service'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="">Ghi chú</label>
                <input type="text" class="form-control" name="note" value="<?php echo isset($rowPending['note']) ? $rowPending['note'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="">ID khách hàng</label>
                <input type="text" class="form-control" name="IDCustomer" value="<?php echo isset($rowPending['IDCustomer']) ? $rowPending['IDCustomer'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="">Tình trạng công việc</label>
                <input type="text" class="form-control" name="work_status" value="<?php echo isset($rowPending['work_status']) ? $rowPending['work_status'] : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </form>
        <?php
        // Display error message if there's any
        if ($error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
    </div>
</div>
<div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
