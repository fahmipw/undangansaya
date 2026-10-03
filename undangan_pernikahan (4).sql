-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 03, 2026 at 05:18 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `undangan_pernikahan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$28qYNbAcAgxyhkOq8/meNes6eSRbwJTF5nakZwR0sPAKAVzBL9Jxy', '2026-07-05 20:43:44', '2026-07-05 20:43:44');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `invitation_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `invitation_id`, `image_path`, `created_at`, `updated_at`) VALUES
(21, 1, 'uploads/img_6a4f623c56d9c.jpg', '2026-07-09 01:56:28', '2026-07-09 01:56:28'),
(22, 1, 'uploads/img_6a4f625a2add1.jpg', '2026-07-09 01:56:58', '2026-07-09 01:56:58'),
(23, 1, 'uploads/img_6a4f6275dd84c.jpg', '2026-07-09 01:57:25', '2026-07-09 01:57:25'),
(26, 1, 'uploads/img_6a4f62a6eff5d.jpg', '2026-07-09 01:58:14', '2026-07-09 01:58:14'),
(29, 1, 'uploads/img_6a4f62f8ca691.jpg', '2026-07-09 01:59:36', '2026-07-09 01:59:36');

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` bigint UNSIGNED NOT NULL,
  `invitation_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `invitation_id`, `nama`, `no_hp`, `slug`) VALUES
(8, 1, 'Budi', '6288210841990', 'budi'),
(9, 1, 'Bapak ucok', '088210841990', 'bapak-ucok'),
(10, 1, 'Bapak ucok', '088210841990', 'bapak-ucok-1783415871'),
(12, 1, 'yanto', '6288210841990', 'yanto'),
(14, 1, 'ucok', '6288210841990', 'ucok'),
(17, 1, 'yanto', '6288210841990', 'yanto-1783584665'),
(18, 1, 'Ucup', '6288210841990', 'Ucup');

-- --------------------------------------------------------

--
-- Table structure for table `invitations`
--

