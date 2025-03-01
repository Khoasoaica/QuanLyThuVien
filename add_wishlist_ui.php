<?php
require_once 'config.php';

$book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;
$message = ""; // Biến để lưu thông báo

if ($book_id <= 0) {
    $message = "ID sách không hợp lệ.";
} else {
    // --- BƯỚC 1: Kiểm tra xem sách đã có trong wishlist chưa (tùy chọn) ---
    $user_id = 1; // **CẦN THAY THẾ BẰNG USER_ID THỰC TẾ**

    $sql_check_wishlist = "SELECT id FROM wishlist WHERE user_id = $user_id AND book_id = $book_id";
    $result_wishlist_check = $conn->query($sql_check_wishlist);

    if ($result_wishlist_check->num_rows > 0) {
        $message = "Sách này đã có trong danh sách yêu thích của bạn rồi.";
    } else {
        // --- BƯỚC 2: Thêm sách vào bảng 'wishlist' ---
        $added_at = date('Y-m-d H:i:s');

        $sql_insert_wishlist = "INSERT INTO wishlist (user_id, book_id, added_at)
                                 VALUES ($user_id, $book_id, '$added_at')";

        if ($conn->query($sql_insert_wishlist) === TRUE) {
            $message = "Đã thêm vào danh sách yêu thích!";
        } else {
            $message = "Lỗi khi thêm vào danh sách yêu thích: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm vào Yêu thích - Thư Viện</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #495057;
            padding-top: 50px;
        }

        .wishlist-add-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .wishlist-add-title {
            text-align: center;
            color: #e53935; /* Màu đỏ của wishlist */
            margin-bottom: 30px;
        }

        .message-box {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 8px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .back-button {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container wishlist-add-container">
        <h2 class="wishlist-add-title">Thêm vào Danh Sách Yêu Thích</h2>

        <?php if ($message): ?>
            <div class="message-box <?php echo (strpos($message, 'thành công') !== false) ? 'success-message' : 'error-message'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="back-button">
            <a href="books.php?id=<?php echo $book_id; ?>" class="btn btn-secondary">Quay lại trang sách</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>