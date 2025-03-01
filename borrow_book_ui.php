<?php
require_once 'config.php';

$book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;
$message = ""; // Biến để lưu thông báo

if ($book_id <= 0) {
    $message = "ID sách không hợp lệ.";
} else {
    // --- BƯỚC 1: Kiểm tra sách còn không ---
    $sql_check_quantity = "SELECT quantity FROM books WHERE id = " . $book_id;
    $result_quantity = $conn->query($sql_check_quantity);

    if ($result_quantity->num_rows > 0) {
        $row_quantity = $result_quantity->fetch_assoc();
        $current_quantity = $row_quantity['quantity'];

        if ($current_quantity <= 0) {
            $message = "Sách hiện đang hết hàng.";
        } else {
            // --- BƯỚC 2: Giảm số lượng sách (nếu có quản lý số lượng) ---
            $sql_update_quantity = "UPDATE books SET quantity = quantity - 1 WHERE id = " . $book_id;
            if ($conn->query($sql_update_quantity) !== TRUE) {
                $message = "Lỗi khi cập nhật số lượng sách: " . $conn->error;
            } else {
                // --- BƯỚC 3: Thêm bản ghi mượn sách vào bảng 'borrows_records' ---
                $user_id = 1; // **CẦN THAY THẾ BẰNG USER_ID THỰC TẾ**
                $borrow_date = date('Y-m-d');
                $due_date = date('Y-m-d', strtotime('+7 days'));
                $borrow_status = 'borrowed';

                $sql_insert_borrow = "INSERT INTO borrows_records (book_id, user_id, borrow_date, due_date, borrow_status)
                                       VALUES ($book_id, $user_id, '$borrow_date', '$due_date', '$borrow_status')";

                if ($conn->query($sql_insert_borrow) === TRUE) {
                    $message = "Mượn sách thành công!";
                } else {
                    $message = "Lỗi khi mượn sách: " . $conn->error;
                    // **[TÙY CHỌN - XỬ LÝ ROLLBACK]:**
                    // Nếu thêm bản ghi mượn sách lỗi, bạn có thể muốn hoàn tác việc giảm số lượng sách
                    // (ví dụ: UPDATE books SET quantity = quantity + 1 WHERE id = ... )
                }
            }
        }
    } else {
        $message = "Không tìm thấy sách.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mượn Sách - Thư Viện</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            color: #495057;
            padding-top: 50px;
        }

        .borrow-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .borrow-title {
            text-align: center;
            color: #007bff;
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
    <div class="container borrow-container">
        <h2 class="borrow-title">Xác nhận mượn sách</h2>

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