<?php
session_start();
include 'config.php';
$user_id = $_SESSION['user']['id'];
$book_id = $_GET['book_id'];
$borrow_date = date('Y-m-d');
$sql = "INSERT INTO borrow_records (user_id, book_id, borrow_date, status) VALUES ('$user_id', '$book_id', '$borrow_date', 'borrowed')";
if ($conn->query($sql)) {
    $conn->query("UPDATE books SET status='borrowed' WHERE id='$book_id'");
    echo "Mượn sách thành công!";
} else {
    echo "Lỗi: " . $conn->error;
}
?>