<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống quản lý thư viện</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include 'pages/header.php'; ?>

    <main class="container">
        <section id="book-list" class="section book-section">
            <h1 class="section-title book-section-title">Khám Phá Sách Mới Nhất</h1>
            <div class="book-grid">
                <div class="book-card">
                    <img class="book-cover" src="images/dac-nhan-tam.jpg" alt="Đắc nhân tâm">

                    <h2 class="book-title">Đắc nhân tâm</h2>
                    <p class="book-author">Tác giả: Dale Carnegie</p>
                    <a href="books.php" class="book-button">Xem chi tiết</a>
                </div>
                <div class="book-card">
                    <img class="book-cover" src="images/hoa-vang-co-xanh.jpg" alt="Hoa vàng trên cỏ xanh">
                    <h2 class="book-title">Hoa vàng trên cỏ xanh</h2>
                    <p class="book-author">Tác giả: Nguyễn Nhật Ánh</p>
                    <a href="books.php" class="book-button">Xem chi tiết</a>
                </div>
                <div class="book-card">
                    <img class="book-cover" src="images/harry-potter-1.jpg" alt="Harry Potter và Hòn đá Phù thủy">
                    <h2 class="book-title">Harry Potter</h2>
                    <p class="book-author">Tác giả: J.K. Rowling</p>
                    <a href="books.php" class="book-button">Xem chi tiết</a>
                </div>
                <div class="book-card">
                    <img class="book-cover" src="images/nha-gia-kim.jpg" alt="Nhà Giả Kim">
                    <h2 class="book-title">Nhà Giả Kim</h2>
                    <p class="book-author">Tác giả: Paulo Coelho</p>
                    <a href="books.php" class="book-button">Xem chi tiết</a>
                </div>
                <div class="book-card">
                    <img class="book-cover" src="images/hoang-tu-be.jpg" alt="Hoàng Tử Bé">
                    <h2 class="book-title">Hoàng Tử Bé</h2>
                    <p class="book-author">Tác giả: Antoine de Saint-Exupéry</p>
                    <a href="books.php" class="book-button">Xem chi tiết</a>
                </div>
            </div>
        </section>

        <section id="about" class="section">
            <h1 class="section-title">Về Chúng Tôi</h1>
            <div id="about-content">
                <div class="about-content">
                    <h2 class="about-title">Chào Mừng Đến Với New Library</h2>

                    <p>
                        <i class="fas fa-book-open icon-about"></i> <strong>Sứ mệnh của chúng tôi</strong> là khơi dậy
                        niềm đam mê đọc sách, lan tỏa tri thức và xây dựng một cộng đồng học tập vững mạnh. Tại New Library, chúng tôi tin rằng sách là chìa khóa mở cánh cửa tri thức, kết nối con người và kiến tạo
                        tương lai.
                    </p>

                    <p>
                        <i class="fas fa-history icon-about"></i> <strong>Lịch sử hình thành</strong>: New Library
                        thành lập với mong muốn trở thành một không gian văn hóa đọc lý
                        tưởng cho sinh viên, cộng đồng địa phương,. Từ những ngày đầu, chúng tôi đã không ngừng nỗ
                        lực để phát triển và mở rộng bộ sưu tập sách, đa dạng hóa các dịch vụ và tiện ích, đáp ứng nhu
                        cầu ngày càng cao của độc giả.
                    </p>

                    <p>
                        <i class="fas fa-users icon-about"></i> <strong>Đội ngũ tận tâm</strong>: Đội ngũ nhân viên thư
                        viện của chúng tôi luôn sẵn sàng hỗ trợ và đồng hành cùng bạn trên hành trình khám phá tri thức.
                        Với sự nhiệt tình, chuyên nghiệp và am hiểu sâu sắc về sách, chúng tôi cam kết mang đến cho bạn
                        trải nghiệm thư viện tốt nhất.
                    </p>

                    <p>
                        <i class="fas fa-cogs icon-about"></i> <strong>Dịch vụ và tiện ích</strong>: New Library cung
                        cấp một loạt các dịch vụ và tiện ích đa dạng, bao gồm:
                    <ul>
                        <li><i class="fas fa-check-circle list-icon"></i> Bộ sưu tập sách phong phú với số lượng sách đa dạngdạng
                            đầu sách thuộc nhiều lĩnh vực.</li>
                        <li><i class="fas fa-check-circle list-icon"></i> Không gian đọc sách yên tĩnh, thoải mái, đầy
                            đủ tiện nghi.</li>
                        <li><i class="fas fa-check-circle list-icon"></i> Hệ thống tìm kiếm sách trực tuyến hiện đại, dễ
                            dàng tra cứu.</li>
                        <li><i class="fas fa-check-circle list-icon"></i> Các hoạt động văn hóa, sự kiện, câu lạc bộ đọc
                            sách thú vị.</li>
                        <li><i class="fas fa-check-circle list-icon"></i> Dịch vụ mượn trả sách linh hoạt, nhanh chóng.
                        </li>
                    </ul>
                    </p>

                    <p>
                        <i class="fas fa-hand-sparkles icon-about"></i> <strong>Giá trị cốt lõi</strong>: Tại New Library
                      , chúng tôi đề cao các giá trị: <strong>Tri thức, Sáng tạo, Cộng đồng và Phát triển bền
                            vững</strong>. Chúng tôi mong muốn thư viện không chỉ là nơi lưu trữ sách, mà còn là một
                        trung tâm văn hóa, nơi mọi người có thể học hỏi, chia sẻ và cùng nhau phát triển.
                    </p>

                    <p class="cta-about">
                        Hãy đến với New Library để trải nghiệm không gian tri thức tuyệt vời và khám phá thế giới
                        sách vô tận!
                        <br>
                       <center> <a href="contact.php" class="book-button about-button">Liên hệ với chúng tôi</a> </center>
                    </p>
                </div>
            </div>
        </section>

        <section id="articles" class="section">
            <h1 class="section-title">Góc Chia Sẻ Kiến Thức</h1>
            <div class="article-list">
                <article class="article-item">
                    <img src="images/article-thumbnail-1.jpg" alt="Ảnh đại diện bài viết 1" class="article-thumbnail"
                        width="90%">
                    <h2 class="article-title">Khám Phá Thế Giới Sách: 5 Cuốn Tiểu Thuyết Gây Bão Mùa Hè Này</h2>
                    <p class="article-excerpt">Mùa hè này bạn đã có kế hoạch đọc gì chưa? Hãy cùng chúng tôi điểm qua 5
                        cuốn tiểu thuyết mới nhất, hứa hẹn sẽ "gây bão" trong cộng đồng yêu sách mùa hè năm nay. Từ
                        những câu chuyện tình yêu lãng mạn đến những cuộc phiêu lưu kỳ thú, chắc chắn bạn sẽ tìm thấy
                        cuốn sách phù hợp để "chill" trong mùa hè này...</p> <a href="articles.php"
                        class="article-button">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                </article>

                <article class="article-item">
                    <img src="images/article-thumbnail-2.jpg" alt="Ảnh đại diện bài viết 2" class="article-thumbnail">
                    <h2 class="article-title">Bí Quyết Đọc Sách Hiệu Quả: 7 Mẹo Nhỏ Dành Cho Người Bận Rộn</h2>
                    <p class="article-excerpt">Bạn là người bận rộn và luôn cảm thấy "không có thời gian" để đọc sách?
                        Đừng lo lắng! Bài viết này sẽ chia sẻ 7 mẹo nhỏ giúp bạn đọc sách hiệu quả hơn, ngay cả khi lịch
                        trình của bạn dày đặc. Áp dụng ngay để biến việc đọc sách thành thói quen hàng ngày...</p> <a
                        href="articles.php" class="article-button">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                </article>
            </div>
        </section>
    </main>

    <?php include 'pages/footer.php'; ?>
</body>

</html>