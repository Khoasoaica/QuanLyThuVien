<?php
session_start();

require_once '../config.php'; // Đảm bảo file config.php đã được tạo và chứa thông tin kết nối CSDL

$error_message = "";
$reset_success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['re_password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $re_password = $_POST['re_password'];

        if ($password != $re_password) {
            $error_message = "Mật khẩu và mật khẩu nhập lại không trùng khớp!";
        } else {
            // ==================================================================
            // THỰC HIỆN LOGIC ĐẶT LẠI MẬT KHẨU Ở ĐÂY
            // ==================================================================
            // 1. Kiểm tra xem tên đăng nhập có tồn tại trong CSDL không
            $stmt = $conn->prepare("SELECT id, username FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($user_id, $db_username);
                $stmt->fetch();
                $stmt->close();

                // 2. Nếu tên đăng nhập tồn tại, tạo mật khẩu hash mới từ $password
                $new_hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // 3. Cập nhật mật khẩu hash mới vào CSDL cho người dùng có tên đăng nhập tương ứng
                $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $update_stmt->bind_param("si", $new_hashed_password, $user_id);

                if ($update_stmt->execute()) {
                    // 4. (Tùy chọn) Gửi email thông báo đặt lại mật khẩu thành công (bạn có thể thêm ở đây nếu cần)

                    $reset_success = true;
                    // 5. Chuyển hướng người dùng đến trang đăng nhập sau khi thành công
                    header("Location: login.php?reset_password_success=true");
                    exit();

                } else {
                    // Lỗi cập nhật mật khẩu vào CSDL
                    $error_message = "Có lỗi xảy ra khi cập nhật mật khẩu. Vui lòng thử lại sau!";
                }
                $update_stmt->close();


            } else {
                // Tên đăng nhập không tồn tại
                $error_message = "Tên đăng nhập không tồn tại!";
                $stmt->close(); // Đóng statement ở đây nếu không tìm thấy username
            }
            // ==================================================================

        }

    } else {
        $error_message = "Vui lòng nhập đầy đủ thông tin!";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - Thư Viện Cao Cấp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <style>
        /* ================== Forgot Password Page Styles ================== */
.forgot-password-page-container {
    background: linear-gradient(to right, #e0f7fa, #b2ebf2, #80deea); /* Subtle gradient background */
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px; /* Add some padding around the container */
}

.forgot-password-card-container {
    max-width: 500px; /* Slightly narrower card */
    width: 100%;
}

.forgot-password-card {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); /* More pronounced shadow */
}

.forgot-password-card .card-body {
    padding: 3rem; /* Increased padding inside card body */
}

.forgot-password-title {
    font-size: 2.5rem; /* Larger title */
    color: #263238; /* Darker title color */
    font-weight: 700;
    margin-bottom: 10px;
}

.forgot-password-subtitle {
    color: #546e7a; /* Muted subtitle color */
    font-size: 1.1rem;
    margin-bottom: 25px;
}

.forgot-password-label {
    color: #37474f; /* Darker label color */
    font-weight: 500;
}

.forgot-password-input {
    border: 1px solid #cfd8dc; /* Light border for inputs */
    padding: 1rem; /* Increased input padding */
    font-size: 1rem;
    color: #455a64; /* Input text color */
}

.forgot-password-input:focus {
    border-color: #00bcd4; /* Highlight color on focus */
    box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.25); /* Focus shadow */
}

.forgot-password-button {
    padding: 1rem 1.5rem; /* Button padding */
    font-size: 1.2rem; /* Larger button text */
    font-weight: 600;
    border: none;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Button shadow */
    transition: transform 0.2s ease-in-out;
    box-shadow: 0 7px 20px rgba(0, 0, 0, 0.25); /* Increased shadow on hover */
}

.forgot-password-button:hover {
    transform: translateY(-2px); /* Slight lift on hover */
    box-shadow: 0 7px 20px rgba(0, 0, 0, 0.25); /* Increased shadow on hover */
}

.forgot-password-login-link {
    color: #0097a7; /* Link color */
    font-weight: 500;
}

.forgot-password-login-link:hover {
    color: #00bcd4; /* Link hover color */
    text-decoration: underline;
}
    </style>
</head>
<body class="bg-light">

<div class="forgot-password-page-container">
    <div class="forgot-password-card-container">
        <div class="card forgot-password-card shadow-lg border-0 rounded-lg overflow-hidden">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h1 class="forgot-password-title">Quên mật khẩu</h1>
                    <p class="forgot-password-subtitle">Vui lòng nhập tên đăng nhập và mật khẩu mới của bạn.</p>
                </div>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>

                <?php if ($reset_success): ?>
                    <div class="alert alert-success text-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> Mật khẩu đã được đặt lại thành công! Vui lòng <a href="login.php" class="alert-link">đăng nhập lại</a>.
                    </div>
                <?php endif; ?>

                <form class="user" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control forgot-password-input rounded-pill" id="username" name="username" placeholder="Tên đăng nhập" required>
                        <label for="username" class="forgot-password-label">Tên đăng nhập</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control forgot-password-input rounded-pill" id="password" name="password" placeholder="Mật khẩu mới" required>
                        <label for="password" class="forgot-password-label">Mật khẩu mới</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control forgot-password-input rounded-pill" id="re_password" name="re_password" placeholder="Nhập lại mật khẩu mới" required>
                        <label for="re_password" class="forgot-password-label">Nhập lại mật khẩu mới</label>
                    </div>

                    <button type="submit" class="btn btn-primary forgot-password-button btn-block rounded-pill">
                        Đặt lại mật khẩu
                    </button>
                </form>

                <hr>

                <div class="text-center">
                    <a class="forgot-password-login-link small" href="login.php">Quay lại đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>