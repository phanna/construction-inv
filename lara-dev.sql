-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2017 at 03:18 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lara-dev`
--
CREATE DATABASE IF NOT EXISTS `lara-dev` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `lara-dev`;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2017_04_07_071756_create_tbl_sale_invs_table', 1),
('2017_04_07_074020_create_tbl_sale_details_table', 1),
('2017_04_07_075549_create_tbl_companies_table', 1),
('2017_04_10_085456_create_tbl_sub_menuses_table', 2),
('2017_04_10_093123_create_tbl_menuses_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_companies`
--

DROP TABLE IF EXISTS `tbl_companies`;
CREATE TABLE `tbl_companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_task` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_companies`
--

INSERT INTO `tbl_companies` (`id`, `name`, `address`, `number`, `company_task`, `created_at`, `updated_at`) VALUES
(1, 'mwgroup', 'Psa chas', '0123654789', 'dd', '2017-04-07 02:42:16', '2017-04-07 02:42:16'),
(2, 'mwgroup', 'pp', '0123654789', 'hello', '2017-04-07 03:13:37', '2017-04-07 03:13:37'),
(3, 'mwgroup', 'pp', '0123654789', 'hello', '2017-04-07 03:14:02', '2017-04-07 03:14:02'),
(4, '   MingWuoy Group', '   90Eo', '   012365478', '   Businesss group', '2017-04-07 03:14:23', '2017-04-07 03:14:23'),
(5, 'fff', 'fff', 'fff', 'fff', '2017-04-07 03:31:05', '2017-04-07 03:31:05'),
(6, '', '', '', '', '2017-04-07 18:25:04', '2017-04-07 18:25:04'),
(7, '', '', '', '', '2017-04-07 19:07:20', '2017-04-07 19:07:20'),
(8, '', '', '', '', '2017-04-07 19:07:53', '2017-04-07 19:07:53'),
(9, '', '', '', '', '2017-04-07 19:08:38', '2017-04-07 19:08:38'),
(10, '', '', '', '', '2017-04-07 19:18:30', '2017-04-07 19:18:30'),
(11, '', '', '', '', '2017-04-07 19:18:37', '2017-04-07 19:18:37'),
(12, '', '', '', '', '2017-04-07 19:21:28', '2017-04-07 19:21:28'),
(13, '', '', '', '', '2017-04-07 19:22:02', '2017-04-07 19:22:02'),
(14, '', '', '', '', '2017-04-07 19:23:15', '2017-04-07 19:23:15'),
(15, '', '', '', '', '2017-04-07 19:23:44', '2017-04-07 19:23:44'),
(16, '', '', '', '', '2017-04-07 19:23:54', '2017-04-07 19:23:54'),
(17, '', '', '', '', '2017-04-07 19:24:01', '2017-04-07 19:24:01'),
(18, '', '', '', '', '2017-04-07 19:24:27', '2017-04-07 19:24:27'),
(19, '', '', '', '', '2017-04-07 19:24:42', '2017-04-07 19:24:42'),
(20, '', '', '', '', '2017-04-07 19:24:48', '2017-04-07 19:24:48'),
(21, 'qq', 'qq', '123456789', 'qqq', '2017-04-07 19:49:11', '2017-04-07 19:49:11'),
(22, 'qq', 'qq', '123456789', 'qqq', '2017-04-07 19:50:02', '2017-04-07 19:50:02'),
(23, 'Web development', 'Phnom Penh', '0123654789', 'Develop website and system.', '2017-04-10 18:17:33', '2017-04-10 18:17:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menus`
--

DROP TABLE IF EXISTS `tbl_menus`;
CREATE TABLE `tbl_menus` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `actived` tinyint(4) NOT NULL COMMENT '0:enable 1 disable'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_menus`
--

INSERT INTO `tbl_menus` (`id`, `name`, `icon`, `link`, `actived`) VALUES
(1, 'Dashboard', '', '', 0),
(2, 'Accounts', '', '', 0),
(3, 'Reports', '', '', 0),
(4, 'Contacts', '', '', 0),
(5, 'Setting', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menuses`
--

DROP TABLE IF EXISTS `tbl_menuses`;
CREATE TABLE `tbl_menuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_menuses`
--

