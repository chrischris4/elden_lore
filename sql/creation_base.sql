-- Création de la BDD
CREATE DATABASE IF NOT EXISTS `partage_de_recettes`;
USE `partage_de_recettes`;

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

delete from `users`;
insert into `users` (`age`, `email`, `full_name`, `password`, `user_id`) values (34, 'mickael.andrieu@exemple.com', 'Mickaël Andrieu', 'devine', 1);
insert into `users` (`age`, `email`, `full_name`, `password`, `user_id`) values (34, 'mathieu.nebra@exemple.com', 'Mathieu Nebra', 'MiamMiam', 2);
insert into `users` (`age`, `email`, `full_name`, `password`, `user_id`) values (28, 'laurene.castor@exemple.com', 'Laurène Castor', 'laCasto28', 3);

delete from `items`;
insert into `items` (`author`, `is_enabled`, `info_item`, `items_id`, `title`) values ('mickael.andrieu@exemple.com', 1, "Malenia est une empyréenne, soeur de miquella, fille de radagon et de marika", 1, 'Malenia');
insert into `items` (`author`, `is_enabled`, `info_item`, `items_id`, `title`) values ('mickael.andrieu@exemple.com', 1, "Radagon est, avec marika, créateur du cercle d'elden", 2, 'Radagon');
insert into `items` (`author`, `is_enabled`, `info_item`, `items_id`, `title`) values ('laurene.castor@exemple.com', 1, "Marika est beaucoup de choses", 4, 'Marika');
insert into `items` (`author`, `is_enabled`, `info_item`, `items_id`, `title`) values ('mathieu.nebra@exemple.com', 1, "Ranni est une empyréenne, soeur de Rakyard et Radhan, fille de Rennala et de Radagon", 3, 'Ranni');