DROP TABLE IF EXISTS `userlog`;
CREATE TABLE `userlog` (
    id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `item_id` int(11) NOT NULL,
    `old_name` varchar(512) NOT NULL,
    `new_name` varchar(512) NOT NULL,
    `user_ip` varchar(16) NOT NULL,
    `timestamp` DATETIME NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;