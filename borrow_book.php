<?php
require_once 'config.php';

$book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;

if ($book_id <= 0) {
    echo "ID sách không hợp lệ.";
    exit;
}

// --- BƯỚC 1: Kiểm tra sách còn không ---
$sql_check_quantity = "SELECT quantity FROM books WHERE id = " . $book_id;
$result_quantity = $conn->query($sql_check_quantity);

if ($result_quantity->num_rows > 0) {
    $row_quantity = $result_quantity->fetch_assoc();
    $current_quantity = $row_quantity['quantity'];

    if ($current_quantity <= 0) {
        echo "Sách hiện đang hết hàng.";
        $conn->close();
        exit;
    }
} else {
    echo "Không tìm thấy sách."; // Trường hợp không tìm thấy sách (lỗi)
    $conn->close();
    exit;
}


// --- BƯỚC 2: Giảm số lượng sách (nếu có quản lý số lượng) ---
// Nếu bạn có trường 'quantity' và muốn giảm khi mượn
$sql_update_quantity = "UPDATE books SET quantity = quantity - 1 WHERE id = " . $book_id;
if ($conn->query($sql_update_quantity) !== TRUE) {
    echo "Lỗi khi cập nhật số lượng sách: " . $conn->error;
    $conn->close();
    exit;
}


// --- BƯỚC 3: Thêm bản ghi mượn sách vào bảng 'borrows_records' ---
// **LƯU Ý QUAN TRỌNG:**
// Trong ví dụ này, chúng ta GIẢ ĐỊNH user_id = 1 (ví dụ user đang đăng nhập).
// **TRONG ỨNG DỤNG THỰC TẾ, BẠN CẦN LẤY USER_ID CỦA NGƯỜI DÙNG ĐANG ĐĂNG NHẬP.**
$user_id = 1; // **CẦN THAY THẾ BẰNG USER_ID THỰC TẾ**
$borrow_date = date('Y-m-d'); // Ngày mượn là ngày hiện tại
$due_date = date('Y-m-d', strtotime('+7 days')); // Ngày hết hạn sau 7 ngày (ví dụ)
$borrow_status = 'borrowed'; // Trạng thái mượn sách

$sql_insert_borrow = "INSERT INTO borrows_records (book_id, user_id, borrow_date, due_date, borrow_status)
                       VALUES ($book_id, $user_id, '$borrow_date', '$due_date', '$borrow_status')";

if ($conn->query($sql_insert_borrow) === TRUE) {
    echo "Mượn sách thành công!";
} else {
    echo "Lỗi khi mượn sách: " . $conn->error;
    // **[TÙY CHỌN - XỬ LÝ ROLLBACK]:**
    // Nếu thêm bản ghi mượn sách lỗi, bạn có thể muốn hoàn tác việc giảm số lượng sách
    // (ví dụ: UPDATE books SET quantity = quantity + 1 WHERE id = ... )
}

$conn->close();
?>