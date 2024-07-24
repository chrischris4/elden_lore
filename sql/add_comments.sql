USE `elden_lore`;

CREATE TABLE IF NOT EXISTS `comments` (
    `comment_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `items_id` int(11) NOT NULL,
    `comment` longtext NOT NULL,
    PRIMARY KEY (`comment_id`),
    KEY `IDX_5F9E962A9D86650F` (`user_id`),
    KEY `IDX_5F9E962A69574A48` (`items_id`),
    CONSTRAINT `FK_5F9E962A69574A48` FOREIGN KEY (`items_id`) REFERENCES `items` (`items_id`) ON DELETE CASCADE,
    CONSTRAINT `FK_5F9E962A9D86650F` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;