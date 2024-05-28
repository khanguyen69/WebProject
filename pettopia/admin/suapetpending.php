<?php
include 'header.php';
require_once 'connect.php';

// Lấy các tham số từ URL
$IDpet = isset($_GET['IDpet']) ? mysqli_real_escape_string($conn, $_GET['IDpet']) : '';
$ID_service = isset($_GET['ID_service']) ? mysqli_real_escape_string($conn, $_GET['ID_service']) : '';
$IDCustomer = isset($_GET['IDCustomer']) ? mysqli_real_escape_string($conn, $_GET['IDCustomer']) : '';
$time_coming = isset($_GET['time_coming']) ? mysqli_real_escape_string($conn, $_GET['time_coming']) : '';

// Lấy dữ liệu từ bảng pet_pending dựa trên các tham số
$sql = "SELECT time_coming, IDpet, healt_status, ID_service, note, IDCustomer, work_status FROM pet_pending 
        WHERE IDpet = '$IDpet' AND ID_service = '$ID_service' AND IDCustomer = '$IDCustomer' AND time_coming = '$time_coming'";
$result = mysqli_query($conn, $sql);
$rowPending = mysqli_fetch_assoc($result);

// Lấy dữ liệu cho các combobox
$customers = mysqli_query($conn, "SELECT IDCustomer, name_customer FROM customer");
$services = mysqli_query($conn, "SELECT ID_service, name_service FROM services");

