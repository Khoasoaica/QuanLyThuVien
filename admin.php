<?php
session_start();

// --- TÀI KHOẢN ADMIN MẶC ĐỊNH ---
$admin_username = 'admin'; // **Tên đăng nhập admin mặc định**
$admin_password = '123456';

// --- Xử lý đăng xuất ---
if (isset($_GET['logout'])) {
    $_SESSION['admin_logged_in'] = false;
    session_destroy();
    header("Location: admin.php");
    exit();
}

// --- Kiểm tra đăng nhập ---
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($username === $admin_username && $password === $admin_password) {
            $_SESSION['admin_logged_in'] = true;
        } else {
            $login_error = "Tên đăng nhập hoặc mật khẩu không đúng.";
        }
    }

    // Form đăng nhập
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true || isset($login_error)) {
?>
        <!DOCTYPE html>
        <html>

        <head>
            <title>Admin Login</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    padding-top: 40px;
                    padding-bottom: 40px;
                    background-color: #f5f5f5;
                }

                .form-signin {
                    max-width: 330px;
                    padding: 15px;
                    margin: 0 auto;
                }

                .form-signin .form-control {
                    position: relative;
                    height: auto;
                    -webkit-box-sizing: border-box;
                    -moz-box-sizing: border-box;
                    box-sizing: border-box;
                    padding: 10px;
                    font-size: 16px;
                }

                .form-signin input[type="text"],
                .form-signin input[type="password"] {
                    margin-bottom: 10px;
                }
            </style>
        </head>

        <body>
            <div class="container text-center">
                <form class="form-signin" method="post">
                    <h2 class="form-signin-heading">Admin login</h2>
                    <?php if (isset($login_error)): ?>
                        <div class="alert alert-danger"><?= $login_error ?></div>
                    <?php endif; ?>
                    <label for="inputUsername" class="sr-only"></label>
                    <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Tên đăng nhập" required autofocus>
                    <label for="inputPassword" class="sr-only"></label>
                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Mật khẩu" required>
                    <button class="btn btn-lg btn-primary btn-block mt-3" type="submit" name="login">Đăng nhập</button>
                </form>
            </div>
        </body>

        </html>
<?php
        exit();
    }
}

require_once 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

$current_tab = $_GET['tab'] ?? 'users';

// --- Xử lý tìm kiếm ---
$search_users_id = $_GET['search_users_id'] ?? ''; // Tìm kiếm User theo ID
$search_users_name = $_GET['search_users_name'] ?? ''; // Tìm kiếm User theo Tên (thêm vào để linh hoạt)
$search_books = $_GET['search_books'] ?? '';
$search_borrows = $_GET['search_borrows'] ?? '';


// --- Xử lý Người dùng ---
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Người dùng mới đã được thêm thành công!'); window.location.href='admin.php?tab=users';</script>";
    } else {
        echo "<script>alert('Lỗi khi thêm người dùng: " . $conn->error . "'); window.location.href='admin.php?tab=users';</script>";
    }
}

if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    $sql = "DELETE FROM users WHERE id=$user_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Người dùng đã được xóa thành công!'); window.location.href='admin.php?tab=users';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa người dùng: " . $conn->error . "'); window.location.href='admin.php?tab=users';</script>";
    }
}


// --- Xử lý Sách ---
if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $publisher = $_POST['publisher'];
    $publication_year = $_POST['publication_year'];
    $isbn = $_POST['isbn'];
    $description = $_POST['description'];
    $image_path = $_POST['image_path'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];

    $sql = "INSERT INTO books (title, author, genre, publisher, publication_year, isbn, description, image_path, quantity, location)
            VALUES ('$title', '$author', '$genre', '$publisher', '$publication_year', '$isbn', '$description', '$image_path', '$quantity', '$location')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sách mới đã được thêm thành công!'); window.location.href='admin.php?tab=books';</script>";
    } else {
        echo "<script>alert('Lỗi khi thêm sách: " . $conn->error . "'); window.location.href='admin.php?tab=books';</script>";
    }
}

