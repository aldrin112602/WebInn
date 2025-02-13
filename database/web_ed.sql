-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 02:07 PM
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
-- Database: `web_inn`
--

-- --------------------------------------------------------

--
-- Table structure for table `absents`
--

CREATE TABLE `absents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `grade_handle_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `extension_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'Admin',
  `profile` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`id`, `id_number`, `name`, `gender`, `username`, `password`, `extension_name`, `email`, `position`, `role`, `profile`, `address`, `phone_number`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '4226621527', 'Trever Huel', 'Male', 'wuckert.finn', '$2y$12$b7cc1mJLe04x1Oh0qMsfuuqxBG.9Ad0PUUEyZl93Z2a2/Jw9vv28W', NULL, 'xrobel@example.net', NULL, 'Admin', NULL, '32050 Jamar Valleys\nEast Lydia, OK 86230', '09555978623', NULL, NULL, '2024-11-30 01:12:53', '2024-11-30 01:12:53'),
(2, '9169321180', 'Torey Rath', 'Female', 'orie68', '$2y$12$glELvb92rblKMo7gp8f38uuC4ktsmjLRrMII9kYV3Q6YnQ.K7vMH6', NULL, 'leilani04@example.com', NULL, 'Admin', NULL, '380 Keebler Flat\nLake Tracy, SC 17024', '09095906910', NULL, NULL, '2024-11-30 01:12:54', '2024-11-30 01:12:54'),
(3, '4849556166', 'Dr. Kennedy Hoppe', 'Female', 'balistreri.jadon', '$2y$12$9agoH.Illk/MtWtYOi3UleAQr/Gm9.ADhdvBwteWbPz.BRXCWBAZm', NULL, 'orlo33@example.org', NULL, 'Admin', NULL, '760 Abagail Glens Apt. 418\nWest Tanner, AL 62104', '09797153562', NULL, NULL, '2024-11-30 01:12:56', '2024-11-30 01:12:56'),
(4, '6964769483', 'Lilyan Schuppe', 'Female', 'morissette.sebastian', '$2y$12$VpV7mH7nusIWEevj3L57h..ticlWeR0iYTl0a5mXKvzvV6OjhVA3.', NULL, 'xleffler@example.org', NULL, 'Admin', NULL, '918 Maud Bridge\nBlanchemouth, MA 25185-5399', '09171305682', NULL, NULL, '2024-11-30 01:12:57', '2024-11-30 01:12:57'),
(5, '9216078204', 'Josh Powlowski DVM', 'Female', 'kristofer.greenholt', '$2y$12$BfWh11pSLTKVtDGz8dFKXOP5FhWAiEHlmsZEtKwBFcQL0SdVnVzn.', NULL, 'ahmad59@example.net', NULL, 'Admin', NULL, '718 Boyer Alley\nWisokystad, VA 53894-9451', '09467958420', NULL, NULL, '2024-11-30 01:12:59', '2024-11-30 01:12:59'),
(6, '0146336994', 'Dr. Linwood O\'Kon Sr.', 'Male', 'leo.koepp', '$2y$12$pFhi27a6FB7QLVxozQUOYuB9Vp15ELDC.E.QyXv/8hU87zVz506wa', NULL, 'norris59@example.com', NULL, 'Admin', NULL, '3162 Macejkovic Springs\nVeronicaton, WI 83150-1723', '09801993006', NULL, NULL, '2024-11-30 01:13:01', '2024-11-30 01:13:01'),
(7, '7490453710', 'Rosemarie Spencer PhD', 'Male', 'prohaska.jevon', '$2y$12$IBXDzxwQ5exh6EGMVBsRReJHK.WOMAdLcve5CXi1.c1YGiSX/dAPK', NULL, 'pquitzon@example.org', NULL, 'Admin', NULL, '4098 Harris Circles\nNorth Martamouth, NV 47181', '09284058327', NULL, NULL, '2024-11-30 01:13:03', '2024-11-30 01:13:03'),
(8, '4413334987', 'Toney Robel', 'Female', 'robbie83', '$2y$12$MQPnT8x3MnaBXbYROojczOkprGMcmSfACmlHnUh925vVYYRPpivO2', NULL, 'graciela51@example.org', NULL, 'Admin', NULL, '9015 Trace Parks\nSchaeferfurt, ME 64756-5661', '09524940626', NULL, NULL, '2024-11-30 01:13:05', '2024-11-30 01:13:05'),
(9, '0771377731', 'Nikki Corkery', 'Female', 'macejkovic.ladarius', '$2y$12$.XQVj5qqgf14axconVZ8JOqBLl/qVS7E3NeKXHGl/R9m4TYob3wo6', NULL, 'gmohr@example.com', NULL, 'Admin', NULL, '67561 Vincenzo Turnpike Apt. 361\nSouth Stefan, IL 59081', '09815225683', NULL, NULL, '2024-11-30 01:13:06', '2024-11-30 01:13:06'),
(10, '5915445754', 'Antonina Bailey', 'Female', 'cassie52', '$2y$12$VOd3RiN.EmUhTqr2vBxG6.riqfWPASZWkVlWK42sU.KsJ3AVK7HBu', NULL, 'areilly@example.net', NULL, 'Admin', NULL, '37975 Keeling Isle Apt. 238\nNorth Graciestad, AR 10267-8596', '09109214777', NULL, NULL, '2024-11-30 01:13:07', '2024-11-30 01:13:07'),
(11, '7948325017', 'Mr. Osbaldo Padberg', 'Male', 'femard', '$2y$12$E.Nimzfgiayr8yhydEVP7OfcJiPVm9ThQtH0gSvQKds9FV4U5bGbq', NULL, 'eloy.armstrong@example.org', NULL, 'Admin', NULL, '70761 Juvenal Square\nAlanview, OK 94824', '09463073495', NULL, NULL, '2024-11-30 01:13:09', '2024-11-30 01:13:09'),
(12, '5974524825', 'Arnulfo Thompson', 'Male', 'jordane.grimes', '$2y$12$jo9dHpteSVZ5iqYvH75C1.jGoENfj29saCCWsGF99FoSpDdENW4sS', NULL, 'hdare@example.com', NULL, 'Admin', NULL, '724 Hamill Skyway Suite 851\nEast Bernhard, OH 99457', '09490343518', NULL, NULL, '2024-11-30 01:13:11', '2024-11-30 01:13:11'),
(13, '3062148957', 'Andre Cassin', 'Male', 'alfonso.mitchell', '$2y$12$xs9lPX0mECQllJKtvOril.ge5xo2MolIQcYx2HKjJFc.PXiKNIN5W', NULL, 'bartoletti.deja@example.org', NULL, 'Admin', NULL, '241 Ella Islands Apt. 232\nLake Oren, DE 78269', '09441821778', NULL, NULL, '2024-11-30 01:13:12', '2024-11-30 01:13:12'),
(14, '0358025148', 'Jared Quitzon', 'Female', 'irving.haag', '$2y$12$gZjjWkeLG02hitQ/PEkAPu6kU.rs4mTQ3v.ZsPJaLW.Jx60XaVzYm', NULL, 'uschimmel@example.com', NULL, 'Admin', NULL, '9985 Wilkinson Underpass\nGabriellebury, MA 17418', '09420250829', NULL, NULL, '2024-11-30 01:13:14', '2024-11-30 01:13:14'),
(15, '2446942291', 'Mr. Elbert Cronin', 'Male', 'halie25', '$2y$12$HQZ2N7ty3HnkxBVtKZNbTuQSH5vZnGNv.QMrh0Vf6G1LYuseF5bz6', NULL, 'kristy.effertz@example.net', NULL, 'Admin', NULL, '308 Rossie Forest Suite 755\nWeberfurt, CT 19947', '09329247992', NULL, NULL, '2024-11-30 01:13:15', '2024-11-30 01:13:15'),
(16, '1044858017', 'Zachary Hammes', 'Female', 'electa29', '$2y$12$qvIXBbj2iBPGnc0O6lyJr.rx4kBXdJxnZqQksAF8PtDfOauID.pHy', NULL, 'aberge@example.org', NULL, 'Admin', NULL, '7639 Ignacio Ramp\nBrownchester, GA 20765-7718', '09675587438', NULL, NULL, '2024-11-30 01:13:17', '2024-11-30 01:13:17'),
(17, '8355408515', 'Emmy Littel', 'Female', 'mmorar', '$2y$12$4nWMptFeAwvh2qX8i39Ng.h953CHPgC5YCFEEsyF8BKt4fVLQ9YfG', NULL, 'mlockman@example.com', NULL, 'Admin', NULL, '958 Balistreri Drive\nSouth Ramonaberg, UT 20435-5604', '09314577303', NULL, NULL, '2024-11-30 01:13:18', '2024-11-30 01:13:18'),
(18, '0709996255', 'Miss Madaline Jerde I', 'Female', 'bradford42', '$2y$12$qpcTxpqRSPv8sDWSux99PuBQwn/S1oGGkoQUkEsL0tMSL/9n.tp72', NULL, 'flind@example.org', NULL, 'Admin', NULL, '580 Aliyah Walk\nPort Salvador, IL 55295', '09397764955', NULL, NULL, '2024-11-30 01:13:19', '2024-11-30 01:13:19'),
(19, '8690499083', 'Willa Daniel', 'Male', 'hgibson', '$2y$12$QRWMIgzMMqTvTUz6ymWRxexXTXG4BxFuK/6EJDfA..bFMnjUJZlQG', NULL, 'fgreen@example.org', NULL, 'Admin', NULL, '85056 Ramona Summit Suite 211\nEast Douglas, OH 60059-8122', '09803007326', NULL, NULL, '2024-11-30 01:13:21', '2024-11-30 01:13:21'),
(20, '8155296400', 'Prof. Brendan Johnson V', 'Female', 'jamar.abshire', '$2y$12$6mkWCKCDjROGzC9qC8i50uDUp5vpYn7mMl6j6sEv013Bwafksh2pG', NULL, 'harvey.juana@example.com', NULL, 'Admin', NULL, '845 Ellie Springs\nLindtown, VT 75552', '09708908318', NULL, NULL, '2024-11-30 01:13:22', '2024-11-30 01:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'low',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_otp_accounts`
--

