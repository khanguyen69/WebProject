<?php
include 'dieuhuong.php';
require_once 'ketnoi.php';



// Process search form submission
$search_term = '';
if (isset($_POST['search_customer'])) {
    $search_term = mysqli_real_escape_string($conn, $_POST['search_term']);
    // Search query for pet name, owner name, and phone number
    $sql = "SELECT s.IDpet, s.pet_name, s.pet_img, s.Pet_type, s.PhoneNumber_owner, s.IDCustomer, c.Name_customer 
            FROM pet AS s 
            JOIN customer AS c ON s.IDCustomer = c.IDCustomer
            WHERE s.pet_name LIKE '%$search_term%' OR s.PhoneNumber_owner LIKE '%$search_term%' OR c.Name_customer LIKE '%$search_term%'";
} else {
    $search_term = isset($_GET['search_term']) ? mysqli_real_escape_string($conn, $_GET['search_term']) : '';
    if ($search_term) {
        // Search query for pet name, owner name, and phone number
        $sql = "SELECT s.IDpet, s.pet_name, s.pet_img, s.Pet_type, s.PhoneNumber_owner, s.IDCustomer, c.Name_customer 
                FROM pet AS s 
                JOIN customer AS c ON s.IDCustomer = c.IDCustomer
                WHERE s.pet_name LIKE '%$search_term%' OR s.PhoneNumber_owner LIKE '%$search_term%' OR c.Name_customer LIKE '%$search_term%'";
    } else {
        // Default query to fetch all pets
        $sql = "SELECT s.IDpet, s.pet_name, s.pet_img, s.Pet_type, s.PhoneNumber_owner, s.IDCustomer, c.Name_customer 
                FROM pet AS s 
                JOIN customer AS c ON s.IDCustomer = c.IDCustomer";
    }
}

$records_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

$sql_with_limit = $sql . " LIMIT $offset, $records_per_page";
$pet = mysqli_query($conn, $sql_with_limit);

$total_records_result = mysqli_query($conn, $sql);
$total_records = mysqli_num_rows($total_records_result);
$total_pages = ceil($total_records / $records_per_page);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <title>Petopia - Đánh giá dịch vụ</title>
    <style>
    .phan-trang {
        width: 100%;
        display: flex;
        justify-content: center;
        text-align: center;
        list-style: none;
        font-weight: bold;
        font-size: 1.5em;
        overflow: hidden;
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

    .img-zoom {
        cursor: pointer;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.9);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    .close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }

    .table-striped tbody tr:nth-of-type(even) {
        background-color: #e9e9e9;
    }
</style>

</head>
<body>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Danh sách thú cưng</h3>
        <a href="dkpet.php" style="color: lime; margin-left: 10px;"><i class="fas fa-plus-circle"></i> Thêm thú cưng của bạn vào danh sách</a>
    </div>
    <div class="panel-body">
        <form method="POST" action="" id="searchForm">
            <div class="form-group">
                <label for="search_term">Tìm kiếm thú cưng:</label>
                <input type="text" name="search_term" id="search_term" class="form-control" placeholder="Nhập tên hoặc số điện thoại" value="<?php echo $search_term; ?>">
            </div>
            <button type="submit" name="search_customer" class="btn btn-primary">Tìm kiếm</button>
            <button type="button" onclick="cancelSearch()" class="btn btn-danger" style="margin-left:5px;">Hủy tìm</button>
        </form>
    </div>
    <?php if (mysqli_num_rows($pet) > 0) { ?>
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th>ID thú cưng</th>
                    <th>Loại thú cưng</th>
                    <th>Tên thú cưng</th>
                    <th>Ảnh thú cưng</th>
                    <th>Tên Khách hàng</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($pet)) { ?>
                    <tr>
                        <td><?php echo $row['IDpet']; ?></td>
                        <td><?php echo $row['Pet_type']; ?></td>
                        <td><?php echo $row['pet_name']; ?></td>
                        <td>
                            <img class="img-zoom" width="100px" height="auto" src="./uploads/<?php echo $row['pet_img']; ?>" alt="<?php echo $row['pet_name']; ?>" onclick="zoomImage(this)">
                        </td>
                        <td><?php echo $row['IDCustomer'] . ' - ' . $row['Name_customer']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>Không tìm thấy thú cưng nào.</p>
    <?php } ?>
    <div class="phan-trang">
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php if ($current_page > 1) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page - 1 ?>&search_term=<?php echo urlencode($search_term); ?>">Trước</a></li>
                <?php } ?>

                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i ?>&search_term=<?php echo urlencode($search_term); ?>"><?php echo $i ?></a></li>
                <?php } ?>

                <?php if ($current_page < $total_pages) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page + 1 ?>&search_term=<?php echo urlencode($search_term); ?>">Sau</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</div>
<div class="duoi">
    <?php require_once 'footer.php'; ?>
</div>

<!-- Modal for displaying the enlarged image -->
<div id="myModal" class="modal">
    <span class="close" onclick="closeModal()">&times;</span>
    <img class="modal-content" id="img01">
</div>

<script>
    function zoomImage(img) {
        var modal = document.getElementById("myModal");
        var modalImg = document.getElementById("img01");

        modal.style.display = "flex";
        modalImg.src = img.src;
    }

    function closeModal() {
        var modal = document.getElementById("myModal");
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        var modal = document.getElementById("myModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // JavaScript to set the page to 1 after search
    document.getElementById('searchForm').onsubmit = function() {
        window.location.href = '?search_term=' + encodeURIComponent(document.getElementById('search_term').value) + '&page=1';
        return false;
    };
    function cancelSearch() {
        window.location.href = 'petshop.php';
    }
</script>
</body>
</html>
