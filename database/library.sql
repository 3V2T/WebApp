-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th3 17, 2024 lúc 02:59 PM
-- Phiên bản máy phục vụ: 8.0.36
-- Phiên bản PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `library`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `doimatkhau` (IN `username` VARCHAR(50), IN `password` CHAR(128))   BEGIN
  PREPARE stmt FROM 'UPDATE `user` SET `password` = ? WHERE `username` = ?';
  SET @username = username;
  SET @password = password;
  EXECUTE stmt USING @password, @username;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `doimatkhauadmin` (IN `username` VARCHAR(50), IN `password` CHAR(128))   BEGIN
  PREPARE stmt FROM 'UPDATE `admin` SET `password` = ? WHERE `username` = ?';
  SET @username = username;
  SET @password = password;
  EXECUTE stmt USING @password, @username;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAuthorsbyid` (IN `id` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwauthors` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAuthorsbyname` (IN `author` TEXT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwauthors` WHERE `author` = ?';
  SET @author = author;
  EXECUTE stmt USING @author;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getBooksbyid` (IN `id` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCategoriesbyid` (IN `id` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwcategories` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `gethistorybyuserid` (IN `user_id` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwhistory` WHERE `user_id` = ?';
  SET @user_id = user_id;
  EXECUTE stmt USING @user_id;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUsersbyid` (IN `id` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwusers` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getwlbyuserid` (IN `user_id` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwwishlist` WHERE `user_id` = ?';
  SET @user_id = user_id;
  EXECUTE stmt USING @user_id;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `phantranglichsu` (IN `start` INT, IN `number` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwhistory` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `phantranglstheouserid` (IN `id` INT, IN `start` INT, IN `number` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwhistory` WHERE `user_id` = ? LIMIT ?, ?';
  SET @id = id;
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @id, @start, @number;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `phantrangsach` (IN `start` INT, IN `number` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `phantrangsachtheotacgia` (IN `author` VARCHAR(100), IN `start` INT, IN `number` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE `author_id` = (SELECT `id` FROM `vwauthors` WHERE `author` = ?) LIMIT ?, ?';
  SET @author = author;
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @author, @start, @number;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `phantrangsachtheotheloai` (IN `category` CHAR(100), IN `start` INT, IN `number` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE `category_id` = (SELECT `id` FROM `categories` WHERE `category` = ?) LIMIT ?, ?';
  SET @category = category;
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @category, @start, @number;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `phantrangtacgia` (IN `start` INT, IN `number` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwauthors` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `phantrangwltheouserid` (IN `id` INT, IN `start` INT, IN `number` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwwishlist` WHERE `user_id` = ? LIMIT ?, ?';
  SET @id = id;
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @id, @start, @number;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `phantrangyeuthich` (IN `start` INT, IN `number` INT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwwishlist` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `suaauthor` (IN `id` INT, IN `author` VARCHAR(100), IN `description` TEXT)   BEGIN
  PREPARE stmt FROM 'UPDATE `authors` SET `author` = ?, `description` = ? WHERE `id` = ?';
  SET @id = id;
  SET @author = author;
  SET @description = description;
  EXECUTE stmt USING @author, @description, @id;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `suaduongdan` (IN `id` INT, IN `cover_path` VARCHAR(260), IN `file_path` VARCHAR(260))   BEGIN
  PREPARE stmt FROM 'UPDATE `books` SET `cover_path` = ?, `file_path` = ? WHERE `id` = ?';
  SET @id = id;
  SET @cover_path = cover_path;
  SET @file_path = file_path;
  EXECUTE stmt USING @id, @cover_path, @file_path;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `suaduongdanbiasach` (IN `id` INT, IN `cover_path` VARCHAR(260))   BEGIN
  PREPARE stmt FROM 'UPDATE `books` SET `cover_path` = ? WHERE `id` = ?';
  SET @id = id;
  SET @cover_path = cover_path;
  EXECUTE stmt USING @id, @cover_path;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `suaduongdanfile` (IN `id` INT, IN `file_path` VARCHAR(260))   BEGIN
  PREPARE stmt FROM 'UPDATE `books` SET `file_path` = ? WHERE `id` = ?';
  SET @id = id;
  SET @file_path = file_path;
  EXECUTE stmt USING @id, @file_path;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `suasach` (IN `id` INT, IN `title` VARCHAR(100), IN `author_id` INT, IN `category_id` INT, IN `cover_path` VARCHAR(260), IN `file_path` VARCHAR(260), IN `description` TEXT, IN `published` DATE)   BEGIN
  PREPARE stmt FROM 'UPDATE `books` SET `title` = ?, `author_id` = ?, `category_id` = ?, `cover_path` = ?, `file_path` = ?, `description` = ?, `published` = ? WHERE `id` = ?';
  SET @id = id;
  SET @title = title;
  SET @author_id = author_id;
  SET @category_id = category_id;
  SET @cover_path = cover_path;
  SET @file_path = file_path;
  SET @description = description;
  SET @published = published;
  EXECUTE stmt USING @id, @title, @author_id, @category_id, @cover_path, @file_path, @description, @published;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `suathongtin` (IN `id` INT, IN `name` VARCHAR(100), IN `email` VARCHAR(100))   BEGIN
  PREPARE stmt FROM 'UPDATE `users` SET `name` = ?, `email` = ? WHERE `id` = ?';
  SET @id = id;
  SET @name = name;
  SET @email = email;
  EXECUTE stmt USING @id, @name, @email;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `suauser` (IN `id` INT, IN `username` VARCHAR(50), IN `password` CHAR(128), IN `name` VARCHAR(100), IN `email` VARCHAR(100))   BEGIN
  PREPARE stmt FROM 'UPDATE `users` SET `username` = ?, `password` = ?, `name` = ?, `email` = ? WHERE `id` = ?';
  SET @id = id;
  SET @username = username;
  SET @password = password;
  SET @name = name;
  SET @email = email;
  EXECUTE stmt USING @username, @password, @name, @email, @id;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `themauthor` (IN `author` VARCHAR(100), IN `description` TEXT)   BEGIN
  PREPARE stmt FROM 'INSERT INTO `authors` (`author`, `description`) VALUES (?, ?)';
  SET @author = author;
  SET @description = description;
  EXECUTE stmt USING @author, @description;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `themcategory` (IN `category` CHAR(100))   BEGIN
  PREPARE stmt FROM 'INSERT INTO `categories` (`category`) VALUES (?)';
  SET @category = category;
  EXECUTE stmt USING @category;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `themsach` (IN `title` VARCHAR(100), IN `author_id` INT, IN `category_id` INT, IN `cover_path` VARCHAR(260), IN `file_path` VARCHAR(260), IN `description` TEXT, IN `published` DATE)   BEGIN
  PREPARE stmt FROM 'INSERT INTO `books` (`title`, `author_id`, `category_id`, `cover_path`, `file_path`, `description`, `published`) VALUES (?, ?, ?, ?, ?, ?, ?)';
  SET @title = title;
  SET @author_id = author_id;
  SET @category_id = category_id;
  SET @cover_path = cover_path;
  SET @file_path = file_path;
  SET @description = description;
  SET @published = published;
  EXECUTE stmt USING @title, @author_id, @category_id, @cover_path, @file_path, @description, @published;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `themuser` (IN `username` VARCHAR(50), IN `password` CHAR(128), IN `name` VARCHAR(100), IN `email` VARCHAR(100))   BEGIN
  PREPARE stmt FROM 'INSERT INTO `users` (`username`, `password`, `name`, `email`) VALUES (?, ?, ?, ?)';
  SET @username = username;
  SET @password = password;
  SET @name = name;
  SET @email = email;
  EXECUTE stmt USING @username, @password, @name, @email;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `timsachtheonamxuatban` (IN `published` DATE)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`published`) AGAINST (? WITH QUERY EXPANSION)';
  SET @published = published;
  EXECUTE stmt USING @published;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `timsachtheonoidung` (IN `description` TEXT)   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`description`) AGAINST (? WITH QUERY EXPANSION)';
  SET @description = description;
  EXECUTE stmt USING @description;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `timsachtheotacgia` (IN `author` VARCHAR(100))   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`author`) AGAINST (? WITH QUERY EXPANSION)';
  SET @author = author;
  EXECUTE stmt USING @author;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `timsachtheoten` (IN `title` VARCHAR(100))   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`title`) AGAINST (? WITH QUERY EXPANSION)';
  SET @title = title;
  EXECUTE stmt USING @title;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `timsachtheotheloai` (IN `category` CHAR(100))   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`category`) AGAINST (? WITH QUERY EXPANSION)';
  SET @category = category;
  EXECUTE stmt USING @category;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `timtacgia` (IN `author` VARCHAR(100))   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwauthors` WHERE MATCH (`author`) AGAINST (? WITH QUERY EXPANSION)';
  SET @author = author;
  EXECUTE stmt USING @author;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `timtheloai` (IN `category` CHAR(100))   BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwcategories` WHERE MATCH (`category`) AGAINST (? WITH QUERY EXPANSION)';
  SET @category = category;
  EXECUTE stmt USING @category;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `xoaauthor` (IN `id` INT)   BEGIN
  PREPARE stmt FROM 'DELETE FROM `authors` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `xoakhoihistory` (IN `username` CHAR(100), IN `title` VARCHAR(100))   BEGIN
  PREPARE stmt FROM 'DELETE FROM `history` WHERE `user_id` = (SELECT `id` FROM `users` WHERE `username` = ?) AND `book_id` = (SELECT `id` FROM `books` WHERE `title` = ?)';
  SET @username = username;
  SET @title = title;
  EXECUTE stmt USING @username, @title;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `xoakhoiwishlist` (IN `username` CHAR(100), IN `title` VARCHAR(100))   BEGIN
  PREPARE stmt FROM 'DELETE FROM `wishlist` WHERE `user_id` = (SELECT `id` FROM `users` WHERE `username` = ?) AND `book_id` = (SELECT `id` FROM `books` WHERE `title` = ?)';
  SET @username = username;
  SET @title = title;
  EXECUTE stmt USING @username, @title;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `xoasach` (IN `id` INT)   BEGIN
  PREPARE stmt FROM 'DELETE FROM `books` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `xoauser` (IN `id` INT)   BEGIN
  PREPARE stmt FROM 'DELETE FROM `users` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `yeuthich` (IN `user_id` INT, IN `book_id` INT)   BEGIN
  PREPARE stmt FROM 'INSERT INTO `wishlist` (`user_id`, `book_id`) VALUES (?, ?)';
  SET @user_id = user_id;
  SET @book_id = book_id;
  EXECUTE stmt USING @user_id, @book_id;
  DEALLOCATE PREPARE stmt;
END$$

--
-- Các hàm
--
CREATE DEFINER=`root`@`localhost` FUNCTION `crlichsu` (`_user_id` INT) RETURNS INT DETERMINISTIC RETURN (SELECT COUNT(*) FROM `vwhistory` WHERE `user_id` = _user_id)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `crsach` () RETURNS INT DETERMINISTIC RETURN (SELECT COUNT(*) FROM `vwbooks`)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `crtacgia` () RETURNS INT DETERMINISTIC RETURN (SELECT COUNT(*) FROM `vwauthors`)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `cryeuthich` (`_user_id` INT) RETURNS INT DETERMINISTIC RETURN (SELECT COUNT(*) FROM `vwwishlist` WHERE `user_id` = _user_id)$$

CREATE DEFINER=`root`@`localhost` FUNCTION `kiemtraadmin` (`_username` VARCHAR(50), `_password` CHAR(128)) RETURNS TINYINT(1) DETERMINISTIC RETURN (SELECT COUNT(*) FROM `vwadmin` WHERE `username` = _username AND `password` = _password) > 0$$

CREATE DEFINER=`root`@`localhost` FUNCTION `kiemtratontaiadmin` (`_username` VARCHAR(50)) RETURNS TINYINT(1) DETERMINISTIC RETURN (SELECT COUNT(*) FROM `vwadmin` WHERE `username` = _username) > 0$$

CREATE DEFINER=`root`@`localhost` FUNCTION `kiemtratontaiuser` (`_username` VARCHAR(50)) RETURNS TINYINT(1) DETERMINISTIC RETURN (SELECT COUNT(*) FROM `vwusers` WHERE `username` = _username) > 0$$

CREATE DEFINER=`root`@`localhost` FUNCTION `kiemtrauser` (`_username` VARCHAR(50), `_password` CHAR(128)) RETURNS TINYINT(1) DETERMINISTIC RETURN (SELECT COUNT(*) FROM `users` WHERE `username` = _username AND `password` = _password) > 0$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` char(128) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$T0/D4jNUzs7trqfEcAqOTe4E6viVujBYUQDFM1RvdOHgHThWEGUvm');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `authors`
--

CREATE TABLE `authors` (
  `id` int NOT NULL,
  `author` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Đang đổ dữ liệu cho bảng `authors`
--

INSERT INTO `authors` (`id`, `author`, `description`) VALUES
(7, 'Neil Shubin', ''),
(8, 'Trần Thời', ' '),
(9, 'William J. Bernstein', ' '),
(12, 'Vũ Hữu Tiệp', ' '),
(13, 'Paulo Coelho', ' '),
(14, 'Jeffrey E. Garten', ' '),
(15, 'Peter Lynch', NULL),
(16, 'Mario Puzo', ''),
(17, 'William L. Shirer', ''),
(18, 'Olga Filipova', ''),
(19, 'Thạch Lam', ''),
(20, 'Robin Sharma', ''),
(21, 'Nguyễn Cảnh Bình', '');

--
-- Bẫy `authors`
--
DELIMITER $$
CREATE TRIGGER `xoatacgia` BEFORE DELETE ON `authors` FOR EACH ROW DELETE FROM `books` WHERE `author_id` = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `title` varchar(100) NOT NULL,
  `author_id` int NOT NULL,
  `category_id` int NOT NULL,
  `cover_path` varchar(260) DEFAULT NULL,
  `file_path` varchar(260) DEFAULT NULL,
  `description` text,
  `published` date NOT NULL DEFAULT (curdate())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Đang đổ dữ liệu cho bảng `books`
--

INSERT INTO `books` (`id`, `title`, `author_id`, `category_id`, `cover_path`, `file_path`, `description`, `published`) VALUES
(6, 'Tất Cả Chúng Ta Đều Là Cá', 7, 2, 'nhasachmienphi-tat-ca-chung-ta-deu-la-ca.png', 'nhasachmienphi-tat-ca-chung-ta-deu-la-ca.pdf', 'Neil Shubin, nhà cổ sinh học và giáo sư về giải phẫu học, người đã đồng khám phá Tiktaalik, “loài cá có tay”, kể câu chuyện về cơ thể chúng ta mà bạn chưa bao giờ nghe trước đây. Qua nghiên cứu hóa thạch và ADN của các loại sinh vật nguyên thủy, tác giả Neil Shubin đã cho thấy sự tương đồng về mặt cấu tạo cơ thể giữa người với các loại sinh vật khác, từ cá cho đến giun và thậm chí là vi khuẩn. Bằng những nội dung thú vị, lý thú, Tất cả chúng ta đều là cá đã giúp chủ đề sinh học và cổ sinh học vốn vô cùng phong phú, đa dạng trở nên đặc biệt gần gũi và cuốn hút với độc giả, nhất là các bạn trẻ.', '2017-12-05'),
(7, 'Mật Thư', 8, 2, 'nhasachmienphi-mat-thu.png', 'nhasachmienphi-mat-thu.pdf', 'Mật thư do tác giả Trần Thời biên soạn sẽ giới thiệu đến bạn đọc 9 kiểu mật thư, từ những dạng đơn giản nhất như đọc ngược, đọc lái từ, bỏ đầu bỏ đuôi, đến dạng kí hiệu morse, dạng thay thế, đọc theo khóa, dạng tượng hình hay tọa độ… Sau mỗi phần giới thiệu, bạn sẽ nhanh chóng được thử sức cùng những mật thư nho nhỏ nữa đấy.', '2013-01-01'),
(8, 'Lịch Sử Giao Thương: Thương Mại Định Hình Thế Giới Như Thế Nào ?', 9, 4, 'nhasachmienphi-lich-su-giao-thuong-thuong-mai-dinh-hinh-the-gioi-nhu-the-nao.jpg', 'nhasachmienphi-lich-su-giao-thuong-thuong-mai-dinh-hinh-the-gioi-nhu-the-nao.pdf', '“Toàn cầu hóa” hóa ra không phải là một hay thậm chí là một chuỗi sự kiện; mà đó là tiến trình diễn ra chậm rãi trong một thời gian rất, rất dài. Thế giới không đột nhiên trở nên “phẳng” với phát kiến về Internet, và thương mại không bất ngờ bị các tập đoàn lớn tầm cỡ toàn cầu chi phối vào cuối thế kỷ 20. Khởi đầu bằng hàng hóa giá trị cao được ghi nhận trong lịch sử, sau đó từ từ mở rộng sang các mặt hàng ít quý giá hơn, cồng kềnh và dễ hư hỏng hơn, những thị trường của Cựu Thế giới dần tiến đến hợp nhất. Với hành trình đầu tiên của người châu Âu tới Tân Thế giới, quá trình hội nhập toàn cầu diễn ra ngàycàng mạnh mẽ. Hôm nay, các tàu container đồ sộ, máy bay phản lực, Internet, cùng mạng lưới cung ứng và sản xuất ngày càng được toàn cầu hóa chỉ là những bước tiến xa hơn của một quá trình đã diễn ra suốt 5.000 năm qua.', '2018-01-06'),
(12, 'Machine Learning Cơ Bản', 12, 6, 'nhasachmienphi-machine-learning-co-ban.jpg', 'nhasachmienphi-machine-learning-co-ban.pdf', 'Những năm gần đây, AI – Artificial Intelligence (Trí Tuệ Nhân Tạo), và cụ thể hơn là Machine Learning (Học Máy hoặc Máy Học) nổi lên như một bằng chứng của cuộc cách mạng công nghiệp lần thứ tư (1 – động cơ hơi nước, 2 – năng lượng điện, 3 – công nghệ thông tin). Trí Tuệ Nhân Tạo đang len lỏi vào mọi lĩnh vực trong đời sống mà có thể chúng ta không nhận ra. Xe tự hành của Google và Tesla, hệ thống tự tag khuôn mặt trong ảnh của Facebook, trợ lý ảo Siri của Apple, hệ thống gợi ý sản phẩm của Amazon, hệ thống gợi ý phim của Netflix, máy chơi cờ vây AlphaGo của Google DeepMind, …, chỉ là một vài trong vô vàn những ứng dụng của AI/Machine Learning.', '2020-02-01'),
(13, 'Nhà Giả Kim', 13, 7, '65f1c8a3ee3b5_1161.jpg', '65f1c8a3edfdb_2429.pdf', 'Tất cả những trải nghiệm trong chuyến phiêu du theo đuổi vận mệnh của mình đã giúp Santiago thấu hiểu được ý nghĩa sâu xa nhất của hạnh phúc, hòa hợp với vũ trụ và con người.Tiểu thuyết Nhà giả kim của Paulo Coelho như một câu chuyện cổ tích giản dị, nhân ái, giàu chất thơ, thấm đẫm những minh triết huyền bí của phương Đông. Trong lần xuất bản đầu tiên tại Brazil vào năm 1988, sách chỉ bán được 900 bản. Nhưng, với số phận đặc biệt của cuốn sách dành cho toàn nhân loại, vượt ra ngoài biên giới quốc gia, Nhà giả kim đã làm rung động hàng triệu tâm hồn, trở thành một trong những cuốn sách bán chạy nhất mọi thời đại, và có thể làm thay đổi cuộc đời người đọc.', '2002-01-01'),
(57, 'Từ Tơ Lụa Đến Slicicon', 14, 8, 'nhasachmienphi-tu-to-lua-den-silicon.jpg', 'nhasachmienphi-tu-to-lua-den-silicon.pdf', 'Đây là câu chuyện chưa từng kể về toàn cầu hóa. Nó xoay quanh mười nhân vật đã làm cho thế giới chúng ta nhỏ lại và gắn kết với nhau hơn. Trong số những người bạn sẽ gặp có một thiếu niên lớn lên từ thảo nguyên Trung Á để rồi dựng nên một đế quốc rộng lớn nhất trong lịch sử; có nhà sản xuất các sản phẩm bằng giấy trang trí đã đưa truyền thông toàn cầu đến những tiến bộ vượt xa mọi thành tựu trong lịch sử nhân loại; có nhà buôn (rượu) cognac đã nghĩ ra một thí nghiệm chưa từng ai dám làm để phá bỏ các biên giới các quốc gia; có một người tị nạn trốn chạy khỏi Đức Quốc xã lẫn Liên Xô để dẫn đầu một cuộc cách mạng máy tính; và nhiều người khác nữa với cuộc đời cũng lâm li tương tự. Thành tựu của họ không chỉ kịch tính trong thời đại họ sống mà còn đang tiếp tục định hình thế giới ngày nay của chúng ta. ', '2017-12-01'),
(58, 'Đánh Bại Phố Wall', 15, 8, 'nhasachmienphi-danh-bai-pho-wall.jpg', 'nhasachmienphi-danh-bai-pho-wall.pdf', 'Với 13 năm kinh nghiệm quản lý thành công quỹ đầu tư Fidelity Magellan và lựa chọn hàng nghìn cổ phiếu, Lynch đã đúc kết thành 21 nguyên tắc hài hước mà ông gọi là “Những nguyên tắc của Peter”.\r\n\r\nChìa khóa để đầu tư thành công, theo Lynch, là phải ghi nhớ rằng cổ phiếu không giống như tấm vé số; luôn có một công ty đằng sau mỗi cổ phiếu và một nguyên nhân lý giải cho cách thức vận hành của các công ty – và cổ phiếu của chúng. Lynch chỉ ra làm cách nào chúng ta có thể tìm hiểu tối đa về công ty mục tiêu và xây dựng một danh mục đầu tư sinh lợi dựa trên chính kinh nghiệm, hiểu biết và kết quả nghiên cứu của bản thân. Không có bất kỳ lý do nào cản trở một nhà đầu tư cá nhân tự trở thành chuyên gia, và cuốn sách này sẽ chỉ ra cách thực hiện điều đó.', '2010-01-01'),
(59, 'Bố Già', 16, 1, 'nhasachmienphi-bo-gia.jpg', 'bo-gia.pdf', 'Bố già là tên một cuốn tiểu thuyết nổi tiếng của nhà văn người Mỹ gốc Ý Mario Puzo, được nhà xuất bản G. P. Putnam\'s Sons xuất bản lần đầu vào năm 1969. Tác phẩm là câu chuyện về một gia đình mafia gốc Sicilia tại Mỹ, được một nhân vật gọi là \"Bố già\" Don Vito Corleone tạo lập và lãnh đạo.', '1969-10-03'),
(61, ' Sự Trỗi Dậy Và Suy Tàn Của Đế Chế Thứ Ba – Lịch Sử Đức Quốc Xã', 17, 9, 'nhasachmienphi-su-troi-day-va-suy-tan-cua-de-che-thu-ba-lich-su-duc-quoc-xa.jpg', 'nhasachmienphi-su-troi-day-va-suy-tan-cua-de-che-thu-ba-lich-su-duc-quoc-xa.pdf', 'Ngay trong năm đầu tiên phát hành – 1960, Sự trỗi dậy và suy tàn của Đế chế thứ ba đã bán được tới 1 triệu bản tại Mỹ và được tái bản hơn 20 lần. Cuốn sách là bản tường thuật hết sức chi tiết về nước Đức, dưới sự cai trị của Adolf Hitler và Đảng Quốc xã. Tác giả đã nghiên cứu kĩ lưỡng về sự ra đời của Đế chế thứ ba ở Đức, con đường dẫn đến quyền lực tuyệt đối của Đảng Quốc xã, diễn biến của Chiến tranh thế giới lần thứ hai và sự thất bại của Phát xít Đức. Nguồn tài liệu của cuốn sách bao gồm lời khai của các nhà lãnh đạo Đảng Quốc xã, nhật kí của các quan chức, cùng hàng loạt các quân lệnh và thư mật. ', '1960-12-10'),
(62, 'Đời Ngắn Đừng Ngủ Dài', 20, 3, 'nhasachmienphi-doi-ngan-dung-ngu-dai.png', 'nhasachmienphi-doi-ngan-dung-ngu-dai.pdf', '“Mọi lựa chọn đều giá trị. Mọi bước đi đều quan trọng. Cuộc sống vẫn diễn ra theo cách của nó, không phải theo cách của ta. Hãy kiên nhẫn. Tin tưởng. Hãy giống như người thợ cắt đá, đều đặn từng nhịp, ngày qua ngày. Cuối cùng, một nhát cắt duy nhất sẽ phá vỡ tảng đá và lộ ra viên kim cương. Người tràn đầy nhiệt huyết và tận tâm với việc mình làm không bao giờ bị chối bỏ. Sự thật là thế.”', '2014-01-05'),
(63, 'Hiến Pháp Mỹ Được Làm Ra Như Thế Nào?', 21, 9, '65f24db234ea2_1396.jpg', '65f24db2346b1_3559.pdf', 'Cuốn sách đã cung cấp một bức tranh toàn cảnh về sự ra đời của Hiến pháp Mỹ, như một lời lý giải cho rất nhiều người có cùng mối băn khoăn.Vậy Hiến pháp Mỹ đã được làm ra như thế nào? Nó được làm ra trong những cuộc tranh luận nảy lửa tưởng như không có lối thoát và những mối bất đồng sâu sắc, bởi những bộ óc vĩ đại có một không hai trong lịch sử, và bằng một tinh thần mà người ta khó có thể tìm một tính từ nào thay thế ngoài cách gọi – “tinh thần Mỹ”. Đó là sự tôn trọng đặc biệt lẫn nhau, thừa nhận những quan điểm hoàn toàn khác biệt, chấp nhận và cùng thỏa hiệp để đi tới lợi ích chung cuối cùng.', '2002-01-12');

--
-- Bẫy `books`
--
DELIMITER $$
CREATE TRIGGER `xoasach` BEFORE DELETE ON `books` FOR EACH ROW BEGIN
  DELETE FROM `history` WHERE `book_id` = OLD.id;
  DELETE FROM `wishlist` WHERE `book_id` = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `category` char(100) NOT NULL,
  `name` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `category`, `name`) VALUES
(1, 'trinh-tham', 'Trinh Thám'),
(2, 'khoa-hoc', 'Khoa học'),
(3, 'tam-ly', 'Tâm lý'),
(4, 'lich-su', 'Lịch sử'),
(6, 'cong-nghe-thong-tin', 'Công nghệ thông tin'),
(7, 'tieu-thuyet', 'Tiểu thuyết'),
(8, 'kinh-te', 'Kinh tế'),
(9, 'chinh-tri', 'Chính trị'),
(13, 'van-hoc', 'Văn Học'),
(14, 'than-thoai', 'Thần thoại');

--
-- Bẫy `categories`
--
DELIMITER $$
CREATE TRIGGER `xoatheloai` BEFORE DELETE ON `categories` FOR EACH ROW DELETE FROM `books` WHERE `category_id` = OLD.id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history`
--

CREATE TABLE `history` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `last_read` date NOT NULL DEFAULT (curdate())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`) VALUES
(1, 'khacvi2003', '$2y$10$vbE1BPwZiAcJj681h7.uj.wsaChlUA/u9PGJpbcmLcJxLjd9jUvDO', 'Đoàn Khắc Vi', 'khacvi2003@gmail.com'),
(13, 'vanhuynh', '$2y$10$qzQxKDmLozVAt9CxZlnluua8VvAKHCcBf8QL5ndGQjDAzrbN..AYS', 'Hà Huỳnh Văn', 'hahuynhvan2003@gmail.com'),
(14, 'TriLam2003', '$2y$10$2EamhH4MqXanxh/5m5uqTOk69bFIZ0wctaWNQunnsFPSjGfGHDlnW', 'LÂM QUANG TRÍ', 'triquang2003@gmail.com'),
(15, 'viho2003', '$2y$10$zaM1pD4RZbp4fhYrtmnrY.vq9Z9Pg4QPpLgFXaeBzF03YrY2beG7W', 'Hồ Nguyễn Tường Vy', 'khacvi2003@gmail.com');

--
-- Bẫy `users`
--
DELIMITER $$
CREATE TRIGGER `xoauser` BEFORE DELETE ON `users` FOR EACH ROW BEGIN
  DELETE FROM `history` WHERE `user_id` = OLD.`id`;
  DELETE FROM `wishlist` WHERE `user_id` = OLD.`id`;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `vwadmin`
-- (See below for the actual view)
--
CREATE TABLE `vwadmin` (
`id` int
,`password` char(128)
,`username` varchar(50)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `vwauthors`
-- (See below for the actual view)
--
CREATE TABLE `vwauthors` (
`author` varchar(100)
,`description` text
,`id` int
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `vwbooks`
-- (See below for the actual view)
--
CREATE TABLE `vwbooks` (
`author` varchar(100)
,`category` char(100)
,`cover_path` varchar(260)
,`description` text
,`file_path` varchar(260)
,`id` int
,`published` date
,`title` varchar(100)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `vwcategories`
-- (See below for the actual view)
--
CREATE TABLE `vwcategories` (
`category` char(100)
,`id` int
,`name` char(100)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `vwhistory`
-- (See below for the actual view)
--
CREATE TABLE `vwhistory` (
`id` int
,`last_read` date
,`name` varchar(100)
,`title` varchar(100)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `vwusers`
-- (See below for the actual view)
--
CREATE TABLE `vwusers` (
`email` varchar(100)
,`id` int
,`name` varchar(100)
,`password` char(128)
,`username` varchar(50)
);

-- --------------------------------------------------------

--
-- Cấu trúc đóng vai cho view `vwwishlist`
-- (See below for the actual view)
--
CREATE TABLE `vwwishlist` (
`id` int
,`name` varchar(100)
,`title` varchar(100)
);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Đang đổ dữ liệu cho bảng `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `book_id`) VALUES
(79, 1, 12),
(82, 1, 7),
(84, 13, 59),
(85, 1, 59),
(87, 15, 12);

-- --------------------------------------------------------

--
-- Cấu trúc cho view `vwadmin`
--
DROP TABLE IF EXISTS `vwadmin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwadmin`  AS SELECT `admin`.`id` AS `id`, `admin`.`username` AS `username`, `admin`.`password` AS `password` FROM `admin` ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `vwauthors`
--
DROP TABLE IF EXISTS `vwauthors`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwauthors`  AS SELECT `authors`.`id` AS `id`, `authors`.`author` AS `author`, `authors`.`description` AS `description` FROM `authors` ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `vwbooks`
--
DROP TABLE IF EXISTS `vwbooks`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwbooks`  AS SELECT `books`.`id` AS `id`, `books`.`title` AS `title`, `authors`.`author` AS `author`, `categories`.`category` AS `category`, `books`.`cover_path` AS `cover_path`, `books`.`file_path` AS `file_path`, `books`.`description` AS `description`, `books`.`published` AS `published` FROM ((`books` join `authors` on((`books`.`author_id` = `authors`.`id`))) join `categories` on((`books`.`category_id` = `categories`.`id`))) ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `vwcategories`
--
DROP TABLE IF EXISTS `vwcategories`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwcategories`  AS SELECT `categories`.`id` AS `id`, `categories`.`category` AS `category`, `categories`.`name` AS `name` FROM `categories` ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `vwhistory`
--
DROP TABLE IF EXISTS `vwhistory`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwhistory`  AS SELECT `history`.`id` AS `id`, `users`.`name` AS `name`, `books`.`title` AS `title`, `history`.`last_read` AS `last_read` FROM ((`history` join `users` on((`history`.`user_id` = `users`.`id`))) join `books` on((`history`.`book_id` = `books`.`id`))) ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `vwusers`
--
DROP TABLE IF EXISTS `vwusers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwusers`  AS SELECT `users`.`id` AS `id`, `users`.`username` AS `username`, `users`.`password` AS `password`, `users`.`name` AS `name`, `users`.`email` AS `email` FROM `users` ;

-- --------------------------------------------------------

--
-- Cấu trúc cho view `vwwishlist`
--
DROP TABLE IF EXISTS `vwwishlist`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vwwishlist`  AS SELECT `wishlist`.`id` AS `id`, `users`.`name` AS `name`, `books`.`title` AS `title` FROM ((`wishlist` join `users` on((`wishlist`.`user_id` = `users`.`id`))) join `books` on((`wishlist`.`book_id` = `books`.`id`))) ;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `authors` ADD FULLTEXT KEY `author` (`author`);

--
-- Chỉ mục cho bảng `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `author_id` (`author_id`);
ALTER TABLE `books` ADD FULLTEXT KEY `title` (`title`);
ALTER TABLE `books` ADD FULLTEXT KEY `description` (`description`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category` (`category`);

--
-- Chỉ mục cho bảng `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

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
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `history`
--
ALTER TABLE `history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
