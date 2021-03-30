-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 06, 2021 lúc 10:36 AM
-- Phiên bản máy phục vụ: 10.4.17-MariaDB
-- Phiên bản PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `comp1640`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_content` varchar(50) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `comment`
--

INSERT INTO `comment` (`comment_id`, `user_id`, `post_id`, `comment_content`, `time`) VALUES
(4, 2, 37, 'aasss', '2021-03-06 15:41:05'),
(5, 2, 37, '123', '2021-03-06 15:57:44'),
(6, 2, 37, 'asdfasdf', '2021-03-06 16:00:46'),
(7, 1, 37, 'a', '2021-03-06 16:15:37'),
(9, 1, 37, 'hello\r\n', '2021-03-06 16:17:56'),
(10, 2, 37, 'hello', '2021-03-06 16:18:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `faculty`
--

CREATE TABLE `faculty` (
  `faculty_id` int(11) NOT NULL,
  `faculty_name` varchar(20) NOT NULL,
  `faculty_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `faculty`
--

INSERT INTO `faculty` (`faculty_id`, `faculty_name`, `faculty_description`) VALUES
(1, 'IT', 'Information Technology'),
(2, 'Business', 'Business related subjects'),
(3, 'Event', 'Event related subjects');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `type` text NOT NULL,
  `message` text NOT NULL,
  `status` text NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `notification`
--

INSERT INTO `notification` (`notification_id`, `name`, `type`, `message`, `status`, `date`) VALUES
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:08:25'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:08:43'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:25:28'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:32:46'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:37:59'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 12:38:57'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 14:10:17'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 14:25:49'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 14:31:23'),
(0, NULL, 'newpost', 'A student have uploaded a new post', 'unread', '2021-02-27 15:25:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post`
--

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `term_id` int(11) DEFAULT NULL,
  `faculty_id` int(11) NOT NULL,
  `post_image` char(50) NOT NULL,
  `post_file` text NOT NULL,
  `post_content` text NOT NULL,
  `submit_date` datetime NOT NULL,
  `selected` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `post`
--

INSERT INTO `post` (`post_id`, `user_id`, `term_id`, `faculty_id`, `post_image`, `post_file`, `post_content`, `submit_date`, `selected`) VALUES
(36, 4, NULL, 2, '123845307_3694816403917483_7439521681766803848_n.p', 'NotificationSystemInPHP-master.zip', '', '2021-02-27 12:38:57', 0),
(37, 1, NULL, 1, '123845307_3694816403917483_7439521681766803848_n.p', 'NotificationSystemInPHP-master.zip', '', '2021-02-27 14:10:17', 0),
(38, 5, NULL, 2, 'MONSTER HUNTER_ WORLD(416251) 9_27_2020 7_05_18 PM', 'student coordinator.rar', '', '2021-02-27 14:25:49', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `term`
--

CREATE TABLE `term` (
  `term_id` int(11) NOT NULL,
  `term_deadline` datetime NOT NULL,
  `term_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `faculty_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `user_role` varchar(20) NOT NULL,
  `user_email` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `faculty_id`, `username`, `password`, `user_role`, `user_email`) VALUES
(1, 1, 'DuyAnh', '123', 'Student', 'da200066@gmail.com'),
(2, 1, 'Dung', '123', 'Coordinator', 'something@gmail.com'),
(3, 3, 'Binh', '123', 'Manager', 'something@gmail.com'),
(4, 2, 'Quang', '123', 'Student', 'something@gmail.com'),
(5, 2, 'Long', '123', 'Coordinator', 'da200066@gmail.com');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `comment_user_user_id` (`user_id`),
  ADD KEY `comment_post_post_id` (`post_id`);

--
-- Chỉ mục cho bảng `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`faculty_id`);

--
-- Chỉ mục cho bảng `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_term_term_id` (`term_id`),
  ADD KEY `post_user_user_id` (`user_id`),
  ADD KEY `faculty_id` (`faculty_id`);

--
-- Chỉ mục cho bảng `term`
--
ALTER TABLE `term`
  ADD PRIMARY KEY (`term_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_faculty_faculty_id` (`faculty_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `faculty`
--
ALTER TABLE `faculty`
  MODIFY `faculty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `post`
--
ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT cho bảng `term`
--
ALTER TABLE `term`
  MODIFY `term_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_post_post_id` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`),
  ADD CONSTRAINT `comment_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Các ràng buộc cho bảng `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`),
  ADD CONSTRAINT `post_term_term_id` FOREIGN KEY (`term_id`) REFERENCES `term` (`term_id`),
  ADD CONSTRAINT `post_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Các ràng buộc cho bảng `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_faculty_faculty_id` FOREIGN KEY (`faculty_id`) REFERENCES `faculty` (`faculty_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
