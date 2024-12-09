CREATE TABLE `logs` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `code` int(24) DEFAULT 0,
  `message` varchar(10000) DEFAULT NULL,
  `file` varchar(256) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci