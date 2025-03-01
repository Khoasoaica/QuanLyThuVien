-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th2 26, 2025 lúc 03:20 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `library_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `publication_year` year(4) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `quantity` int(10) UNSIGNED DEFAULT 0,
  `location` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `genre`, `publisher`, `publication_year`, `isbn`, `description`, `image_path`, `quantity`, `location`, `created_at`, `updated_at`) VALUES
(1, 'Đắc Nhân tâm', 'Dale Carnegie', 'Kỹ năng sống', 'Nhà xuất bản Tổng hợp TP.HCM', '2005', '978-9780671723', 'Đắc Nhân Tâm là một cuốn sách self-help bán chạy nhất mọi thời đại. Sách đưa ra những lời khuyên về giao tiếp, ứng xử và làm thế nào để tạo dựng các mối quan hệ tốt đẹp với mọi người.', 'images/dac-nhan-tam.jpg', 0, 'Khu B, Kệ 2, Ngăn 1', '2025-02-19 21:23:33', '2025-02-26 01:17:23'),
(2, 'Tôi Thấy Hoa Vàng Trên Cỏ Xanhh', 'Nguyễn Nhật Ánh', 'Văn học Việt Nam', 'Nhà xuất bản Trẻ', '2010', '978-6041102312', 'Tôi Thấy Hoa Vàng Trên Cỏ Xanh là một truyện dài nổi tiếng của nhà văn Nguyễn Nhật Ánh, kể về tuổi thơ trong sáng và những rung động đầu đời của những đứa trẻ ở một làng quê nghèo.', 'images/hoa-vang-co-xanh.jpg', 4, 'Khu E, Kệ 3, Ngăn 2', '2025-02-19 21:23:33', '2025-02-26 02:01:18'),
(3, 'Harry Potter và Hòn đá Phù thủy', 'J.K. Rowling', 'Fantasy', 'Bloomsbury', '1997', '978-0747532699', 'Harry Potter và Hòn đá Phù thủy là cuốn sách đầu tiên trong bộ truyện Harry Potter nổi tiếng của J.K. Rowling. Câu chuyện kể về cậu bé Harry Potter, người phát hiện ra mình là một phù thủy vào ngày sinh nhật thứ 11 và bắt đầu cuộc hành trình đến trường phù thủy Hogwarts.', 'images/harry-potter-1.jpg', 13, 'Khu D, Kệ 1, Ngăn 4', '2025-02-19 21:23:33', '2025-02-23 20:21:25'),
(4, 'Nhà Giả Kim', 'Paulo Coelho', 'Ngụ ngôn', 'Nhà xuất bản Văn học', '2002', '978-9780722567', 'Nhà Giả Kim kể về hành trình của Santiago, một chàng chăn cừu trẻ tuổi người Tây Ban Nha, trên đường đi tìm kho báu trong giấc mơ của mình. Cuốn sách là một câu chuyện ngụ ngôn sâu sắc về ước mơ, đam mê và định mệnh.', 'images/nha-gia-kim.jpg', 12, 'Khu C, Kệ 4, Ngăn 1', '2025-02-19 21:23:33', '2025-02-19 21:23:33'),
(5, 'Hoàng Tử Bé', 'Antoine de Saint-Exupéry', 'Văn học kinh điển', 'Reynal & Hitchcock', '1943', '978-0156012195', 'Hoàng Tử Bé là một truyện vừa nổi tiếng của nhà văn Pháp Antoine de Saint-Exupéry. Sách kể về cuộc gặp gỡ giữa một phi công bị rơi máy bay và một hoàng tử nhỏ đến từ một hành tinh khác.', 'images/hoang-tu-be.jpg', 19, 'Khu B, Kệ 5, Ngăn 3', '2025-02-19 21:23:33', '2025-02-23 06:02:21'),
(6, 'Mắt Biếc', 'Nguyễn Nhật Ánh', 'Văn học Việt Nam', 'Nhà xuất bản Trẻ', '1990', '978-6041148952', 'Mắt Biếc là một tiểu thuyết nổi tiếng của nhà văn Nguyễn Nhật Ánh, kể về mối tình đơn phương của Ngạn dành cho Hà Lan, cô bạn từ thuở nhỏ có đôi mắt biếc.', 'images/mat-biec.jpg', 7, 'Khu E, Kệ 2, Ngăn 5', '2025-02-19 21:23:33', '2025-02-24 02:40:14'),
(7, 'Sherlock Holmes - Toàn tập', 'Arthur Conan Doyle', 'Trinh thám', 'NXB Văn Học', '2015', '978-6046913252', 'Tuyển tập đầy đủ các truyện ngắn và tiểu thuyết về thám tử tài ba Sherlock Holmes và người bạn đồng hành bác sĩ Watson.', 'images/sherlock-holmes.jpg', 7, 'Khu A, Kệ 3, Ngăn 1', '2025-02-19 21:23:33', '2025-02-19 21:23:33'),
(8, 'Cuốn theo chiều gió', 'Margaret Mitchell', 'Văn học lãng mạn', 'Macmillan Publishers', '1936', '978-0446676353', 'Cuốn theo chiều gió là một tiểu thuyết lãng mạn lịch sử nổi tiếng của nhà văn Margaret Mitchell, lấy bối cảnh miền Nam nước Mỹ thời Nội chiến.', 'images/cuon-theo-chieu-gio.jpg', 5, 'Khu D, Kệ 4, Ngăn 2', '2025-02-19 21:23:33', '2025-02-19 21:23:33'),
(9, 'Ông già và biển cả', 'Ernest Hemingway', 'Văn học kinh điển', 'Charles Scribner\'s Sons', '1952', '978-0684801223', 'Câu chuyện về cuộc chiến sinh tồn của một ông lão ngư dân Cuba với một con cá kiếm khổng lồ trên biển cả.', 'images/ong-gia-va-bien-ca.jpg', 11, 'Khu C, Kệ 1, Ngăn 3', '2025-02-19 21:23:33', '2025-02-21 16:25:37'),
(10, 'Chiến binh cầu vồng', 'Andrea Hirata', 'Tiểu thuyết', 'Bentang Pustaka', '2005', '978-9793062799', 'Câu chuyện cảm động về tình bạn, nghị lực và khát vọng vươn lên của những đứa trẻ nghèo tại một ngôi trường tiểu học tồi tàn trên đảo Belitong, Indonesia.', 'images/chien-binh-cau-vong.jpg', 14, 'Khu E, Kệ 5, Ngăn 4', '2025-02-19 21:23:33', '2025-02-19 21:23:33'),
(11, 'Số Đỏ', 'Vũ Trọng Phụng', 'Văn học Việt Nam', 'Nhà xuất bản Đời Nay', '1938', '978-0312427159', 'Số Đỏ là một tiểu thuyết trào phúng nổi tiếng của nhà văn Vũ Trọng Phụng, phê phán xã hội Việt Nam những năm 1930 qua cuộc đời của Xuân Tóc Đỏ.', 'images/so-do.jpg', 6, 'Khu A, Kệ 2, Ngăn 1', '2025-02-19 21:23:33', '2025-02-19 21:23:33'),
(12, 'Chí Phèo', 'Nam Cao', 'Văn học Việt Nam', 'Nhà xuất bản Văn học', '1941', '978-0824830387', 'Chí Phèo là một truyện ngắn nổi tiếng của nhà văn Nam Cao, kể về cuộc đời bi thảm của Chí Phèo, một người nông dân lương thiện bị xã hội đẩy vào con đường tha hóa.', 'images/chi-pheo.jpg', 13, 'Khu D, Kệ 3, Ngăn 5', '2025-02-19 21:23:33', '2025-02-19 21:23:33'),
(13, 'Tắt Đèn', 'Ngô Tất Tố', 'Văn học Việt Nam', 'Nhà xuất bản Đời Nay', '1939', '978-1904965358', 'Tắt Đèn là một tiểu thuyết hiện thực phê phán nổi tiếng của Ngô Tất Tố, tố cáo xã hội thực dân phong kiến đẩy người nông dân vào cảnh bần cùng, tăm tối.', 'images/tat-den.jpg', 10, 'Khu C, Kệ 5, Ngăn 2', '2025-02-19 21:23:33', '2025-02-19 21:23:33'),
(14, 'Lão Hạc', 'Nam Cao', 'Văn học Việt Nam', 'Nhà xuất bản Văn học', '1943', '978-0520222947', 'Lão Hạc là một truyện ngắn cảm động của nhà văn Nam Cao, kể về số phận đau khổ của lão Hạc, một người nông dân nghèo khổ, giàu lòng tự trọng.', 'images/lao-hac.jpg', 16, 'Khu B, Kệ 1, Ngăn 6', '2025-02-19 21:23:33', '2025-02-19 21:23:33'),
(15, 'Dế Mèn phiêu lưu ký', 'Tô Hoài', 'Văn học thiếu nhi', 'Nhà xuất bản Kim Đồng', '1941', '978-6042481547', 'Dế Mèn phiêu lưu ký là một truyện dài nổi tiếng dành cho thiếu nhi của nhà văn Tô Hoài, kể về cuộc phiêu lưu mạo hiểm và đầy thú vị của chú dế mèn.', 'images/de-men-phieuu-luu-ky.jpg', 18, 'Khu E, Kệ 4, Ngăn 3', '2025-02-19 21:23:33', '2025-02-24 01:32:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `borrows_records`
--

CREATE TABLE `borrows_records` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `borrow_status` varchar(50) DEFAULT 'borrowed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `borrows_records`
--

INSERT INTO `borrows_records` (`id`, `book_id`, `user_id`, `borrow_date`, `due_date`, `return_date`, `borrow_status`, `created_at`, `updated_at`) VALUES
(72, 2, 1, '2025-02-24', '2025-03-10', NULL, 'returned', '2025-02-24 16:37:14', '2025-02-25 05:28:16'),
(73, 2, 1, '2025-02-24', '2025-03-03', NULL, 'returned', '2025-02-24 16:37:14', '2025-02-25 04:55:00'),
(74, 1, 1, '2025-02-25', '2025-03-04', NULL, 'returned', '2025-02-25 04:53:41', '2025-02-26 00:44:53'),
(75, 2, 1, '2025-02-25', '2025-03-04', NULL, 'returned', '2025-02-25 04:53:49', '2025-02-26 00:44:10'),
(76, 2, 1, '2025-02-25', '2025-03-04', NULL, 'returned', '2025-02-25 04:53:49', '2025-02-26 00:44:07'),
(77, 1, 1, '2025-02-26', '2025-03-10', NULL, 'borrowed', '2025-02-26 01:17:23', '2025-02-26 02:01:48'),
(78, 2, 1, '2025-02-26', '2025-03-05', NULL, 'returned', '2025-02-26 01:17:31', '2025-02-26 01:17:45'),
(79, 2, 1, '2025-02-26', '2025-03-05', NULL, 'returned', '2025-02-26 01:17:32', '2025-02-26 01:17:40'),
(80, 2, 1, '2025-02-26', '2025-03-05', NULL, 'borrowed', '2025-02-26 01:27:32', '2025-02-26 01:27:32'),
(81, 2, 1, '2025-02-26', '2025-03-05', NULL, 'borrowed', '2025-02-26 01:27:32', '2025-02-26 01:27:32'),
(82, 2, 1, '2025-02-26', '2025-03-05', NULL, 'borrowed', '2025-02-26 02:01:18', '2025-02-26 02:01:18'),
(83, 2, 1, '2025-02-26', '2025-03-05', NULL, 'borrowed', '2025-02-26 02:01:18', '2025-02-26 02:01:18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(3, 'ed', 're@gmail.com', 'fsdfs', '2025-02-24 02:21:36'),
(4, 'nguyenvana', 'hil024569@gmail.com', 'sách hay lắm\r\n', '2025-02-24 02:41:46'),
(6, 'nhi', 'yennhinhi162@gmail.com', 'tôi không mượn sách được ', '2025-02-25 05:04:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`) VALUES
(1, 'Nhii', '$2y$10$RcIfceY5zVWwvmBv66LNl.ZhdhqWTSiwXq1NEkwEuOhZQaCT9vspW', 'nhi123@gmail.com', 'user'),
(42, 'Nhi123', '$2y$10$u0CM10cixHjNDsgnyUvU3OKleTSHT92PNqNHm4./e0db.wxhL2w.C', '', 'user'),
(44, 'NHO', '$2y$10$gO71Pri/6/DywwtmMI3Bz.JwJAnVx22069msbIZK2uEVlsLAohU.y', '', 'user');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `added_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `book_id`, `added_at`) VALUES
(21, 1, 1, '2025-02-24 03:26:50'),
(22, 1, 2, '2025-02-24 03:26:57'),
(23, 1, 8, '2025-02-24 03:27:17');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `borrows_records`
--
ALTER TABLE `borrows_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `borrows_records`
--
ALTER TABLE `borrows_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT cho bảng `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `borrows_records`
--
ALTER TABLE `borrows_records`
  ADD CONSTRAINT `borrows_records_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrows_records_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
