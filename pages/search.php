<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keyword = $_POST['keyword'];
    $result = $conn->query("SELECT * FROM books WHERE title LIKE '%$keyword%' OR author LIKE '%$keyword%'");
}
?>
<form method="POST">
    <input type="text" name="keyword" placeholder="Nhập tên sách hoặc tác giả">
    <button type="submit">Tìm kiếm</button>
</form>
<ul>
    <?php while (isset($result) && $row = $result->fetch_assoc()) {
        echo "<li>{$row['title']} - {$row['author']}</li>";
    } ?>
</ul>