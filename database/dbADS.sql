DROP DATABASE IF EXISTS `library`;
CREATE DATABASE `library` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `library`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` char(128) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `authors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author` varchar(100) NOT NULL,
  `description` text NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category` char(100) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `author_id` int NOT NULL,
  `category_id` int NOT NULL,
  `cover_path` varchar(260) NULL,
  `file_path` varchar(260) NULL,
  `description` text NULL,
  `published` date NOT NULL DEFAULT (CURRENT_DATE),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `last_read` date NOT NULL DEFAULT (CURRENT_DATE),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `wishlist` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `password` char(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE VIEW `vwusers` AS SELECT * FROM `users`;
CREATE VIEW `vwauthors` AS SELECT * FROM `authors`;
CREATE VIEW `vwcategories` AS SELECT * FROM `categories`;
CREATE VIEW `vwbooks` AS SELECT `books`.`id`, `books`.`title`, `authors`.`author`, `categories`.`category`, `books`.`cover_path`, `books`.`file_path`, `books`.`description`, `books`.`published` FROM `books` INNER JOIN `authors` ON `books`.`author_id` = `authors`.`id` INNER JOIN `categories` ON `books`.`category_id` = `categories`.`id`;
CREATE VIEW `vwhistory` AS SELECT `history`.`id`, `users`.`name`, `books`.`title`, `history`.`last_read` FROM `history` INNER JOIN `users` ON `history`.`user_id` = `users`.`id` INNER JOIN `books` ON `history`.`book_id` = `books`.`id`;
CREATE VIEW `vwwishlist` AS SELECT `wishlist`.`id`, `users`.`name`, `books`.`title` FROM `wishlist` INNER JOIN `users` ON `wishlist`.`user_id` = `users`.`id` INNER JOIN `books` ON `wishlist`.`book_id` = `books`.`id`;
CREATE PROCEDURE `themuser` (IN `username` VARCHAR(50), IN `password` CHAR(128), IN `name` VARCHAR(100), IN `email` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'INSERT INTO `users` (`username`, `password`, `name`, `email`) VALUES (?, ?, ?, ?)';
  SET @username = username;
  SET @password = password;
  SET @name = name;
  SET @email = email;
  EXECUTE stmt USING @username, @password, @name, @email;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `suauser` (IN `id` INT, IN `username` VARCHAR(50), IN `password` CHAR(128), IN `name` VARCHAR(100), IN `email` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'UPDATE `users` SET `username` = ?, `password` = ?, `name` = ?, `email` = ? WHERE `id` = ?';
  SET @id = id;
  SET @username = username;
  SET @password = password;
  SET @name = name;
  SET @email = email;
  EXECUTE stmt USING @username, @password, @name, @email, @id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `themcategory` (IN `category` CHAR(100))
BEGIN
  PREPARE stmt FROM 'INSERT INTO `categories` (`category`) VALUES (?)';
  SET @category = category;
  EXECUTE stmt USING @category;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `themauthor` (IN `author` VARCHAR(100), IN `description` TEXT)
BEGIN
  PREPARE stmt FROM 'INSERT INTO `authors` (`author`, `description`) VALUES (?, ?)';
  SET @author = author;
  SET @description = description;
  EXECUTE stmt USING @author, @description;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `suaauthor` (IN `id` INT, IN `author` VARCHAR(100), IN `description` TEXT)
BEGIN
  PREPARE stmt FROM 'UPDATE `authors` SET `author` = ?, `description` = ? WHERE `id` = ?';
  SET @id = id;
  SET @author = author;
  SET @description = description;
  EXECUTE stmt USING @author, @description, @id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `xoaauthor` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'DELETE FROM `authors` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `themsach` (IN `title` VARCHAR(100), IN `author_id` INT, IN `category_id` INT, IN `cover_path` VARCHAR(260), IN `file_path` VARCHAR(260), IN `description` TEXT, IN `published` DATE)
BEGIN
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
END;
CREATE PROCEDURE `suasach` (IN `id` INT, IN `title` VARCHAR(100), IN `author_id` INT, IN `category_id` INT, IN `cover_path` VARCHAR(260), IN `file_path` VARCHAR(260), IN `description` TEXT, IN `published` DATE)
BEGIN
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
END;
CREATE PROCEDURE `xoasach` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'DELETE FROM `books` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `doimatkhau` (IN `id` INT, IN `password` CHAR(128))
BEGIN
  PREPARE stmt FROM 'UPDATE `users` SET `password` = ? WHERE `id` = ?';
  SET @id = id;
  SET @password = password;
  EXECUTE stmt USING @password, @id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `doimatkhauadmin` (IN `id` INT, IN `password` CHAR(128))
BEGIN
  PREPARE stmt FROM 'UPDATE `admin` SET `password` = ? WHERE `id` = ?';
  SET @id = id;
  SET @password = password;
  EXECUTE stmt USING @password, @id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `suathongtin` (IN `id` INT, IN `name` VARCHAR(100), IN `email` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'UPDATE `users` SET `name` = ?, `email` = ? WHERE `id` = ?';
  SET @id = id;
  SET @name = name;
  SET @email = email;
  EXECUTE stmt USING @id, @name, @email;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `suaduongdan` (IN `id` INT, IN `cover_path` VARCHAR(260), IN `file_path` VARCHAR(260))
BEGIN
  PREPARE stmt FROM 'UPDATE `books` SET `cover_path` = ?, `file_path` = ? WHERE `id` = ?';
  SET @id = id;
  SET @cover_path = cover_path;
  SET @file_path = file_path;
  EXECUTE stmt USING @id, @cover_path, @file_path;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `suaduongdanbiasach` (IN `id` INT, IN `cover_path` VARCHAR(260))
BEGIN
  PREPARE stmt FROM 'UPDATE `books` SET `cover_path` = ? WHERE `id` = ?';
  SET @id = id;
  SET @cover_path = cover_path;
  EXECUTE stmt USING @id, @cover_path;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `suaduongdanfile` (IN `id` INT, IN `file_path` VARCHAR(260))
BEGIN
  PREPARE stmt FROM 'UPDATE `books` SET `file_path` = ? WHERE `id` = ?';
  SET @id = id;
  SET @file_path = file_path;
  EXECUTE stmt USING @id, @file_path;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `vuadoc` (IN `user_id` INT, IN `book_id` INT)
BEGIN 
  PREPARE stmt FROM 'INSERT INTO `history` (`user_id`, `book_id`) VALUES (?, ?)';
  SET @user_id = user_id;
  SET @book_id = book_id;
  EXECUTE stmt USING @user_id, @book_id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `yeuthich` (IN `user_id` INT, IN `book_id` INT)
BEGIN
  PREPARE stmt FROM 'INSERT INTO `wishlist` (`user_id`, `book_id`) VALUES (?, ?)';
  SET @user_id = user_id;
  SET @book_id = book_id;
  EXECUTE stmt USING @user_id, @book_id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `xoauser` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'DELETE FROM `users` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `xoakhoiwishlist` (IN `username` CHAR(100), IN `title` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'DELETE FROM `wishlist` WHERE `user_id` = (SELECT `id` FROM `users` WHERE `username` = ?) AND `book_id` = (SELECT `id` FROM `books` WHERE `title` = ?)';
  SET @username = username;
  SET @title = title;
  EXECUTE stmt USING @username, @title;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `xoakhoihistory` (IN `username` CHAR(100), IN `title` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'DELETE FROM `history` WHERE `user_id` = (SELECT `id` FROM `users` WHERE `username` = ?) AND `book_id` = (SELECT `id` FROM `books` WHERE `title` = ?)';
  SET @username = username;
  SET @title = title;
  EXECUTE stmt USING @username, @title;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `timsachtheoten` (IN `title` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`title`) AGAINST (? WITH QUERY EXPANSION)';
  SET @title = title;
  EXECUTE stmt USING @title;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `timsachtheotacgia` (IN `author` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`author`) AGAINST (? WITH QUERY EXPANSION)';
  SET @author = author;
  EXECUTE stmt USING @author;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `timsachtheotheloai` (IN `category` CHAR(100))
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`category`) AGAINST (? WITH QUERY EXPANSION)';
  SET @category = category;
  EXECUTE stmt USING @category;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `timsachtheonoidung` (IN `description` TEXT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`description`) AGAINST (? WITH QUERY EXPANSION)';
  SET @description = description;
  EXECUTE stmt USING @description;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `timsachtheonamxuatban` (IN `published` DATE)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`published`) AGAINST (? WITH QUERY EXPANSION)';
  SET @published = published;
  EXECUTE stmt USING @published;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `timtacgia` (IN `author` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwauthors` WHERE MATCH (`author`) AGAINST (? WITH QUERY EXPANSION)';
  SET @author = author;
  EXECUTE stmt USING @author;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `timtheloai` (IN `category` CHAR(100))
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwcategories` WHERE MATCH (`category`) AGAINST (? WITH QUERY EXPANSION)';
  SET @category = category;
  EXECUTE stmt USING @category;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `getBooksbyid` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `getAuthorsbyid` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwauthors` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `getCategoriesbyid` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwcategories` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `getUsersbyid` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwusers` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `getwlbyuserid` (IN `user_id` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwwishlist` WHERE `user_id` = ?';
  SET @user_id = user_id;
  EXECUTE stmt USING @user_id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `gethistorybyuserid` (IN `user_id` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwhistory` WHERE `user_id` = ?';
  SET @user_id = user_id;
  EXECUTE stmt USING @user_id;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `phantrangsach` (IN `start` INT, IN `number` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `phantrangtacgia` (IN `start` INT, IN `number` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwauthors` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `phantranglichsu` (IN `start` INT, IN `number` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwhistory` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `phantrangyeuthich` (IN `start` INT, IN `number` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwwishlist` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `phantrangwltheouserid` (IN `id` INT, IN `start` INT, IN `number` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwwishlist` WHERE `user_id` = ? LIMIT ?, ?';
  SET @id = id;
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @id, @start, @number;
  DEALLOCATE PREPARE stmt;
END;
CREATE PROCEDURE `phantranglstheouserid` (IN `id` INT, IN `start` INT, IN `number` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwhistory` WHERE `user_id` = ? LIMIT ?, ?';
  SET @id = id;
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @id, @start, @number;
  DEALLOCATE PREPARE stmt;
END;
CREATE TRIGGER `xoauser` BEFORE DELETE ON `users` FOR EACH ROW 
BEGIN
  DELETE FROM `history` WHERE `user_id` = OLD.id;
  DELETE FROM `wishlist` WHERE `user_id` = OLD.id;
END;
CREATE TRIGGER `xoasach` BEFORE DELETE ON `books` FOR EACH ROW
BEGIN
  DELETE FROM `history` WHERE `book_id` = OLD.id;
  DELETE FROM `wishlist` WHERE `book_id` = OLD.id;
END;
CREATE TRIGGER `xoatacgia` BEFORE DELETE ON `authors` FOR EACH ROW
  DELETE FROM `books` WHERE `author_id` = OLD.id;
CREATE FUNCTION `kiemtratontaiuser` (`username` VARCHAR(50)) RETURNS BOOLEAN
DETERMINISTIC
  RETURN (SELECT COUNT(*) FROM `users` WHERE `username` = username) > 0;
CREATE FUNCTION `kiemtrauser` (`username` VARCHAR(50), `password` CHAR(128)) RETURNS BOOLEAN
DETERMINISTIC
  RETURN (SELECT COUNT(*) FROM `users` WHERE `username` = username AND `password` = password) > 0;
CREATE FUNCTION `kiemtratontaiadmin` (`username` VARCHAR(50)) RETURNS BOOLEAN
DETERMINISTIC
  RETURN (SELECT COUNT(*) FROM `admins` WHERE `username` = username) > 0;
CREATE FUNCTION `kiemtraadmin` (`username` VARCHAR(50), `password` CHAR(128)) RETURNS BOOLEAN
DETERMINISTIC
  RETURN (SELECT COUNT(*) FROM `admins` WHERE `username` = username AND `password` = password) > 0;