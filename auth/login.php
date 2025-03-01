<?php
session_start();

require_once '../config.php';

$error_message = "";
$login_success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $db_username, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $login_success = true;

                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $db_username;

                header("Location: ../index.php?login_success=true");
                if ($username === $admin_username && $password === $admin_password) {
            $_SESSION['admin_logged_in'] = true;
        } else {
            $login_error = "Tên đăng nhập hoặc mật khẩu không đúng.";
        }
    }
                exit();

            } else {
                $error_message = "Mật khẩu không đúng!";
            }
        } else {
            $error_message = "Tên đăng nhập không tồn tại!";
        }
        $stmt->close();
    } else {
        $error_message = "Vui lòng nhập tên đăng nhập và mật khẩu!";
    }

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Thư Viện Cao Cấp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <style>
        
/* ... (các CSS khác của bạn) ... */
.login-page-container {
    background: linear-gradient(to right, #e0f7fa, #b2ebf2, #80deea); /* Subtle gradient background */
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px; /* Add some padding around the container */
}

.login-card-container {
    max-width: 500px; /* Slightly narrower card */
    width: 100%;
}

.login-card {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); /* More pronounced shadow */
}

.login-card .card-body {
    padding: 3rem; /* Increased padding inside card body */
}

.login-title {
    font-size: 2.5rem; /* Larger title */
    color: #263238; /* Darker title color */
    font-weight: 700;
    margin-bottom: 10px;
}

.login-subtitle {
    color: #546e7a; /* Muted subtitle color */
    font-size: 1.1rem;
    margin-bottom: 25px;
}

.login-label {
    color: #37474f; /* Darker label color */
    font-weight: 500;
}

.login-input {
    border: 1px solid #cfd8dc; /* Light border for inputs */
    padding: 1rem; /* Increased input padding */
    font-size: 1rem;
    color: #455a64; /* Input text color */
}

.login-input:focus {
    border-color: #00bcd4; /* Highlight color on focus */
    box-shadow: 0 0 0 0.2rem rgba(0, 188, 212, 0.25); /* Focus shadow */
}

.login-button {
    padding: 1rem 1.5rem; /* Button padding */
    font-size: 1.2rem; /* Larger button text */
    font-weight: 600;
    border: none;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2); /* Button shadow */
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.login-button:hover {
    transform: translateY(-2px); /* Slight lift on hover */
    box-shadow: 0 7px 20px rgba(0, 0, 0, 0.25); /* Increased shadow on hover */
}

.login-login-link {
    color: #0097a7; /* Link color */
    font-weight: 500;
}

.login-login-link:hover {
    color: #00bcd4; /* Link hover color */
    text-decoration: underline;
}

    </style>
</head>
<body class="bg-light">

<div class="login-page-container">
    <div class="login-card-container">
        <div class="card login-card shadow-lg border-0 rounded-lg overflow-hidden">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h1 class="login-title">Chào mừng trở lại</h1>
                    <p class="login-subtitle">Đăng nhập để tiếp tục khám phá thư viện!</p>
                </div>

                <?php if (!empty($error_message)): ?>
                    <div class="alert alert-danger text-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>

                <form class="user" method="POST">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control login-input rounded-pill" id="username" name="username" placeholder="Tên đăng nhập" required>
                        <label for="username" class="login-label">Tên đăng nhập</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control login-input rounded-pill" id="password" name="password" placeholder="Mật khẩu" required>
                        <label for="password" class="login-label">Mật khẩu</label>
                    </div>

                    <button type="submit" class="btn btn-primary login-button btn-block rounded-pill">
                        Đăng nhập
                    </button>
                </form>

                <hr>

                <div class="text-center">
                    <a class="login-forgot-link small" href="forgot_password.php">Quên mật khẩu?</a> <br>
                    <a class="login-register-link small" href="register.php">Chưa có tài khoản? Đăng ký ngay!</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>