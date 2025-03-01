<?php
session_start();
include 'config.php';
$record_id = $_GET['record_id'];
$book_id = $_GET['book_id'];
$return_date = date('Y-m-d');
$conn->query("UPDATE borrow_records SET status='returned', return_date='$return_date' WHERE id='$record_id'");
$conn->query("UPDATE books SET status='available' WHERE id='$book_id'");
echo "Trả sách thành công!";
?>