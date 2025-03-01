<?php
require_once '../config.php';

$signup_success = false;
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['confirm_password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password !== $confirm_password) {
            $error_message = "Mật khẩu nhập lại không khớp!";
        } elseif (strlen($password) < 6) {
            $error_message = "Mật khẩu phải có ít nhất 6 ký tự!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $role = 'user';

            $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error_message = "Tên đăng nhập đã tồn tại!";
            } else {
                $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $username, $hashed_password, $role);
                if ($stmt->execute()) {
                    $signup_success = true;
                } else {
                    $error_message = "Lỗi đăng ký: " . $stmt->error;
                }
            }
            $stmt->close();
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
    <title>Đăng ký tài khoản - Thư Viện Cao Cấp</title>
    <link rel="stylesheet" href="../css/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<div class="register-page-container">
    <div class="register-card-container">
        <div class="card register-card shadow-lg border-0 rounded-lg overflow-hidden">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h1 class="register-title">Tạo tài khoản</h1>
                    <p class="register-subtitle">Chào mừng đến với thư viện sách trực tuyến!</p>
                </div>

                <?php if ($signup_success): ?>
                    <div class="alert alert-success text-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> Đăng ký thành công! <a href="login.php" class="alert-link">Đăng nhập</a>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>

                <form class="user" method="POST" class="needs-validation" novalidate>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control register-input rounded-pill" id="username" name="username" placeholder="Tên đăng nhập" required>
                        <label for="username" class="register-label">Tên đăng nhập</label>
                        <div class="invalid-feedback">Vui lòng nhập tên đăng nhập.</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control register-input rounded-pill" id="password" name="password" placeholder="Mật khẩu" required>
                        <label for="password" class="register-label">Mật khẩu</label>
                        <div class="invalid-feedback">Vui lòng nhập mật khẩu.</div>
                        <small class="text-muted">Mật khẩu phải có ít nhất 6 ký tự</small>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control register-input rounded-pill" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required>
                        <label for="confirm_password" class="register-label">Nhập lại mật khẩu</label>
                        <div class="invalid-feedback">Vui lòng nhập lại mật khẩu.</div>
                    </div>

                    <button type="submit" class="btn btn-primary register-button btn-block rounded-pill">
                        Đăng ký tài khoản
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a class="register-login-link small" href="login.php">Đã có tài khoản? Đăng nhập!</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
</body>
</html>