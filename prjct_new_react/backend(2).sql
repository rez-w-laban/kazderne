-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2024 at 06:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `backend`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `bookmarks_count` bigint(20) UNSIGNED NOT NULL,
  `likes_count` bigint(20) UNSIGNED NOT NULL,
  `comments_count` bigint(20) UNSIGNED NOT NULL,
  `rate_count` bigint(20) UNSIGNED NOT NULL,
  `rate_sum` bigint(20) UNSIGNED NOT NULL,
  `average_rate` double NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `activity_type_id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `activity_name`, `description`, `picture`, `bookmarks_count`, `likes_count`, `comments_count`, `rate_count`, `rate_sum`, `average_rate`, `location`, `activity_type_id`, `city_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'ĒL Boutique Hotel', 'A beautifully located hotel, across the street from the beach within a walking distance from everything you want to see.', 'media_6685b1f0eb469.png', 0, 2, 0, 1, 5, 5, NULL, 2, 2, 1, '2024-07-03 17:17:52', '2024-07-04 05:51:54'),
(3, 'Al Fanar Restaurant', 'A beautifully located restaurant across the street from the beach within a walking distance from everything you want to see.', 'media_6685bf8d4671e.png', 1, 0, 0, 0, 0, 0, NULL, 1, 2, 1, '2024-07-03 18:15:57', '2024-07-03 18:15:57'),
(4, 'enjoying life at Tyre', 'My family and i went to tyre beach and had alot fun. It is truly one of the best.', 'media_668d549f00df3.jpg', 0, 4, 4, 0, 0, 0, NULL, 12, 2, 5, '2024-07-09 12:17:50', '2024-07-09 12:17:51');

-- --------------------------------------------------------

--
-- Table structure for table `activity_pictures`
--

CREATE TABLE `activity_pictures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `media` varchar(255) NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_pictures`
--

INSERT INTO `activity_pictures` (`id`, `media`, `activity_id`, `created_at`, `updated_at`) VALUES
(1, 'media_6685b211c50ba.png', 1, '2024-07-03 17:18:25', '2024-07-03 17:18:25'),
(2, 'media_6685b21607dc3.png', 1, '2024-07-03 17:18:30', '2024-07-03 17:18:30'),
(3, 'media_6685b2190f4c2.png', 1, '2024-07-03 17:18:33', '2024-07-03 17:18:33'),
(4, 'media_6685b21cc67e2.png', 1, '2024-07-03 17:18:36', '2024-07-03 17:18:36'),
(5, 'media_6685bfa357679.png', 3, '2024-07-03 18:16:19', '2024-07-03 18:16:19'),
(6, 'media_6685bfa76afc2.png', 3, '2024-07-03 18:16:23', '2024-07-03 18:16:23'),
(7, 'media_6685bfad77d45.png', 3, '2024-07-03 18:16:29', '2024-07-03 18:16:29'),
(8, 'media_6685bfb0a8104.png', 3, '2024-07-03 18:16:32', '2024-07-03 18:16:32'),
(9, 'media_668d56fe0f21d.jpg', 4, '2024-07-09 12:27:58', '2024-07-09 12:27:58'),
(10, 'media_668d57045f889.jpg', 4, '2024-07-09 12:28:04', '2024-07-09 12:28:04'),
(11, 'media_668d570f57f80.jpg', 4, '2024-07-09 12:28:15', '2024-07-09 12:28:15'),
(12, 'media_668d571b763f5.jpg', 4, '2024-07-09 12:28:27', '2024-07-09 12:28:27'),
(13, 'media_668d5720de69a.jpg', 4, '2024-07-09 12:28:32', '2024-07-09 12:28:32');

-- --------------------------------------------------------

--
-- Table structure for table `activity_types`
--

CREATE TABLE `activity_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_types`
--

