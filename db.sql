CREATE TABLE IF NOT EXISTS `users` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
	`password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
	`email` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `username` (`username`)

) ENGINE=InnoDB  DEFAULT CHARSET=utf8  COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `listings` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`title` varchar(255) NOT NULL,
	`company` varchar(255) NOT NULL,
	`location` varchar(255) NOT NULL,
	`link` varchar(1000) NULL,
	`status` varchar(25) NOT NULL,
	`user_id` int(10) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;