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
CREATE VIEW `vwusers` AS SELECT * FROM `users`;
CREATE VIEW `vwauthors` AS SELECT * FROM `authors`;
CREATE VIEW `vwcategories` AS SELECT * FROM `categories`;
CREATE VIEW `vwbooks` AS SELECT `books`.`id`, `books`.`title`, `authors`.`author`, `categories`.`category`, `books`.`cover_path`, `books`.`file_path`, `books`.`description`, `books`.`published` FROM `books` INNER JOIN `authors` ON `books`.`author_id` = `authors`.`id` INNER JOIN `categories` ON `books`.`category_id` = `categories`.`id`;
CREATE VIEW `vwhistory` AS SELECT `history`.`id`, `users`.`name`, `books`.`title`, `history`.`last_read` FROM `history` INNER JOIN `users` ON `history`.`user_id` = `users`.`id` INNER JOIN `books` ON `history`.`book_id` = `books`.`id`;
CREATE VIEW `vwwishlist` AS SELECT `wishlist`.`id`, `users`.`name`, `books`.`title` FROM `wishlist` INNER JOIN `users` ON `wishlist`.`user_id` = `users`.`id` INNER JOIN `books` ON `wishlist`.`book_id` = `books`.`id`;
DELIMITER $$
CREATE PROCEDURE `themuser` (IN `username` VARCHAR(50), IN `password` CHAR(128), IN `name` VARCHAR(100), IN `email` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'INSERT INTO `users` (`username`, `password`, `name`, `email`) VALUES (?, ?, ?, ?)';
  SET @username = username;
  SET @password = password;
  SET @name = name;
  SET @email = email;
  EXECUTE stmt USING @username, @password, @name, @email;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `themcategory` (IN `category` CHAR(100))
BEGIN
  PREPARE stmt FROM 'INSERT INTO `categories` (`category`) VALUES (?)';
  SET @category = category;
  EXECUTE stmt USING @category;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `themauthor` (IN `author` VARCHAR(100), IN `description` TEXT)
BEGIN
  PREPARE stmt FROM 'INSERT INTO `authors` (`author`, `description`) VALUES (?, ?)';
  SET @author = author;
  SET @description = description;
  EXECUTE stmt USING @author, @description;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
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
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `doimatkhau` (IN `id` INT, IN `password` CHAR(128))
BEGIN
  PREPARE stmt FROM 'UPDATE `users` SET `password` = ? WHERE `id` = ?';
  SET @id = id;
  SET @password = password;
  EXECUTE stmt USING @id, @password;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `suathongtin` (IN `id` INT, IN `name` VARCHAR(100), IN `email` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'UPDATE `users` SET `name` = ?, `email` = ? WHERE `id` = ?';
  SET @id = id;
  SET @name = name;
  SET @email = email;
  EXECUTE stmt USING @id, @name, @email;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `suaduongdan` (IN `id` INT, IN `cover_path` VARCHAR(260), IN `file_path` VARCHAR(260))
BEGIN
  PREPARE stmt FROM 'UPDATE `books` SET `cover_path` = ?, `file_path` = ? WHERE `id` = ?';
  SET @id = id;
  SET @cover_path = cover_path;
  SET @file_path = file_path;
  EXECUTE stmt USING @id, @cover_path, @file_path;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `suaduongdanbiasach` (IN `id` INT, IN `cover_path` VARCHAR(260))
BEGIN
  PREPARE stmt FROM 'UPDATE `books` SET `cover_path` = ? WHERE `id` = ?';
  SET @id = id;
  SET @cover_path = cover_path;
  EXECUTE stmt USING @id, @cover_path;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `suaduongdanfile` (IN `id` INT, IN `file_path` VARCHAR(260))
BEGIN
  PREPARE stmt FROM 'UPDATE `books` SET `file_path` = ? WHERE `id` = ?';
  SET @id = id;
  SET @file_path = file_path;
  EXECUTE stmt USING @id, @file_path;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `yeuthich` (IN `user_id` INT, IN `book_id` INT)
BEGIN
  PREPARE stmt FROM 'INSERT INTO `wishlist` (`user_id`, `book_id`) VALUES (?, ?)';
  SET @user_id = user_id;
  SET @book_id = book_id;
  EXECUTE stmt USING @user_id, @book_id;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `xoauser` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'DELETE FROM `users` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `xoakhoiwishlist` (IN `username` CHAR(100), IN `title` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'DELETE FROM `wishlist` WHERE `user_id` = (SELECT `id` FROM `users` WHERE `username` = ?) AND `book_id` = (SELECT `id` FROM `books` WHERE `title` = ?)';
  SET @username = username;
  SET @title = title;
  EXECUTE stmt USING @username, @title;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `xoakhoihistory` (IN `username` CHAR(100), IN `title` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'DELETE FROM `history` WHERE `user_id` = (SELECT `id` FROM `users` WHERE `username` = ?) AND `book_id` = (SELECT `id` FROM `books` WHERE `title` = ?)';
  SET @username = username;
  SET @title = title;
  EXECUTE stmt USING @username, @title;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `timtensach` (IN `title` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`title`) AGAINST (? WITH QUERY EXPANSION)';
  SET @title = title;
  EXECUTE stmt USING @title;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `timsachtheotacgia` (IN `author` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`author`) AGAINST (? WITH QUERY EXPANSION)';
  SET @author = author;
  EXECUTE stmt USING @author;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `timsachtheotheloai` (IN `category` CHAR(100))
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`category`) AGAINST (? WITH QUERY EXPANSION)';
  SET @category = category;
  EXECUTE stmt USING @category;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `timsachtheonoidung` (IN `description` TEXT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`description`) AGAINST (? WITH QUERY EXPANSION)';
  SET @description = description;
  EXECUTE stmt USING @description;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `timsachtheonamxuatban` (IN `published` DATE)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE MATCH (`published`) AGAINST (? WITH QUERY EXPANSION)';
  SET @published = published;
  EXECUTE stmt USING @published;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `timtacgia` (IN `author` VARCHAR(100))
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwauthors` WHERE MATCH (`author`) AGAINST (? WITH QUERY EXPANSION)';
  SET @author = author;
  EXECUTE stmt USING @author;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `timtheloai` (IN `category` CHAR(100))
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwcategories` WHERE MATCH (`category`) AGAINST (? WITH QUERY EXPANSION)';
  SET @category = category;
  EXECUTE stmt USING @category;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `getBooksbyid` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `getAuthorsbyid` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwauthors` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `getCategoriesbyid` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwcategories` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `getUsersbyid` (IN `id` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwusers` WHERE `id` = ?';
  SET @id = id;
  EXECUTE stmt USING @id;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `phantrangsach` (IN `start` INT, IN `number` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwbooks` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `phantrangtacgia` (IN `start` INT, IN `number` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwauthors` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `phantranglichsu` (IN `start` INT, IN `number` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwhistory` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE PROCEDURE `phantrangyeuthich` (IN `start` INT, IN `number` INT)
BEGIN
  PREPARE stmt FROM 'SELECT * FROM `vwwishlist` LIMIT ?, ?';
  SET @start = start;
  SET @number = number;
  EXECUTE stmt USING @start, @number;
  DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `xoauser` BEFORE DELETE ON `users` FOR EACH ROW 
BEGIN
  DELETE FROM `history` WHERE `user_id` = OLD.`id`;
  DELETE FROM `wishlist` WHERE `user_id` = OLD.`id`;
END$$
DELIMITER ;
CREATE FUNCTION `kiemtratontaiuser` (`username` VARCHAR(50)) RETURNS BOOLEAN
DETERMINISTIC
  RETURN (SELECT COUNT(*) FROM `users` WHERE `username` = username) > 0;
CREATE FUNCTION `kiemtrauser` (`username` VARCHAR(50), `password` CHAR(128)) RETURNS BOOLEAN
DETERMINISTIC
  RETURN (SELECT COUNT(*) FROM `users` WHERE `username` = username AND `password` = password) > 0;