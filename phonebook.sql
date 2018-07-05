CREATE DATABASE IF NOT EXISTS `phonebook1` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;

USE `phonebook1` ;

CREATE  TABLE IF NOT EXISTS `phonebook1`.`contacts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `phone no` VARCHAR(13) NOT NULL,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

USE `phonebook1` ;

INSERT INTO `contacts`(`name`,`phone no`) VALUES
('surya teja','9603696399'),
('sanjay vihar','8639341636');

CREATE USER 'phonebook_user'@'localhost' IDENTIFIED BY 'password';
GRANT USAGE ON *.* TO 'phonebook_user'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON `phonebook1`.* TO 'phonebook_user'@'localhost';