INSERT INTO `tbl_menuses` (`id`, `name`, `icon`, `link`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', '', '', NULL, NULL),
(2, 'Accounts', '', '', NULL, NULL),
(3, 'Reports', '', '', NULL, NULL),
(4, 'Contacts', '', '', NULL, NULL),
(5, 'Setting', '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale_details`
--

DROP TABLE IF EXISTS `tbl_sale_details`;
CREATE TABLE `tbl_sale_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_inv_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `qty` double(8,2) NOT NULL,
  `unit_price` double(8,2) NOT NULL,
  `discount` double(8,2) NOT NULL,
  `sub_total` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sale_invs`
--

DROP TABLE IF EXISTS `tbl_sale_invs`;
CREATE TABLE `tbl_sale_invs` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `toDate` datetime NOT NULL,
  `dueDate` datetime NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reference` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sub_menuses`
--

DROP TABLE IF EXISTS `tbl_sub_menuses`;
CREATE TABLE `tbl_sub_menuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_id` int(11) NOT NULL,
  `sub_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_sub_menuses`
--

INSERT INTO `tbl_sub_menuses` (`id`, `menu_id`, `sub_name`, `created_at`, `updated_at`) VALUES
(1, 2, 'Sales', NULL, NULL),
(2, 2, 'Purchases', NULL, NULL),
(3, 2, 'Inventory', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `company_id`, `role_id`, `status`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 4, 0, 0, 'phanna', 't.phanna@hotmail.com', '$2y$10$2d7XirqzvHrNn.XrCjY2WeE3RqJanEsTFlDRtBcQ2b40t1DaEaW5y', 'eTXsuHqbQDSiyAg0ar4LjzXKsK8dHbtO83WSgK0td9huSvWyTGKKBzSez0sm', '2017-04-07 01:59:09', '2017-04-09 21:40:08'),
(2, 23, 0, 0, 'phalla', 'phalla@gmail.com', '$2y$10$lwICr2DBcgZD2xC37ZUCfOW0sEP1wB8uq56F42HL8NyB8FuWwYVtK', 'dGYEP5LqPEEEWSJRygyfI0JIin6p4mZ37H9lPcjyknsiENP9rMDVK4fo12Ff', '2017-04-07 03:19:30', '2017-04-07 03:21:30'),
(3, 0, 0, 0, 'kolboth', 'k@gmail.com', '$2y$10$9F9bnspYKUr7fsN0MZqUKuU/4M5/S5AzvUKV0i1yOAtfAcvEYHJ9.', NULL, '2017-04-07 03:21:47', '2017-04-07 03:21:47'),
(4, 5, 1, 0, 'kolboth', 'k1@gmail.com', '$2y$10$ihLwMY7be7Znu5LO/1YYt.mMAdYPUhefErlEPfl1srbrxp3HNvT1y', 'KJQtjP6ip5gKzdXmkXp7CzOqCa7NVs18VQa2P2RYA41uyTswiRNFlcGXKRZ8', '2017-04-07 03:30:52', '2017-04-07 03:32:14'),
(5, 6, 1, 0, 'hh', 'h@gmail.com', '$2y$10$YxFB9ygyjAFRPmH3r2LrLeO778PVwRGFUC2R2VK2O9GVHeSRxUpJW', 'dEzhFlSvwAkfpUA9Z1T9kZuHlgkVd1osD80mdXtQPZ1KF8izTqbZPHRjV4tv', '2017-04-07 03:32:31', '2017-04-07 19:05:44'),
(6, 22, 1, 0, 'phalla', 'phalla1@gmail.com', '$2y$10$7K8/F13Dz/G4DOxVJYKME.uut1xsf5WUnWTzxT77D9FsNk3K8ZvP6', 'd3vlmdHzjyKfMYpDrPwd90ajbQA05ZB6pm88vWxYgTGit1HEPdCqXiSf8WiK', '2017-04-07 19:07:10', '2017-04-07 20:46:17'),
(7, 0, 1, 0, 'hh', 'h1@gmail.com', '$2y$10$HSEWjcB7nNhGegP0tryrbOaj3S1Psev/hiJB1W.FTfZvp3Ob735yS', 'VgjLdic6y1IxLEkzEmb3LdzhP4VaiqFCYkiuLDXhPJrKVc9Tq9C4s3KVzeJf', '2017-04-07 20:47:22', '2017-04-07 21:58:26'),
(8, 0, 1, 0, 'dara', 'dara@abc.com', '$2y$10$Z2apAKOV2AhY4YAnqz.0MeyGrFTvlkWA4nQftm4ayRb.w3dPruE.u', '41KNJtfRpcvaBhxqANvw8E2sD60WDWs0aBgzaFKgwoP65xF5cG00Q9bWxJFv', '2017-04-09 20:57:07', '2017-04-10 00:51:01'),
(9, 0, 1, 0, 'abcd', 'abcd@abc.com', '$2y$10$9CZY/5S0IJ42/u1lweWwie8kmvgqBS3v5mG0MgW74yXPkvUqfa3kS', '55HNQCcgquvuxaBbCD0i6phTYcWLE2ioX1JZdxvtkt16zTyJJwdwEc3ziPdS', '2017-04-09 21:15:49', '2017-04-09 21:18:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menuses`
--
ALTER TABLE `tbl_menuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sale_details`
--
ALTER TABLE `tbl_sale_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sale_invs`
--
ALTER TABLE `tbl_sale_invs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sub_menuses`
--
ALTER TABLE `tbl_sub_menuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_companies`
--
ALTER TABLE `tbl_companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_menuses`
--
ALTER TABLE `tbl_menuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tbl_sale_details`
--
ALTER TABLE `tbl_sale_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_sale_invs`
--
ALTER TABLE `tbl_sale_invs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_sub_menuses`
--
ALTER TABLE `tbl_sub_menuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