CREATE TABLE `admin_otp_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `grade_handle_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `announcement` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_histories`
--

CREATE TABLE `attendance_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_model_id` bigint(20) UNSIGNED NOT NULL,
  `grade_handle_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `status` varchar(255) NOT NULL,
  `time_in` varchar(255) DEFAULT 'N/A',
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `face_recognition_keys`
--

CREATE TABLE `face_recognition_keys` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pattern` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_by_admin_id` bigint(20) UNSIGNED NOT NULL,
  `updated_by_admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `face_scans`
--

CREATE TABLE `face_scans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `time` time DEFAULT curtime(),
  `time_out` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grading_headers`
--

CREATE TABLE `grading_headers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `region` varchar(255) DEFAULT 'IV - A',
  `division` varchar(255) DEFAULT '2nd',
  `school_name` varchar(255) DEFAULT 'Philippine Technological Institute of Science Arts and Trade Inc',
  `school_id` varchar(255) DEFAULT '405210',
  `school_year` varchar(255) DEFAULT '2023-2024',
  `grade_handle_id` int(11) DEFAULT NULL,
  `written_work_percentage` varchar(255) DEFAULT NULL,
  `performance_task_percentage` varchar(255) DEFAULT NULL,
  `quarterly_assessment_percentage` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guidance_accounts`
--

CREATE TABLE `guidance_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `extension_name` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'Guidance',
  `profile` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guidance_accounts`
--

INSERT INTO `guidance_accounts` (`id`, `id_number`, `name`, `extension_name`, `gender`, `username`, `password`, `email`, `role`, `profile`, `address`, `phone_number`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '0355379507', 'Milford Jakubowski', NULL, 'Male', 'lwunsch', '$2y$12$guVSPsGZInCat/SZjlaG1uQh5AP.I0THsKdoaIqZFbeOslB01hRNy', 'noemie.dare@example.org', 'Guidance', NULL, '98507 Trantow Locks Apt. 421\nRoybury, TN 49132', '09222997549', NULL, NULL, '2024-11-30 01:12:53', '2024-11-30 01:12:53'),
(2, '1237914711', 'Karley Johnston', NULL, 'Male', 'clovis.mitchell', '$2y$12$FdbPSoo3nBF2fLr1Akcjq.u/gklGzq7stO.6ShjISOpp1UBiAFHoa', 'wyman.kyla@example.org', 'Guidance', NULL, '48621 Hintz Summit\nVanessabury, MA 78596-2065', '09100128974', NULL, NULL, '2024-11-30 01:12:55', '2024-11-30 01:12:55'),
(3, '0000681817', 'Yvonne Grady', NULL, 'Female', 'dolly.watsica', '$2y$12$3iksUNIPfKq5FMAnSUWZvOlT2iSRj.60Z46IjauH4ndKtcQZunGJy', 'eichmann.sofia@example.com', 'Guidance', NULL, '288 Metz Loop\nNew Alexandre, OR 97040', '09902045094', NULL, NULL, '2024-11-30 01:12:56', '2024-11-30 01:12:56'),
(4, '5320148081', 'Prof. Hettie Tillman II', NULL, 'Female', 'hauck.carmen', '$2y$12$SWYTcrIyhxwKzDzi/mrWyOIaAxYfapGX2rfMN.N5leIxQ4EKSs8BS', 'stanford.paucek@example.org', 'Guidance', NULL, '57934 Brad Island Suite 979\nBogisichville, FL 90707', '09559507859', NULL, NULL, '2024-11-30 01:12:58', '2024-11-30 01:12:58'),
(5, '5744342796', 'Herminia Harber', NULL, 'Female', 'arnoldo71', '$2y$12$t2Hcy60m3qajne9K0xSeruJM6jaNSVgC92gWp6oorWl.XOOjyoksu', 'victoria.langworth@example.com', 'Guidance', NULL, '90567 Jordyn Ports\nSouth Lisandro, WI 27661', '09472173860', NULL, NULL, '2024-11-30 01:12:59', '2024-11-30 01:12:59'),
(6, '9792573689', 'Else Homenick', NULL, 'Female', 'stephany.rippin', '$2y$12$4qZ6aVajMoX/8u3kjYpjLemdGM6sM8Njr13lzvYeD2FXJh22kNJvq', 'ewell.torphy@example.net', 'Guidance', NULL, '9540 Koelpin Junctions Apt. 930\nPaucekborough, SD 25841', '09223953372', NULL, NULL, '2024-11-30 01:13:02', '2024-11-30 01:13:02'),
(7, '6678346291', 'Destinee Russel', NULL, 'Male', 'kunde.koby', '$2y$12$KM9VIus4W9RjyOZ0I1cNqeOfDV3fLPgko6VNbfSlxq59QePtWfy1C', 'ylegros@example.net', 'Guidance', NULL, '874 Kayley Vista\nGeorgiannaside, MA 25460-6023', '09614736633', NULL, NULL, '2024-11-30 01:13:03', '2024-11-30 01:13:03'),
(8, '6208013783', 'Hilda Tromp', NULL, 'Female', 'charlie.roob', '$2y$12$9Z8EtYFpHvJN/EecJtful./J8ADFtNrsl5A7asYzgWjprQvtADO9S', 'pfannerstill.elisa@example.net', 'Guidance', NULL, '192 Lamar Canyon\nOlsonberg, HI 27734-6670', '09785421807', NULL, NULL, '2024-11-30 01:13:05', '2024-11-30 01:13:05'),
(9, '0350643558', 'Charlie Cartwright V', NULL, 'Male', 'donato.cole', '$2y$12$N41JyohjZ9uJmbqllpridOSeSjnR6R1iEP9T5VlEJkkXZ1AR1w6Ta', 'cartwright.jada@example.com', 'Guidance', NULL, '9791 Calista Isle\nReichelton, ID 98071-9169', '09462522812', NULL, NULL, '2024-11-30 01:13:07', '2024-11-30 01:13:07'),
(10, '8708127545', 'Willow Rowe', NULL, 'Female', 'henri60', '$2y$12$wgB6xkIq/l8bkvLy/DoMP.qU6IhHF2fpy49aHXb.Gutl0Pub4yH9O', 'maida27@example.net', 'Guidance', NULL, '5263 Julian Creek Suite 096\nLizatown, NV 73094', '09465344396', NULL, NULL, '2024-11-30 01:13:08', '2024-11-30 01:13:08'),
(11, '0808900044', 'Kirsten Hoeger', NULL, 'Female', 'cfritsch', '$2y$12$J2YFFJ0/SW7KNXrJ29dIq.IHEV5ybfY3yru3HAoWboJIqOJl/bFBe', 'isimonis@example.org', 'Guidance', NULL, '5576 Dillon Stream\nNew Briaport, NV 64746', '09232470373', NULL, NULL, '2024-11-30 01:13:10', '2024-11-30 01:13:10'),
(12, '8718948652', 'Prof. Burnice Dooley', NULL, 'Male', 'pbode', '$2y$12$WECJo3w9r//ZZZqPvRneouDktz12NZr7yL2pICF8Sj0DLoak/Xs76', 'kovacek.claudine@example.org', 'Guidance', NULL, '5530 Loy Courts Suite 851\nWilfredborough, WY 18237-5791', '09581924618', NULL, NULL, '2024-11-30 01:13:11', '2024-11-30 01:13:11'),
(13, '2760842510', 'Ms. Simone Reinger', NULL, 'Female', 'rath.randy', '$2y$12$Bl3O6MuZrbrMnLg4Cp/3oud7472Z9o9NcbTMsXk3W3b8006LdTt1S', 'ila42@example.org', 'Guidance', NULL, '53301 Quitzon Stream\nNorth Daphneeside, VT 86770', '09965466372', NULL, NULL, '2024-11-30 01:13:13', '2024-11-30 01:13:13'),
(14, '4219641048', 'Estell Reilly', NULL, 'Male', 'waters.ivory', '$2y$12$xX/uKRd1ek7r2TKdtV3rReDf3Etjtc7pQ.OlzGJ8ZvbxA8M3gjNua', 'dell25@example.net', 'Guidance', NULL, '5808 Delbert Shoal Suite 402\nLake Jeanette, KY 34075', '09388009917', NULL, NULL, '2024-11-30 01:13:14', '2024-11-30 01:13:14'),
(15, '8413862674', 'Lillie Bechtelar', NULL, 'Male', 'damore.ola', '$2y$12$T.iUcoR/F5RbIAHayyKC2.6f5xMsnyzjZ/K42VKOjliGrNa93ZYDS', 'jerde.teagan@example.com', 'Guidance', NULL, '6029 Jany Cliff Apt. 949\nSchmitttown, ME 40782', '09482958639', NULL, NULL, '2024-11-30 01:13:16', '2024-11-30 01:13:16'),
(16, '7739975699', 'Chris Heaney', NULL, 'Female', 'irwin.klocko', '$2y$12$k6WtGYhGE5E.7Tv0qZN5velKN2C5XC.a7488.aFpbKzko/XiRaSd2', 'nking@example.org', 'Guidance', NULL, '54494 Koelpin Cove\nNew Melvintown, HI 07243', '09748321604', NULL, NULL, '2024-11-30 01:13:17', '2024-11-30 01:13:17'),
(17, '0188971514', 'Mrs. Lottie Walsh V', NULL, 'Female', 'myrtice.sanford', '$2y$12$oqAWEnws/eXs25EMQxWbz.ZhLPDjNwdudh/GaTDbqUXVMWTEiPJ7O', 'tara.boyle@example.net', 'Guidance', NULL, '869 Edmond Way Suite 155\nEarlside, WA 55566', '09499036052', NULL, NULL, '2024-11-30 01:13:18', '2024-11-30 01:13:18'),
(18, '9431706373', 'Devin Swaniawski', NULL, 'Male', 'hilpert.merle', '$2y$12$HJ98AATVAuQ/9bNqqkqNZO.ZPFRcE4OH5yawvwWUwhpnuch0.2xLW', 'sierra.waters@example.net', 'Guidance', NULL, '3803 Tevin Mews Apt. 043\nWest Nat, CT 35569-3009', '09353444328', NULL, NULL, '2024-11-30 01:13:20', '2024-11-30 01:13:20'),
(19, '4789341257', 'Sigrid Gerhold', NULL, 'Male', 'tblock', '$2y$12$DpHXBKYCaUvd35sF5TERpOKb6HYG/AOqbq2fm2FOm.DVjsLB80WIe', 'foster.pacocha@example.net', 'Guidance', NULL, '2304 Valerie Fords Apt. 544\nSchambergerburgh, LA 06951-0087', '09199409316', NULL, NULL, '2024-11-30 01:13:22', '2024-11-30 01:13:22'),
(20, '2574101779', 'Vivienne Dach DDS', NULL, 'Female', 'bradtke.libbie', '$2y$12$T48n7ckAKEp/wFSTV2f1.e40IBNWPp0XqZl8MiUT6Qjs3waBCw4Dq', 'uskiles@example.org', 'Guidance', NULL, '26055 Marlin Mall\nParkerstad, NJ 33761', '09192115509', NULL, NULL, '2024-11-30 01:13:23', '2024-11-30 01:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `guidance_notifications`
--

CREATE TABLE `guidance_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'low',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guidance_otp_accounts`
--

CREATE TABLE `guidance_otp_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `highest_possible_score_grading_sheets`
--

