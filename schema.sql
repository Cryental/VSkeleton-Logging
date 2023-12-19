CREATE TABLE `products`
(
    `id`         int(11) NOT NULL AUTO_INCREMENT,
    `name`       varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `created_at` datetime                                NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `products_UN` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `access_tokens`
(
    `id`              int(11) NOT NULL AUTO_INCREMENT,
    `product_id`      int(11) NOT NULL,
    `key`             varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
    `secret`          varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
    `secret_salt`     varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
    `whitelist_range` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '[]' CHECK (json_valid(`whitelist_range`)),
    `created_at`      datetime                               NOT NULL DEFAULT current_timestamp(),
    `updated_at`      datetime                               NOT NULL DEFAULT current_timestamp(),
    `active`          tinyint(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`),
    KEY               `access_token_key` (`key`),
    KEY               `access_tokens_FK` (`product_id`),
    CONSTRAINT `access_tokens_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `admin_logs`
(
    `id`                      char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `access_token_id`         char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `url`                     varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
    `method`                  varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `ip`                      varchar(255) COLLATE utf8mb4_unicode_ci  NOT NULL,
    `user_agent`              varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at`              datetime                                NOT NULL,
    `logging_access_token_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY                       `log_access_token_id` (`access_token_id`),
    KEY                       `admin_logs_FK` (`logging_access_token_id`),
    CONSTRAINT `admin_logs_FK` FOREIGN KEY (`logging_access_token_id`) REFERENCES `access_tokens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `user_logs`
(
    `id`                      char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `user_id`                 char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `subscription_id`         char(36) COLLATE utf8mb4_unicode_ci     NOT NULL,
    `url`                     varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
    `method`                  varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `ip`                      varchar(255) COLLATE utf8mb4_unicode_ci  NOT NULL,
    `user_agent`              varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at`              datetime                                NOT NULL,
    `logging_access_token_id` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY                       `subscription_id` (`subscription_id`),
    KEY                       `user_logs_FK` (`logging_access_token_id`),
    CONSTRAINT `user_logs_FK` FOREIGN KEY (`logging_access_token_id`) REFERENCES `access_tokens` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;