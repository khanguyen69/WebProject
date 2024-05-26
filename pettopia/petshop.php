<?php
include 'dieuhuong.php';
require_once 'ketnoi.php';



// Process search form submission
if(isset($_POST['search_customer'])) {
    $search_term = mysqli_real_escape_string($conn, $_POST['search_term']);
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
$pet = mysqli_query($conn, $sql);
$records_per_page = 10;
$total_records = mysqli_num_rows($pet);
$total_pages = ceil($total_records / $records_per_page);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;
$sql .= " LIMIT $offset, $records_per_page";

$pet = mysqli_query($conn, $sql);
?>
<style>
    .phan-trang {
        width: 100%;
        display: flex;
        justify-content: center;
        text-align: center;
        list-style: none;
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
</style>
</style>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Danh sách thú cưng</h3>
    </div>
    <div class="panel-body">
        <form method="POST" action="">
            <div class="form-group">
                <label for="search_term">Tìm kiếm thú cưng:</label>
                <input type="text" name="search_term" id="search_term" class="form-control" placeholder="Nhập tên hoặc số điện thoại hoặc email">
            </div>
            <button type="submit" name="search_customer" class="btn btn-primary">Tìm kiếm</button>
        </form>
    </div>
    <?php
    $page = 0;
    if (isset($_GET["page"])) {
        $page = $_GET["page"] - 1;
    }

    $sql = "SELECT CEIL((SELECT COUNT(*) FROM `pet`) / 6) AS 'totalpage'";
    $result = mysqli_query($conn, $sql);
    $totalpage = 0;
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $totalpage = $row["totalpage"];
        }
    }

    $sql = "SELECT " . $page . " * (SELECT (SELECT COUNT(*) FROM `pet`) / (SELECT CEIL((SELECT COUNT(*) FROM `pet`) / 6))) AS 'offset'";
    $result = mysqli_query($conn, $sql);
    $offset = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $offset = (int) $row["offset"];
    }

    $sql = "SELECT * FROM `pet` LIMIT " . $offset . ", 6";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    ?>
        
        <table class="table table-bordered table-hover">
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
                <?php 
                while ($row = mysqli_fetch_assoc($pet)) {
                ?>
                    <tr>
                        <td><?php echo $row['IDpet']; ?></td>
                        <td><?php echo $row['Pet_type']; ?></td>
                        <td><?php echo $row['pet_name']; ?></td>
                        <td>
                            <img class="img-zoom" width="100px" height="auto" src="uploads/<?php echo $row['pet_img']; ?>" alt="<?php echo $row['pet_name']; ?>" onclick="zoomImage(this)">
                        </td>
                        <td><?php echo $row['IDCustomer'] . ' - ' . $row['Name_customer']; ?></td>
                    </tr>
                <?php }; ?>
            </tbody>
        </table>
    <?php }else { ?>
        <p>Không có Thú cưng nào.</p>
    <?php } ?>
    <div class="phan-trang">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($current_page > 1) : ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page - 1 ?>">Trước</a></li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?php echo ($i == $current_page) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $current_page + 1 ?>">Sau</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
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

    // Close the modal when clicking outside of the image
    window.onclick = function(event) {
        var modal = document.getElementById("myModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>