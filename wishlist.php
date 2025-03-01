<?php
require_once 'config.php';

// **LƯU Ý QUAN TRỌNG:**
// Trong ví dụ này, chúng ta GIẢ ĐỊNH user_id = 1 (ví dụ user đang đăng nhập).
// **TRONG ỨNG DỤNG THỰC TẾ, BẠN CẦN LẤY USER_ID CỦA NGƯỜI DÙNG ĐANG ĐĂNG NHẬP.**
$user_id = 1; // **CẦN THAY THẾ BẰNG USER_ID THỰC TẾ**

// Truy vấn SQL để lấy danh sách sách yêu thích của người dùng hiện tại
$sql_wishlist_books = "SELECT w.id AS wishlist_id, w.book_id, b.title, b.author, w.added_at
                         FROM wishlist AS w
                         JOIN books AS b ON w.book_id = b.id
                         WHERE w.user_id = $user_id";
$result_wishlist_books = $conn->query($sql_wishlist_books);

$wishlist_books = []; // Mảng chứa danh sách sách yêu thích
if ($result_wishlist_books->num_rows > 0) {
    while ($row = $result_wishlist_books->fetch_assoc()) {
        $wishlist_books[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Yêu Thích - Thư Viện</title>
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
            padding-top: 50px;
        }

        .wishlist-container {
            max-width: 960px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .wishlist-title {
            text-align: center;
            color: #e53935; /* Màu đỏ của wishlist */
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .wishlist-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .wishlist-table th,
        .wishlist-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }

        .wishlist-table th {
            background-color: #e53935; /* Màu đỏ của wishlist header */
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .wishlist-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .wishlist-table tbody tr:hover {
            background-color: #e9ecef;
        }

        .wishlist-actions {
            text-align: center;
        }

        .wishlist-actions button {
            margin: 5px;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 500;
            transition: transform 0.2s ease-in-out;
            background-color: #dc3545; /* Màu đỏ nút xóa */
            border-color: #dc3545;
            color: white;
        }

        .wishlist-actions button:hover {
            transform: scale(1.05);
            background-color: #c82333;
            border-color: #bd2130;
        }


        .no-wishlist-message {
            text-align: center;
            font-style: italic;
            color: #6c757d;
            padding: 20px;
        }

        .book-cover-small {
            max-height: 80px;
        }
    </style>
</head>
<body>
    <?php include 'pages/header.php'; ?>
    <div class="container wishlist-container py-5">
        <h2 class="wishlist-title"><i class="fas fa-heart mr-2"></i> Danh Sách Yêu Thích</h2>

        <?php if (empty($wishlist_books)): ?>
            <p class="no-wishlist-message">Danh sách yêu thích của bạn hiện đang trống.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="wishlist-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên Sách</th>
                            <th>Tác Giả</th>
                            <th>Ngày Thêm</th>
                            <th class="text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($wishlist_books as $index => $book): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($book['title']); ?></td>
                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($book['added_at']))); ?></td>
                                <td class="wishlist-actions">
                                    <button class="btn btn-danger btn-remove-wishlist" onclick="removeFromWishlist(<?php echo $book['wishlist_id']; ?>)">
                                        <i class="fas fa-trash-alt mr-1"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <?php include 'pages/footer.php'; ?>

    <script>
        function removeFromWishlist(wishlistId) {
            if (confirm('Bạn có chắc chắn muốn xóa sách này khỏi danh sách yêu thích?')) {
                fetch('remove_from_wishlist.php?wishlist_id=' + wishlistId)
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Hiển thị thông báo từ server
                        if (data.includes('thành công')) {
                            // Tải lại trang để cập nhật danh sách yêu thích
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        alert('Có lỗi xảy ra khi xóa khỏi danh sách yêu thích. Vui lòng thử lại sau.');
                    });
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>