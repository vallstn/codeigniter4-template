-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2022 at 05:47 AM
-- Server version: 10.9.3-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learn2code`
--

-- --------------------------------------------------------

--
-- Table structure for table `bf_auth_groups_users`
--

CREATE TABLE `bf_auth_groups_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bf_auth_groups_users`
--

INSERT INTO `bf_auth_groups_users` (`id`, `user_id`, `group`, `created_at`) VALUES
(1, 1, 'superadmin', '2022-09-30 22:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `bf_auth_identities`
--

CREATE TABLE `bf_auth_identities` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `secret` varchar(255) NOT NULL,
  `secret2` varchar(255) DEFAULT NULL,
  `expires` datetime DEFAULT NULL,
  `extra` text DEFAULT NULL,
  `force_reset` tinyint(1) NOT NULL DEFAULT 0,
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bf_auth_identities`
--

INSERT INTO `bf_auth_identities` (`id`, `user_id`, `type`, `name`, `secret`, `secret2`, `expires`, `extra`, `force_reset`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'email_password', NULL, 'admin@admin.com', '$2y$10$KUEy0AAY4/VcmlZk4GuOgeq3cuKrYRhxT/UcoEX1KNuZmGwySSXgC', NULL, NULL, 0, '2022-10-15 09:04:15', '2022-09-30 22:20:17', '2022-10-15 09:04:15'),
(2, 1, 'magic-link', NULL, '379f05eb52fab24f4778', NULL, '2022-10-01 05:46:57', NULL, 0, NULL, '2022-10-01 04:46:57', '2022-10-01 04:46:57');

-- --------------------------------------------------------

--
-- Table structure for table `bf_auth_logins`
--

CREATE TABLE `bf_auth_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `bf_auth_permissions_users`
--

CREATE TABLE `bf_auth_permissions_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `permission` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `bf_auth_remember_tokens`
--

CREATE TABLE `bf_auth_remember_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `expires` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `bf_auth_token_logins`
--

CREATE TABLE `bf_auth_token_logins` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `id_type` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `bf_captcha`
--

CREATE TABLE `bf_captcha` (
  `captcha_id` bigint(13) UNSIGNED NOT NULL,
  `captcha_time` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(50) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  `imgName` double(18,4) NOT NULL DEFAULT 0.0000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bf_ci_sessions`
--

CREATE TABLE `bf_ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bf_meta_info`
--

CREATE TABLE `bf_meta_info` (
  `id` int(11) UNSIGNED NOT NULL,
  `resource_id` int(11) UNSIGNED NOT NULL,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `bf_migrations`
--

CREATE TABLE `bf_migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bf_migrations`
--

INSERT INTO `bf_migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2020-12-28-223112', 'CodeIgniter\\Shield\\Database\\Migrations\\CreateAuthTables', 'default', 'CodeIgniter\\Shield', 1664594379, 1),
(2, '2021-07-04-041948', 'CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable', 'default', 'CodeIgniter\\Settings', 1664594379, 1),
(3, '2021-09-04-044800', 'App\\Database\\Migrations\\AdditionalUserFields', 'default', 'Bonfire\\{Users}', 1664594379, 1),
(4, '2021-10-05-040656', 'App\\Database\\Migrations\\CreateMetaTable', 'default', 'Bonfire\\{Users}', 1664594379, 1),
(5, '2021-11-14-143905', 'CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn', 'default', 'CodeIgniter\\Settings', 1664594379, 1);

-- --------------------------------------------------------

--
-- Table structure for table `bf_settings`
--

CREATE TABLE `bf_settings` (
  `id` int(9) NOT NULL,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `type` varchar(31) NOT NULL DEFAULT 'string',
  `context` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `bf_users`
--

CREATE TABLE `bf_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `last_active` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `bf_users`
--

INSERT INTO `bf_users` (`id`, `username`, `first_name`, `last_name`, `avatar`, `status`, `status_message`, `active`, `last_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', 'Administrator', 'user', NULL, NULL, NULL, 0, '2022-10-15 09:04:15', '2022-09-30 22:20:16', '2022-10-15 09:04:15', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bf_auth_groups_users`
--
ALTER TABLE `bf_auth_groups_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bf_auth_groups_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `bf_auth_identities`
--
ALTER TABLE `bf_auth_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `type_secret` (`type`,`secret`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bf_auth_logins`
--
ALTER TABLE `bf_auth_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bf_auth_permissions_users`
--
ALTER TABLE `bf_auth_permissions_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bf_auth_permissions_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `bf_auth_remember_tokens`
--
ALTER TABLE `bf_auth_remember_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `bf_auth_remember_tokens_user_id_foreign` (`user_id`);

--
-- Indexes for table `bf_auth_token_logins`
--
ALTER TABLE `bf_auth_token_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_type_identifier` (`id_type`,`identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bf_captcha`
--
ALTER TABLE `bf_captcha`
  ADD PRIMARY KEY (`captcha_id`),
  ADD KEY `word` (`word`);

--
-- Indexes for table `bf_ci_sessions`
--
ALTER TABLE `bf_ci_sessions`
  ADD PRIMARY KEY (`id`,`ip_address`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `bf_meta_info`
--
ALTER TABLE `bf_meta_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resource_id` (`resource_id`);

--
-- Indexes for table `bf_migrations`
--
ALTER TABLE `bf_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bf_settings`
--
ALTER TABLE `bf_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bf_users`
--
ALTER TABLE `bf_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bf_auth_groups_users`
--
ALTER TABLE `bf_auth_groups_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bf_auth_identities`
--
ALTER TABLE `bf_auth_identities`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bf_auth_logins`
--
ALTER TABLE `bf_auth_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bf_auth_permissions_users`
--
ALTER TABLE `bf_auth_permissions_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bf_auth_remember_tokens`
--
ALTER TABLE `bf_auth_remember_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bf_auth_token_logins`
--
ALTER TABLE `bf_auth_token_logins`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bf_captcha`
--
ALTER TABLE `bf_captcha`
  MODIFY `captcha_id` bigint(13) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `bf_meta_info`
--
ALTER TABLE `bf_meta_info`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bf_migrations`
--
ALTER TABLE `bf_migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `bf_settings`
--
ALTER TABLE `bf_settings`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bf_users`
--
ALTER TABLE `bf_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bf_auth_groups_users`
--
ALTER TABLE `bf_auth_groups_users`
  ADD CONSTRAINT `bf_auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `bf_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bf_auth_identities`
--
ALTER TABLE `bf_auth_identities`
  ADD CONSTRAINT `bf_auth_identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `bf_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bf_auth_permissions_users`
--
ALTER TABLE `bf_auth_permissions_users`
  ADD CONSTRAINT `bf_auth_permissions_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `bf_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bf_auth_remember_tokens`
--
ALTER TABLE `bf_auth_remember_tokens`
  ADD CONSTRAINT `bf_auth_remember_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `bf_users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
