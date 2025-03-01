<?php
require_once 'config.php';

$book_id = isset($_GET['book_id']) ? $_GET['book_id'] : 0;

if ($book_id <= 0) {
    echo "ID sách không hợp lệ.";
    exit;
}

// --- BƯỚC 1: Kiểm tra xem sách đã có trong wishlist chưa (tùy chọn) ---
// Để tránh trùng lặp, bạn có thể kiểm tra xem sách đã có trong wishlist của user chưa
// **LƯU Ý QUAN TRỌNG:** Tương tự như mượn sách, chúng ta GIẢ ĐỊNH user_id = 1.
$user_id = 1; // **CẦN THAY THẾ BẰNG USER_ID THỰC TẾ**

$sql_check_wishlist = "SELECT id FROM wishlist WHERE user_id = $user_id AND book_id = $book_id";
$result_wishlist_check = $conn->query($sql_check_wishlist);

if ($result_wishlist_check->num_rows > 0) {
    echo "Sách này đã có trong danh sách yêu thích của bạn rồi.";
    $conn->close();
    exit;
}


// --- BƯỚC 2: Thêm sách vào bảng 'wishlist' ---
// **Giả sử bạn có bảng 'wishlist' với các cột: id, user_id, book_id, added_at**
$added_at = date('Y-m-d H:i:s'); // Thời điểm thêm vào wishlist

$sql_insert_wishlist = "INSERT INTO wishlist (user_id, book_id, added_at)
                        VALUES ($user_id, $book_id, '$added_at')";

if ($conn->query($sql_insert_wishlist) === TRUE) {
    echo "Đã thêm vào danh sách yêu thích!";
} else {
    echo "Lỗi khi thêm vào danh sách yêu thích: " . $conn->error;
}

$conn->close();
?>