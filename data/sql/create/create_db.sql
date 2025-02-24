CREATE TABLE `licenses` (
  `license_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `description` varchar(10000) CHARACTER SET utf8 COLLATE utf8_czech_ci DEFAULT NULL,
  `doc_url` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `monthly_price` int(10) DEFAULT NULL,
  `currency` varchar(5) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`license_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

CREATE TABLE `logs` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `code` int(24) DEFAULT 0,
  `message` varchar(10000) DEFAULT NULL,
  `file` varchar(256) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `level` int(3) NOT NULL,
  `google_user` tinyint(1) NOT NULL DEFAULT 0,
  `uuid` varchar(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `secret_key` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

CREATE TABLE `license_keys` (
  `license_key_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `license_id` int(10) unsigned NOT NULL,
  `license_key` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `create_date` date NOT NULL DEFAULT current_timestamp(),
  `expiration_date` date NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT 1,
  `last_update` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`license_key_id`),
  FOREIGN KEY (`user_id`) REFERENCES users(`user_key`),
  FOREIGN KEY (`license_id`) REFERENCES licenses(`license_key`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;