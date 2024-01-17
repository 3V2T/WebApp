DROP DATABASE IF EXISTS `library`;
CREATE DATABASE `library` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `library`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(128) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`, `username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category` char(100) NOT NULL UNIQUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `category` char(100) NOT NULL,
  `description` text NOT NULL DEFAULT '',
  `published` date NOT NULL DEFAULT NOW(),
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category`) REFERENCES `categories` (`category`) ON DELETE CASCADE ON UPDATE CASCADE,
  FULLTEXT KEY `title` (`title`),
  FULLTEXT KEY `author` (`author`),
  FULLTEXT KEY `description` (`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `checkouts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `book_id` int NOT NULL,
  `checkout_date` date NOT NULL DEFAULT NOW(),
  `return_date` date NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE PROCEDURE `themuser` (IN `username` VARCHAR(50), IN `password` CHAR(128), IN `name` VARCHAR(100), IN `email` VARCHAR(100))
    INSERT INTO `users` (`username`, `password`, `name`, `email`) VALUES (username, password, name, email);
CREATE PROCEDURE `themcategory` (IN `category` CHAR(100))
    INSERT INTO `categories` (`category`) VALUES (category);
CREATE PROCEDURE `themsach` (IN `title` VARCHAR(100), IN `author` VARCHAR(100), IN `category` CHAR(100), IN `description` TEXT, IN `published` DATE)
    INSERT INTO `books` (`title`, `author`, `category`, `description`, `published`) VALUES (title, author, category, description, published);
CREATE PROCEDURE `muonsach` (IN `user_id` INT, IN `book_id` INT)
    INSERT INTO `checkouts` (`user_id`, `book_id`) VALUES (user_id, book_id);
CREATE PROCEDURE `trasach` (IN `id` INT)
    UPDATE `checkouts` SET `return_date` = NOW() WHERE `id` = id;
CREATE PROCEDURE `muonsachtheongay` (IN `user_id` INT, IN `book_id` INT, IN `checkout_date` DATE)
    INSERT INTO `checkouts` (`user_id`, `book_id`, `checkout_date`) VALUES (user_id, book_id, checkout_date);
CREATE PROCEDURE `trasachtheongay` (IN `id` INT, IN `return_date` DATE)
    UPDATE `checkouts` SET `return_date` = return_date WHERE `id` = id;