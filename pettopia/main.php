
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
    .text-box {
        border: 2px solid #000;
        border-radius: 50px; 
        padding: 20px;
        background-color:  #ff4d4d;
        position: relative;
        animation: moveText 6s infinite alternate; 
        cursor: pointer;
    }

    @keyframes moveText {
        0% {
        left: 0;
        }
        50% {
        left: 100px; 
        }
        100% {
        left: 0;
        }
    }

    .text-link {
        position: absolute;
        bottom: 10px;
        right: 10px;
        text-decoration: none;
        color: #000;
    }


    .fe img {
        transition: transform 0.3s ease;
        cursor: pointer; /* Add cursor pointer for better UX */
    }
    .fe img:hover {
        transform: scale(1.1);
    }

    #wp-products {
        padding-top:116px;
        padding-bottom: 78px;
        padding-left:134px;
        padding-right:134px;
    }

    #wp-products h2 {
        text-align: center;
        margin-bottom: 76px;
        font-size:32px;
        color:#626a67;
    }


    #list-products {
        display: flex;
        list-style: none;
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;
    }

    #list-products .item {
        width: 290px;
        height: 374px;
        background:#362f2f;
        border-radius: 10px;
        margin-bottom: 50px;
    }

    #list-products .item img {
        display: block;
        margin:0px auto;
        margin-top:17px;
    }


    #list-products .item .name {
        text-align: center;
        color:#fff;
        font-weight: bold;
        margin-top:21px;
    }

    #list-products .item .desc {
        text-align: center;
        color:#626a67;
    }

    .cover {  display: flex;}
    .rectangle {
        flex: 1;
        border: 1px solid #000;
        padding: 20px;
        margin: 10px;
        text-align: center; 
        background-color: #005a5a; 
        color: #fff; 
    }

    .rectangle:nth-child(1) h2 {
        animation: colorChange 3s linear infinite alternate;
    }

    .rectangle:nth-child(2) h2 {
        animation: colorChange 3s linear infinite alternate-reverse;
    }

    .rectangle:nth-child(3) h2 {
        animation: colorChange 3s linear infinite;
    }

    @keyframes colorChange {
        0% { color: white; }
        50% { color: red; }
        100% { color: white; }
    }

    .rectangle h2, .rectangle p {
        margin: 0;
    }

        .service-container {
            width: 80%;
            margin: 0 auto;
            padding-top: 50px;
        }
        .service-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px;
        }
        .service-box {
            width: 45%;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #ebebeb;
            border-radius: 5px;
            padding: 0;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: box-shadow 0.3s ease, background 0.3s ease;
            background-image: url('https://img.freepik.com/free-vector/flat-design-black-white-halftone-background_23-2150607369.jpg');
            background-size: cover;
            background-position: center;
            overflow: hidden;
        }
        .service-box:hover {
            box-shadow: 20px 20px 20px rgba(0, 0, 0, 0.2);
        }
        .service-box-header {
            padding: 20px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .service-box-header:nth-child(1) {
            background-color: #67c23a;
        }
        .service-box-header:nth-child(2) {
            background-color: #ff4d7d;
        }
        .service-box-header:nth-child(3) {
            background-color: #6a5acd;
        }
        .service-box-header:nth-child(4) {
            background-color: #ff8c00;
        }
        .service-box-header h3 {
            margin: 0;
            font-size: 30px;
            color: #fff;
        }
        .service-box-body {
            font-size: 20px;
            padding: 20px;
        }
        .service-box-footer {
            background-color: #ADD8E6; 
            padding: 10px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .service-box-footer button {
            background-color: #fff;
            color: #000; 
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
            text-transform: uppercase;
        }
        .service-box-footer button:hover {
            background-color: #000;
            color: #fff;
        }


        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        

        
        .services-2 {
            padding: 2rem 2rem 2.5rem;
            border: 5px solid #000;
            border-radius: 30px;
            margin-bottom: 20px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
            margin: 10px 200px 20px 200px;
            padding: 10px;
        }
        
        .services-2:hover {
            border-color: #ff0000;
        }
        
        
        .text {
            text-align: left;
        }
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
<div style="text-align: center;margin-top: 50px;margin-bottom:50px; font-size:25px;color:#626a67;text-transform: uppercase;">
            <h2>Vì sao nên lựa chọn chúng tôi? </h2> </div>
        <div class="container">
            <div class="row">
              <div class="services-2">
                <div class="text">
                  <h2>Đa dạng dịch vụ:</h2>
                  <p> Cung cấp một loạt các loai hình dịch vụ chăm sóc thú cưng từ cơ bản đến cao cấp. Khách hàng có thể dễ dàng tìm thấy các gói dịch vụ phù hợp với nhu cầu và ngân sách của họ, từ việc tắm gội cho thú cưng đến spa và dịch vụ y tế chuyên sâu.</p>
                </div>
              </div>
              <div class="services-2">
                <div class="text">
                  <h2>Chất lượng dịch vụ:</h2>
                  <p>Cam kết đem lại chất lượng dịch vụ hàng đầu cho thú cưng của khách hàng. Đội ngũ nhân viên được đào tạo chuyên nghiệp và có kinh nghiệm trong việc chăm sóc thú cưng, đồng thời sử dụng các sản phẩm và thiết bị tiên tiến để đảm bảo sức khỏe và hạnh phúc cho thú cưng.</p>
                </div>
              </div>
              <div class="services-2">
                <div class="text">
                  <h2>Tiện ích và tiếp cận dễ dàng:</h2>
                  <p>Website được thiết kế để đảm bảo khách hàng có thể truy cập và sử dụng một cách dễ dàng. Giao diện thân thiện và tiện ích giúp khách hàng tìm kiếm thông tin, đặt lịch hẹn và thậm chí đặt hàng trực tuyến một cách thuận tiện từ bất kỳ thiết bị nào có kết nối internet.</p>
                </div>
              </div>
              <div class="services-2">
                <div class="text">
                  <h2>Cam kết về trải nghiệm khách hàng:</h2>
                  <p>Cam kết cung cấp một trải nghiệm khách hàng tốt nhất có thể. Bằng cách cung cấp thông tin chi tiết về dịch vụ, chính sách đặt lịch và phản hồi từ khách hàng trước đó, bạn tạo ra một môi trường tin cậy và an tâm cho chủ thú cưng khi sử dụng dịch vụ của bạn.</p>
                </div>
              </div>
            </div>
          </div>
          
          <h1 style="margin-top:100px; margin-left: 380px;margin-bottom: 20px;font-size:30px;"><u><b>3 ĐIỀU LUÔN CAM KẾT VỚI KHÁCH HÀNG</b></u></h1>
    <div class="cover">
        <div class="rectangle">
          <h2>HẾT MÌNH VÌ CÔNG VIỆC</h2>
          <p>Chúng tôi làm việc hết mình với chữ tâm, trách nhiệm và sự yêu nghề. Thú cưng khỏe mạnh là niềm hạnh phúc của chúng tôi.</p>
        </div>
        <div class="rectangle">
          <h2>GIÁ DỊCH VỤ RẺ NHẤT</h2>
          <p>Chúng tôi cam kết đưa ra mức giá ưu đãi nhất trên thị trường để tất cả thú cưng đều có cơ hội được trải nghiệm dịch vụ của chúng tôi.</p>
        </div>
        <div class="rectangle">
          <h2>CHẤT LƯỢNG HÀNG ĐẦU</h2>
          <p>Chúng tôi không ngừng nâng cao phát triển trình độ kỹ năng của nhân sự để phục vụ thú cưng đem đến kết quả tốt nhất.</p>
        </div>
      </div>
      <div id="wp-products">
        <h2>DỊCH VỤ CỦA CHÚNG TÔI</h2>
        <ul id="list-products">
            <div class="item">
                <img src="img/how-long-you-should-walk-your-dog (1).jpg" alt="">
                <div class="name">Vui chơi cùng bé</div>
                <div class="desc">Cung cấp một môi trường an toàn và vui vẻ cho thú cưng của bạn để tận hưởng những khoảnh khắc thú vị. </div>
                
            </div>


            <div class="item">
                <img src="img/Wellness-Exam-1024x768 (1).jpeg" alt="">
                <div class="name">Chăm sóc sức khỏe</div>
                <div class="desc">Bảo vệ sức khỏe toàn diện cho thú cưng của bạn, bao gồm kiểm tra sức khỏe định kỳ, tiêm phòng, và tư vấn chăm sóc cá nhân, đảm bảo thú cưng luôn khỏe mạnh và hạnh phúc.</div>
               
            </div>
            <div class="item">
                <img src="img/_1260126.jpg" alt="">
                <div class="name">Spa & Grooming</div>
                <div class="desc">Cung cấp các liệu pháp tắm, cắt tỉa lông, vệ sinh răng miệng và móng cho thú cưng của bạn, giúp chúng luôn sạch sẽ, xinh đẹp và tự tin.</div>
             
            </div>
        </ul>  
    </div>



    <div style="text-align: center;margin-top: 20px;margin-bottom:10px; font-size:25px;color:#626a67;text-transform: uppercase;">        
        <h2>Các gói dịch vụ </h2>
    </div>
    <div class="service-container">
        <div class="service-grid">
            <div class="service-box">
                <div class="service-box-header" style="background-color: #67c23a;">
                    <h3>Làm đẹp</h3>
                </div>
                <div class="service-box-body">
                    <p>Thời gian phục vụ: 120 phút</p>
                    <div class="description">Dịch vụ làm đẹp cho thú cưng của bạn một vẻ ngoài lộng lẫy với các dịch vụ chuyên nghiệp.</div>
                    <div class="price">Giá: 300.000 VND</div>
                </div>
                <div class="service-box-footer">
                    <a href="dichvu.php">
                        <button>Chi tiết hơn</button>
                    </a>
                </div>
            </div>
            <div class="service-box">
                <div class="service-box-header" style="background-color: #ff4d7d;">
                    <h3>Vaccin</h3>
                </div>
                <div class="service-box-body">
                    <p>Thời gian phục vụ: 15 phút</p>
                    <div class="description">Dịch vụ tiêm phòng vắc xin để bảo vệ thú cưng khỏi các bệnh truyền nhiễm.</div>
                    <div class="price">Giá: 150.000 VND</div>
                </div>
                <div class="service-box-footer">
                    <a href="dichvu.php">
                        <button>Chi tiết hơn</button>
                    </a>
                </div>
            </div>
            <div class="service-box">
                <div class="service-box-header" style="background-color: #6a5acd;">
                    <h3>Chăm sóc</h3>
                </div>
                <div class="service-box-body">
                    <p>Thời gian phục vụ: 90 phút</p>
                    <div class="description">Dịch vụ chăm sóc toàn diện, đảm bảo sức khỏe và hạnh phúc cho thú cưng của bạn.</div>
                    <div class="price">Giá: 200.000 VND</div>
                </div>
                <div class="service-box-footer">
                    <a href="dichvu.php">
                        <button>Chi tiết hơn</button>
                    </a>
                </div>
            </div>
            <div class="service-box">
                <div class="service-box-header" style="background-color: #ff8c00;">
                    <h3>Thức ăn</h3>
                </div>
                <div class="service-box-body">
                    <p>Thời gian phục vụ: 20 phút</p>
                    <div class="description">Dịch vụ cung cấp thức ăn chất lượng cao, đầy đủ dinh dưỡng cho thú cưng.</div>
                    <div class="price">Giá: 30.000 VND</div>
                </div>
                <div class="service-box-footer">
                    <a href="dichvu.php">
                        <button>Chi tiết hơn</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="block" style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 20px; box-sizing: border-box;">
        <div style="text-align: center; margin-top: 20px; margin-bottom: 10px; font-size: 25px; color: #626a67; text-transform: uppercase;">
            <h2>Ảnh thú cưng</h2>
        </div>
        <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
            <?php
            require_once 'ketnoi.php';

            // Set up the base SQL query
            $sql = "SELECT * FROM `pet`";

            // Append WHERE clause for search keyword if provided
            if (isset($_GET["search"])) {
                $search = $_GET["search"];
                $sql .= (strpos($sql, 'WHERE') === false) ? ' WHERE' : ' AND';
                $sql .= " `pet_name` LIKE '%$search%'";
            }

            // Fetch all products based on the SQL query
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                foreach ($result as $row) {
            ?>
                    <div class="fe" style="width: 220px; height: 300px; text-align: center; padding: 5px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                        <div style="overflow: hidden;">
                            <img style="width: 200px; height: 200px; object-fit: cover;" src="uploads/<?php echo $row["pet_img"] ?>" alt="<?php echo $row["pet_name"] ?>" onclick="openModal('uploads/<?php echo $row["pet_img"] ?>')">
                        </div>
                        <br>
                        <div>
                            <span style="font-size: 15px; font-weight: bold;"><?php echo $row["pet_name"] ?></span> <br>
                        </div>
                        <br>
                    </div>
            <?php
                }
            } else {
                echo "<p>Không có sản phẩm nào.</p>";
            }
            ?>
        </div>
    </div>

    <div style="position: relative;
                width: 95vw;
                height: 40vh;
                display: flex;
                justify-content: center;
                align-items: center;
                overflow: hidden;">
                <div class="text-box" onclick="redirectToLink()">
                    <h1><b>Đặt lịch trước để trải nghiệm dịch vụ tốt nhất</b></h1>
                <a href="datlich.php" class="text-link"></a></div></div>
      <script>
            function redirectToLink() {
              window.location.href = "datlich.php"; 
            }
      </script>


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
        const images = document.querySelectorAll('.fe img');

        // Find the index of the clicked image
        images.forEach((img, index) => {
            if (img.src.includes(imageSrc)) {
                slideIndex = index + 1; // Set the slideIndex to the clicked image's index
            }
        });

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

        if (n > images.length) {
            slideIndex = 1;
        }
        if (n < 1) {
            slideIndex = images.length;
        }

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
