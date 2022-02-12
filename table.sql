CREATE TABLE `products` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `created_at` datetime NOT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `access_tokens` (
                                 `id` int(11) NOT NULL AUTO_INCREMENT,
                                 `product_id` int(11) NOT NULL,
                                 `key` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `secret` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `secret_salt` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
                                 `whitelist_range` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' CHECK (json_valid(`whitelist_range`)),
                                 `permissions` longtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '[]',
                                 `created_at` datetime NOT NULL DEFAULT current_timestamp(),
                                 `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
                                 PRIMARY KEY (`id`),
                                 KEY `access_token_key` (`key`),
                                 KEY `access_tokens_FK` (`product_id`),
                                 CONSTRAINT `access_tokens_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                                 CONSTRAINT `permissions` CHECK (json_valid(`permissions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `admin_logs` (
                              `id` int(11) NOT NULL AUTO_INCREMENT,
                              `access_token_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
                              `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                              `created_at` datetime NOT NULL,
                              PRIMARY KEY (`id`),
                              KEY `log_access_token_id` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `user_logs` (
                             `id` int(11) NOT NULL AUTO_INCREMENT,
                             `subscription_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `ip` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
                             `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                             `created_at` datetime NOT NULL,
                             PRIMARY KEY (`id`),
                             KEY `subscription_id` (`subscription_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;