if (isset($_POST['edit_book'])) {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $publisher = $_POST['publisher'];
    $publication_year = $_POST['publication_year'];
    $isbn = $_POST['isbn'];
    $description = $_POST['description'];
    $image_path = $_POST['image_path'];
    $quantity = $_POST['quantity'];
    $location = $_POST['location'];

    $sql = "UPDATE books SET title='$title', author='$author', genre='$genre', publisher='$publisher',
            publication_year='$publication_year', isbn='$isbn', description='$description',
            image_path='$image_path', quantity='$quantity', location='$location' WHERE id=$book_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thông tin sách đã được cập nhật thành công!'); window.location.href='admin.php?tab=books';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật sách: " . $conn->error . "'); window.location.href='admin.php?tab=books';</script>";
    }
}

if (isset($_POST['delete_book'])) {
    $book_id = $_POST['book_id'];

    $sql = "DELETE FROM books WHERE id=$book_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sách đã được xóa thành công!'); window.location.href='admin.php?tab=books';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa sách: " . $conn->error . "'); window.location.href='admin.php?tab=books';</script>";
    }
}


// --- Xử lý Mượn Sách ---
if (isset($_POST['add_borrow'])) {
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];
    $borrow_date = $_POST['borrow_date'];
    $due_date = $_POST['due_date'];
    $borrow_status = $_POST['borrow_status'];
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO borrows_records (book_id, user_id, borrow_date, due_date, borrow_status, created_at, updated_at)
            VALUES ('$book_id', '$user_id', '$borrow_date', '$due_date', '$borrow_status', '$created_at', '$updated_at')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thông tin mượn sách đã được thêm thành công!'); window.location.href='admin.php?tab=borrows';</script>";
    } else {
        echo "<script>alert('Lỗi khi thêm thông tin mượn sách: " . $conn->error . "'); window.location.href='admin.php?tab=borrows';</script>";
    }
}

if (isset($_POST['edit_borrow'])) {
    $borrow_id = $_POST['borrow_id'];
    $book_id = $_POST['book_id'];
    $user_id = $_POST['user_id'];
    $borrow_date = $_POST['borrow_date'];
    $due_date = $_POST['due_date'];
    $borrow_status = $_POST['borrow_status'];
    $updated_at = date('Y-m-d H:i:s');

    $sql = "UPDATE borrows_records SET book_id='$book_id', user_id='$user_id', borrow_date='$borrow_date',
            due_date='$due_date', borrow_status='$borrow_status', updated_at='$updated_at' WHERE id=$borrow_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thông tin mượn sách đã được cập nhật thành công!'); window.location.href='admin.php?tab=borrows';</script>";
    } else {
        echo "<script>alert('Lỗi khi cập nhật thông tin mượn sách: " . $conn->error . "'); window.location.href='admin.php?tab=borrows';</script>";
    }
}

if (isset($_POST['delete_borrow'])) {
    $borrow_id = $_POST['borrow_id'];
    $sql = "DELETE FROM borrows_records WHERE id=$borrow_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thông tin mượn sách đã được xóa thành công!'); window.location.href='admin.php?tab=borrows';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa thông tin mượn sách: " . $conn->error . "'); window.location.href='admin.php?tab=borrows';</script>";
    }
}


// --- Truy vấn dữ liệu cho các tab ---
// Người dùng
$sql_users = "SELECT id, username FROM users";
if ($search_users_id) {
    $sql_users .= " WHERE id = '$search_users_id'"; // Tìm kiếm theo ID
} elseif ($search_users_name) { // Nếu không tìm ID, tìm theo tên (thêm điều kiện else if)
    $sql_users .= " WHERE username LIKE '%$search_users_name%'";
}
$users = $conn->query($sql_users);

// Sách
$sql_books = "SELECT id, title, author, genre, publisher, publication_year, isbn, description, image_path, quantity, location FROM books";
if ($search_books) {
    $sql_books .= " WHERE title LIKE '%$search_books%'";
}
$books = $conn->query($sql_books);