// Lấy dữ liệu cho dropdown ID thú cưng
$pets = [];
if ($IDCustomer) {
    $petResult = mysqli_query($conn, "SELECT IDpet, pet_name FROM pet WHERE IDCustomer = '$IDCustomer'");
    while ($petRow = mysqli_fetch_assoc($petResult)) {
        $pets[] = $petRow;
    }
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form và sanitize
    $time = mysqli_real_escape_string($conn, $_POST['time_coming']);
    $idpet = mysqli_real_escape_string($conn, $_POST['IDpet']);
    $healt = mysqli_real_escape_string($conn, $_POST['healt_status']);
    $idservice = mysqli_real_escape_string($conn, $_POST['ID_service']);
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $IDCustomer = mysqli_real_escape_string($conn, $_POST['IDCustomer']);
    $work = mysqli_real_escape_string($conn, $_POST['work_status']);

    // Update thông tin pet_pending
    $sql = "UPDATE pet_pending 
            SET time_coming = '$time', IDpet = '$idpet', healt_status = '$healt', ID_service = '$idservice', note = '$note', IDCustomer = '$IDCustomer', work_status = '$work' 
            WHERE IDpet = '$IDpet' AND ID_service = '$ID_service' AND IDCustomer = '$IDCustomer' AND time_coming = '$time_coming'";
    
    if (mysqli_query($conn, $sql)) {
        header('location: petpending.php');
    } else {
        $error = 'Có lỗi khi cập nhật dữ liệu, vui lòng thử lại.';
    }
}
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Chỉnh sửa thông tin tình trạng thú cưng</h3>
    </div>
    <div class="panel-body">
        <form id="petForm" action="" method="POST" role="form">
            <div class="form-group">
                <label for="IDCustomer">ID khách hàng</label>
                <select class="form-control" name="IDCustomer" id="IDCustomer" required>
                    <option value="">Chọn ID khách hàng</option>
                    <?php while($customer = mysqli_fetch_assoc($customers)): ?>
                        <option value="<?php echo $customer['IDCustomer']; ?>" <?php echo $customer['IDCustomer'] == $rowPending['IDCustomer'] ? 'selected' : ''; ?>>
                            <?php echo $customer['IDCustomer'] . ' - ' . $customer['name_customer']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="IDpet">ID thú cưng</label>
                <select class="form-control" name="IDpet" id="IDpet" required>
                    <option value="">Chọn ID thú cưng</option>
                    <?php foreach($pets as $pet): ?>
                        <option value="<?php echo $pet['IDpet']; ?>" <?php echo $pet['IDpet'] == $rowPending['IDpet'] ? 'selected' : ''; ?>>
                            <?php echo $pet['IDpet'] . ' - ' . $pet['pet_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="ID_service">ID dịch vụ</label>
                <select class="form-control" name="ID_service" id="ID_service" required>
                    <option value="">Chọn ID dịch vụ</option>
                    <?php while($service = mysqli_fetch_assoc($services)): ?>
                        <option value="<?php echo $service['ID_service']; ?>" <?php echo $service['ID_service'] == $rowPending['ID_service'] ? 'selected' : ''; ?>>
                            <?php echo $service['ID_service'] . ' - ' . $service['name_service']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="time_coming">Thời gian đến</label>
                <input type="datetime-local" class="form-control" name="time_coming" id="time_coming" value="<?php echo isset($rowPending['time_coming']) ? $rowPending['time_coming'] : ''; ?>" required>
                <div id="timeError" style="color: red; font-size: 1em; display: none;">Thời gian không hợp lệ.</div>
            </div>
            <div class="form-group">
                <label for="healt_status">Tình trạng sức khỏe</label>
                <input type="text" class="form-control" name="healt_status" id="healt_status" value="<?php echo isset($rowPending['healt_status']) ? $rowPending['healt_status'] : ''; ?>" placeholder="Nhập tình trạng sức khỏe" required>
            </div>
            <div class="form-group">
                <label for="note">Ghi chú</label>
                <input type="text" class="form-control" name="note" id="note" value="<?php echo isset($rowPending['note']) ? $rowPending['note'] : ''; ?>" placeholder="Nhập ghi chú">
            </div>
            <div class="form-group">
                <label for="work_status">Tình trạng</label>
                <select class="form-control" name="work_status" id="work_status" required>
                    <option value="">Chọn tình trạng</option>
                    <option value="Đang tại shop" <?php echo $rowPending['work_status'] == 'Đang tại shop' ? 'selected' : ''; ?>>Đang tại shop</option>
                    <option value="Đã xong" <?php echo $rowPending['work_status'] == 'Đã xong' ? 'selected' : ''; ?>>Đã xong</option>
                    <option value="Chưa đến" <?php echo $rowPending['work_status'] == 'Chưa đến' ? 'selected' : ''; ?>>Chưa đến</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Lưu lại</button>
        </form>
        <?php
        if ($error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
    </div>
</div>
<div class="duoi">
    <?php require_once 'footer.php' ?>
</div>

<script>
    document.getElementById('IDCustomer').addEventListener('change', function() {
    var customerId = this.value;
    var idPetSelect = document.getElementById('IDpet');
    idPetSelect.innerHTML = '<option value="">Chọn ID thú cưng</option>';

    if (customerId) {
        fetch('/shop/backend/fetch_pets.php?IDCustomer=' + customerId)
            .then(response => response.json())
            .then(data => {
                data.forEach(pet => {
                    var option = document.createElement('option');
                    option.value = pet.IDpet;
                    option.textContent = pet.IDpet + ' - ' + pet.pet_name;
                    idPetSelect.appendChild(option);
                });
            });
    }
});


// Function to show error message
function showError(message) {
    var errorDiv = document.getElementById('timeError');
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
    setTimeout(function() {
        errorDiv.style.display = 'none';
    }, 3000);
}

// Function to validate form
function validateForm(event) {
    var workStatus = document.getElementById('work_status').value;
    var timeComingInput = document.getElementById('time_coming');
    var timeComingValue = new Date(timeComingInput.value);
    var currentTime = new Date();
    currentTime.setMinutes(currentTime.getMinutes() - currentTime.getTimezoneOffset());  // Adjust for timezone

    if (workStatus === 'Chưa đến') {
        var minTime = new Date(currentTime.getTime() - 7 * 60 * 60 * 1000);
        if (timeComingValue < minTime) {
            showError('Thời gian đến phải lớn hơn thời gian hiện tại.');
            event.preventDefault();  // Prevent form submission
        }
    } else if (workStatus === 'Đang tại shop' || workStatus === 'Đã xong') {
        var maxTime = new Date(currentTime.getTime() - 7 * 60 * 60 * 1000);
        if (timeComingValue > maxTime) {
            showError('Thời gian đến phải nhỏ hơn hoặc bằng thời gian hiện tại.');
            event.preventDefault();  // Prevent form submission
        }
    }
}

document.getElementById('petForm').addEventListener('submit', validateForm);
</script>
</script>

