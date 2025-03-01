<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sách - Thư Viện Cao Cấp</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #495057; /* Màu chữ trung tính hơn */
            line-height: 1.6; /* Tăng khoảng cách dòng */
        }

        h2 {
            color: #343a40; /* Tiêu đề đậm hơn */
            font-weight: 700; /* In đậm tiêu đề */
            margin-bottom: 25px; /* Tăng khoảng cách dưới tiêu đề */
        }

        .filter-section {
            background-color: #fff;
            border-radius: 12px; /* Bo tròn góc bộ lọc */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08); /* Bóng đổ sâu hơn */
            padding: 25px; /* Tăng padding bộ lọc */
        }

        .filter-section .card-title {
            color: #495057; /* Tiêu đề bộ lọc đậm vừa */
            font-weight: 600;
            margin-bottom: 20px; /* Tăng khoảng cách dưới tiêu đề bộ lọc */
        }

        .filter-section .form-control,
        .filter-section .form-select {
            border: 1px solid #e0e0e0; /* Border input/select nhạt hơn */
            border-radius: 8px; /* Bo tròn góc input/select */
            padding: 12px; /* Padding input/select lớn hơn */
            font-size: 1rem; /* Font size input/select lớn hơn */
            box-shadow: none !important;
        }

        .filter-section .form-control:focus,
        .filter-section .form-select:focus {
            border-color: #0080ff; /* Border focus màu xanh dương đậm hơn */
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 128, 255, 0.25) !important; /* Shadow focus xanh dương đậm hơn */
        }

        .book-container h2 {
            margin-bottom: 30px; /* Tăng khoảng cách dưới tiêu đề danh sách sách */
        }

        .book-list {
            margin-top: 15px; /* Tăng khoảng cách trên danh sách sách */
        }

        .book-item {
            border-radius: 12px; /* Bo tròn góc card sách */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08); /* Bóng đổ sâu hơn cho card sách */
            overflow: hidden; /* Ẩn phần tràn ra ngoài border-radius */
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Transition mượt mà hơn */
            border: 1px solid #fff; /* Thêm border trắng mỏng để tạo hiệu ứng nâng lên */
        }


        .book-item:hover {
            transform: translateY(-5px); /* Nâng card lên khi hover */
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12); /* Bóng đổ đậm hơn khi hover */
            border: 1px solid #eee; /* Border nhạt hơn khi hover */
        }

        .book-item .card-img-top {
            border-radius: 12px 12px 0 0; /* Bo tròn góc trên ảnh bìa */
            height: 300px; /* Chiều cao ảnh bìa lớn hơn nữa */
            object-fit: cover;
            transition: opacity 0.3s ease-in-out; /* Thêm transition cho opacity ảnh */
        }

        .book-item:hover .card-img-top {
            opacity: 0.9; /* Giảm opacity ảnh khi hover */
        }

        .book-item .card-body {
            padding: 20px; /* Padding card body lớn hơn */
        }

        .book-item .card-title {
            font-size: 1.2rem; /* Tiêu đề sách lớn hơn */
            font-weight: 600; /* Tiêu đề sách đậm vừa */
            color: #343a40; /* Màu tiêu đề sách đậm hơn */
            margin-bottom: 10px; /* Khoảng cách dưới tiêu đề sách */
        }

        .book-item .card-text.book-author {
            color: #757575; /* Màu tác giả xám đậm hơn */
            font-size: 1rem; /* Font size tác giả lớn hơn */
            margin-bottom: 8px; /* Khoảng cách dưới tác giả */
        }

        .book-item .card-text.book-category {
            color: #9e9e9e; /* Màu thể loại xám nhạt hơn */
            font-size: 0.9rem; /* Font size thể loại lớn hơn */
            margin-bottom: 15px; /* Khoảng cách dưới thể loại lớn hơn */
        }

        .btn-detail {
            background-color: #0080ff; /* Màu nút xanh dương đậm hơn */
            border-color: #0080ff;
            color: #fff; /* Chữ nút màu trắng */
            font-size: 1rem; /* Font size nút lớn hơn */
            padding: 10px 20px; /* Padding nút lớn hơn */
            border-radius: 8px; /* Bo tròn góc nút */
            transition: background-color 0.3s ease-in-out, border-color 0.3s ease-in-out, transform 0.2s ease-in-out; /* Transition mượt mà hơn cho nút */
            box-shadow: 0 4px 8px rgba(0, 128, 255, 0.2); /* Bóng đổ nhẹ cho nút */
        }

        .btn-detail:hover {
            background-color: #0059b3; /* Màu nút hover đậm hơn */
            border-color: #0059b3;
            transform: scale(1.03); /* Scale nút nhẹ khi hover */
            box-shadow: 0 6px 12px rgba(0, 128, 255, 0.3); /* Bóng đổ đậm hơn khi hover nút */
        }
    </style>