// Mượn sách
$sql_borrows = "SELECT id, book_id, user_id, borrow_date, due_date, borrow_status, created_at, updated_at FROM borrows_records";
if ($search_borrows) {
    $sql_borrows .= " WHERE user_id LIKE '%$search_borrows%' OR book_id LIKE '%$search_borrows%'";
}
$borrows = $conn->query($sql_borrows);


$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Quản lý Thư viện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .content-section {
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="mt-4">Admin Panel - Quản lý Thư viện</h2>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php if ($current_tab == 'users') echo 'active'; ?>" id="users-tab" data-bs-toggle="tab" data-bs-target="#users-section" type="button" role="tab" aria-controls="users-section" aria-selected="<?php if ($current_tab == 'users') echo 'true';
                                                                                                                                                                                                                                            else echo 'false'; ?>">Người dùng</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php if ($current_tab == 'books') echo 'active'; ?>" id="books-tab" data-bs-toggle="tab" data-bs-target="#books-section" type="button" role="tab" aria-controls="books-section" aria-selected="<?php if ($current_tab == 'books') echo 'true';
                                                                                                                                                                                                                                            else echo 'false'; ?>">Sách</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php if ($current_tab == 'borrows') echo 'active'; ?>" id="borrows-tab" data-bs-toggle="tab" data-bs-target="#borrows-section" type="button" role="tab" aria-controls="borrows-section" aria-selected="<?php if ($current_tab == 'borrows') echo 'true';
                                                                                                                                                                                                                                                    else echo 'false'; ?>">Mượn Sách</button>
                </li>
            </ul>
            <a href="admin.php?logout=true" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
        </div>


        <div class="tab-content" id="myTabContent">

            <div id="users-section" class="content-section tab-pane fade <?php if ($current_tab == 'users') echo 'show active'; ?>" role="tabpanel" aria-labelledby="users-tab">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Quản lý Người dùng</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-plus"></i> Thêm Người dùng</button>
                        </div>
                        <div class="mt-2">
                            <form class="form-inline" method="GET" action="admin.php">
                                <input type="hidden" name="tab" value="users">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search_users_id" value="<?= $search_users_id ?>" placeholder="Tìm kiếm theo ID">
                                    <input type="text" class="form-control" name="search_users_name" value="<?= $search_users_name ?>" placeholder="Tìm kiếm theo Tên đăng nhập">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <a href="admin.php?tab=users" class="btn btn-outline-secondary"><i class="fas fa-sync-alt"></i> Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên đăng nhập</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($user = $users->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $user['id'] ?></td>
                                            <td><?= $user['username'] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-danger delete-user-btn"
                                                    data-bs-toggle="modal" data-bs-target="#deleteUserModal<?= $user['id'] ?>"
                                                    data-id="<?= $user['id'] ?>"
                                                    data-username="<?= htmlspecialchars($user['username']) ?>">
                                                    <i class="fas fa-trash-alt"></i> Xóa
                                                </button>
                                                <div class="modal fade" id="deleteUserModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="deleteUserModalLabel<?= $user['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteUserModalLabel<?= $user['id'] ?>">Xác nhận xóa người dùng</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Bạn có chắc chắn muốn xóa người dùng "<b><?= htmlspecialchars($user['username']) ?></b>" không?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Hủy</button>
                                                                <form method="POST" action="admin.php?tab=users" style="display: inline;">
                                                                    <input type="hidden" name="delete_user" value="1">
                                                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Xóa</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    <?php if ($users->num_rows == 0): ?>
                                        <tr>
                                            <td colspan="3" class="text-center">Không có người dùng.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="books-section" class="content-section tab-pane fade <?php if ($current_tab == 'books') echo 'show active'; ?>" role="tabpanel" aria-labelledby="books-tab">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Quản lý Sách</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal"><i class="fas fa-plus"></i> Thêm Sách</button>
                        </div>
                        <div class="mt-2">
                            <form class="form-inline" method="GET" action="admin.php">
                                <input type="hidden" name="tab" value="books">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search_books" value="<?= $search_books ?>" placeholder="Tìm kiếm sách theo tiêu đề">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <a href="admin.php?tab=books" class="btn btn-outline-secondary"><i class="fas fa-sync-alt"></i> Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tiêu đề</th>
                                        <th>Tác giả</th>
                                        <th>Thể loại</th>
                                        <th>Nhà xuất bản</th>
                                        <th>Năm xuất bản</th>
                                        <th>ISBN</th>
                                        <th>Mô tả</th>
                                        <th>Ảnh</th>
                                        <th>Số lượng</th>
                                        <th>Vị trí</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($book = $books->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $book['id'] ?></td>
                                            <td><?= $book['title'] ?></td>
                                            <td><?= $book['author'] ?></td>
                                            <td><?= $book['genre'] ?></td>
                                            <td><?= $book['publisher'] ?></td>
                                            <td><?= $book['publication_year'] ?></td>
                                            <td><?= $book['isbn'] ?></td>
                                            <td><?= $book['description'] ?></td>
                                            <td>
                                                <?php if ($book['image_path']): ?> <img src="<?php echo htmlspecialchars($book['image_path']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" class="book-cover-small" style="max-height: 100px; max-width: 80px;">
                                                <?php else: ?>
                                                    <i class="fas fa-book fa-3x"></i>
                                                <?php endif; ?>
                                            <td><?= $book['quantity'] ?></td>
                                            <td><?= $book['location'] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning edit-book-btn"
                                                    data-bs-toggle="modal" data-bs-target="#editBookModal<?= $book['id'] ?>"
                                                    data-id="<?= $book['id'] ?>"
                                                    data-title="<?= htmlspecialchars($book['title']) ?>"
                                                    data-author="<?= htmlspecialchars($book['author']) ?>"
                                                    data-genre="<?= htmlspecialchars($book['genre']) ?>"
                                                    data-publisher="<?= htmlspecialchars($book['publisher']) ?>"
                                                    data-publication_year="<?= $book['publication_year'] ?>"
                                                    data-isbn="<?= htmlspecialchars($book['isbn']) ?>"
                                                    data-description="<?= htmlspecialchars($book['description']) ?>"
                                                    data-image_path="<?= htmlspecialchars($book['image_path']) ?>"
                                                    data-quantity="<?= $book['quantity'] ?>"
                                                    data-location="<?= htmlspecialchars($book['location']) ?>">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger delete-book-btn"
                                                    data-bs-toggle="modal" data-bs-target="#deleteBookModal<?= $book['id'] ?>"
                                                    data-id="<?= $book['id'] ?>">
                                                    <i class="fas fa-trash-alt"></i> Xóa
                                                </button>
                                                <div class="modal fade" id="editBookModal<?= $book['id'] ?>" tabindex="-1" aria-labelledby="editBookModalLabel<?= $book['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editBookModalLabel<?= $book['id'] ?>">Sửa Sách</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="editBookForm<?= $book['id'] ?>" method="POST" action="admin.php?tab=books">
                                                                    <input type="hidden" name="edit_book" value="1">
                                                                    <input type="hidden" name="book_id" id="editBookId<?= $book['id'] ?>">
                                                                    <div class="mb-3">
                                                                        <label for="editBookTitle<?= $book['id'] ?>" class="form-label">Tiêu đề</label>
                                                                        <input type="text" class="form-control" id="editBookTitle<?= $book['id'] ?>" name="title" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="editBookAuthor<?= $book['id'] ?>" class="form-label">Tác giả</label>
                                                                        <input type="text" class="form-control" id="editBookAuthor<?= $book['id'] ?>" name="author" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="editBookGenre<?= $book['id'] ?>" class="form-label">Thể loại</label>
                                                                        <input type="text" class="form-control" id="editBookGenre<?= $book['id'] ?>" name="genre">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="editBookPublisher<?= $book['id'] ?>" class="form-label">Nhà xuất bản</label>
                                                                        <input type="text" class="form-control" id="editBookPublisher<?= $book['id'] ?>" name="publisher">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="editBookPublicationYear<?= $book['id'] ?>" class="form-label">Năm xuất bản</label>
                                                                        <input type="number" class="form-control" id="editBookPublicationYear<?= $book['id'] ?>" name="publication_year">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="editBookISBN<?= $book['id'] ?>" class="form-label">ISBN</label>
                                                                        <input type="text" class="form-control" id="editBookISBN<?= $book['id'] ?>" name="isbn">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="editBookDescription<?= $book['id'] ?>" class="form-label">Mô tả</label>
                                                                        <textarea class="form-control" id="editBookDescription<?= $book['id'] ?>" name="description"></textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="editBookImagePath<?= $book['id'] ?>" class="form-label">Đường dẫn ảnh</label>
                                                                        <input type="text" class="form-control" id="editBookImagePath<?= $book['id'] ?>" name="image_path">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="editBookQuantity<?= $book['id'] ?>" class="form-label">Số lượng</label>
                                                                        <input type="number" class="form-control" id="editBookQuantity<?= $book['id'] ?>" name="quantity" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="editBookLocation<?= $book['id'] ?>" class="form-label">Vị trí</label>
                                                                        <input type="text" class="form-control" id="editBookLocation<?= $book['id'] ?>" name="location">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Đóng</button>
                                                                <button type="submit" form="editBookForm<?= $book['id'] ?>" class="btn btn-primary"><i class="fas fa-save"></i> Lưu thay đổi</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="deleteBookModal<?= $book['id'] ?>" tabindex="-1" aria-labelledby="deleteBookModalLabel<?= $book['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteBookModalLabel<?= $book['id'] ?>">Xác nhận xóa sách</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Bạn có chắc chắn muốn xóa sách "<b><?= htmlspecialchars($book['title']) ?></b>" không?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Hủy</button>
                                                                <form method="POST" action="admin.php?tab=books" style="display: inline;">
                                                                    <input type="hidden" name="delete_book" value="1">
                                                                    <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Xóa</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    <?php if ($books->num_rows == 0): ?>
                                        <tr>
                                            <td colspan="12" class="text-center">Không có sách nào.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="borrows-section" class="content-section tab-pane fade <?php if ($current_tab == 'borrows') echo 'show active'; ?>" role="tabpanel" aria-labelledby="borrows-tab">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Quản lý Mượn Sách</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBorrowModal"><i class="fas fa-plus"></i> Thêm Mượn Sách</button>
                        </div>
                        <div class="mt-2">
                            <form class="form-inline" method="GET" action="admin.php">
                                <input type="hidden" name="tab" value="borrows">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search_borrows" value="<?= $search_borrows ?>" placeholder="Tìm kiếm theo User ID hoặc Book ID">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i> Tìm kiếm</button>
                                        <a href="admin.php?tab=borrows" class="btn btn-outline-secondary"><i class="fas fa-sync-alt"></i> Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Book ID</th>
                                        <th>User ID</th>
                                        <th>Ngày Mượn</th>
                                        <th>Ngày Hết Hạn</th>
                                        <th>Trạng Thái</th>
                                        <th>Ngày Tạo</th>
                                        <th>Ngày Cập Nhật</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($borrow = $borrows->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $borrow['id'] ?></td>
                                            <td><?= $borrow['book_id'] ?></td>
                                            <td><?= $borrow['user_id'] ?></td>
                                            <td><?= $borrow['borrow_date'] ?></td>
                                            <td><?= $borrow['due_date'] ?></td>
                                            <td><?= $borrow['borrow_status'] ?></td>
                                            <td><?= $borrow['created_at'] ?></td>
                                            <td><?= $borrow['updated_at'] ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-warning edit-borrow-btn"
                                                    data-bs-toggle="modal" data-bs-target="#editBorrowModal<?= $borrow['id'] ?>"
                                                    data-id="<?= $borrow['id'] ?>"
                                                    data-book_id="<?= $borrow['book_id'] ?>"
                                                    data-user_id="<?= $borrow['user_id'] ?>"
                                                    data-borrow_date="<?= $borrow['borrow_date'] ?>"
                                                    data-due_date="<?= $borrow['due_date'] ?>"
                                                    data-borrow_status="<?= $borrow['borrow_status'] ?>">
                                                    <i class="fas fa-edit"></i> Sửa
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger delete-borrow-btn"
                                                    data-bs-toggle="modal" data-bs-target="#deleteBorrowModal<?= $borrow['id'] ?>"
                                                    data-id="<?= $borrow['id'] ?>">
                                                    <i class="fas fa-trash-alt"></i> Xóa
                                                </button>
                                                <button type="button" class="btn btn-sm btn-info remind-borrow-btn"
                                                    data-bs-toggle="modal" data-bs-target="#remindBorrowModal<?= $borrow['id'] ?>"
                                                    data-id="<?= $borrow['id'] ?>"
                                                    data-book_id="<?= $borrow['book_id'] ?>"
                                                    data-user_id="<?= $borrow['user_id'] ?>">
                                                    <i class="fas fa-bell"></i> Nhắc trả
                                                </button>
                                                <div class="modal fade" id="editBorrowModal<?= $borrow['id'] ?>" tabindex="-1" aria-labelledby="editBorrowModalLabel<?= $borrow['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editBorrowModalLabel<?= $borrow['id'] ?>">Sửa Thông Tin Mượn Sách</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form id="editBorrowForm<?= $borrow['id'] ?>" method="POST" action="admin.php?tab=borrows">
                                                                    <input type="hidden" name="edit_borrow" value="1">
                                                                    <input type="hidden" name="borrow_id" id="editBorrowId<?= $borrow['id'] ?>"> <!- Hidden field for Borrow ID -->
                                                                        <div class="mb-3">
                                                                            <label for="editBorrowBookId<?= $borrow['id'] ?>" class="form-label">Book ID</label>
                                                                            <input type="text" class="form-control" id="editBorrowBookId<?= $borrow['id'] ?>" name="book_id" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="editBorrowUserId<?= $borrow['id'] ?>" class="form-label">User ID</label>
                                                                            <input type="text" class="form-control" id="editBorrowUserId<?= $borrow['id'] ?>" name="user_id" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="editBorrowDate<?= $borrow['id'] ?>" class="form-label">Ngày Mượn</label>
                                                                            <input type="date" class="form-control" id="editBorrowDate<?= $borrow['id'] ?>" name="borrow_date" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="editDueDate<?= $borrow['id'] ?>" class="form-label">Ngày Hết Hạn</label>
                                                                            <input type="date" class="form-control" id="editDueDate<?= $borrow['id'] ?>" name="due_date" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="editBorrowStatus<?= $borrow['id'] ?>" class="form-label">Trạng Thái</label>
                                                                            <select class="form-control" id="editBorrowStatus<?= $borrow['id'] ?>" name="borrow_status">
                                                                                <option value="borrowed">Đang mượn</option>
                                                                                <option value="returned">Đã trả</option>
                                                                                <option value="overdue">Quá hạn</option>
                                                                            </select>
                                                                        </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Đóng</button>
                                                                <button type="submit" form="editBorrowForm<?= $borrow['id'] ?>" class="btn btn-primary"><i class="fas fa-save"></i> Lưu Thay Đổi</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="deleteBorrowModal<?= $borrow['id'] ?>" tabindex="-1" aria-labelledby="deleteBorrowModalLabel<?= $borrow['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteBorrowModalLabel<?= $borrow['id'] ?>">Xác nhận xóa thông tin mượn sách</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Bạn có chắc chắn muốn xóa thông tin mượn sách ID: <b><?= $borrow['id'] ?></b> không?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Hủy</button>
                                                                <form method="POST" action="admin.php?tab=borrows" style="display: inline;">
                                                                    <input type="hidden" name="delete_borrow" value="1">
                                                                    <input type="hidden" name="borrow_id" value="<?= $borrow['id'] ?>">
                                                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Xóa</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal fade" id="remindBorrowModal<?= $borrow['id'] ?>" tabindex="-1" aria-labelledby="remindBorrowModalLabel<?= $borrow['id'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="remindBorrowModalLabel<?= $borrow['id'] ?>">Nhắc trả sách</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Bạn có muốn gửi thông báo nhắc trả sách cho User ID: <b><?= $borrow['user_id'] ?></b>, Book ID: <b><?= $borrow['book_id'] ?></b> không?
                                                                <br><br>
                                                                **Lưu ý:** Chức năng nhắc trả sách thực tế cần được cấu hình thêm (ví dụ: gửi email, thông báo trên hệ thống...). Nút này hiện tại chỉ là placeholder về giao diện.
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Đóng</button>
                                                                <button type="button" class="btn btn-info"><i class="fas fa-bell"></i> Nhắc trả</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                    <?php if ($borrows->num_rows == 0): ?>
                                        <tr>
                                            <td colspan="9" class="text-center">Không có dữ liệu mượn sách.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Thêm Người dùng mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserForm" method="POST" action="admin.php?tab=users">
                            <input type="hidden" name="add_user" value="1">
                            <div class="mb-3">
                                <label for="addUsername" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="addUsername" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="addPassword" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="addPassword" name="password" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Đóng</button>
                        <button type="submit" form="addUserForm" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Thêm Sách mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addBookForm" method="POST" action="admin.php?tab=books">
                            <input type="hidden" name="add_book" value="1">
                            <div class="mb-3">
                                <label for="addBookTitle" class="form-label">Tiêu đề</label>
                                <input type="text" class="form-control" id="addBookTitle" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="addBookAuthor" class="form-label">Tác giả</label>
                                <input type="text" class="form-control" id="addBookAuthor" name="author" required>
                            </div>
                            <div class="mb-3">
                                <label for="addBookGenre" class="form-label">Thể loại</label>
                                <input type="text" class="form-control" id="addBookGenre" name="genre">
                            </div>
                            <div class="mb-3">
                                <label for="addBookPublisher" class="form-label">Nhà xuất bản</label>
                                <input type="text" class="form-control" id="addBookPublisher" name="publisher">
                            </div>
                            <div class="mb-3">
                                <label for="addBookPublicationYear" class="form-label">Năm xuất bản</label>
                                <input type="number" class="form-control" id="addBookPublicationYear" name="publication_year">
                            </div>
                            <div class="mb-3">
                                <label for="addBookISBN" class="form-label">ISBN</label>
                                <input type="text" class="form-control" id="addBookISBN" name="isbn">
                            </div>
                            <div class="mb-3">
                                <label for="addBookDescription" class="form-label">Mô tả</label>
                                <textarea class="form-control" id="addBookDescription" name="description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="addBookImagePath" class="form-label">Đường dẫn ảnh</label>
                                <input type="text" class="form-control" id="addBookImagePath" name="image_path">
                            </div>
                            <div class="mb-3">
                                <label for="addBookQuantity" class="form-label">Số lượng</label>
                                <input type="number" class="form-control" id="addBookQuantity" name="quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="addBookLocation" class="form-label">Vị trí</label>
                                <input type="text" class="form-control" id="addBookLocation" name="location">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Đóng</button>
                        <button type="submit" form="addBookForm" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addBorrowModal" tabindex="-1" aria-labelledby="addBorrowModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBorrowModalLabel">Thêm Mượn Sách</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addBorrowForm" method="POST" action="admin.php?tab=borrows">
                            <input type="hidden" name="add_borrow" value="1">
                            <div class="mb-3">
                                <label for="addBorrowBookId" class="form-label">Book ID</label>
                                <input type="text" class="form-control" id="addBorrowBookId" name="book_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="addBorrowUserId" class="form-label">User ID</label>
                                <input type="text" class="form-control" id="addBorrowUserId" name="user_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="addBorrowDate" class="form-label">Ngày Mượn</label>
                                <input type="date" class="form-control" id="addBorrowDate" name="borrow_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="addDueDate" class="form-label">Ngày Hết Hạn</label>
                                <input type="date" class="form-control" id="addDueDate" name="due_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="addBorrowStatus" class="form-label">Trạng Thái</label>
                                <select class="form-control" id="addBorrowStatus" name="borrow_status">
                                    <option value="borrowed">Đang mượn</option>
                                    <option value="returned">Đã trả</option>
                                    <option value="overdue">Quá hạn</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Đóng</button>
                        <button type="submit" form="addBorrowForm" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
           // JavaScript cho Modal Sửa Sách (Cải tiến - Điền dữ liệu cũ)
        const editBookButtons = document.querySelectorAll('.edit-book-btn');
        editBookButtons.forEach(function(editBookButton) {
            editBookButton.addEventListener('click', function(event) {
                var button = event.target;
                var id = button.getAttribute('data-id');
                var title = button.getAttribute('data-title');
                var author = button.getAttribute('data-author');
                var genre = button.getAttribute('data-genre');
                var publisher = button.getAttribute('data-publisher');
                var publication_year = button.getAttribute('data-publication_year');
                var isbn = button.getAttribute('data-isbn');
                var description = button.getAttribute('data-description');
                var image_path = button.getAttribute('data-image_path');
                var quantity = button.getAttribute('data-quantity');
                var location = button.getAttribute('data-location');
                var editBookModal = document.querySelector('#editBookModal' + id);

                if (editBookModal) {
                    editBookModal.querySelector('#editBookId' + id).value = id;
                    editBookModal.querySelector('#editBookTitle' + id).value = title;
                    editBookModal.querySelector('#editBookAuthor' + id).value = author;
                    editBookModal.querySelector('#editBookGenre' + id).value = genre;
                    editBookModal.querySelector('#editBookPublisher' + id).value = publisher;
                    editBookModal.querySelector('#editBookPublicationYear' + id).value = publication_year;
                    editBookModal.querySelector('#editBookISBN' + id).value = isbn;
                    editBookModal.querySelector('#editBookDescription' + id).value = description;
                    editBookModal.querySelector('#editBookImagePath' + id).value = image_path;
                    editBookModal.querySelector('#editBookQuantity' + id).value = quantity;
                    editBookModal.querySelector('#editBookLocation' + id).value = location;

                    var modalInstance = bootstrap.Modal.getOrCreateInstance(editBookModal);
                    modalInstance.show();
                } else {
                    console.error('Modal with ID editBookModal' + id + ' not found');
                }
            });
        });

            // JavaScript cho Modal Sửa Mượn Sách (giữ nguyên)
            const editBorrowModals = document.querySelectorAll('.edit-borrow-btn');
            editBorrowModals.forEach(function(editBorrowButton) {
                editBorrowButton.addEventListener('click', function(event) {
                    var button = event.target;
                    var id = button.getAttribute('data-id');
                    var book_id = button.getAttribute('data-book_id');
                    var user_id = button.getAttribute('data-user_id');
                    var borrow_date = button.getAttribute('data-borrow_date');
                    var due_date = button.getAttribute('data-due_date');
                    var borrow_status = button.getAttribute('data-borrow_status');
                    var editBorrowModal = document.querySelector('#editBorrowModal' + id);

                    if (editBorrowModal) {
                        editBorrowModal.querySelector('#editBorrowId' + id).value = id;
                        editBorrowModal.querySelector('#editBorrowBookId' + id).value = book_id;
                        editBorrowModal.querySelector('#editBorrowUserId' + id).value = user_id;
                        editBorrowModal.querySelector('#editBorrowDate' + id).value = borrow_date;
                        editBorrowModal.querySelector('#editDueDate' + id).value = due_date;
                        editBorrowModal.querySelector('#editBorrowStatus' + id).value = borrow_status;

                        var modalInstance = bootstrap.Modal.getOrCreateInstance(editBorrowModal);
                        modalInstance.show();
                    } else {
                        console.error('Modal with ID editBorrowModal' + id + ' not found');
                    }
                });
            });
        });
    </script>

</body>

</html>