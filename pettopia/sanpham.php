
<?php
require_once 'dieuhuong.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pet</title>
    <link rel="stylesheet" href="main.css">

    <style>
        .block {
            display: flex;
            flex-direction: column;
        }

        .phantrang {
            width: 100%;
            margin-left: 30%;
        }

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

        /* Additional styles for modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

        .close {
            color: #ffffff;
            position: absolute;
            top: 15px;
            right: 35px;
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

        .modal-caption {
            color: #ffffff;
            text-align: center;
            margin-top: 20px;
            font-size: 1.5em;
        }

        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -50px;
            color: #ffffff;
            font-weight: bold;
            font-size: 30px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            z-index: 2; /* Ensure buttons are above the image */
        }

        .prev {
            left: 0;
        }

        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover,
        .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Responsive styles */
        @media screen and (max-width: 700px) {
            .modal-content {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="block">
        <div>
            <h1><b><i>Chào mừng bạn đến với Pet Shop</i></b></h1>
            <div class="block-right">
                <?php
                require_once 'ketnoi.php';

                // phân trang 
                $page = isset($_GET["page"]) ? $_GET["page"] : 1;

                // Set up the base SQL query
                $sql = "SELECT * FROM `pet`";

                // Append WHERE clause for search keyword if provided
                if (isset($_GET["search"])) {
                    $search = $_GET["search"];
                    $sql .= (strpos($sql, 'WHERE') === false) ? ' WHERE' : ' AND';
                    $sql .= " `pet_name` LIKE '%$search%'";
                }

                // Count the total number of rows
                $result = mysqli_query($conn, $sql);
                $totalRows = mysqli_num_rows($result);
                $totalpage = ceil($totalRows / 10); // Assuming 10 products per page

                // Calculate OFFSET based on current page
                $offset = ($page > 1) ? ($page - 1) * 10 : 0;

                // Update the SQL query to include LIMIT and OFFSET
                $sql .= " LIMIT $offset, 10";

                // Fetch products based on the updated SQL query
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    foreach ($result as $row) {
                ?>
                        <div class="fe" style="width: 220px; height: 300px; text-align: center; padding: 5px; margin-left: 10px; margin-top: 5px; box-sizing: border-box;">
                            <div>
                                <img style="width: 200px; height: 200px; object-fit: cover; " src="uploads/<?php echo $row["pet_img"] ?>" alt="<?php echo $row["pet_name"] ?>" onclick="openModal('uploads/<?php echo $row["pet_img"] ?>')">
                            </div>
                            <br>
                            <div>
                                <span style="font-size: 15px; font-weight: bold;"><?php echo $row["pet_name"] ?></span> <br>
                            </div>
                            <br>
                        </div>
                <?php
                    }
                ?>
                    <br></br>
                    <!-- Phân trang -->
                    <div class="phantrang">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <?php if ($page > 1) : ?>
                                    <li class="page-item"><a class="page-link" href="sanpham.php?page=<?php echo $page - 1 ?>">Trước</a></li>
                                <?php endif; ?>

                                <?php for ($i = 1; $i <= $totalpage; $i++) : ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="sanpham.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                <?php endfor; ?>

                                <?php if ($page < $totalpage) : ?>
                                    <li class="page-item"><a class="page-link" href="sanpham.php?page=<?php echo $page + 1 ?>">Sau</a></li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                <?php
                } else {
                    echo "<p>Không có sản phẩm nào.</p>";
                }
                ?>
            </div>


        </div>
        <div class="duoi">
            <?php require_once 'footer.php' ?>
        </div>
    </div>

    <!-- Modal for image preview -->
    <div id="myModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
        <div class="modal-caption"></div>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <script>
        let slideIndex = 1;

        function openModal(imageSrc) {
            const modal = document.getElementById('myModal');
            const modalImg = document.getElementById('modalImage');
            const captionText = document.querySelector('.modal-caption');
            const pagination = document.querySelector('.phantrang'); 

            modal.style.display = 'block';
            modalImg.src = imageSrc;
            captionText.innerHTML = document.querySelector(`[src="${imageSrc}"]`).alt;

            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function showSlides(n) {
            const modalImg = document.getElementById('modalImage');
            const captionText = document.querySelector('.modal-caption');
            const images = document.querySelectorAll('.fe img');
            if (n > images.length) { slideIndex = 1; }
            if (n < 1) { slideIndex = images.length; }
            modalImg.src = images[slideIndex - 1].src;
            captionText.innerHTML = images[slideIndex - 1].alt;
        }

        document.addEventListener('click', function(event) {
            if (event.target === document.getElementById('myModal')) {
                closeModal();
            }
        });
    </script>
</body>

</html>