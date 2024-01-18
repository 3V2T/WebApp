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
  `description` text NULL,
  `published` date NOT NULL DEFAULT CURRENT_DATE(),
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
  `last_read` date NOT NULL DEFAULT CURRENT_DATE(),
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
CREATE VIEW `vwbooks` AS SELECT `books`.`id`, `books`.`title`, `authors`.`author`, `categories`.`category`, `books`.`description`, `books`.`published` FROM `books` INNER JOIN `authors` ON `books`.`author_id` = `authors`.`id` INNER JOIN `categories` ON `books`.`category_id` = `categories`.`id`;
CREATE VIEW `vwhistory` AS SELECT `history`.`id`, `users`.`name`, `books`.`title`, `history`.`last_read` FROM `history` INNER JOIN `users` ON `history`.`user_id` = `users`.`id` INNER JOIN `books` ON `history`.`book_id` = `books`.`id`;
CREATE PROCEDURE `themuser` (IN `username` VARCHAR(50), IN `password` CHAR(128), IN `name` VARCHAR(100), IN `email` VARCHAR(100))
  INSERT INTO `users` (`username`, `password`, `name`, `email`) VALUES (username, password, name, email);
CREATE PROCEDURE `themcategory` (IN `category` CHAR(100))
  INSERT INTO `categories` (`category`) VALUES (category);
CREATE PROCEDURE `themauthor` (IN `author` VARCHAR(100), IN `description` TEXT)
  INSERT INTO `authors` (`author`, `description`) VALUES (author, description);
CREATE PROCEDURE `themsach` (IN `title` VARCHAR(100), IN `author` VARCHAR(100), IN `category` CHAR(100), IN `description` TEXT, IN `published` DATE)
  INSERT INTO `books` (`title`, `author`, `category`, `description`, `published`) VALUES (title, author, category, description, published);
CREATE PROCEDURE `vuadoc` (IN `user_id` INT, IN `book_id` INT)
  INSERT INTO `history` (`user_id`, `book_id`) VALUES (user_id, book_id);
CREATE PROCEDURE `yeuthich` (IN `user_id` INT, IN `book_id` INT)
  INSERT INTO `wishlist` (`user_id`, `book_id`) VALUES (user_id, book_id);
CREATE PROCEDURE `xoauser` (IN `id` INT)
  DELETE FROM `users` WHERE `id` = id;
DELIMITER $$
CREATE TRIGGER `xoauser` BEFORE DELETE ON `users` FOR EACH ROW 
BEGIN
  DELETE FROM `history` WHERE `user_id` = OLD.`id`;
  DELETE FROM `wishlist` WHERE `user_id` = OLD.`id`;
END$$
DELIMITER ;