CREATE TABLE `highest_possible_score_grading_sheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grade_handle_id` int(11) DEFAULT NULL,
  `highest_possible_written_1` int(11) DEFAULT NULL,
  `highest_possible_written_2` int(11) DEFAULT NULL,
  `highest_possible_written_3` int(11) DEFAULT NULL,
  `highest_possible_written_4` int(11) DEFAULT NULL,
  `highest_possible_written_5` int(11) DEFAULT NULL,
  `highest_possible_written_6` int(11) DEFAULT NULL,
  `highest_possible_written_7` int(11) DEFAULT NULL,
  `highest_possible_written_8` int(11) DEFAULT NULL,
  `highest_possible_written_9` int(11) DEFAULT NULL,
  `highest_possible_written_10` int(11) DEFAULT NULL,
  `highest_possible_task_1` int(11) DEFAULT NULL,
  `highest_possible_task_2` int(11) DEFAULT NULL,
  `highest_possible_task_3` int(11) DEFAULT NULL,
  `highest_possible_task_4` int(11) DEFAULT NULL,
  `highest_possible_task_5` int(11) DEFAULT NULL,
  `highest_possible_task_6` int(11) DEFAULT NULL,
  `highest_possible_task_7` int(11) DEFAULT NULL,
  `highest_possible_task_8` int(11) DEFAULT NULL,
  `highest_possible_task_9` int(11) DEFAULT NULL,
  `highest_possible_task_10` int(11) DEFAULT NULL,
  `teacher_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `highest_possible_score_grading_sheets`
--

INSERT INTO `highest_possible_score_grading_sheets` (`id`, `grade_handle_id`, `highest_possible_written_1`, `highest_possible_written_2`, `highest_possible_written_3`, `highest_possible_written_4`, `highest_possible_written_5`, `highest_possible_written_6`, `highest_possible_written_7`, `highest_possible_written_8`, `highest_possible_written_9`, `highest_possible_written_10`, `highest_possible_task_1`, `highest_possible_task_2`, `highest_possible_task_3`, `highest_possible_task_4`, `highest_possible_task_5`, `highest_possible_task_6`, `highest_possible_task_7`, `highest_possible_task_8`, `highest_possible_task_9`, `highest_possible_task_10`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 1, '2024-11-30 10:55:47', '2024-11-30 10:55:47');

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `history` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `histories`
--

INSERT INTO `histories` (`id`, `position`, `user_id`, `history`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Teacher', 1, 'Created a subject', 'Subject created: ', '2024-11-30 01:18:08', '2024-11-30 01:18:08'),
(2, 'Teacher', 1, 'Created a subject', 'Subject created: ', '2024-11-30 01:18:44', '2024-11-30 01:18:44'),
(3, 'Teacher', 1, 'Created a subject', 'Subject created: ', '2024-11-30 01:19:13', '2024-11-30 01:19:13'),
(4, 'Teacher', 1, 'Create student account', 'ID Number: 533968, Name: Aldrin Caballero', '2024-11-30 01:20:27', '2024-11-30 01:20:27'),
(5, 'Teacher', 1, 'Added the subject  to Aldrin Caballero\'s account', NULL, '2024-11-30 10:52:58', '2024-11-30 10:52:58'),
(6, 'Teacher', 1, 'Added the subject  to Aldrin Caballero\'s account', NULL, '2024-11-30 10:53:02', '2024-11-30 10:53:02'),
(7, 'Teacher', 1, 'Added the subject  to Aldrin Caballero\'s account', NULL, '2024-11-30 10:53:06', '2024-11-30 10:53:06'),
(8, 'Teacher', 1, 'Updated user account', 'ID Number: 533968, Name: Aldrin Caballero', '2024-12-01 01:29:16', '2024-12-01 01:29:16'),
(9, 'Teacher', 1, 'Updated user account', 'ID Number: 533968, Name: Aldrin E Caballero', '2024-12-01 01:34:03', '2024-12-01 01:34:03'),
(10, 'Teacher', 1, 'Updated user account', 'ID Number: 533968, Name: Aldrin Esparaguera Caballero', '2024-12-01 01:34:15', '2024-12-01 01:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` varchar(255) NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_type` varchar(255) NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2024_07_09_035355_create_admin_accounts_table', 1),
(4, '2024_07_09_035427_create_teacher_accounts_table', 1),
(5, '2024_07_09_035447_create_student_accounts_table', 1),
(6, '2024_07_09_035518_create_guidance_accounts_table', 1),
(7, '2024_07_13_110545_create_subject_list_models_table', 1),
(8, '2024_07_16_094542_create_admin_otp_accounts_table', 1),
(9, '2024_07_17_054521_create_teacher_otp_accounts_table', 1),
(10, '2024_07_17_071410_create_student_otp_accounts_table', 1),
(11, '2024_07_17_071436_create_guidance_otp_accounts_table', 1),
(12, '2024_07_21_073138_create_messages_table', 1),
(13, '2024_07_24_041529_create_student_images_table', 1),
(14, '2024_07_26_024638_create_histories_table', 1),
(15, '2024_07_28_231217_create_teacher_grade_handles_table', 1),
(16, '2024_08_01_235232_create_student_handles_table', 1),
(17, '2024_08_04_030803_create_absents_table', 1),
(18, '2024_08_04_032257_create_presents_table', 1),
(19, '2024_08_06_001256_create_face_scans_table', 1),
(20, '2024_08_08_012247_create_qr_generates_table', 1),
(21, '2024_08_14_104433_create_announcements_table', 1),
(22, '2024_08_21_232604_create_attendance_histories_table', 1),
(23, '2024_09_06_132514_create_admin_notifications_table', 1),
(24, '2024_09_06_132543_create_student_notifications_table', 1),
(25, '2024_09_06_132601_create_teacher_notifications_table', 1),
(26, '2024_09_06_132618_create_guidance_notifications_table', 1),
(27, '2024_10_04_132336_create_seen_announcements_table', 1),
(28, '2024_10_06_031626_create_grading_headers_table', 1),
(29, '2024_10_06_233213_create_highest_possible_score_grading_sheets_table', 1),
(31, '2024_11_19_105151_create_face_recognition_keys_table', 1),
(32, 'z2024_07_24_074649_create_student_subjects_table', 1),
(34, '2024_10_14_090328_create_student_grades_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `presents`
--

CREATE TABLE `presents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `grade_handle_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qr_generates`
--

