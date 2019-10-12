-- --------------------------------------------------------
-- Host:                         gvandrqz.beget.tech
-- Server version:               5.7.21-20-beget-5.7.21-20-1-log - (LTD BeGet)
-- Server OS:                    Linux
-- HeidiSQL Version:             10.1.0.5490
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table gvandrqz_omega.role
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table gvandrqz_omega.role_m2m_user_type
CREATE TABLE IF NOT EXISTS `role_m2m_user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_role_m2m_user_type_role` (`role_id`),
  KEY `FK_role_m2m_user_type_user_type` (`user_type_id`),
  CONSTRAINT `FK_role_m2m_user_type_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_role_m2m_user_type_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table gvandrqz_omega.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) DEFAULT NULL,
  `birthday_date` date DEFAULT '0000-00-00',
  `organization` varchar(255) DEFAULT NULL,
  `user_type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_book_role` (`user_type_id`),
  CONSTRAINT `FK_book_role` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table gvandrqz_omega.user_m2m_role
CREATE TABLE IF NOT EXISTS `user_m2m_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_o2m_role_user` (`user_id`),
  KEY `FK_user_o2m_role_role` (`role_id`),
  CONSTRAINT `FK_user_o2m_role_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_user_o2m_role_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
-- Dumping structure for table gvandrqz_omega.user_type
CREATE TABLE IF NOT EXISTS `user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Data exporting was unselected.
-- Dumping structure for view gvandrqz_omega.view_role_m2m_user_type
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_role_m2m_user_type` (
	`user_type_id` INT(11) NOT NULL,
	`roleObj` TEXT NULL COLLATE 'utf8mb4_bin'
) ENGINE=MyISAM;

-- Dumping structure for view gvandrqz_omega.view_user
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_user` (
	`id` INT(11) NOT NULL,
	`full_name` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`birthday_date` DATE NULL,
	`created_at` TIMESTAMP NULL,
	`user_type_id` INT(11) NULL,
	`organization` VARCHAR(255) NULL COLLATE 'utf8_general_ci',
	`user_type_title` VARCHAR(50) NULL COLLATE 'utf8_general_ci',
	`role_arr` TEXT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view gvandrqz_omega.view_user_m2m_role
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_user_m2m_role` (
	`user_id` INT(11) NULL,
	`roleArr` TEXT NULL COLLATE 'utf8mb4_general_ci'
) ENGINE=MyISAM;

-- Dumping structure for view gvandrqz_omega.view_role_m2m_user_type
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_role_m2m_user_type`;
CREATE ALGORITHM=UNDEFINED DEFINER=`gvandrqz_omega`@`%` SQL SECURITY DEFINER VIEW `view_role_m2m_user_type` AS select `role_m2m_user_type`.`user_type_id` AS `user_type_id`,group_concat(json_object('id',`role`.`id`,'title',`role`.`title`) separator ',') AS `roleObj` from (`role_m2m_user_type` left join `role` on((`role`.`id` = `role_m2m_user_type`.`role_id`))) group by `role_m2m_user_type`.`user_type_id`;

-- Dumping structure for view gvandrqz_omega.view_user
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_user`;
CREATE ALGORITHM=UNDEFINED DEFINER=`gvandrqz_omega`@`%` SQL SECURITY DEFINER VIEW `view_user` AS select `gvandrqz_omega`.`user`.`id` AS `id`,`gvandrqz_omega`.`user`.`full_name` AS `full_name`,`gvandrqz_omega`.`user`.`birthday_date` AS `birthday_date`,`gvandrqz_omega`.`user`.`created_at` AS `created_at`,`gvandrqz_omega`.`user`.`user_type_id` AS `user_type_id`,`gvandrqz_omega`.`user`.`organization` AS `organization`,`gvandrqz_omega`.`user_type`.`title` AS `user_type_title`,group_concat(`t1`.`id` separator ',') AS `role_arr` from ((`gvandrqz_omega`.`user` left join (select `gvandrqz_omega`.`role`.`id` AS `id`,`gvandrqz_omega`.`role`.`title` AS `role_title`,`gvandrqz_omega`.`user_m2m_role`.`user_id` AS `user_id` from (`gvandrqz_omega`.`user_m2m_role` left join `gvandrqz_omega`.`role` on((`gvandrqz_omega`.`user_m2m_role`.`role_id` = `gvandrqz_omega`.`role`.`id`)))) `t1` on((`t1`.`user_id` = `gvandrqz_omega`.`user`.`id`))) left join `gvandrqz_omega`.`user_type` on((`gvandrqz_omega`.`user`.`user_type_id` = `gvandrqz_omega`.`user_type`.`id`))) group by `gvandrqz_omega`.`user`.`id`;

-- Dumping structure for view gvandrqz_omega.view_user_m2m_role
-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_user_m2m_role`;
CREATE ALGORITHM=UNDEFINED DEFINER=`gvandrqz_omega`@`%` SQL SECURITY DEFINER VIEW `view_user_m2m_role` AS select `user_m2m_role`.`user_id` AS `user_id`,group_concat(`user_m2m_role`.`role_id` separator ',') AS `roleArr` from `user_m2m_role` group by `user_m2m_role`.`user_id`;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
