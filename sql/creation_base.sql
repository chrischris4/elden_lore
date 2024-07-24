-- Création de la BDD
CREATE DATABASE IF NOT EXISTS `elden_lore`;
USE `elden_lore`;

-- Création de la table items
CREATE TABLE IF NOT EXISTS `items` (
    `items_id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(128) NOT NULL,
    `info_item` TEXT NOT NULL,
    `author` varchar(255) NOT NULL,
    `is_enabled` BOOLEAN NOT NULL,
    PRIMARY KEY (`items_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ALTER TABLE `items`
ADD COLUMN `category` VARCHAR(255) NOT NULL;


-- Création de la table users
CREATE TABLE IF NOT EXISTS `users` (
    `user_id` int(11) NOT NULL AUTO_INCREMENT,
    `full_name` varchar(64) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `age` INT NOT NULL,
    PRIMARY KEY (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
