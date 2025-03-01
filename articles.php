<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài viết - Hệ thống quản lý thư viện</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/articles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php include 'pages/header.php'; ?>

    <main class="container">
        <section id="all-articles" class="section">
            <h1 class="section-title">Hoạt động thư viện</h1>
            <div class="article-list">
                <?php
                    // Sample Article Data (You can expand this array)
                    $articles = [
                        [
                            'title' => 'Khám phá thế giới sách: Hướng dẫn đọc sách hiệu quả cho người mới bắt đầu',
                            'excerpt' => 'Bạn mới bắt đầu hành trình đọc sách và cảm thấy bối rối không biết bắt đầu từ đâu? Bài viết này sẽ cung cấp cho bạn những hướng dẫn chi tiết và hữu ích để khám phá thế giới sách một cách hiệu quả, từ việc lựa chọn sách phù hợp đến việc xây dựng thói quen đọc sách bền vững.',
                            'image' => 'images/article-placeholder-1.jpg', // Placeholder image 1
                            'detail_link' => 'article_detail.php?id=1' // Link to article detail page (you'll create this later)
                        ],
                        [
                            'title' => 'Top 5 cuốn sách kinh điển bạn nên đọc ít nhất một lần trong đời',
                            'excerpt' => 'Những tác phẩm văn học kinh điển không chỉ là di sản văn hóa vô giá mà còn chứa đựng những bài học sâu sắc về cuộc sống, con người và xã hội. Hãy cùng điểm qua top 5 cuốn sách kinh điển mà bạn nên đọc ít nhất một lần trong đời để mở rộng tầm nhìn và làm phong phú tâm hồn.',
                            'image' => 'images/article-placeholder-2.jpg', // Placeholder image 2
                            'detail_link' => 'article_detail.php?id=2'
                        ],
                        [
                            'title' => 'Bí quyết lựa chọn sách phù hợp với sở thích và mục tiêu cá nhân',
                            'excerpt' => 'Giữa vô vàn đầu sách trên thị trường, việc lựa chọn được những cuốn sách phù hợp với sở thích và mục tiêu cá nhân có thể là một thách thức. Bài viết này sẽ chia sẻ những bí quyết hữu ích giúp bạn dễ dàng tìm thấy những cuốn sách "chân ái" và tận hưởng trọn vẹn niềm vui đọc sách.',
                            'image' => 'images/article-placeholder-3.jpg', // Placeholder image 3
                            'detail_link' => 'article_detail.php?id=3'
                        ],
                         [
                            'title' => 'Sách và sức khỏe tinh thần: Đọc sách giúp giảm căng thẳng và cải thiện tâm trạng như thế nào?',
                            'excerpt' => 'Bạn có biết rằng đọc sách không chỉ là một hoạt động giải trí mà còn mang lại nhiều lợi ích tuyệt vời cho sức khỏe tinh thần? Bài viết này sẽ khám phá mối liên hệ giữa sách và sức khỏe tinh thần, đồng thời chia sẻ những loại sách có thể giúp bạn giảm căng thẳng, cải thiện tâm trạng và nâng cao chất lượng cuộc sống.',
                            'image' => 'images/article-placeholder-4.jpg', // Placeholder image 4
                            'detail_link' => 'article_detail.php?id=4'
                        ],
                    ];
                ?>

                <?php foreach ($articles as $article): ?>
                    <article class="article-item">
                        <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="article-image">
                        <div class="article-body">
                            <h2 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h2>
                            <p class="article-excerpt"><?php echo htmlspecialchars($article['excerpt']); ?></p>
                            <a href="<?php echo htmlspecialchars($article['detail_link']); ?>" class="article-button">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </article>
                <?php endforeach; ?>

                <?php if (empty($articles)): ?>
                    <p>Chưa có bài viết nào.</p>
                <?php endif; ?>

            </div>
        </section>
    </main>

    <?php include 'pages/footer.php'; ?>
</body>
</html>