CREATE TABLE `qr_generates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `qr_code_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seen_announcements`
--

CREATE TABLE `seen_announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `announcement_id` bigint(20) UNSIGNED NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `grade_handle_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('XOaDg93gu0ndfnNzAVMOKn99W4eUZ6pMvGzisteB', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVUFHRE1zbTVvM240ZWZSTzRFbENPR0hOOUpCdnBaa3dJYmtJRU0yVyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjU1OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvc3R1ZGVudC9ub3RpZmljYXRpb25zL3Vuc2Vlbk5vdGlmIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1NDoibG9naW5fc3R1ZGVudF81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1733058468);

-- --------------------------------------------------------

--
-- Table structure for table `student_accounts`
--

CREATE TABLE `student_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `extension_name` varchar(255) DEFAULT NULL,
  `lrn` varchar(255) DEFAULT NULL,
  `birthdate` varchar(255) DEFAULT NULL,
  `strand` varchar(255) NOT NULL,
  `section` varchar(255) DEFAULT NULL,
  `grade` int(11) NOT NULL,
  `parents_contact_number` varchar(255) NOT NULL,
  `parents_email` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'Student',
  `profile` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_accounts`
--

INSERT INTO `student_accounts` (`id`, `id_number`, `name`, `gender`, `extension_name`, `lrn`, `birthdate`, `strand`, `section`, `grade`, `parents_contact_number`, `parents_email`, `username`, `password`, `email`, `role`, `profile`, `address`, `phone_number`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '533968', 'Aldrin Esparaguera Caballero', 'Male', NULL, '108465080002', '2002-11-26', 'ICT', 'A', 11, '09512793354', 'caballeroaldrin02@gmail.com', 'aldrin02', '$2y$12$USDtPUgweXMqQYTrDrJmTeYaSvYX3saEtvU0PJl/e12T/1KpuAohm', 'caballeroaldrin02@gmail.com', 'Student', 'profiles/1732929627_WIN_20241124_09_21_24_Pro.jpg', NULL, '09512793354', NULL, NULL, '2024-11-30 01:20:27', '2024-12-01 01:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `student_grades`
--

CREATE TABLE `student_grades` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `grade_handle_id` bigint(20) UNSIGNED NOT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `strand` varchar(255) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `semester` varchar(255) DEFAULT NULL,
  `quarter` varchar(255) DEFAULT NULL,
  `track` varchar(255) DEFAULT NULL,
  `written_1` int(11) DEFAULT NULL,
  `written_2` int(11) DEFAULT NULL,
  `written_3` int(11) DEFAULT NULL,
  `written_4` int(11) DEFAULT NULL,
  `written_5` int(11) DEFAULT NULL,
  `written_6` int(11) DEFAULT NULL,
  `written_7` int(11) DEFAULT NULL,
  `written_8` int(11) DEFAULT NULL,
  `written_9` int(11) DEFAULT NULL,
  `written_10` int(11) DEFAULT NULL,
  `written_total` int(11) DEFAULT NULL,
  `written_ps` int(11) DEFAULT NULL,
  `written_ws` int(11) DEFAULT NULL,
  `task_1` int(11) DEFAULT NULL,
  `task_2` int(11) DEFAULT NULL,
  `task_3` int(11) DEFAULT NULL,
  `task_4` int(11) DEFAULT NULL,
  `task_5` int(11) DEFAULT NULL,
  `task_6` int(11) DEFAULT NULL,
  `task_7` int(11) DEFAULT NULL,
  `task_8` int(11) DEFAULT NULL,
  `task_9` int(11) DEFAULT NULL,
  `task_10` int(11) DEFAULT NULL,
  `task_total` int(11) DEFAULT NULL,
  `task_ps` int(11) DEFAULT NULL,
  `task_ws` int(11) DEFAULT NULL,
  `quart_1` int(11) DEFAULT NULL,
  `quart_ps` int(11) DEFAULT NULL,
  `quart_ws` int(11) DEFAULT NULL,
  `initial_grade` double DEFAULT NULL,
  `quarterly_grade` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_grades`
