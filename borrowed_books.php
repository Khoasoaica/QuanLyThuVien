<?php
require_once 'config.php';

// **LƯU Ý QUAN TRỌNG:**
// Trong ví dụ này, chúng ta GIẢ ĐỊNH user_id = 1 (ví dụ user đang đăng nhập).
// **TRONG ỨNG DỤNG THỰC TẾ, BẠN CẦN LẤY USER_ID CỦA NGƯỜI DÙNG ĐANG ĐĂNG NHẬP.**
$user_id = 1; // **CẦN THAY THẾ BẰNG USER_ID THỰC TẾ**

// Truy vấn SQL để lấy danh sách sách đã mượn của người dùng hiện tại
$sql_borrowed_books = "SELECT br.id AS borrow_record_id, br.book_id, b.title, b.author, br.borrow_date, br.due_date, br.borrow_status
                         FROM borrows_records AS br
                         JOIN books AS b ON br.book_id = b.id
                         WHERE br.user_id = $user_id AND br.borrow_status = 'borrowed'"; // Chỉ lấy sách đang mượn
$result_borrowed_books = $conn->query($sql_borrowed_books);

$borrowed_books = []; // Mảng chứa danh sách sách đã mượn
if ($result_borrowed_books->num_rows > 0) {
    while ($row = $result_borrowed_books->fetch_assoc()) {
        $borrowed_books[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sách Đã Mượn - Thư Viện</title>
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

        .borrowed-books-container {
            max-width: 960px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Stronger shadow */
        }

        .borrowed-books-title {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
            font-size: 2.5rem; /* Larger title */
            font-weight: 700;
        }

        .borrowed-books-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px; /* Increased bottom margin */
            border-radius: 8px; /* Rounded table corners */
            overflow: hidden; /* Ensure rounded corners are visible */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05); /* Subtle table shadow */
        }

        .borrowed-books-table th,
        .borrowed-books-table td {
            padding: 15px 20px; /* More padding */
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }

        .borrowed-books-table th {
            background-color: #007bff; /* Blue header */
            color: white;
            font-weight: bold;
            text-transform: uppercase; /* Uppercase header text */
            letter-spacing: 0.8px; /* Spacing for header text */
        }

        .borrowed-books-table tbody tr:nth-child(even) {
            background-color: #f8f9fa; /* Even row background */
        }

        .borrowed-books-table tbody tr:hover {
            background-color: #e9ecef; /* Hover background */
        }

        .borrow-actions {
            text-align: center; /* Center action buttons */
        }

        .borrow-actions button {
            margin: 5px; /* Spacing around buttons */
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 500; /* Bold button text */
            transition: transform 0.2s ease-in-out; /* Button hover animation */
        }

        .borrow-actions button:hover {
            transform: scale(1.05); /* Button hover scale */
        }


        .btn-return {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-return:hover {
            background-color: #218838;
            border-color: #218838;
        }

        .btn-renew {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #343a40;
        }

        .btn-renew:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .no-books-message {
            text-align: center;
            font-style: italic;
            color: #6c757d;
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include 'pages/header.php'; ?>
    <div class="container borrowed-books-container py-5">
        <h2 class="borrowed-books-title"><i class="fas fa-book-reader mr-2"></i> Sách Bạn Đang Mượn</h2>

        <?php if (empty($borrowed_books)): ?>
            <p class="no-books-message">Hiện tại bạn chưa mượn cuốn sách nào.</p>
        <?php else: ?>
            <div class="table-responsive">
            <table class="borrowed-books-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên Sách</th>
                        <th>Tác Giả</th>
                        <th>Ngày Mượn</th>
                        <th>Ngày Hết Hạn</th>
                        <th>Trạng Thái</th>
                        <th class="text-center">Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrowed_books as $index => $book): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                            <td><?php echo htmlspecialchars($book['author']); ?></td>
                            <td><?php echo htmlspecialchars($book['borrow_date']); ?></td>
                            <td><?php echo htmlspecialchars($book['due_date']); ?></td>
                            <td>
                                <?php
                                    if ($book['borrow_status'] == 'borrowed') {
                                        echo '<span class="badge badge-primary">Đang mượn</span>';
                                    } else {
                                        echo htmlspecialchars($book['borrow_status']);
                                    }
                                ?>
                            </td>
                            <td class="borrow-actions">
                                <button class="btn btn-success btn-return" onclick="returnBook(<?php echo $book['borrow_record_id']; ?>)">
                                    <i class="fas fa-check-circle mr-1"></i> Trả sách
                                </button>
                                <button class="btn btn-warning btn-renew" onclick="renewBook(<?php echo $book['borrow_record_id']; ?>)">
                                    <i class="fas fa-calendar-plus mr-1"></i> Gia hạn
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
        function returnBook(borrowRecordId) {
            if (confirm('Bạn có chắc chắn muốn trả sách này?')) {
                fetch('return_book.php?borrow_record_id=' + borrowRecordId)
                    .then(response => response.text())
                    .then(data => {
                        alert(data); // Hiển thị thông báo từ server
                        if (data.includes('thành công')) {
                            // Tải lại trang để cập nhật danh sách sách đã mượn
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi:', error);
                        alert('Có lỗi xảy ra khi trả sách. Vui lòng thử lại sau.');
                    });
            }
        }

        function renewBook(borrowRecordId) {
            // 1. Hiển thị hộp thoại prompt để nhập số ngày gia hạn
            let renewDays = prompt("Nhập số ngày gia hạn (tối đa 7 ngày):", "7");

            // 2. Kiểm tra giá trị nhập vào
            if (renewDays != null && !isNaN(renewDays)) { // Kiểm tra không bị cancel và là số
                renewDays = parseInt(renewDays); // Chuyển sang số nguyên
                if (renewDays > 0 && renewDays <= 7) { // Kiểm tra số ngày hợp lệ (1-7)

                    // 3. Gửi yêu cầu gia hạn đến renew_book.php kèm số ngày
                    fetch('renew_book.php?borrow_record_id=' + borrowRecordId + '&renew_days=' + renewDays)
                        .then(response => response.text())
                        .then(data => {
                            alert(data); // Hiển thị thông báo từ server
                            if (data.includes('thành công')) {
                                // Tải lại trang để cập nhật danh sách sách đã mượn
                                window.location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            alert('Có lỗi xảy ra khi gia hạn sách. Vui lòng thử lại sau.');
                        });

                } else {
                    alert("Số ngày gia hạn không hợp lệ. Vui lòng nhập số từ 1 đến 7.");
                }
            } else if (renewDays != null) { // Trường hợp nhập không phải số
                alert("Vui lòng nhập số ngày gia hạn hợp lệ.");
            }
            // Trường hợp người dùng bấm "Cancel" trong prompt thì không làm gì cả
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>