CREATE TABLE `invitations` (
  `id` bigint UNSIGNED NOT NULL,
  `slug` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invitations`
--

INSERT INTO `invitations` (`id`, `slug`, `title`, `created_at`, `updated_at`) VALUES
(1, 'hawa-adam', 'Hawa & Adam', '2026-07-05 20:43:44', '2026-07-16 08:51:11'),
(8, 'udin', 'udin', '2026-07-07 02:33:09', '2026-07-07 02:33:09');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_07_06_034049_create_invitations_table', 1),
(6, '2026_07_06_034056_create_admins_table', 1),
(7, '2026_07_06_034103_create_settings_table', 1),
(8, '2026_07_06_034110_create_rsvps_table', 1),
(9, '2026_07_06_034118_create_ucapans_table', 1),
(10, '2026_07_06_034124_create_guests_table', 1),
(11, '2026_07_06_034131_create_galleries_table', 1),
(12, '2026_07_06_034138_create_music_table', 1),
(13, '2026_07_06_034147_create_stories_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `music`
--

CREATE TABLE `music` (
  `id` bigint UNSIGNED NOT NULL,
  `invitation_id` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rsvps`
--

CREATE TABLE `rsvps` (
  `id` bigint UNSIGNED NOT NULL,
  `invitation_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_tamu` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `status` enum('hadir','tidak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `rsvps`
--

INSERT INTO `rsvps` (`id`, `invitation_id`, `nama`, `jumlah_tamu`, `status`, `alasan`, `created_at`, `updated_at`) VALUES
(2, 1, 'Hadirr', 2, 'hadir', '', '2026-07-09 01:12:58', '2026-07-09 01:12:58'),
(3, 1, 'Yanti', 2, 'hadir', '', '2026-07-09 01:13:43', '2026-07-09 01:13:43'),
(4, 1, 'Rudi', 2, 'tidak', '', '2026-07-09 01:15:04', '2026-07-09 01:15:04'),
(5, 1, 'Yanto', 2, 'tidak', 'lembur', '2026-07-09 01:15:39', '2026-07-09 01:15:39'),
(6, 1, 'yy', 1, 'hadir', '', '2026-07-16 09:31:44', '2026-07-16 09:31:44'),
(7, 1, 'ucok', 1, 'hadir', '', '2026-07-16 09:34:26', '2026-07-16 09:34:26');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `invitation_id` bigint UNSIGNED NOT NULL,
  `key_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`invitation_id`, `key_name`, `key_value`) VALUES
(1, 'bride_child_of', ''),
(1, 'bride_name', 'Hawa Ananda'),
(1, 'bride_nickname', 'Hawa'),
(1, 'bride_parents', 'Bapak Yakub & Ibu Rahel'),
(1, 'bride_photo', 'uploads/profile_6a4f63862b95e.jpg'),
(1, 'gift_account', '1234 5678 9101'),
(1, 'gift_address', 'Jl. Pintu Satu Senayan, RT.1/RW.3, Gelora, Kecamatan Tanah Abang, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10270'),
(1, 'gift_bank', 'BANK BCA'),
(1, 'gift_bank_logo', 'uploads/bank_logo_6a4f65511ce46.png'),
(1, 'gift_maps_link', 'https://maps.app.goo.gl/prznPN8Uoum4RGd66'),
(1, 'gift_owner', 'Hawa Ananda'),
(1, 'groom_child_of', ''),
(1, 'groom_name', 'Adam Firdaus'),
(1, 'groom_nickname', 'Adam'),
(1, 'groom_parents', 'Bapak Ibrahim & Ibu Sarah'),
(1, 'groom_photo', 'uploads/profile_6a4f637e46b54.jpg'),
(1, 'music_autoplay', '1'),
(1, 'music_volume', '50'),
(1, 'reception_date', '2026-07-19'),
(1, 'reception_location', 'Jl. Pintu Satu Senayan, RT.1/RW.3, Gelora, Kecamatan Tanah Abang, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10270'),
(1, 'reception_map_link', 'https://maps.app.goo.gl/prznPN8Uoum4RGd66'),
(1, 'reception_time_end', 'Selesai'),
(1, 'reception_time_start', '11:00'),
(1, 'reception_timezone', ''),
(1, 'theme_background', '#fbf9f5'),
(1, 'theme_background_text', '#fbf9f5'),
(1, 'theme_preset', 'classic-gold'),
(1, 'theme_primary', '#361f1a'),
(1, 'theme_primary_container', '#4e342e'),
(1, 'theme_primary_container_text', '#4e342e'),
(1, 'theme_primary_text', '#361f1a'),
(1, 'theme_secondary', '#775a19'),
(1, 'theme_secondary_container', '#fed488'),
(1, 'theme_secondary_container_text', '#fed488'),
(1, 'theme_secondary_text', '#775a19'),
(1, 'theme_surface_container_low', '#f5f3ef'),
(1, 'theme_surface_container_low_text', '#f5f3ef'),
(1, 'wa_template', ''),
(1, 'wedding_date', '2026-07-19'),
(1, 'wedding_location', 'Kediaman Mempelai Wanita'),
(1, 'wedding_map_link', 'https://maps.app.goo.gl/prznPN8Uoum4RGd66'),
(1, 'wedding_time_end', '10:00'),
(1, 'wedding_time_start', '08:00'),
(1, 'wedding_timezone', '');

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` bigint UNSIGNED NOT NULL,
  `invitation_id` bigint UNSIGNED NOT NULL,
  `tahun` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `judul` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `invitation_id`, `tahun`, `judul`, `isi`, `created_at`, `updated_at`) VALUES
(1, 1, '2025', 'Pertemuan Pertama', 'Kami bermula dari sebuah DM sederhana di Instagram. Pesan singkat yang tak disangka menjadi awal perjalanan dua hati yang saling menemukan. Dari obrolan ringan setiap hari, kami belajar saling mengenal, memahami, hingga tumbuh rasa nyaman yang perlahan berubah menjadi cinta', '2026-07-05 20:43:44', '2026-07-05 20:43:44'),
(2, 1, '2026', 'Janji Suci', 'Mengukir janji untuk saling mendukung dalam suka dan duka, melangkah bersama menuju masa depan yang cerah.', '2026-07-05 20:43:44', '2026-07-05 20:43:44'),
(3, 1, 'diamond', 'Hari Kemenangan', 'Menyatukan dua keluarga besar dalam ikatan suci pernikahan yang langgeng, selamanya.', '2026-07-05 20:43:44', '2026-07-05 20:43:44');

-- --------------------------------------------------------

--
-- Table structure for table `ucapans`
--

CREATE TABLE `ucapans` (
  `id` bigint UNSIGNED NOT NULL,
  `invitation_id` bigint UNSIGNED NOT NULL,
  `nama` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ucapans`
--

INSERT INTO `ucapans` (`id`, `invitation_id`, `nama`, `pesan`, `created_at`, `updated_at`) VALUES
(3, 1, 'Wulandari', 'Happy Wedding Adam dan Hawa...Lancar yaa sampai hari H', '2026-07-09 00:55:11', '2026-07-16 08:40:39'),
(4, 1, 'Aisyah', 'Semoga lancar sampai hari H', '2026-07-09 01:42:43', '2026-07-16 08:39:42'),
(5, 1, 'Fahmi', 'Semoga samawa...', '2026-07-16 08:54:08', '2026-07-16 08:54:08'),
(8, 1, 'Rizky Ali', 'Selamat menempuh hidup baru. Semoga cinta dan kebahagiaan selalu menyertai kalian', '2026-07-16 09:03:54', '2026-07-16 09:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_invitation_id_foreign` (`invitation_id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guests_invitation_id_foreign` (`invitation_id`);

--
-- Indexes for table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invitations_slug_unique` (`slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`id`),
  ADD KEY `music_invitation_id_foreign` (`invitation_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rsvps`
--
ALTER TABLE `rsvps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rsvps_invitation_id_foreign` (`invitation_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`invitation_id`,`key_name`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stories_invitation_id_foreign` (`invitation_id`);

--
-- Indexes for table `ucapans`
--
ALTER TABLE `ucapans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ucapans_invitation_id_foreign` (`invitation_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `music`
--
ALTER TABLE `music`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rsvps`
--
ALTER TABLE `rsvps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ucapans`
--
ALTER TABLE `ucapans`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_invitation_id_foreign` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guests`
--
ALTER TABLE `guests`
  ADD CONSTRAINT `guests_invitation_id_foreign` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `music`
--
ALTER TABLE `music`
  ADD CONSTRAINT `music_invitation_id_foreign` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rsvps`
--
ALTER TABLE `rsvps`
  ADD CONSTRAINT `rsvps_invitation_id_foreign` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `settings_invitation_id_foreign` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stories`
--
ALTER TABLE `stories`
  ADD CONSTRAINT `stories_invitation_id_foreign` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ucapans`
--
ALTER TABLE `ucapans`
  ADD CONSTRAINT `ucapans_invitation_id_foreign` FOREIGN KEY (`invitation_id`) REFERENCES `invitations` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