--

INSERT INTO `student_grades` (`id`, `teacher_id`, `student_id`, `grade_handle_id`, `grade`, `strand`, `section`, `subject`, `semester`, `quarter`, `track`, `written_1`, `written_2`, `written_3`, `written_4`, `written_5`, `written_6`, `written_7`, `written_8`, `written_9`, `written_10`, `written_total`, `written_ps`, `written_ws`, `task_1`, `task_2`, `task_3`, `task_4`, `task_5`, `task_6`, `task_7`, `task_8`, `task_9`, `task_10`, `task_total`, `task_ps`, `task_ws`, `quart_1`, `quart_ps`, `quart_ws`, `initial_grade`, `quarterly_grade`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '11', 'ICT', 'A', 'Math', 'First Semester', 'First Quarter', 'Core Subject (All Tracks)', 10, 9, 8, 10, 7, 8, 10, 8, 10, 7, 87, 87, 22, 10, 7, 8, 9, 10, 8, 9, 10, 8, 5, 84, 84, 42, 9, 90, 23, 86.25, 91, '2024-11-30 11:04:13', '2024-11-30 11:45:10'),
(2, 1, 1, 1, '11', 'ICT', 'A', 'Earth and life science', 'First Semester', 'First Quarter', 'Core Subject (All Tracks)', 10, 9, 8, 10, 10, 8, 10, 8, 10, 7, 90, 90, 23, 10, 7, 8, 9, 10, 8, 9, 10, 8, 7, 86, 86, 43, 7, 70, 18, 83, 89, '2024-11-30 11:48:17', '2024-11-30 11:48:17'),
(3, 1, 1, 1, '11', 'ICT', 'A', 'Earth and life science', 'First Semester', 'Second Quarter', 'Core Subject (All Tracks)', 10, 9, 8, 10, 3, 8, 10, 8, 10, 7, 83, 83, 21, 10, 10, 8, 9, 10, 9, 9, 10, 8, 5, 88, 88, 44, 7, 70, 18, 82.25, 88, '2024-11-30 11:50:29', '2024-11-30 11:50:29'),
(4, 1, 1, 1, '11', 'ICT', 'A', 'Math', 'First Semester', 'Second Quarter', 'Core Subject (All Tracks)', 10, 10, 8, 10, 7, 8, 10, 5, 10, 6, 84, 84, 21, 10, 7, 8, 9, 10, 8, 9, 10, 8, 4, 83, 83, 42, 5, 50, 13, 75, 84, '2024-11-30 11:51:03', '2024-11-30 11:51:03'),
(5, 1, 1, 1, '11', 'ICT', 'A', 'Math', 'Second Semester', 'First Quarter', 'Core Subject (All Tracks)', 10, 9, 8, 10, 7, 8, 10, 5, 10, 10, 87, 87, 22, 10, 7, 8, 9, 10, 8, 9, 10, 8, 10, 89, 89, 45, 7, 70, 18, 83.75, 89, '2024-11-30 11:53:37', '2024-11-30 12:05:24'),
(6, 1, 1, 1, '11', 'ICT', 'A', 'Earth and life science', 'Second Semester', 'First Quarter', 'Core Subject (All Tracks)', 10, 9, 8, 10, 7, 8, 10, 8, 10, 10, 90, 90, 23, 10, 7, 8, 9, 10, 8, 9, 10, 8, 10, 89, 89, 45, 9, 90, 23, 89.5, 93, '2024-11-30 11:54:14', '2024-11-30 11:54:14'),
(7, 1, 1, 1, '11', 'ICT', 'A', 'Math', 'Second Semester', 'Second Quarter', 'Core Subject (All Tracks)', 10, 9, 8, 10, 7, 8, 10, 7, 10, 7, 86, 86, 22, 10, 10, 8, 9, 10, 8, 9, 10, 8, 5, 87, 87, 44, 6, 60, 15, 80, 87, '2024-11-30 12:33:49', '2024-11-30 12:33:49'),
(8, 1, 1, 1, '11', 'ICT', 'A', 'Earth and life science', 'Second Semester', 'Second Quarter', 'Core Subject (All Tracks)', 10, 9, 8, 10, 7, 9, 10, 8, 10, 7, 88, 88, 22, 10, 9, 8, 9, 10, 8, 9, 10, 8, 5, 86, 86, 43, 10, 100, 25, 90, 93, '2024-11-30 12:34:18', '2024-11-30 12:34:18');

