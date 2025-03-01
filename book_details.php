<?php
// Kết nối database (giả sử bạn đã có file config.php)
require_once 'config.php';

// Lấy ID sách từ URL
$book_id = isset($_GET['id']) ? $_GET['id'] : 0; // Lấy id từ query parameter, mặc định là 0 nếu không có

// Nếu không có ID sách hoặc ID không hợp lệ, chuyển hướng hoặc hiển thị lỗi
if ($book_id <= 0) {
    // Có thể chuyển hướng về trang danh sách sách hoặc hiển thị thông báo lỗi
    header("Location: books_list.php"); // Ví dụ: chuyển hướng về trang danh sách sách
    exit();
}

// Truy vấn SQL để lấy thông tin chi tiết sách dựa trên ID
$sql = "SELECT * FROM books WHERE id = " . $book_id;
$result = $conn->query($sql);

// Kiểm tra xem có sách tồn tại không
if ($result->num_rows <= 0) {
    // Xử lý trường hợp không tìm thấy sách (ví dụ: hiển thị thông báo lỗi)
    echo "Không tìm thấy sách!";
    exit();
}

$book = $result->fetch_assoc(); // Lấy dữ liệu sách dưới dạng mảng kết hợp
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sách - Thư Viện Cao Cấp - <?php echo htmlspecialchars($book['title']); ?></title>
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
            color: #495057;
            line-height: 1.6;
        }

        .book-detail-container {
            max-width: 960px;
        }

        .book-detail-card {
            border-radius: 15px;
        }

        .book-cover-col {
            padding-right: 0;
        }

        .book-cover {
            border-radius: 15px 0 0 15px;
            width: 100%;
            height: auto; /* Để chiều cao tự động điều chỉnh theo chiều rộng */
            object-fit: cover;
            min-height: 400px; /* Đảm bảo chiều cao tối thiểu */
        }

        .book-info-col {
            padding-left: 0;
        }

        .book-info-body {
            padding: 30px;
        }

        .book-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #343a40;
            margin-bottom: 15px;
        }

        .book-author,
        .book-category,
        .book-publisher,
        .book-publication-year,
        .book-isbn,
        .book-quantity,
        .book-location {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .book-category i {
            margin-right: 5px;
        }

        .book-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #495057;
            margin-bottom: 25px;
        }

        .book-actions .btn {
            margin-right: 10px;
            border-radius: 8px;
            font-size: 1rem;
            padding: 12px 25px;
            transition: transform 0.2s ease-in-out;
        }

        .book-actions .btn:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #0080ff;
            border-color: #0080ff;
        }

        .btn-primary:hover {
            background-color: #0059b3;
            border-color: #0059b3;
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            color: #495057;
            border-color: #495057;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <?php include 'pages/header.php'; ?>
    <div class="container book-detail-container py-5">
        <div class="card book-detail-card shadow border-0">
            <div class="row no-gutters">
                <div class="col-md-5 book-cover-col">
                    <img src="<?php echo htmlspecialchars($book['image_path']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" class="card-img book-cover">
                </div>
                <div class="col-md-7 book-info-col">
                    <div class="card-body book-info-body">
                        <h2 class="card-title book-title"><?php echo htmlspecialchars($book['title']); ?></h2>
                        <p class="card-text book-author">Tác giả: <?php echo htmlspecialchars($book['author']); ?></p>
                        <p class="card-text book-category"><i class="fas fa-tags"></i> Thể loại: <?php echo htmlspecialchars($book['genre']); ?></p>
                        <p class="card-text book-publisher">Nhà xuất bản: <?php echo htmlspecialchars($book['publisher']); ?></p>
                        <p class="card-text book-publication-year">Năm xuất bản: <?php echo htmlspecialchars($book['publication_year']); ?></p>
                        <p class="card-text book-isbn">ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
                        <p class="card-text book-quantity">Số lượng: <?php echo htmlspecialchars($book['quantity']); ?></p>
                        <p class="card-text book-location">Vị trí: <?php echo htmlspecialchars($book['location']); ?></p>
                        <p class="card-text book-description">
                            <?php echo htmlspecialchars($book['description']); ?>
                        </p>
                        <div class="book-actions">
                            <button class="btn btn-primary btn-borrow" onclick="borrowBook(<?php echo $book['id']; ?>)"><i class="fas fa-bookmark"></i> Mượn sách</button>
                            <button class="btn btn-outline-secondary btn-wishlist" onclick="addToWishlist(<?php echo $book['id']; ?>)"><i class="fas fa-heart"></i> Yêu thích</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'pages/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function borrowBook(bookId) {
    fetch('borrow_book_ui.php?book_id=' + bookId) // Sửa thành borrow_book_ui.php
        .then(response => response.text())
        .then(data => {
            // Không cần alert nữa vì thông báo hiển thị trên trang mới
            window.location.href = 'borrow_book_ui.php?book_id=' + bookId; // Chuyển hướng đến trang borrow_book_ui.php để xem thông báo
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Có lỗi xảy ra khi mượn sách. Vui lòng thử lại sau.');
        });
}

function addToWishlist(bookId) {
        fetch('add_wishlist_ui.php?book_id=' + bookId) // Sửa thành add_wishlist_ui.php
            .then(response => response.text())
            .then(data => {
                // Không cần alert nữa vì thông báo hiển thị trên trang mới
                window.location.href = 'add_wishlist_ui.php?book_id=' + bookId; // Chuyển hướng đến trang add_wishlist_ui.php
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert('Có lỗi xảy ra khi thêm vào danh sách yêu thích. Vui lòng thử lại sau.');
            });
    }
    </script>
</body>

</html>