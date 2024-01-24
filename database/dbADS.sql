DROP DATABASE IF EXISTS `library`;
CREATE DATABASE `library` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `library`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NULL,
  PRIMARY KEY (`id`, `username`)
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
CREATE PROCEDURE `themuser` (IN `username` VARCHAR(50), IN `password` CHAR(128), IN `name` VARCHAR(100), IN `email` VARCHAR(100))
  INSERT INTO `users` (`username`, `password`, `name`, `email`) VALUES (username, password, name, email);
CREATE PROCEDURE `themcategory` (IN `category` CHAR(100))
  INSERT INTO `categories` (`category`) VALUES (category);
CREATE PROCEDURE `themauthor` (IN `author` VARCHAR(100), IN `description` TEXT)
  INSERT INTO `authors` (`author`, `description`) VALUES (author, description);
CREATE PROCEDURE `themsach` (IN `title` VARCHAR(100), IN `author_id` INT, IN `category_id` INT, IN `cover_path` VARCHAR(260), IN `file_path` VARCHAR(260), IN `description` TEXT, IN `published` DATE)
  INSERT INTO `books` (`title`, `author_id`, `category_id`, `cover_path`, `file_path`, `description`, `published`) VALUES (title, author_id, category_id, cover_path, file_path, description, published);
CREATE PROCEDURE `suaduongdan` (IN `id` INT, IN `cover_path` VARCHAR(260), IN `file_path` VARCHAR(260))
  UPDATE `books` SET `cover_path` = cover_path, `file_path` = file_path WHERE `id` = id;
CREATE PROCEDURE `suaduongdanbiasach` (IN `id` INT, IN `cover_path` VARCHAR(260))
  UPDATE `books` SET `cover_path` = cover_path WHERE `id` = id;
CREATE PROCEDURE `suaduongdanfile` (IN `id` INT, IN `file_path` VARCHAR(260))
  UPDATE `books` SET `file_path` = file_path WHERE `id` = id;
CREATE PROCEDURE `vuadoc` (IN `user_id` INT, IN `book_id` INT)
  INSERT INTO `history` (`user_id`, `book_id`) VALUES (user_id, book_id);
CREATE PROCEDURE `yeuthich` (IN `user_id` INT, IN `book_id` INT)
  INSERT INTO `wishlist` (`user_id`, `book_id`) VALUES (user_id, book_id);
CREATE PROCEDURE `xoauser` (IN `id` INT)
  DELETE FROM `users` WHERE `id` = id;
CREATE PROCEDURE `timtensach` (IN `title` VARCHAR(100))
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
CREATE PROCEDURE `phantrangsach` (IN `start` INT, IN `number` INT)
  SELECT * FROM `vwbooks` LIMIT start, number;
CREATE PROCEDURE `phantrangtacgia` (IN `start` INT, IN `number` INT)
  SELECT * FROM `vwauthors` LIMIT start, number;
CREATE PROCEDURE `phantranglichsu` (IN `start` INT, IN `number` INT)
  SELECT * FROM `vwhistory` LIMIT start, number;
CREATE PROCEDURE `phantrangyeuthich` (IN `start` INT, IN `number` INT)
  SELECT * FROM `vwwishlist` LIMIT start, number;
CREATE TRIGGER `xoauser` BEFORE DELETE ON `users` FOR EACH ROW 
BEGIN
  DELETE FROM `history` WHERE `user_id` = OLD.id;
  DELETE FROM `wishlist` WHERE `user_id` = OLD.id;
END;
CREATE FUNCTION `kiemtratontaiuser` (`username` VARCHAR(50)) RETURNS BOOLEAN
DETERMINISTIC
  RETURN (SELECT COUNT(*) FROM `users` WHERE `username` = username) > 0;
CREATE FUNCTION `kiemtrauser` (`username` VARCHAR(50), `password` CHAR(128)) RETURNS BOOLEAN
DETERMINISTIC
  RETURN (SELECT COUNT(*) FROM `users` WHERE `username` = username AND `password` = password) > 0;