-- --------------------------------------------------------

--
-- Table structure for table `student_handles`
--

CREATE TABLE `student_handles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `grade_handle_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_handles`
--

INSERT INTO `student_handles` (`id`, `student_id`, `teacher_id`, `grade_handle_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2024-11-30 01:20:27', '2024-11-30 01:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `student_images`
--

CREATE TABLE `student_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_images`
--

INSERT INTO `student_images` (`id`, `student_id`, `image_path`, `created_at`, `updated_at`) VALUES
(1, 1, 'face_images/Aldrin Caballero/0.jpg', '2024-11-30 01:20:27', '2024-11-30 01:20:27'),
(2, 1, 'face_images/Aldrin Caballero/1.jpg', '2024-11-30 01:20:27', '2024-11-30 01:20:27'),
(3, 1, 'face_images/Aldrin Caballero/2.jpg', '2024-11-30 01:20:27', '2024-11-30 01:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `student_notifications`
--

CREATE TABLE `student_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'low',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_otp_accounts`
--

CREATE TABLE `student_otp_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_subjects`
--

CREATE TABLE `student_subjects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `subject_id` bigint(20) UNSIGNED NOT NULL,
  `teacher_id` bigint(20) UNSIGNED NOT NULL,
  `grade_handle_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_subjects`
--

INSERT INTO `student_subjects` (`id`, `student_id`, `subject_id`, `teacher_id`, `grade_handle_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '2024-11-30 10:52:58', '2024-11-30 10:52:58'),
(2, 1, 2, 1, 1, '2024-11-30 10:53:02', '2024-11-30 10:53:02'),
(3, 1, 3, 1, 1, '2024-11-30 10:53:06', '2024-11-30 10:53:06');

-- --------------------------------------------------------

--
-- Table structure for table `subject_models`
--

CREATE TABLE `subject_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `day` varchar(255) DEFAULT NULL,
  `grade_handle_id` bigint(20) UNSIGNED DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject_models`
--

