<?php
include 'header.php';
require_once 'connect.php';

// Function to delete a pet from the database
function deletePet($conn, $petId) {
    $deleted = mysqli_query($conn, "DELETE FROM pet WHERE IDpet = $petId");
    return $deleted;
}

// Initialize search term and current page
$search_term = '';
$current_page = 1;

// Process search form submission
if (isset($_POST['search_customer'])) {
    $search_term = mysqli_real_escape_string($conn, $_POST['search_term']);
    $current_page = 1; // Reset to the first page when a new search is performed
} else {
    // If search term exists in the query string, use it
    if (isset($_GET['search_term'])) {
        $search_term = mysqli_real_escape_string($conn, $_GET['search_term']);
    }
    // Check current page number
    if (isset($_GET['page'])) {
        $current_page = (int)$_GET['page'];
    }
}

// Search query for pet name, owner name, and phone number
if (!empty($search_term)) {
    $sql = "SELECT s.IDpet, s.pet_name, s.pet_img, s.Pet_type, s.PhoneNumber_owner, s.IDCustomer FROM pet AS s 
            WHERE s.pet_name LIKE '%$search_term%' 
            OR s.PhoneNumber_owner LIKE '%$search_term%' 
            OR s.IDCustomer IN (SELECT IDCustomer FROM customer WHERE Name_customer LIKE '%$search_term%')";
} else {
    // Default query to fetch all pets
    $sql = "SELECT s.IDpet, s.pet_name, s.pet_img, s.Pet_type, s.PhoneNumber_owner, s.IDCustomer FROM pet AS s";
}

$pet = mysqli_query($conn, $sql);
$rows_per_page = 10;
$total_rows = mysqli_num_rows($pet);
$total_pages = ceil($total_rows / $rows_per_page);
$start_index = ($current_page - 1) * $rows_per_page;
$sql .= " LIMIT $start_index, $rows_per_page";
$pet = mysqli_query($conn, $sql);
?>

<style>
    .phan-trang {
        width: 100%;
        text-align: center;
        list-style: none;
        font-weight: bold;
        font-size: 1.5em;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .phan-trang li {
        display: inline;
    }

    .phan-trang a {
        padding: 10px;
        border: 1px solid #ebebeb;
        text-decoration: none;
    }
    .phan-trang a.active {
            color: red;
            font-weight: bold;
        }
    /* Styles for image modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 60px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .modal-content img {
        width: 100%;
        height: auto;
    }

    .modal-caption {
        text-align: center;
        color: #ccc;
        padding: 10px;
        font-size: 20px;
    }

    .close {
        position: absolute;
        top: 15px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Danh sách thú cưng</h3>
    </div>
    <div class="panel-body">
        <form method="POST" action="">
            <div class="form-group">
                <label for="search_term">Tìm kiếm thú cưng:</label>
                <input type="text" name="search_term" id="search_term" class="form-control" placeholder="Nhập tên hoặc số điện thoại" value="<?php echo htmlspecialchars($search_term); ?>">
            </div>
            <button type="submit" name="search_customer" class="btn btn-primary">Tìm kiếm</button>
            <a href="petshop.php" class="btn btn-danger">Hủy tìm</a>
            <a href="thempet.php" class="btn btn-primary btn-sm">Thêm thú cưng</a>
        </form>
    </div>
    <?php
    if (mysqli_num_rows($pet) > 0) {
    ?>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID thú cưng</th>
                    <th>Loại thú cưng</th>
                    <th>Tên thú cưng</th>
                    <th>Ảnh thú cưng</th>
                    <th>Số điện thoại chủ</th>
                    <th>ID Khách hàng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                while ($row = mysqli_fetch_assoc($pet)) {
                ?>
                    <tr>
                        <td><?php echo $row['IDpet']; ?></td>
                        <td><?php echo $row['Pet_type']; ?></td>
                        <td><?php echo $row['pet_name']; ?></td>
                        <td>
                            <img src="./uploads/<?php echo $row['pet_img']; ?>" alt="<?php echo $row['pet_name']; ?>" class="img-thumbnail" style="width: 100px; cursor: pointer;" onclick="openModal(this.src, '<?php echo $row['pet_name']; ?>')">
                        </td>
                        <td><?php echo $row['PhoneNumber_owner']; ?></td>
                        <td><?php echo $row['IDCustomer']; ?></td>
                        <td>
                            <a href="suapet.php?Proid=<?php echo $row['IDpet']; ?>" class="btn btn-xs btn-primary">Sửa</a>
                            <!-- <a href="/shop/backend/xoapet.php?Proid=<?php echo $row['IDpet']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Bạn có chắc muốn xóa thú cưng này không?')">Xóa</a> -->
                        </td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Không tìm thấy thú cưng nào.</p>
    <?php } ?>
    <ul class="phan-trang">
    <?php
    for ($i = 1; $i <= $total_pages; $i++) {
        $page_link = "?page=$i";
        if (!empty($search_term)) {
            $page_link .= "&search_term=" . urlencode($search_term);
        }
        if ($i == $current_page) {
            echo "<li><a href='$page_link' class='active'>$i</a></li>";
        } else {
            echo "<li><a href='$page_link'>$i</a></li>";
        }
    }
    ?>
    </ul>
</div>

<!-- The Modal -->
<div id="myModal" class="modal" onclick="closeModal(event)">
    <span class="close" onclick="closeModal(event)">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption" class="modal-caption"></div>
</div>

<script>
function openModal(src, caption) {
    var modal = document.getElementById("myModal");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    
    modal.style.display = "block";
    modalImg.src = src;
    captionText.innerText = caption;
}

function closeModal(event) {
    var modal = document.getElementById("myModal");
    if (event.target === modal || event.target.className === 'close') {
        modal.style.display = "none";
    }
}
</script>

<div class="duoi">
    <?php require_once 'footer.php'; ?>
</div>