</head>

<body>
    <?php include 'pages/header.php'; ?>
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col-md-3">
                <div class="filter-section card border-0">
                    <h3 class="card-title text-left">Lọc Sách</h3>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-right-0 rounded-0">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control border-left-0 rounded-0" id="search"
                                    placeholder="Tìm kiếm tên sách..." onkeyup="filterBooks()">
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-select rounded-0" id="category" onchange="filterBooks()">
                                <option value="all">Tất cả thể loại</option>
                                <option value="Kỹ năng sống">Kỹ năng sống</option>
                                <option value="Văn học Việt Nam">Văn học Việt Nam</option>
                                <option value="Fantasy">Fantasy</option>
                                <option value="Ngụ ngôn">Ngụ ngôn</option>
                                <option value="Trinh thám">Trinh thám</option>
                                <option value="Tiểu thuyết">Tiểu thuyết</option>
                                <option value="Văn học kinh điển">Văn học kinh điển</option>
                                <option value="Văn học thiếu nhi">Văn học thiếu nhi</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="book-container">
                    <h2>Khám Phá Sách Mới Nhất</h2>
                    <div id="book-list" class="book-list row">
                        <?php
                        // Kết nối database
                        require_once 'config.php';

                        // Truy vấn SQL để lấy dữ liệu sách
                        $sql = "SELECT id, title, author, image_path, genre FROM books";
                        $result = $conn->query($sql);

                        // Tạo mảng books để JavaScript có thể dùng
                        $books = [];
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $books[] = $row;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dữ liệu sách từ PHPMyAdmin (đã được chuyển thành JSON)
        const books = <?php echo json_encode($books); ?>;

        // Hàm hiển thị sách
        function displayBooks(bookArray) {
            const bookList = document.getElementById('book-list');
            bookList.innerHTML = "";
            bookArray.forEach(book => {
                bookList.innerHTML += `
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="card book-item border-0">
                            <img src="${book.image_path}" class="card-img-top" alt="${book.title}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title book-title">${book.title}</h5>
                                <p class="card-text book-author text-muted">${book.author}</p>
                                <p class="card-text book-category"><small class="text-muted">${book.genre}</small></p>
                                <a href="book_details.php?id=${book.id}" class="btn btn-primary mt-auto btn-detail">Xem Chi Tiết</a>
                            </div>
                        </div>
                    </div>`;
            });
        }

        // Hàm lọc sách
        function filterBooks() {
            const searchInput = document.getElementById('search').value.toLowerCase();
            const categoryInput = document.getElementById('category').value;

            const filteredBooks = books.filter(book => {
                const matchTitle = book.title.toLowerCase().includes(searchInput);
                const matchCategory = categoryInput === 'all' || book.genre === categoryInput;
                return matchTitle && matchCategory;
            });

            displayBooks(filteredBooks);
        }

        // Hiển thị toàn bộ sách ban đầu
        displayBooks(books);
    </script>
    <?php include 'pages/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>