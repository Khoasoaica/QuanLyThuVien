<?php
require_once 'config.php';

$wishlist_id = isset($_GET['wishlist_id']) ? $_GET['wishlist_id'] : 0;

if ($wishlist_id <= 0) {
    echo "ID wishlist không hợp lệ.";
    exit;
}

// --- BƯỚC 1: Xóa sách khỏi bảng 'wishlist' ---
$sql_delete_wishlist = "DELETE FROM wishlist WHERE id = " . $wishlist_id;

if ($conn->query($sql_delete_wishlist) === TRUE) {
    echo "Xóa khỏi danh sách yêu thích thành công!";
} else {
    echo "Lỗi khi xóa khỏi danh sách yêu thích: " . $conn->error;
}

$conn->close();
?>