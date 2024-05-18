<?php
include 'header.php';
require_once 'connect.php';
require_once 'uploadfiles.php';

$id = !empty($_GET['Proid']) ? (int)$_GET['Proid'] : 0;
$result = mysqli_query($conn, "SELECT p.IDpet, p.Pet_type, p.pet_name, p.pet_img, p.PhoneNumber_owner, p.IDCustomer 
                    FROM pet p WHERE p.IDpet = $id");
$rowPet = mysqli_fetch_assoc($result);

$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pet_type = $_POST['Pet_type'];
    $pet_name = $_POST['pet_name'];
    $phone_number = $_POST['PhoneNumber_owner'];
    $customer_id = $_POST['IDCustomer'];

    // Validate input
    if (empty($pet_name)) {
        $error = 'Pet name is required';
    }

    // Check if image file is uploaded
    $isUploadOk = uploadFile($_FILES["pet_img"], $pet_name);
    if ($isUploadOk) {
        echo "File uploaded successfully.";
        $pet_img = str_replace(" ", "_", $pet_name) . "." . "jpg";
    } else {
        echo "File upload failed.";
    }

    // If no errors, update the record
    if (!$error) {
        $sql = "UPDATE pet SET Pet_type ='$pet_type', pet_name='$pet_name', pet_img='$pet_img', 
                PhoneNumber_owner='$phone_number', IDCustomer='$customer_id' WHERE IDpet = $id";
        if (mysqli_query($conn, $sql)) {
            header('Location: petshop.php');
            exit();
        } else {
            $error = 'Error updating record.';
        }
    }
}
?>
<?php $customers = mysqli_query($conn, "SELECT * FROM customer"); ?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Edit Pet</h3>
    </div>
    <div class="panel-body">
        <form action="" method="POST" enctype="multipart/form-data" role="form">
            <div class="form-group">
                <label for="Pet_type">Pet Type</label>
                <input type="text" class="form-control" name="Pet_type" value="<?php echo isset($rowPet['Pet_type']) ? $rowPet['Pet_type'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="pet_name">Pet Name</label>
                <input type="text" class="form-control" name="pet_name" value="<?php echo isset($rowPet['pet_name']) ? $rowPet['pet_name'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="pet_img">Pet Image</label>
                <input type="file" class="form-control" name="pet_img" value="<?php echo isset($rowPet['pet_img']) ? $rowPet['pet_img'] : ''; ?>">
                <?php if (!empty($rowPet['pet_img'])): ?>
                    <img width="200" height="200" src="<?php echo "../uploads/".$rowPet['pet_img'] ?>" alt="Image">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="PhoneNumber_owner">Phone Number Owner</label>
                <input type="text" class="form-control" name="PhoneNumber_owner" value="<?php echo isset($rowPet['PhoneNumber_owner']) ? $rowPet['PhoneNumber_owner'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="IDCustomer">Customer ID</label>
                <select name="IDCustomer" class="form-control">
                    <?php if (!empty($customers)): ?>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?php echo $customer['IDCustomer']; ?>" <?php echo ($customer['IDCustomer'] == $rowPet['IDCustomer']) ? 'selected' : ''; ?>>
                                <?php echo $customer['Name_customer']; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>
