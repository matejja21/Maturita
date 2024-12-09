CREATE TABLE `license_types` (
  `license_type_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `description` varchar(10000) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `doc_url` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `monthly_price` int(10) DEFAULT NULL,
  `currency` varchar(5) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`license_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci