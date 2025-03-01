<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ - Hệ thống quản lý thư viện</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
    /* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
    text-align: center;
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 400px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    animation: slideUp 0.5s ease-in-out;

}

/* Đóng nút (X) */
.close-btn {
    color: #aaa;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 10px;
    right: 25px;
    cursor: pointer;
}

.close-btn:hover,
.close-btn:focus {
    color: black;
}

/* Nút Thoát và OK */
.btn-close, .btn-ok {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    margin: 10px;
    cursor: pointer;
    border-radius: 5px;
}

.btn-close:hover, .btn-ok:hover {
    background-color: #45a049;
}

/* Hiệu ứng Fade-In và Zoom-In */
@keyframes fadeInZoom {
    0% {
        opacity: 0;
        transform: scale(0.8); /* Bắt đầu với kích thước nhỏ */
    }
    100% {
        opacity: 1;
        transform: scale(1); /* Kết thúc với kích thước bình thường */
    }
}


    </style>
</head>

<body>
    <?php include 'pages/header.php'; ?>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Nhận dữ liệu từ form
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        // Kết nối tới cơ sở dữ liệu MySQL
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "library_db";

        // Tạo kết nối
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Thêm tin nhắn vào cơ sở dữ liệu
        $sql = "INSERT INTO messages (name, email, message) VALUES ('$name', '$email', '$message')";

        if ($conn->query($sql) === TRUE) {
            echo "success"; // Gửi phản hồi thành công
        } else {
            echo "error"; // Gửi phản hồi lỗi
        }

        // Đóng kết nối
        $conn->close();
    }
    ?>

    <main class="container">
        <section id="contact-page" class="section">
            <h1 class="section-title">Liên hệ với New Library </h1>
            <div class="contact-content">
                <div class="contact-section">
                    <h2 class="contact-section-title">Thông tin liên hệ</h2>
                    <p>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Hãy liên hệ với chúng tôi qua các kênh sau:</p>
                    <ul class="contact-info-list">
                        <li class="contact-info-item">
                            <i class="fas fa-map-marker-alt contact-info-icon"></i>
                            <span class="contact-info-text">Địa chỉ: <strong>Số 7, Đường Tri Thức, Khu Đô Thị Văn Hóa,
                                    Quận 1, Thành phố Hồ Chí Minh, Việt Nam</strong></span>
                        </li>
                        <li class="contact-info-item">
                            <i class="fas fa-phone contact-info-icon"></i>
                            <span class="contact-info-text">Điện thoại: <a href="tel:+842812345678">(+84) 28 1234
                                    5678</a></span>
                        </li>
                        <li class="contact-info-item">
                            <i class="fas fa-envelope contact-info-icon"></i>
                            <span class="contact-info-text">Email: <a
                                    href="mailto:info@Newlibrary.com">info@Newlibrary.com</a></span>
                        </li>
                    </ul>
                </div>

                <div class="contact-section">
                    <h2 class="contact-section-title">Gửi tin nhắn cho chúng tôi</h2>
                    <p>Vui lòng điền vào mẫu dưới đây để gửi tin nhắn trực tiếp đến đội ngũ Thư Viện New Library. Chúng tôi
                        sẽ phản hồi bạn trong thời gian sớm nhất.</p>

                    <form id="contactForm" method="post" class="contact-form">
                        <div class="form-group">
                            <label for="name"><b>Tên của bạn:</b></label>
                            <input type="text" id="name" name="name" placeholder="Nhập tên của bạn" required>
                        </div>
                        <div class="form-group">
                            <label for="email"><b>Địa chỉ Email:</b></label>
                            <input type="email" id="email" name="email" placeholder="Nhập địa chỉ email của bạn"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="message"><b>Tin nhắn của bạn:</b></b></label>
                            <textarea id="message" name="message" rows="7" placeholder="Nhập tin nhắn của bạn"
                                required></textarea>
                        </div>
                        <button type="submit" class="submit-button">Gửi tin nhắn</button>
                    </form>

                    <!-- Modal -->
                    <div id="successModal" class="modal">
                        <div class="modal-content">
                            <span class="close-btn" onclick="closeModal()">&times;</span>
                            <h2>Tin nhắn của bạn đã được gửi thành công!</h2>
                            <button class="btn-close" onclick="closeModal()">Thoát</button>
                            <button class="btn-ok" onclick="closeModal()">OK</button>
                        </div>
                    </div>

                </div>

                <div class="contact-section">
                    <iframe class="contact-map" src="https://www.google.com/maps/embed?pb=!1m18..."></iframe>
                    <p class="map-note">(Bản đồ chỉ mang tính chất minh họa. Vui lòng xác nhận địa chỉ chính xác ở
                        trên.)</p>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Ngăn chặn form gửi mặc định và sử dụng AJAX để gửi dữ liệu
        document.getElementById('contactForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Ngừng gửi form theo cách mặc định

            var formData = new FormData(this); // Lấy dữ liệu từ form

            // Gửi dữ liệu form bằng AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true); // POST dữ liệu tới trang hiện tại
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Hiển thị modal thành công
                    showModal();
                } else {
                    alert("Có lỗi xảy ra. Vui lòng thử lại.");
                }
            };
            xhr.send(formData);
        });

        function showModal() {
            document.getElementById("successModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("successModal").style.display = "none";
        }
    </script>
    <?php include 'pages/footer.php'; ?>
</body>

</html>