INSERT INTO `subject_models` (`id`, `subject`, `day`, `grade_handle_id`, `teacher_id`, `time`, `created_at`, `updated_at`) VALUES
(1, 'Earth and life science', 'Monday', 1, 1, '07:00 AM - 08:00 AM', '2024-11-30 01:18:08', '2024-11-30 01:18:08'),
(2, 'Math', 'Tuesday', 1, 1, '06:00 AM - 08:30 AM', '2024-11-30 01:18:44', '2024-11-30 01:18:44'),
(3, 'Values', 'Wednesday', 1, 1, '11:00 AM - 12:00 PM', '2024-11-30 01:19:13', '2024-11-30 01:19:13');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_accounts`
--

CREATE TABLE `teacher_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_number` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `extension_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'Teacher',
  `profile` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_accounts`
--

INSERT INTO `teacher_accounts` (`id`, `id_number`, `name`, `gender`, `position`, `username`, `password`, `extension_name`, `email`, `role`, `profile`, `address`, `phone_number`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '8005238424', 'Twila Doyle', 'Female', 'Teacher 3', 'aldrin02', '$2y$12$n9x0mMPeP6pqNd7Vrb0tl.27pAXZRJCH20q5y.sC9MyHqUcu5xqqW', NULL, 'caballeroaldrin02@gmail.com', 'Teacher', NULL, '5489 Frank Courts\nWest Joanborough, FL 40708-0535', '09963175217', NULL, NULL, '2024-11-30 01:12:54', '2024-11-30 01:12:54'),
(2, '2521375154', 'Simone Mohr', 'Female', 'Teacher 2', 'okuhlman', '$2y$12$ZSGyzKdOPawikqquRiCImOgJWzGcWAfxHhJ1JlgdcWinEz/Cc5ciS', NULL, 'tyrese55@example.net', 'Teacher', NULL, '278 Everette Route\nMelvinchester, ND 91570-0810', '09425466523', NULL, NULL, '2024-11-30 01:12:55', '2024-11-30 01:12:55'),
(3, '7082497969', 'Clovis Jaskolski', 'Female', 'Teacher 1', 'wrohan', '$2y$12$HC1jUKhPHCeyFc1Vrw0eUOWu9KqRYOBcYnM.WPypTorZ2GihG6xfW', NULL, 'roy.marvin@example.net', 'Teacher', NULL, '3705 Zboncak Shoals Apt. 508\nSandrinestad, RI 72177', '09374455704', NULL, NULL, '2024-11-30 01:12:56', '2024-11-30 01:12:56'),
(4, '6333271791', 'Mrs. Holly Weber DDS', 'Male', 'Teacher 3', 'eli79', '$2y$12$CJsAxwtenoaaNzG9xVRh9Ojq3xmDnW7r8RHotnXJ4IGttU7/0wCn6', NULL, 'hudson.efren@example.com', 'Teacher', NULL, '49643 Dora Mall Apt. 454\nPort Flavio, TX 65219-5724', '09489238169', NULL, NULL, '2024-11-30 01:12:58', '2024-11-30 01:12:58'),
(5, '3022431925', 'Earline Williamson', 'Male', 'Teacher 3', 'rohan.rashad', '$2y$12$rKZeKFPNrbF89ql1ysLezeV7OAeit9LDdu3JSbRb1/5rj4zO2i2xe', NULL, 'zackery.johns@example.com', 'Teacher', NULL, '9822 Jacobi Mill\nNew Gabriel, NV 69894', '09932063644', NULL, NULL, '2024-11-30 01:13:00', '2024-11-30 01:13:00'),
(6, '4260931939', 'Geo Eichmann I', 'Male', 'Teacher 3', 'hartmann.daisha', '$2y$12$bB1YJepaMK4Fyhff2PuPN.5CjQfu9G750UGArqk9eD.uEkLzTgK4u', NULL, 'emmitt.bogisich@example.org', 'Teacher', NULL, '911 Eden Stream\nPreciousborough, MA 90460-7075', '09793455592', NULL, NULL, '2024-11-30 01:13:02', '2024-11-30 01:13:02'),
(7, '5090457887', 'Guido Bins', 'Female', 'Teacher 1', 'heidenreich.cortney', '$2y$12$z/a6o5ClI2LN/TBW0puL.es2qn4bKkWHpykGQlrUb5a/PUTbhzKgK', NULL, 'kaci43@example.org', 'Teacher', NULL, '382 Alia Mews\nLake Wilhelminemouth, NJ 95896-4395', '09058358425', NULL, NULL, '2024-11-30 01:13:04', '2024-11-30 01:13:04'),
(8, '9532104850', 'Dr. Summer Harber IV', 'Male', 'Teacher 1', 'jakayla25', '$2y$12$lXFIXqPByX1du46UNruq6uPdbJ12.YKRLX6BF3o7dg.i9Ep2iQTbS', NULL, 'collins.alfonso@example.net', 'Teacher', NULL, '5548 Muller Plains Suite 627\nAlexanneberg, NY 07839', '09951665904', NULL, NULL, '2024-11-30 01:13:06', '2024-11-30 01:13:06'),
(9, '9378381712', 'Ms. Dorothea Goldner DVM', 'Female', 'Teacher 1', 'emelia12', '$2y$12$MZ07t4rw42WqgSRKrY9m7O10AHbPr0rPbvJFvYBf/MNHzNBpq6xeS', NULL, 'nitzsche.marcellus@example.com', 'Teacher', NULL, '379 Germaine Summit Suite 214\nNew Grayceburgh, NJ 80112', '09521289139', NULL, NULL, '2024-11-30 01:13:07', '2024-11-30 01:13:07'),
(10, '2599391950', 'Prof. Ambrose DuBuque', 'Male', 'Teacher 2', 'einar68', '$2y$12$z8pL7FZc9.Se/utcZG/Bo.1FCXWh1Zf2KxCQE96ENjn83hwluVHru', NULL, 'ashly.bailey@example.net', 'Teacher', NULL, '563 Sammie Alley Apt. 074\nRoweville, NJ 51536-8855', '09139729038', NULL, NULL, '2024-11-30 01:13:09', '2024-11-30 01:13:09'),
(11, '4009707544', 'Jeramy McGlynn Sr.', 'Female', 'Teacher 1', 'gorczany.miller', '$2y$12$RFTPy3nBvYt/SVIaPZWb4ObWinHB6gDxTgPjgHb9e6CY8k3AYJ/DS', NULL, 'feil.melisa@example.net', 'Teacher', NULL, '4292 Keebler Trail Apt. 813\nAnamouth, WI 35918-9952', '09280451171', NULL, NULL, '2024-11-30 01:13:10', '2024-11-30 01:13:10'),
(12, '5111281325', 'Joshua Bernhard', 'Male', 'Teacher 2', 'lue42', '$2y$12$JWKqfm8di9LWkgzISr9l1.pvaq/UbM9JWZWZo98ZYfgTz0wmeRjcq', NULL, 'schroeder.sincere@example.net', 'Teacher', NULL, '52018 Kozey Roads\nSatterfieldhaven, NV 78965-5089', '09101298566', NULL, NULL, '2024-11-30 01:13:12', '2024-11-30 01:13:12'),
(13, '6314450716', 'Kaylin Murphy PhD', 'Male', 'Teacher 3', 'lebsack.dayna', '$2y$12$.bl5VarKX1YugT5E8ttY8.G3Ba77Zq1Q17qYr0LPRuww1yEBsGUiy', NULL, 'otilia08@example.net', 'Teacher', NULL, '445 Woodrow Parkways\nStrackefurt, IA 19164', '09971632031', NULL, NULL, '2024-11-30 01:13:14', '2024-11-30 01:13:14'),
(14, '2908855480', 'Mr. Reuben Watsica', 'Female', 'Teacher 1', 'ismael38', '$2y$12$jIm1huiQKfML7BvSUVye9uScSokNl.RuafLvkQUC5Kgin8PPEsUf.', NULL, 'kylee.yost@example.org', 'Teacher', NULL, '5104 Chyna Expressway Suite 540\nEast Stewartshire, MO 11170', '09468795209', NULL, NULL, '2024-11-30 01:13:15', '2024-11-30 01:13:15'),
(15, '6261464404', 'Wilford O\'Reilly', 'Female', 'Teacher 2', 'oprosacco', '$2y$12$ExI03Fj/J4WuTkf0NWDayurboNKeeot5hyN6k9IXaLx5.sF2BR8om', NULL, 'cromaguera@example.com', 'Teacher', NULL, '568 Gerard Dale\nHirtheville, NE 46665', '09769784878', NULL, NULL, '2024-11-30 01:13:16', '2024-11-30 01:13:16'),
(16, '0233521821', 'Delaney Barrows', 'Male', 'Teacher 2', 'pearl08', '$2y$12$rPX5pK/Qf1tqvErfJlrHheJpo9sc4VV/UyFmy4r3bQFSl94ihjcza', NULL, 'rolfson.jerel@example.net', 'Teacher', NULL, '9861 Audra Via Apt. 272\nPort Arnehaven, PA 00432-9580', '09059357985', NULL, NULL, '2024-11-30 01:13:18', '2024-11-30 01:13:18'),
(17, '3899737993', 'Ms. Angelita Kuhn', 'Male', 'Teacher 2', 'schumm.cierra', '$2y$12$VoGjwfHhsk0xeEiPrxe5W.jSLRaFScLNr/nbD/MiW8oJi.xy60Otm', NULL, 'jhermann@example.net', 'Teacher', NULL, '9694 Americo Landing\nSouth Tabithabury, VA 88569-1786', '09468461324', NULL, NULL, '2024-11-30 01:13:19', '2024-11-30 01:13:19'),
(18, '8231262829', 'Agustina Block', 'Male', 'Teacher 1', 'ometz', '$2y$12$G/MxckMo1NhLxWRnj4bJzuBb.EXKbPOuNbddRNoxLscXMIsiPr.lG', NULL, 'nolan.kasey@example.net', 'Teacher', NULL, '2602 Robyn Ways Suite 270\nNew Vicenta, IA 60920', '09674450941', NULL, NULL, '2024-11-30 01:13:20', '2024-11-30 01:13:20'),
(19, '8208223106', 'Kaycee Connelly', 'Female', 'Teacher 1', 'arlo.reilly', '$2y$12$WzCU7JY.eXTuIEli9nki7.48lF8x78eTk/27z9Z8w5gPw7NK3LNQq', NULL, 'ldurgan@example.com', 'Teacher', NULL, '768 Schaefer Freeway Suite 191\nWest Thea, NY 61844', '09136389705', NULL, NULL, '2024-11-30 01:13:22', '2024-11-30 01:13:22'),
(20, '8432483537', 'Shany Koelpin', 'Male', 'Teacher 3', 'ryann49', '$2y$12$e.kFrzQ.OfjgtcnM/Dw1O.tiJFhIulEzz2cLaSrIjRGOMY0DODUVW', NULL, 'hleannon@example.org', 'Teacher', NULL, '362 Rylee Gateway\nDickiview, MI 61495', '09505634881', NULL, NULL, '2024-11-30 01:13:23', '2024-11-30 01:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_grade_handles`
--

CREATE TABLE `teacher_grade_handles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grade` varchar(255) DEFAULT NULL,
  `strand` varchar(255) DEFAULT NULL,
  `section` varchar(255) DEFAULT NULL,
  `semester` varchar(255) DEFAULT 'First semester',
  `quarter` varchar(255) DEFAULT 'First quarter',
  `subject` varchar(255) DEFAULT NULL,
  `track` varchar(255) DEFAULT NULL,
  `teacher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teacher_grade_handles`
--

INSERT INTO `teacher_grade_handles` (`id`, `grade`, `strand`, `section`, `semester`, `quarter`, `subject`, `track`, `teacher_id`, `created_at`, `updated_at`) VALUES
(1, '11', 'ICT', 'A', 'First semester', 'First quarter', NULL, NULL, 1, '2024-11-30 01:17:35', '2024-11-30 01:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_notifications`
--

CREATE TABLE `teacher_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `url` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'low',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_otp_accounts`
--

CREATE TABLE `teacher_otp_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absents`
--
ALTER TABLE `absents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_accounts_id_number_unique` (`id_number`),
  ADD UNIQUE KEY `admin_accounts_username_unique` (`username`),
  ADD UNIQUE KEY `admin_accounts_email_unique` (`email`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `admin_otp_accounts`
--
ALTER TABLE `admin_otp_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance_histories`
--
ALTER TABLE `attendance_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_histories_student_id_foreign` (`student_id`),
  ADD KEY `attendance_histories_subject_model_id_foreign` (`subject_model_id`),
  ADD KEY `attendance_histories_teacher_id_foreign` (`teacher_id`),
  ADD KEY `attendance_histories_grade_handle_id_foreign` (`grade_handle_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `face_recognition_keys`
--
ALTER TABLE `face_recognition_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `face_scans`
--
ALTER TABLE `face_scans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `face_scans_student_id_foreign` (`student_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grading_headers`
--
ALTER TABLE `grading_headers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guidance_accounts`
--
ALTER TABLE `guidance_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guidance_accounts_id_number_unique` (`id_number`),
  ADD UNIQUE KEY `guidance_accounts_username_unique` (`username`),
  ADD UNIQUE KEY `guidance_accounts_email_unique` (`email`);

--
-- Indexes for table `guidance_notifications`
--
ALTER TABLE `guidance_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guidance_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `guidance_otp_accounts`
--
ALTER TABLE `guidance_otp_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `highest_possible_score_grading_sheets`
--
ALTER TABLE `highest_possible_score_grading_sheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_sender_type_index` (`sender_id`,`sender_type`),
  ADD KEY `messages_receiver_id_receiver_type_index` (`receiver_id`,`receiver_type`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `presents`
--
ALTER TABLE `presents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qr_generates`
--
ALTER TABLE `qr_generates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seen_announcements`
--
ALTER TABLE `seen_announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `student_accounts`
--
ALTER TABLE `student_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_accounts_id_number_unique` (`id_number`),
  ADD UNIQUE KEY `student_accounts_username_unique` (`username`),
  ADD UNIQUE KEY `student_accounts_email_unique` (`email`);

--
-- Indexes for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_grades_grade_handle_id_foreign` (`grade_handle_id`);

--
-- Indexes for table `student_handles`
--
ALTER TABLE `student_handles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_handles_student_id_foreign` (`student_id`),
  ADD KEY `student_handles_grade_handle_id_foreign` (`grade_handle_id`);

--
-- Indexes for table `student_images`
--
ALTER TABLE `student_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_images_student_id_foreign` (`student_id`);

--
-- Indexes for table `student_notifications`
--
ALTER TABLE `student_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `student_otp_accounts`
--
ALTER TABLE `student_otp_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_subjects_student_id_foreign` (`student_id`),
  ADD KEY `student_subjects_subject_id_foreign` (`subject_id`),
  ADD KEY `student_subjects_grade_handle_id_foreign` (`grade_handle_id`);

--
-- Indexes for table `subject_models`
--
ALTER TABLE `subject_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_accounts`
--
ALTER TABLE `teacher_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_accounts_id_number_unique` (`id_number`),
  ADD UNIQUE KEY `teacher_accounts_username_unique` (`username`),
  ADD UNIQUE KEY `teacher_accounts_email_unique` (`email`);

--
-- Indexes for table `teacher_grade_handles`
--
ALTER TABLE `teacher_grade_handles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_grade_handles_teacher_id_foreign` (`teacher_id`);

--
-- Indexes for table `teacher_notifications`
--
ALTER TABLE `teacher_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `teacher_otp_accounts`
--
ALTER TABLE `teacher_otp_accounts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absents`
--
ALTER TABLE `absents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_otp_accounts`
--
ALTER TABLE `admin_otp_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_histories`
--
ALTER TABLE `attendance_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `face_recognition_keys`
--
ALTER TABLE `face_recognition_keys`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `face_scans`
--
ALTER TABLE `face_scans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grading_headers`
--
ALTER TABLE `grading_headers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guidance_accounts`
--
ALTER TABLE `guidance_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `guidance_notifications`
--
ALTER TABLE `guidance_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guidance_otp_accounts`
--
ALTER TABLE `guidance_otp_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `highest_possible_score_grading_sheets`
--
ALTER TABLE `highest_possible_score_grading_sheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `presents`
--
ALTER TABLE `presents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qr_generates`
--
ALTER TABLE `qr_generates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seen_announcements`
--
ALTER TABLE `seen_announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_accounts`
--
ALTER TABLE `student_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_grades`
--
ALTER TABLE `student_grades`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student_handles`
--
ALTER TABLE `student_handles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_images`
--
ALTER TABLE `student_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_notifications`
--
ALTER TABLE `student_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_otp_accounts`
--
ALTER TABLE `student_otp_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student_subjects`
--
ALTER TABLE `student_subjects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subject_models`
--
ALTER TABLE `subject_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teacher_accounts`
--
ALTER TABLE `teacher_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `teacher_grade_handles`
--
ALTER TABLE `teacher_grade_handles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teacher_notifications`
--
ALTER TABLE `teacher_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teacher_otp_accounts`
--
ALTER TABLE `teacher_otp_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD CONSTRAINT `admin_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admin_accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `attendance_histories`
--
ALTER TABLE `attendance_histories`
  ADD CONSTRAINT `attendance_histories_grade_handle_id_foreign` FOREIGN KEY (`grade_handle_id`) REFERENCES `teacher_grade_handles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_histories_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `student_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_histories_subject_model_id_foreign` FOREIGN KEY (`subject_model_id`) REFERENCES `subject_models` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_histories_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teacher_accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `face_scans`
--
ALTER TABLE `face_scans`
  ADD CONSTRAINT `face_scans_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `student_accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guidance_notifications`
--
ALTER TABLE `guidance_notifications`
  ADD CONSTRAINT `guidance_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `guidance_accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_grades`
--
ALTER TABLE `student_grades`
  ADD CONSTRAINT `student_grades_grade_handle_id_foreign` FOREIGN KEY (`grade_handle_id`) REFERENCES `teacher_grade_handles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_handles`
--
ALTER TABLE `student_handles`
  ADD CONSTRAINT `student_handles_grade_handle_id_foreign` FOREIGN KEY (`grade_handle_id`) REFERENCES `teacher_grade_handles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_handles_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `student_accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_images`
--
ALTER TABLE `student_images`
  ADD CONSTRAINT `student_images_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `student_accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_notifications`
--
ALTER TABLE `student_notifications`
  ADD CONSTRAINT `student_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `student_accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `student_subjects`
--
ALTER TABLE `student_subjects`
  ADD CONSTRAINT `student_subjects_grade_handle_id_foreign` FOREIGN KEY (`grade_handle_id`) REFERENCES `teacher_grade_handles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subjects_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `student_accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_subjects_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subject_models` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_grade_handles`
--
ALTER TABLE `teacher_grade_handles`
  ADD CONSTRAINT `teacher_grade_handles_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teacher_accounts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `teacher_notifications`
--
ALTER TABLE `teacher_notifications`
  ADD CONSTRAINT `teacher_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `teacher_accounts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
