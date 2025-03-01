<?php
require_once 'config.php';

$borrow_record_id = isset($_GET['borrow_record_id']) ? $_GET['borrow_record_id'] : 0;

if ($borrow_record_id <= 0) {
    echo "ID bản ghi mượn không hợp lệ.";
    exit;
}

// --- BƯỚC 1: Lấy book_id từ borrow_record_id ---
$sql_get_book_id = "SELECT book_id FROM borrows_records WHERE id = " . $borrow_record_id;
$result_book_id = $conn->query($sql_get_book_id);

if ($result_book_id->num_rows <= 0) {
    echo "Không tìm thấy bản ghi mượn.";
    $conn->close();
    exit;
}
$row_book_id = $result_book_id->fetch_assoc();
$book_id = $row_book_id['book_id'];

// --- BƯỚC 2: Cập nhật trạng thái mượn sách thành 'returned' trong bảng 'borrows_records' ---
$sql_update_borrow_status = "UPDATE borrows_records SET borrow_status = 'returned' WHERE id = " . $borrow_record_id;
if ($conn->query($sql_update_borrow_status) !== TRUE) {
    echo "Lỗi khi cập nhật trạng thái trả sách: " . $conn->error;
    $conn->close();
    exit;
}

// --- BƯỚC 3: Tăng số lượng sách trong bảng 'books' (nếu có quản lý số lượng) ---
// Nếu bạn có trường 'quantity' và muốn tăng khi trả sách
$sql_update_quantity = "UPDATE books SET quantity = quantity + 1 WHERE id = " . $book_id;
if ($conn->query($sql_update_quantity) !== TRUE) {
    echo "Lỗi khi cập nhật số lượng sách: " . $conn->error;
    $conn->close();
    exit;
}

echo "Trả sách thành công!";

$conn->close();
?>