<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="container header-container">
            <div class="logo">
                <a href="index.php" class="logo-link">
                    <img src="images/library-logo.png" alt="Logo Thư Viện" class="logo-img">
                    <span class="logo-text">New<br> Library</span>
                </a>
            </div>

            <nav class="navigation">
                <ul class="nav-list">
                    <?php
                        $current_page = $_SERVER['PHP_SELF'];

                        $nav_items = [
                            'index.php' => 'Trang chủ',
                            'books.php' => 'Sách',
                            'borrowed_books.php' => 'Sách đã mượn',
                            'articles.php' => 'Bài viết',
                            'about.php' => 'Về chúng tôi',
                            'contact.php' => 'Liên hệ'
                        ];

                        foreach ($nav_items as $url => $label) {
                            $active_class = '';
                            if (strpos($current_page, $url) !== false) {
                                $active_class = 'active';
                            }
                            echo '<li class="nav-item"><a href="' . $url . '" class="nav-link ' . $active_class . '">' . $label . '</a></li>';
                        }
                    ?>
                </ul>
            </nav>

            <div class="header-functions">
                <div class="wishlist-header">  <a href="wishlist.php" class="wishlist-link">
                        <i class="fas fa-heart wishlist-icon"></i>
                        <span class="wishlist-count"></span>  </a>
                </div>
                <div class="header-auth-icons">
                    <a href="auth/login.php" class="header-auth-icon-link">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Đăng nhập</span>
                    </a>
                    <a href="auth/register.php" class="header-auth-icon-link">
                        <i class="fas fa-user-plus"></i>
                        <span>Đăng ký</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

</body>
</html>