INSERT INTO `activity_types` (`id`, `name`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'restaurant', 'media_6685af879130a.png', '2024-07-03 17:07:35', '2024-07-03 17:07:35'),
(2, 'hotels', 'media_6685afccca5d0.png', '2024-07-03 17:08:44', '2024-07-03 17:08:44'),
(3, 'Nature', 'media_668658bfb4e26.jpg', '2024-07-04 05:09:35', '2024-07-04 05:09:35'),
(4, 'festivals', 'media_668658e0aece4.jpg', '2024-07-04 05:10:08', '2024-07-04 05:10:08'),
(5, 'Malls', 'media_6686591eee329.jpg', '2024-07-04 05:11:10', '2024-07-04 05:11:10'),
(6, 'Sports', 'media_6686595273a20.png', '2024-07-04 05:12:02', '2024-07-04 05:12:02'),
(7, 'Landmarks', 'media_6686596e27c22.png', '2024-07-04 05:12:30', '2024-07-04 05:12:30'),
(8, 'Museums', 'media_668659929c1a7.png', '2024-07-04 05:13:06', '2024-07-04 05:13:06'),
(9, 'Others', 'media_668659ebcc356.png', '2024-07-04 05:14:35', '2024-07-04 05:14:35'),
(10, 'parks', 'media_668d499170af8.jpg', '2024-07-09 11:30:41', '2024-07-09 11:30:41'),
(11, 'Tourist Attractions', 'media_668d4aa77a088.jpg', '2024-07-09 11:35:19', '2024-07-09 11:35:19'),
(12, 'Beaches', 'media_668d4b32ce467.jpg', '2024-07-09 11:37:38', '2024-07-09 11:37:38');

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookmarks`
--

INSERT INTO `bookmarks` (`id`, `activity_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `isdeleted_receiver` tinyint(1) NOT NULL,
  `isdeleted_sender` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`, `description`, `picture`, `created_at`, `updated_at`) VALUES
(1, 'Baalbek', 'Baalbek is a city located east of the Litani River in Lebanon\'s Beqaa Valley, about 67 km (42 mi) northeast of Beirut.', 'picture_6685b00c7c71c.jpg', '2024-07-03 17:09:48', '2024-07-03 17:09:48'),
(2, 'tyre', 'Today, Tyre is the fourth largest city in Lebanon after Beirut, Tripoli, and Sidon. ... It is the capital of the Tyre District in the South Governorate.', 'picture_6685b1750aaf1.jpg', '2024-07-03 17:13:37', '2024-07-03 17:15:49'),
(3, 'Beirut', NULL, 'picture_6686583a71c8b.jpg', '2024-07-04 05:07:22', '2024-07-04 05:07:22');

-- --------------------------------------------------------

--
-- Table structure for table `city_pictures`
--

CREATE TABLE `city_pictures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `media` varchar(255) DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `city_pictures`
--

INSERT INTO `city_pictures` (`id`, `media`, `city_id`, `created_at`, `updated_at`) VALUES
(2, 'media_6685b04e2d895.jpg', 1, '2024-07-03 17:10:54', '2024-07-03 17:10:54'),
(4, 'media_6685b051cfb15.jpg', 1, '2024-07-03 17:10:57', '2024-07-03 17:10:57'),
(9, 'media_6685b1380270e.jpg', 2, '2024-07-03 17:14:48', '2024-07-03 17:14:48'),
(10, 'media_6685b1620c6ce.jpg', 2, '2024-07-03 17:15:30', '2024-07-03 17:15:30');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(255) NOT NULL,
  `activity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_reply` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `activity_id`, `user_id`, `comment_id`, `is_reply`, `created_at`, `updated_at`) VALUES
