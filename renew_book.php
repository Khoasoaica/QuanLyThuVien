<?php
require_once 'config.php';

$borrow_record_id = isset($_GET['borrow_record_id']) ? $_GET['borrow_record_id'] : 0;
$renew_days = isset($_GET['renew_days']) ? $_GET['renew_days'] : 0; // Lấy số ngày gia hạn từ GET

if ($borrow_record_id <= 0) {
    echo "ID bản ghi mượn không hợp lệ.";
    exit;
}

// --- BƯỚC 1: Kiểm tra số ngày gia hạn hợp lệ ---
if (!is_numeric($renew_days) || $renew_days <= 0 || $renew_days > 7) {
    echo "Số ngày gia hạn không hợp lệ. Vui lòng nhập số từ 1 đến 7.";
    $conn->close();
    exit;
}
$renew_days = intval($renew_days); // Chuyển sang số nguyên

// --- BƯỚC 2: Kiểm tra xem có được phép gia hạn không (ví dụ: chưa quá hạn, số lần gia hạn...) ---
// **[TÙY CHỌN - THÊM LOGIC KIỂM TRA GIA HẠN TẠI ĐÂY NẾU CẦN]**
// Ví dụ đơn giản: Không kiểm tra điều kiện gì, luôn cho phép gia hạn nếu số ngày hợp lệ

// --- BƯỚC 3: Cập nhật ngày hết hạn (due_date) trong bảng 'borrows_records' ---
$sql_update_due_date = "UPDATE borrows_records SET due_date = DATE_ADD(due_date, INTERVAL $renew_days DAY) WHERE id = " . $borrow_record_id; // Gia hạn thêm số ngày yêu cầu
if ($conn->query($sql_update_due_date) !== TRUE) {
    echo "Lỗi khi gia hạn sách: " . $conn->error;
    $conn->close();
    exit;
}

echo "Gia hạn sách thành công! Ngày hết hạn mới đã được cập nhật."; // Thông báo gia hạn thành công

$conn->close();
?>