(12, 'looks nice', 4, 1, NULL, 0, NULL, NULL),
(15, 'I think there is a war going on right there !!!!', 4, 4, NULL, 0, NULL, NULL),
(16, 'wooww ,really beautifull', 4, 3, NULL, 0, NULL, NULL),
(17, 'forget about tyre this app is so coool', 4, 2, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `followings`
--

CREATE TABLE `followings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `follower_id` bigint(20) UNSIGNED NOT NULL,
  `followed_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `activity_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 3, NULL, NULL),
(3, 4, 1, NULL, NULL),
(4, 4, 3, NULL, NULL),
(5, 4, 5, NULL, NULL),
(6, 4, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notification` varchar(255) NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification`, `sender_id`, `receiver_id`, `activity_id`, `created_at`, `updated_at`) VALUES
(1, 'commented on your activity', 1, 1, 1, '2024-07-03 19:38:12', '2024-07-03 19:38:12'),
(2, 'commented on your activity', 1, 1, 1, '2024-07-03 19:38:12', '2024-07-03 19:38:12'),
(3, 'commented on your activity', 1, 1, 1, '2024-07-03 19:38:13', '2024-07-03 19:38:13'),
(4, 'commented on your activity', 1, 1, 1, '2024-07-03 19:38:13', '2024-07-03 19:38:13'),
(5, 'commented on your activity', 1, 1, 1, '2024-07-03 19:38:14', '2024-07-03 19:38:14'),
(6, 'commented on your activity', 1, 1, 1, '2024-07-03 19:38:14', '2024-07-03 19:38:14'),
(7, 'commented on your activity', 1, 1, 1, '2024-07-03 19:38:15', '2024-07-03 19:38:15'),
(8, 'commented on your activity', 1, 1, 1, '2024-07-03 19:38:15', '2024-07-03 19:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `rating` bigint(20) UNSIGNED NOT NULL,
  `content` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`id`, `rating`, `content`, `user_id`, `activity_id`, `created_at`, `updated_at`) VALUES
(17, 4, 'niceee', 1, 1, '2024-07-04 05:07:46', '2024-07-04 05:07:46');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`) VALUES
(0, 'sadmin', NULL, NULL),
(1, 'admin', NULL, NULL),
(2, 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `profile_picture`, `role_id`, `remember_token`, `created_at`, `updated_at`, `bio`) VALUES
(1, 'brince', 'brince@acc', NULL, '$2y$10$Ltc1k363tugNhK3gnD2GDuJ5y5wEIEhXy6uo/p/MAKx1aA1tw7vq6', NULL, 0, NULL, '2024-07-03 17:03:54', '2024-07-03 17:03:54', 'owner of boutique and fanar hotels'),
(2, 'messi', 'messi@acc', NULL, '$2y$10$30nMVlAoJDfuA4VrW95QmuoanhL2PFjga1QYJaYaIA3HhuZJq9yVi', 'media_6685aef6e84ac.png', 0, NULL, '2024-07-03 17:05:10', '2024-07-05 14:37:31', NULL),
(3, 'fofo', 'fofo@acc', NULL, '$2y$10$EkF7MYeuMu9OqEb9S0sXaujOpyap2jy8LHpDphoR4dNShlIfnixTi', 'media_6685af1d37503.png', 2, NULL, '2024-07-03 17:05:49', '2024-07-09 11:31:15', NULL),
(4, 'traveler', 'traveler@acc', NULL, '$2y$10$3iQ8ymWOLpKaJ8y9nDo8fezTNeeCnRRdgKFywigk7uKmlVzKB4xe2', NULL, 2, NULL, '2024-07-09 11:50:03', '2024-07-09 11:50:03', NULL),
(5, 'joshua knight', 'joshua@acc', NULL, '$2y$10$N7WteJ2.kI8D4rczPJ4muek5D4mEt2onScYxTPEXDEDDUSD.i3oOe', 'media_668d52d2985dd.png', 2, NULL, '2024-07-09 12:07:30', '2024-07-09 13:03:59', 'Amazed by Lebanon'),
(6, 'test', 'test@acc', NULL, '$2y$10$OCegJAov1Cr7Y1g8faiEKuRmKxx/JetcvMGe6/DntK00fYpSckA3G', NULL, 2, NULL, '2024-07-09 13:04:49', '2024-07-09 13:04:49', NULL),
(7, 'test', 'acc@acc', NULL, '$2y$10$lVg7F.OydfntcwzqMT1vHOK.FIXHa23WuZzeg6c487BsGYbuwo8ui', NULL, 2, NULL, '2024-07-09 13:04:57', '2024-07-09 13:04:57', NULL),
(8, 'test', 'acc1@acc', NULL, '$2y$10$TxXFQbqSL4AJCOMahTVvQ.p8RnwNDAANGvxmhvTrbu1hJKFY218iS', NULL, 2, NULL, '2024-07-09 13:05:02', '2024-07-09 13:05:02', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activities_activity_type_id_foreign` (`activity_type_id`),
  ADD KEY `activities_city_id_foreign` (`city_id`),
  ADD KEY `activities_user_id_foreign` (`user_id`);

--
-- Indexes for table `activity_pictures`
--
ALTER TABLE `activity_pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_pictures_activity_id_foreign` (`activity_id`);

--
-- Indexes for table `activity_types`
--
ALTER TABLE `activity_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookmarks_activity_id_foreign` (`activity_id`),
  ADD KEY `bookmarks_user_id_foreign` (`user_id`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chats_sender_id_foreign` (`sender_id`),
  ADD KEY `chats_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `city_pictures`
--
ALTER TABLE `city_pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_pictures_city_id_foreign` (`city_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_comment_id_foreign` (`comment_id`),
  ADD KEY `comments_activity_id_foreign` (`activity_id`),
  ADD KEY `comments_user_id_foreign` (`user_id`);

--
-- Indexes for table `followings`
--
ALTER TABLE `followings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `followings_follower_id_foreign` (`follower_id`),
  ADD KEY `followings_followed_id_foreign` (`followed_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `likes_activity_id_foreign` (`activity_id`),
  ADD KEY `likes_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_sender_id_foreign` (`sender_id`),
  ADD KEY `notifications_receiver_id_foreign` (`receiver_id`),
  ADD KEY `notifications_activity_id_foreign` (`activity_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ratings_activity_id_foreign` (`activity_id`),
  ADD KEY `ratings_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `activity_pictures`
--
ALTER TABLE `activity_pictures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `activity_types`
--
ALTER TABLE `activity_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `city_pictures`
--
ALTER TABLE `city_pictures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `followings`
--
ALTER TABLE `followings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_activity_type_id_foreign` FOREIGN KEY (`activity_type_id`) REFERENCES `activity_types` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activities_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `activity_pictures`
--
ALTER TABLE `activity_pictures`
  ADD CONSTRAINT `activity_pictures_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chats_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `city_pictures`
--
ALTER TABLE `city_pictures`
  ADD CONSTRAINT `city_pictures_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `followings`
--
ALTER TABLE `followings`
  ADD CONSTRAINT `followings_followed_id_foreign` FOREIGN KEY (`followed_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `followings_follower_id_foreign` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_activity_id_foreign` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
