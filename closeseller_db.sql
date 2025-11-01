-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2025 at 05:02 PM
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
-- Database: `closeseller_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$12$lqm/OUuHuHMQgRSiNLuhS.X8WprsFkBwJD/Aih.LK4Ficqwmixk2S', 'admin', '2025-10-28 12:34:31', '2025-10-28 12:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `bank_details`
--

CREATE TABLE `bank_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `bankCode` varchar(255) NOT NULL,
  `bankName` varchar(255) NOT NULL,
  `acctName` varchar(255) NOT NULL,
  `acctNo` varchar(20) NOT NULL,
  `recipient_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_details`
--

INSERT INTO `bank_details` (`id`, `vendor_id`, `bankCode`, `bankName`, `acctName`, `acctNo`, `recipient_code`, `created_at`, `updated_at`) VALUES
(1, 1, '999992', 'OPay Digital Services Limited (OPay)', 'DENNIS SILAS MBAGWU', '8102678284', 'RCP_2c21zoq36izp324', '2025-10-27 08:55:27', '2025-10-27 10:09:32');

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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` bigint(20) NOT NULL DEFAULT 1,
  `price` double NOT NULL DEFAULT 0,
  `attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attributes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `inMenu` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-active,0-inactive',
  `isdelete` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-deleted,0-not deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `category_name`, `image`, `inMenu`, `status`, `isdelete`, `created_at`, `updated_at`) VALUES
(1, 'Beauty and Personal Care', 'Beauty and Personal Care', 'spa', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(2, 'Health and Wellness', 'Health and Wellness', 'favorite', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(3, 'Sports and Outdoors', 'Sports and Outdoors', 'sports_soccer', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(4, 'Electronics', 'Electronics', 'devices', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(5, 'Food and Beverage', 'Food and Beverage', 'restaurant', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(6, 'Baby and Kids', 'Baby and Kids', 'child_care', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(7, 'Automobiles', 'Automobiles', 'directions_car', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(8, 'Office Supplies', 'Office Supplies', 'description', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(9, 'Books', 'Books', 'menu_book', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(10, 'Phoness & Accessories', 'Phoness & Accessories', 'smartphone', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(11, 'Toys and Games', 'Toys and Games', 'sports_esports', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(12, 'Agro Products', 'Agro Products', 'grass', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(13, 'Furniture', 'Furniture', 'chair', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34'),
(14, 'Hospitality', 'Hospitality', 'local_hotel', 0, 1, 0, '2025-10-14 10:18:34', '2025-10-14 10:18:34');

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-active,0-inactive',
  `isdelete` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-deleted,0-not deleted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`id`, `name`, `color`, `code`, `status`, `isdelete`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Black', '#0000', 0, 0, '2025-10-14 10:44:53', '2025-10-14 10:44:53'),
(2, NULL, 'Blue', '#2986cc', 0, 0, '2025-10-14 10:44:53', '2025-10-14 10:44:53'),
(3, NULL, 'Yellow', '#f1c232', 0, 0, '2025-10-14 10:44:53', '2025-10-14 10:44:53'),
(4, NULL, 'Red', '#ff6347', 0, 0, '2025-10-14 10:44:53', '2025-10-14 10:44:53');

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `category`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(1, 'Account', 'How do I create an account?', 'Click on the \"Sign Up\" button, fill in your details, and verify your email.', '2025-10-30 21:25:36', '2025-10-30 21:25:36'),
(2, 'Account', 'How do I reset my password?', 'Click \"Forgot Password\" on the login page and follow the instructions.', '2025-10-30 21:25:36', '2025-10-30 21:25:36'),
(3, 'Account', 'Can I change my registered email?', 'Yes, go to Account Settings and update your email address.', '2025-10-30 21:25:36', '2025-10-30 21:25:36'),
(4, 'Payment', 'What payment methods do you accept?', 'We accept credit/debit cards, PayPal, and bank transfers.', '2025-10-30 21:25:36', '2025-10-30 21:25:36'),
(5, 'Payment', 'How can I view my billing history?', 'Log in, go to \"Billing\" under account settings to see all transactions.', '2025-10-30 21:25:36', '2025-10-30 21:25:36'),
(6, 'Payment', 'Can I get a refund?', 'Refunds are processed based on our refund policy. Contact support for details.', '2025-10-30 21:25:36', '2025-10-30 21:25:36'),
(7, 'Orders & Shipping', 'How do I track my order?', 'After purchase, you will receive an email with a tracking link.', '2025-10-30 21:25:36', '2025-10-30 21:25:36'),
(8, 'Orders & Shipping', 'Do you ship internationally?', 'Yes, we ship worldwide. Shipping costs vary by location.', '2025-10-30 21:25:36', '2025-10-30 21:25:36'),
(9, 'Orders & Shipping', 'What should I do if my order is delayed?', 'Contact our support team with your order number for assistance.', '2025-10-30 21:25:36', '2025-10-30 21:25:36'),
(10, 'Technical Support', 'The website is not loading properly?', 'Clear your browser cache and try again. If the issue persists, contact support.', '2025-10-30 21:25:36', '2025-10-30 21:25:36'),
(11, 'Technical Support', 'How do I update the mobile app?', 'Visit the App Store or Google Play Store and check for updates.', '2025-10-30 21:25:36', '2025-10-30 21:25:36'),
(12, 'Technical Support', 'What should I do if I encounter an error?', 'Take a screenshot and report the issue to our support team.', '2025-10-30 21:25:36', '2025-10-30 21:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `topic`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Payment', 'User', 'How does the payment charge work?', '2025-10-30 21:17:50', '2025-10-30 21:17:50'),
(2, 1, 'Delivery', 'Vendor', 'How do U get to deliver all the products at once, while I need an estimated time of delivery', '2025-10-30 21:19:00', '2025-10-30 21:19:00');

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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Abia', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(2, 'Adamawa', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(3, 'Akwa Ibom', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(4, 'Anambra', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(5, 'Bauchi', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(6, 'Bayelsa', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(7, 'Benue', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(8, 'Borno', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(9, 'Cross River', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(10, 'Delta', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(11, 'Ebonyi', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(12, 'Edo', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(13, 'Ekiti', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(14, 'Enugu', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(15, 'Gombe', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(16, 'Imo', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(17, 'Jigawa', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(18, 'Kaduna', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(19, 'Kano', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(20, 'Katsina', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(21, 'Kebbi', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(22, 'Kogi', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(23, 'Kwara', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(24, 'Lagos', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(25, 'Nasarawa', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(26, 'Niger', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(27, 'Ogun', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(28, 'Ondo', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(29, 'Osun', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(30, 'Oyo', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(31, 'Plateau', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(32, 'Rivers', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(33, 'Sokoto', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(34, 'Taraba', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(35, 'Yobe', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(36, 'Zamfara', '2025-10-14 10:38:13', '2025-10-14 10:38:13'),
(37, 'Federal Capital Territory (Abuja)', '2025-10-14 10:38:13', '2025-10-14 10:38:13');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_08_202954_create_vendors_table', 1),
(5, '2025_10_09_230409_create_password_otps_table', 1),
(6, '2025_10_10_000000_create_categories_table', 1),
(7, '2025_10_10_072650_create_vendor_verifications_table', 1),
(8, '2025_10_11_000000_create_products_table', 1),
(9, '2025_10_11_092826_create_colors_table', 1),
(10, '2025_10_11_093126_create_product_colors_table', 1),
(11, '2025_10_11_093413_create_product_images_table', 1),
(12, '2025_10_11_093914_create_product_sizes_table', 1),
(13, '2025_10_11_094213_create_product_wishlists_table', 1),
(14, '2025_10_11_094354_create_product_reviews_table', 1),
(15, '2025_10_13_195926_create_units_table', 2),
(16, '2025_10_14_103416_create_locations_table', 3),
(17, '2025_10_18_065855_create_notifications_table', 4),
(18, '2025_10_17_063856_create_bank_details_table', 5),
(19, '2025_10_20_102126_create_product_whishlists_table', 5),
(20, '2025_10_21_005421_create_carts_table', 6),
(21, '2025_10_21_005720_create_cart_items_table', 6),
(22, '2025_10_22_201718_create_shipping_addresses_table', 7),
(23, '2025_10_23_081233_create_orders_table', 8),
(24, '2025_10_23_090407_create_order_items_table', 9),
(25, '2025_10_23_093544_create_order_trackings_table', 10),
(26, '2025_10_21_210014_create_faqs_table', 11),
(27, '2025_10_22_105400_create_feedback_table', 11),
(28, '2025_10_24_111455_add_reference_to_orders_table', 12),
(29, '2025_10_27_094154_create_vendor_payouts_table', 13),
(30, '2025_10_27_094220_create_platform_earnings_table', 13),
(31, '2025_10_28_123607_create_admins_table', 14),
(32, '2025_10_30_225921_create_tickets_table', 15);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_type` enum('user','vendor','admin') DEFAULT NULL COMMENT 'Identifies whether notification is for user, vendor, or admin',
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `message` mediumtext DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 => sent to admin, 0 => not admin',
  `is_read` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 => read, 0 => unread',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `user_type`, `title`, `url`, `message`, `is_admin`, `is_read`, `created_at`, `updated_at`) VALUES
(16, 1, 'user', 'Order #ORD-SW3ZPPUY Dispatched', 'http://127.0.0.1:8000/users/order/summary/24', 'Your order #ORD-SW3ZPPUY has been dispatched and is on its way.', 0, 1, '2025-10-29 04:22:09', '2025-10-29 04:22:22'),
(17, 1, 'vendor', 'You Dispatched an Order #ORD-SW3ZPPUY', 'http://127.0.0.1:8000/vendors/order-summary/24', 'You have dispatched order #ORD-SW3ZPPUY to the buyer.', 0, 0, '2025-10-29 04:22:09', '2025-10-29 04:22:09'),
(18, 1, 'user', 'Order #ORD-SW3ZPPUY Delivered', 'http://127.0.0.1:8000/users/order/summary/24', 'Your order #ORD-SW3ZPPUY has been delivered successfully.', 0, 1, '2025-10-29 04:23:09', '2025-10-29 07:17:29'),
(19, 1, 'vendor', 'You Delivered an Order #ORD-SW3ZPPUY', 'http://127.0.0.1:8000/vendors/order-summary/24', 'You have completed delivery for order #ORD-SW3ZPPUY.', 0, 0, '2025-10-29 04:23:09', '2025-10-29 04:23:09'),
(20, 3, 'user', 'Account Creation Successful', 'https://lol.com', 'Welcome to Closeseller! Discover a world of top-quality products, trusted vendors, and smooth shopping experiences.', 0, 1, '2025-10-29 05:23:04', '2025-10-29 05:23:16'),
(21, 1, 'vendor', '💳 New Payment Received', 'http://127.0.0.1:8000/vendors/order-summary/25', 'Dear Vendor, You\'ve received 120.00 for Order #ORD-RY9CCHKC', 0, 0, '2025-10-29 05:57:07', '2025-10-29 05:57:07'),
(22, NULL, 'admin', '💳 New Payment Processed', 'http://127.0.0.1:8000/admin/orders/details/25', 'Vendor DENNIS SILAS MBAGWU (ID: 1) has received ₦110.00 for Order #ORD-RY9CCHKC. Gross amount: ₦120.00, Fees: ₦10.00', 1, 0, '2025-10-29 05:57:07', '2025-10-29 05:57:07'),
(23, 3, 'user', 'Order Confirmed', 'http://127.0.0.1:8000/users/order/summary/25', ' Thank you for your order #ORD-RY9CCHKC\n                        Order Date: October 29, 2025\n                        Payment Method: paystack\n                        Amount Paid: ₦120.00 Your order is now being processed. You\'ll receive another notification when your items ship.', 0, 0, '2025-10-29 05:57:07', '2025-10-29 05:57:07'),
(24, 1, 'user', 'Order #ORD-SW3ZPPUY Dispatched', 'http://127.0.0.1:8000/users/order/summary/24', 'Your order #ORD-SW3ZPPUY has been dispatched and is on its way.', 0, 0, '2025-10-29 07:30:47', '2025-10-29 07:30:47'),
(25, 1, 'vendor', 'You Dispatched an Order #ORD-SW3ZPPUY', 'http://127.0.0.1:8000/vendors/order-summary/24', 'You have dispatched order #ORD-SW3ZPPUY to the buyer.', 0, 0, '2025-10-29 07:30:47', '2025-10-29 07:30:47'),
(26, 1, 'user', 'Order #ORD-SW3ZPPUY Delivered', 'http://127.0.0.1:8000/users/order/summary/24', 'Your order #ORD-SW3ZPPUY has been delivered successfully.', 0, 0, '2025-10-29 07:30:57', '2025-10-29 07:30:57'),
(27, 1, 'vendor', 'You Delivered an Order #ORD-SW3ZPPUY', 'http://127.0.0.1:8000/vendors/order-summary/24', 'You have completed delivery for order #ORD-SW3ZPPUY.', 0, 0, '2025-10-29 07:30:57', '2025-10-29 07:30:57'),
(28, 1, 'user', 'Order #ORD-SW3ZPPUY Delivered', 'http://127.0.0.1:8000/users/order/summary/24', 'Your order #ORD-SW3ZPPUY has been delivered successfully.', 0, 0, '2025-10-29 07:31:15', '2025-10-29 07:31:15'),
(29, 1, 'vendor', 'You Delivered an Order #ORD-SW3ZPPUY', 'http://127.0.0.1:8000/vendors/order-summary/24', 'You have completed delivery for order #ORD-SW3ZPPUY.', 0, 0, '2025-10-29 07:31:15', '2025-10-29 07:31:15'),
(30, 1, 'user', 'Order #ORD-SW3ZPPUY Dispatched', 'http://127.0.0.1:8000/users/order/summary/24', 'Your order #ORD-SW3ZPPUY has been dispatched and is on its way.', 0, 0, '2025-10-29 07:32:03', '2025-10-29 07:32:03'),
(31, 1, 'vendor', 'You Dispatched an Order #ORD-SW3ZPPUY', 'http://127.0.0.1:8000/vendors/order-summary/24', 'You have dispatched order #ORD-SW3ZPPUY to the buyer.', 0, 0, '2025-10-29 07:32:03', '2025-10-29 07:32:03'),
(32, 1, 'user', 'Order #ORD-SW3ZPPUY Delivered', 'http://127.0.0.1:8000/users/order/summary/24', 'Your order #ORD-SW3ZPPUY has been delivered successfully.', 0, 0, '2025-10-29 07:32:07', '2025-10-29 07:32:07'),
(33, 1, 'vendor', 'You Delivered an Order #ORD-SW3ZPPUY', 'http://127.0.0.1:8000/vendors/order-summary/24', 'You have completed delivery for order #ORD-SW3ZPPUY.', 0, 0, '2025-10-29 07:32:07', '2025-10-29 07:32:07'),
(34, 1, 'vendor', '💳 New Payment Received', 'http://127.0.0.1:8000/vendors/order-summary/30', 'Dear Vendor, You\'ve received 600,000.00 for Order #ORD-LLYSUOZH', 0, 0, '2025-10-29 16:16:57', '2025-10-29 16:16:57'),
(35, NULL, 'admin', '💳 New Payment Processed', 'http://127.0.0.1:8000/admin/orders/details/30', 'Vendor DENNIS SILAS MBAGWU (ID: 1) has received ₦599,990.00 for Order #ORD-LLYSUOZH. Gross amount: ₦600,000.00, Fees: ₦10.00', 1, 0, '2025-10-29 16:16:57', '2025-10-29 16:16:57'),
(36, 1, 'vendor', '💳 New Payment Received', 'http://127.0.0.1:8000/vendors/order-summary/30', 'Dear Vendor, You\'ve received 320,000.00 for Order #ORD-LLYSUOZH', 0, 0, '2025-10-29 16:17:00', '2025-10-29 16:17:00'),
(37, NULL, 'admin', '💳 New Payment Processed', 'http://127.0.0.1:8000/admin/orders/details/30', 'Vendor DENNIS SILAS MBAGWU (ID: 1) has received ₦319,990.00 for Order #ORD-LLYSUOZH. Gross amount: ₦320,000.00, Fees: ₦10.00', 1, 0, '2025-10-29 16:17:00', '2025-10-29 16:17:00'),
(38, 3, 'user', 'Order Confirmed', 'http://127.0.0.1:8000/users/order/summary/30', ' Thank you for your order #ORD-LLYSUOZH\n                        Order Date: October 29, 2025\n                        Payment Method: paystack\n                        Amount Paid: ₦380,000.00 Your order is now being processed. You\'ll receive another notification when your items ship.', 0, 1, '2025-10-29 16:17:00', '2025-10-31 07:24:18'),
(39, 1, 'vendor', '💳 New Payment Received', 'http://127.0.0.1:8000/vendors/order-summary/31', 'Dear Vendor, You\'ve received 600,000.00 for Order #ORD-XOCU7MIG', 0, 0, '2025-10-29 16:52:43', '2025-10-29 16:52:43'),
(40, NULL, 'admin', '💳 New Payment Processed', 'http://127.0.0.1:8000/admin/orders/details/31', 'Vendor DENNIS SILAS MBAGWU (ID: 1) has received ₦599,990.00 for Order #ORD-XOCU7MIG. Gross amount: ₦600,000.00, Fees: ₦10.00', 1, 0, '2025-10-29 16:52:43', '2025-10-29 16:52:43'),
(41, 1, 'vendor', '💳 New Payment Received', 'http://127.0.0.1:8000/vendors/order-summary/31', 'Dear Vendor, You\'ve received 520.00 for Order #ORD-XOCU7MIG', 0, 0, '2025-10-29 16:52:45', '2025-10-29 16:52:45'),
(42, NULL, 'admin', '💳 New Payment Processed', 'http://127.0.0.1:8000/admin/orders/details/31', 'Vendor DENNIS SILAS MBAGWU (ID: 1) has received ₦510.00 for Order #ORD-XOCU7MIG. Gross amount: ₦520.00, Fees: ₦10.00', 1, 0, '2025-10-29 16:52:45', '2025-10-29 16:52:45'),
(43, 1, 'user', 'Order Confirmed', 'http://127.0.0.1:8000/users/order/summary/31', ' Thank you for your order #ORD-XOCU7MIG\n                        Order Date: October 29, 2025\n                        Payment Method: paystack\n                        Amount Paid: ₦300,260.00 Your order is now being processed. You\'ll receive another notification when your items ship.', 0, 0, '2025-10-29 16:52:45', '2025-10-29 16:52:45'),
(44, 1, 'vendor', '💳 New Payment Received', 'http://127.0.0.1:8000/vendors/order-summary/32', 'Dear Vendor, You\'ve received 60,000.00 for Order #ORD-ZIACTR82', 0, 0, '2025-10-29 17:00:20', '2025-10-29 17:00:20'),
(45, NULL, 'admin', '💳 New Payment Processed', 'http://127.0.0.1:8000/admin/orders/details/32', 'Vendor DENNIS SILAS MBAGWU (ID: 1) has received ₦59,990.00 for Order #ORD-ZIACTR82. Gross amount: ₦60,000.00, Fees: ₦10.00', 1, 0, '2025-10-29 17:00:20', '2025-10-29 17:00:20'),
(46, 1, 'vendor', '💳 New Payment Received', 'http://127.0.0.1:8000/vendors/order-summary/32', 'Dear Vendor, You\'ve received 650.00 for Order #ORD-ZIACTR82', 0, 0, '2025-10-29 17:00:22', '2025-10-29 17:00:22'),
(47, NULL, 'admin', '💳 New Payment Processed', 'http://127.0.0.1:8000/admin/orders/details/32', 'Vendor DENNIS SILAS MBAGWU (ID: 1) has received ₦640.00 for Order #ORD-ZIACTR82. Gross amount: ₦650.00, Fees: ₦10.00', 1, 0, '2025-10-29 17:00:22', '2025-10-29 17:00:22'),
(48, 1, 'user', 'Order Confirmed', 'http://127.0.0.1:8000/users/order/summary/32', ' Thank you for your order #ORD-ZIACTR82\n                        Order Date: October 29, 2025\n                        Payment Method: paystack\n                        Amount Paid: ₦60,650.00 Your order is now being processed. You\'ll receive another notification when your items ship.', 0, 1, '2025-10-29 17:00:22', '2025-10-29 17:13:37'),
(49, 1, 'user', 'Order #ORD-ZIACTR82 Dispatched', 'http://127.0.0.1:8000/users/order/summary/32', 'Your order #ORD-ZIACTR82 has been dispatched and is on its way.', 0, 0, '2025-10-29 17:19:21', '2025-10-29 17:19:21'),
(50, 1, 'vendor', 'You Dispatched an Order #ORD-ZIACTR82', 'http://127.0.0.1:8000/vendors/order-summary/32', 'You have dispatched order #ORD-ZIACTR82 to the buyer.', 0, 0, '2025-10-29 17:19:21', '2025-10-29 17:19:21'),
(51, 1, 'user', 'Order #ORD-ZIACTR82 Delivered', 'http://127.0.0.1:8000/users/order/summary/32', 'Your order #ORD-ZIACTR82 has been delivered successfully.', 0, 0, '2025-10-29 17:20:01', '2025-10-29 17:20:01'),
(52, 1, 'vendor', 'You Delivered an Order #ORD-ZIACTR82', 'http://127.0.0.1:8000/vendors/order-summary/32', 'You have completed delivery for order #ORD-ZIACTR82.', 0, 0, '2025-10-29 17:20:01', '2025-10-29 17:20:01'),
(53, 1, 'user', 'Order #ORD-ZIACTR82 Delivered', 'http://127.0.0.1:8000/users/order/summary/32', 'Your order #ORD-ZIACTR82 has been delivered successfully.', 0, 0, '2025-10-29 17:20:19', '2025-10-29 17:20:19'),
(54, 1, 'vendor', 'You Delivered an Order #ORD-ZIACTR82', 'http://127.0.0.1:8000/vendors/order-summary/32', 'You have completed delivery for order #ORD-ZIACTR82.', 0, 0, '2025-10-29 17:20:19', '2025-10-29 17:20:19'),
(55, 1, 'user', 'Order #ORD-ZIACTR82 Dispatched', 'http://127.0.0.1:8000/users/order/summary/32', 'Your order #ORD-ZIACTR82 has been dispatched and is on its way.', 0, 0, '2025-10-29 17:21:07', '2025-10-29 17:21:07'),
(56, 1, 'vendor', 'You Dispatched an Order #ORD-ZIACTR82', 'http://127.0.0.1:8000/vendors/order-summary/32', 'You have dispatched order #ORD-ZIACTR82 to the buyer.', 0, 0, '2025-10-29 17:21:07', '2025-10-29 17:21:07'),
(57, 1, 'user', 'Order #ORD-ZIACTR82 Delivered', 'http://127.0.0.1:8000/users/order/summary/32', 'Your order #ORD-ZIACTR82 has been delivered successfully.', 0, 0, '2025-10-29 17:21:38', '2025-10-29 17:21:38'),
(58, 1, 'vendor', 'You Delivered an Order #ORD-ZIACTR82', 'http://127.0.0.1:8000/vendors/order-summary/32', 'You have completed delivery for order #ORD-ZIACTR82.', 0, 0, '2025-10-29 17:21:38', '2025-10-29 17:21:38'),
(59, 1, 'user', 'Order #ORD-ZIACTR82 Delivered', 'http://127.0.0.1:8000/users/order/summary/32', 'Your order #ORD-ZIACTR82 has been delivered successfully.', 0, 0, '2025-10-29 17:33:50', '2025-10-29 17:33:50'),
(60, 1, 'vendor', 'You Delivered an Order #ORD-ZIACTR82', 'http://127.0.0.1:8000/vendors/order-summary/32', 'You have completed delivery for order #ORD-ZIACTR82.', 0, 0, '2025-10-29 17:33:50', '2025-10-29 17:33:50'),
(61, 1, 'user', 'Order #ORD-ZIACTR82 Delivered', 'http://127.0.0.1:8000/users/order/summary/32', 'Your order #ORD-ZIACTR82 has been delivered successfully.', 0, 0, '2025-10-29 17:34:25', '2025-10-29 17:34:25'),
(62, 1, 'vendor', 'You Delivered an Order #ORD-ZIACTR82', 'http://127.0.0.1:8000/vendors/order-summary/32', 'You have completed delivery for order #ORD-ZIACTR82.', 0, 0, '2025-10-29 17:34:25', '2025-10-29 17:34:25'),
(63, 1, 'vendor', '💳 New Payment Received', 'http://127.0.0.1:8000/vendors/order-summary/33', 'Dear Vendor, You\'ve received 70,000.00 for Order #ORD-K0MF1D53', 0, 0, '2025-10-30 19:32:30', '2025-10-30 19:32:30'),
(64, NULL, 'admin', '💳 New Payment Processed', 'http://127.0.0.1:8000/admin/orders/details/33', 'Vendor DENNIS SILAS MBAGWU (ID: 1) has received ₦69,990.00 for Order #ORD-K0MF1D53. Gross amount: ₦70,000.00, Fees: ₦10.00', 1, 0, '2025-10-30 19:32:30', '2025-10-30 19:32:30'),
(65, 1, 'user', 'Order Confirmed', 'http://127.0.0.1:8000/users/order/summary/33', ' Thank you for your order #ORD-K0MF1D53\n                        Order Date: October 30, 2025\n                        Payment Method: paystack\n                        Amount Paid: ₦70,000.00 Your order is now being processed. You\'ll receive another notification when your items ship.', 0, 0, '2025-10-30 19:32:30', '2025-10-30 19:32:30'),
(66, 1, 'user', 'Password Changed', '', 'Your account password was successfully changed on Oct 30, 2025 21:43 PM', 0, 0, '2025-10-30 20:43:20', '2025-10-30 20:43:20'),
(67, 1, 'user', 'Password Changed', '', 'Your account password was successfully changed on Oct 30, 2025 21:46 PM', 0, 0, '2025-10-30 20:46:06', '2025-10-30 20:46:06'),
(68, 1, 'user', 'Password Changed', '', 'Your account password was successfully changed on Oct 30, 2025 21:47 PM', 0, 0, '2025-10-30 20:47:36', '2025-10-30 20:47:36'),
(69, 1, 'vendor', 'New Product Review', 'http://127.0.0.1:8000/vendors/reviews', 'A customer has submitted a review for your product: ', 0, 1, '2025-10-31 07:17:38', '2025-10-31 07:17:58'),
(70, 1, 'vendor', 'New Product Review', 'http://127.0.0.1:8000/vendors/reviews', 'A customer has submitted a review for your product: Airpods', 0, 1, '2025-10-31 07:19:31', '2025-10-31 07:20:00'),
(71, 1, 'vendor', '💳 New Payment Received', 'http://127.0.0.1:8000/vendors/order-summary/34', 'Dear Vendor, You\'ve received 35,000.00 for Order #ORD-6S9CP703', 0, 0, '2025-10-31 07:38:04', '2025-10-31 07:38:04'),
(72, NULL, 'admin', '💳 New Payment Processed', 'http://127.0.0.1:8000/admin/orders/details/34', 'Vendor DENNIS SILAS MBAGWU (ID: 1) has received ₦34,990.00 for Order #ORD-6S9CP703. Gross amount: ₦35,000.00, Fees: ₦10.00', 1, 0, '2025-10-31 07:38:04', '2025-10-31 07:38:04'),
(73, 3, 'user', 'Order Confirmed', 'http://127.0.0.1:8000/users/order/summary/34', ' Thank you for your order #ORD-6S9CP703\n                        Order Date: October 31, 2025\n                        Payment Method: paystack\n                        Amount Paid: ₦35,000.00 Your order is now being processed. You\'ll receive another notification when your items ship.', 0, 0, '2025-10-31 07:38:04', '2025-10-31 07:38:04'),
(74, 1, 'vendor', 'New Product Review', 'http://127.0.0.1:8000/vendors/reviews', 'A customer has submitted a review for your product: Airpods', 0, 0, '2025-10-31 07:39:17', '2025-10-31 07:39:17'),
(75, 1, 'vendor', 'New Product Review', 'http://127.0.0.1:8000/vendors/reviews', 'A customer has submitted a review for your product: Bags', 0, 0, '2025-10-31 13:37:39', '2025-10-31 13:37:39'),
(76, 1, 'vendor', 'New Product Review', 'http://127.0.0.1:8000/vendors/reviews', 'A customer has submitted a review for your product: Bags', 0, 0, '2025-10-31 13:37:41', '2025-10-31 13:37:41'),
(77, 1, 'vendor', 'New Product Review', 'http://127.0.0.1:8000/vendors/reviews', 'A customer has submitted a review for your product: Sneakers', 0, 0, '2025-10-31 13:38:21', '2025-10-31 13:38:21');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_no` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_amount` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `shipping_id` tinyint(4) DEFAULT 1,
  `shipping_amount` varchar(255) DEFAULT '0',
  `total_amount` varchar(255) DEFAULT '0',
  `payment_method` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0 COMMENT '0 => Canceled, 1 => Processing, 2 => In progress, 3 => Completed',
  `is_payment` tinyint(4) DEFAULT 0 COMMENT '0 => false, 1 => true',
  `payment_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payment_data`)),
  `is_delete` tinyint(4) DEFAULT 0 COMMENT '0 => false, 1 => true',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_no`, `transaction_id`, `reference`, `user_id`, `name`, `email`, `phone`, `coupon_code`, `coupon_amount`, `address`, `state`, `city`, `country`, `shipping_id`, `shipping_amount`, `total_amount`, `payment_method`, `status`, `is_payment`, `payment_data`, `is_delete`, `created_at`, `updated_at`) VALUES
(32, 'ORD-ZIACTR82', '5479269309', 'paystack_690248114512a', 1, 'Silas Dennis', 'martindennis10@gmail.com', '08102678284', NULL, NULL, '12 Emmanuel street', 'Cross River', 'Calabar', 'NIgeria', 1, '0', '60650.00', 'paystack', 3, 1, '{\"product_value\":\"60650.00\",\"paystack_percentage_fee\":\"959\",\"paystack_fixed_fee\":\"100\",\"platform_fee\":\"959\",\"total_fees\":\"62569.5\"}', 0, '2025-10-29 16:59:55', '2025-10-29 17:00:18'),
(33, 'ORD-K0MF1D53', '5483032134', 'paystack_6903bd2564d36', 1, 'Marcus Rasford', 'martindennis10@gmail.com', '08102678284', NULL, NULL, '10 Ilipeju ave', 'Edo', 'Benin City', 'NIgeria', 1, '0', '70000.00', 'paystack', 3, 1, '{\"product_value\":\"70000.00\",\"paystack_percentage_fee\":\"1050\",\"paystack_fixed_fee\":\"100\",\"platform_fee\":\"1050\",\"total_fees\":\"72200\"}', 0, '2025-10-30 19:31:29', '2025-10-30 19:32:25'),
(34, 'ORD-6S9CP703', '5484294988', 'paystack_690467478ea48', 3, 'Anthony Alfred', 'alfred@gmail.com', '+17075224321', NULL, NULL, 'Park Boulevard IIB 3720 S Dearborn St, Chicago, IL 60609', 'Abia', 'illinois', 'NIgeria', 1, '0', '35000.00', 'paystack', 3, 1, '{\"product_value\":\"35000.00\",\"paystack_percentage_fee\":\"525\",\"paystack_fixed_fee\":\"100\",\"platform_fee\":\"525\",\"total_fees\":\"36150\"}', 0, '2025-10-31 07:37:29', '2025-10-31 07:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) DEFAULT NULL,
  `cart_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `price` varchar(255) DEFAULT '0',
  `quantity` varchar(255) DEFAULT '0',
  `color_name` varchar(255) DEFAULT NULL,
  `size_name` varchar(255) DEFAULT NULL,
  `size_amount` varchar(255) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `cart_id`, `product_id`, `price`, `quantity`, `color_name`, `size_name`, `size_amount`, `total_price`, `created_at`, `updated_at`) VALUES
(43, 32, 16, 5, '20000', '3', 'Black', '', '0', '60000', '2025-10-29 16:59:55', '2025-10-29 16:59:55'),
(44, 32, 16, 6, '130', '5', 'Yellow', 'Large', '30.00', '650', '2025-10-29 16:59:55', '2025-10-29 16:59:55'),
(45, 33, 17, 4, '35000', '2', 'Black', '', '0', '70000', '2025-10-30 19:31:29', '2025-10-30 19:31:29'),
(46, 34, 18, 4, '35000', '1', 'Yellow', '', '0', '35000', '2025-10-31 07:37:29', '2025-10-31 07:37:29');

-- --------------------------------------------------------

--
-- Table structure for table `order_trackings`
--

CREATE TABLE `order_trackings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(4) DEFAULT 1 COMMENT '0 = Canceled, 1 = Placed, 2 = Dispatched, 3 = Completed',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_trackings`
--

INSERT INTO `order_trackings` (`id`, `order_id`, `product_id`, `status`, `created_at`, `updated_at`) VALUES
(31, 32, 5, 1, '2025-10-29 17:00:18', '2025-10-29 17:00:18'),
(32, 32, 6, 1, '2025-10-29 17:00:20', '2025-10-29 17:00:20'),
(33, 32, 5, 2, '2025-10-29 17:19:21', '2025-10-29 17:19:21'),
(36, 32, 6, 2, '2025-10-29 17:21:06', '2025-10-29 17:21:06'),
(38, 32, 6, 3, '2025-10-29 17:33:50', '2025-10-29 17:33:50'),
(39, 32, 5, 3, '2025-10-29 17:34:24', '2025-10-29 17:34:24'),
(40, 33, 4, 1, '2025-10-30 19:32:25', '2025-10-30 19:32:25'),
(41, 34, 4, 1, '2025-10-31 07:38:02', '2025-10-31 07:38:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_otps`
--

CREATE TABLE `password_otps` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `expires_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_otps`
--

INSERT INTO `password_otps` (`id`, `email`, `otp`, `expires_at`, `created_at`, `updated_at`) VALUES
(3, 'micheal@gmail.com', '754210', '2025-10-15 12:11:29', '2025-10-15 12:10:29', '2025-10-15 12:10:29');

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
-- Table structure for table `platform_earnings`
--

CREATE TABLE `platform_earnings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `platform_earnings`
--

INSERT INTO `platform_earnings` (`id`, `order_id`, `amount`, `transaction_id`, `created_at`, `updated_at`) VALUES
(23, 32, 10.00, '5479269309', '2025-10-29 17:00:20', '2025-10-29 17:00:20'),
(24, 32, 10.00, '5479269309', '2025-10-29 17:00:22', '2025-10-29 17:00:22'),
(25, 33, 10.00, '5483032134', '2025-10-30 19:32:30', '2025-10-30 19:32:30'),
(26, 34, 10.00, '5484294988', '2025-10-31 07:38:04', '2025-10-31 07:38:04');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `old_price` double DEFAULT 0,
  `new_price` double DEFAULT 0,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `description` longtext DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `product_owner` varchar(255) DEFAULT NULL COMMENT 'admin or vendor',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1-active,0-inactive',
  `isdelete` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1-deleted,0-not deleted',
  `isFeatured` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `title`, `vendor_id`, `admin_id`, `category_id`, `sku`, `old_price`, `new_price`, `stock_quantity`, `description`, `unit`, `location`, `city`, `tags`, `product_owner`, `status`, `isdelete`, `isFeatured`, `created_at`, `updated_at`) VALUES
(1, 'Samsung A20', 'Samsung A20', 1, NULL, 10, NULL, 0, 250, 10, '', 'Box', 'Abia', 'Umahia', '[]', 'Vendor', 1, 0, 0, '2025-10-13 17:21:44', '2025-10-27 17:02:29'),
(2, 'Poultry Natural Feed', 'Poultry Natural Feed', 1, NULL, 12, NULL, 0, 10500, 15, 'Poultry FEed', 'bag', 'Lagos', 'Ikeja', '[\"feed\",\"agric product\",\"poultry\",\"birds\",\"livestock\"]', 'Vendor', 1, 0, 0, '2025-10-13 17:22:50', '2025-10-15 03:42:50'),
(3, 'Bevesege Pack', 'Bevesege Pack', 1, NULL, 5, NULL, 180000, 150000, 30, 'beverages pack', 'carton', 'Benue', 'Makuurdi', '[\"beverages\",\"bonvita\",\"milo\",\"milk\"]', 'Vendor', 1, 0, 0, '2025-10-13 17:29:06', '2025-10-15 03:39:40'),
(4, 'Airpods', 'Airpods', 1, NULL, 10, NULL, 45000, 35000, 20, 'airpod description', 'Box', 'Edo', 'Benin', '[\"Airpod\",\"Apple earphones\",\"earphone\"]', 'Vendor', 1, 0, 0, '2025-10-14 09:24:09', '2025-10-15 03:37:32'),
(5, 'Bags', 'Bags', 1, NULL, 1, NULL, 0, 20000, 5, 'Some description oo', 'bag', 'Cross River', 'Lagos', '[\"bags\",\"bagpacks\"]', 'Vendor', 1, 0, 0, '2025-10-14 11:33:54', '2025-10-15 03:35:22'),
(6, 'Sneakers', 'Sneakers', 1, NULL, 1, 'SNE-LR0BOYUF', 400, 100, 10, 'description gain', 'Box', 'Adamawa', 'Lagos', '[\"wear\",\"shoes\",\"addidas\"]', 'Vendor', 1, 0, 0, '2025-10-14 11:34:45', '2025-10-14 11:50:49');

-- --------------------------------------------------------

--
-- Table structure for table `product_colors`
--

CREATE TABLE `product_colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `color_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_colors`
--

INSERT INTO `product_colors` (`id`, `product_id`, `color_id`, `created_at`, `updated_at`) VALUES
(7, 6, 4, '2025-10-14 11:54:19', '2025-10-14 11:54:19'),
(8, 6, 3, '2025-10-14 11:54:19', '2025-10-14 11:54:19'),
(11, 5, 1, '2025-10-15 03:35:23', '2025-10-15 03:35:23'),
(12, 5, 2, '2025-10-15 03:35:27', '2025-10-15 03:35:27'),
(18, 4, 1, '2025-10-15 08:51:45', '2025-10-15 08:51:45'),
(19, 4, 3, '2025-10-15 08:51:45', '2025-10-15 08:51:45'),
(22, 2, 2, '2025-10-17 13:35:28', '2025-10-17 13:35:28'),
(23, 2, 3, '2025-10-17 13:35:28', '2025-10-17 13:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_extension` varchar(255) DEFAULT NULL,
  `order_by` int(11) DEFAULT 100,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_name`, `image`, `image_extension`, `order_by`, `created_at`, `updated_at`) VALUES
(2, 6, 'uploads/products/1845961907068622.png', 'uploads/products/1845961907068622.png', 'png', 100, '2025-10-14 11:54:19', '2025-10-14 11:54:19'),
(4, 6, 'uploads/products/1845961907251948.png', 'uploads/products/1845961907251948.png', 'png', 100, '2025-10-14 11:54:20', '2025-10-14 11:54:20'),
(5, 5, 'uploads/products/1846021119958956.jpg', 'uploads/products/1846021119958956.jpg', 'jpg', 100, '2025-10-15 03:35:40', '2025-10-15 03:35:40'),
(6, 5, 'uploads/products/1846021131021868.jpg', 'uploads/products/1846021131021868.jpg', 'jpg', 100, '2025-10-15 03:35:40', '2025-10-15 03:35:40'),
(7, 4, 'uploads/products/1846021250006242.jpg', 'uploads/products/1846021250006242.jpg', 'jpg', 100, '2025-10-15 03:37:33', '2025-10-15 03:37:33'),
(8, 4, 'uploads/products/1846021251135227.jpg', 'uploads/products/1846021251135227.jpg', 'jpg', 100, '2025-10-15 03:37:34', '2025-10-15 03:37:34'),
(9, 4, 'uploads/products/1846021252381546.jpg', 'uploads/products/1846021252381546.jpg', 'jpg', 100, '2025-10-15 03:37:36', '2025-10-15 03:37:36'),
(10, 4, 'uploads/products/1846021254331412.jpg', 'uploads/products/1846021254331412.jpg', 'jpg', 100, '2025-10-15 03:37:37', '2025-10-15 03:37:37'),
(11, 3, 'uploads/products/1846021383541218.jpg', 'uploads/products/1846021383541218.jpg', 'jpg', 100, '2025-10-15 03:39:41', '2025-10-15 03:39:41'),
(12, 3, 'uploads/products/1846021383668864.jpg', 'uploads/products/1846021383668864.jpg', 'jpg', 100, '2025-10-15 03:39:41', '2025-10-15 03:39:41'),
(13, 3, 'uploads/products/1846021383710460.jpg', 'uploads/products/1846021383710460.jpg', 'jpg', 100, '2025-10-15 03:39:41', '2025-10-15 03:39:41'),
(14, 3, 'uploads/products/1846021383751380.jpg', 'uploads/products/1846021383751380.jpg', 'jpg', 100, '2025-10-15 03:39:41', '2025-10-15 03:39:41'),
(20, 2, 'uploads/products/1846240061307804.jpg', 'uploads/products/1846240061307804.jpg', 'jpg', 100, '2025-10-17 13:35:28', '2025-10-17 13:35:28'),
(21, 1, 'uploads/products/1846246448095853.jpg', 'uploads/products/1846246448095853.jpg', 'jpg', 100, '2025-10-17 15:16:59', '2025-10-17 15:16:59'),
(22, 1, 'uploads/products/1846246448254873.jpg', 'uploads/products/1846246448254873.jpg', 'jpg', 100, '2025-10-17 15:16:59', '2025-10-17 15:16:59');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 0,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `user_id`, `order_id`, `rating`, `review`, `created_at`, `updated_at`) VALUES
(4, 4, 1, 33, 3, 'Not bad for an airpod of this price', '2025-10-31 07:19:31', '2025-10-31 07:19:31'),
(5, 4, 3, 34, 4, 'This is good', '2025-10-31 07:39:17', '2025-10-31 07:39:17'),
(6, 5, 1, 32, 5, 'Excellent Bag, It is comfy', '2025-10-31 13:37:39', '2025-10-31 13:37:39'),
(7, 6, 1, 32, 3, 'I searched sneakers and we still a cloth picture', '2025-10-31 13:38:21', '2025-10-31 13:38:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_sizes`
--

CREATE TABLE `product_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sizes`
--

INSERT INTO `product_sizes` (`id`, `product_id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(10, 6, 'Small', 10.00, '2025-10-14 11:54:19', '2025-10-14 11:54:19'),
(11, 6, 'Medium', 20.00, '2025-10-14 11:54:19', '2025-10-14 11:54:19'),
(12, 6, 'Large', 30.00, '2025-10-14 11:54:19', '2025-10-14 11:54:19'),
(22, 2, 'small', 0.00, '2025-10-17 13:35:28', '2025-10-17 13:35:28'),
(23, 2, 'medium', 5000.00, '2025-10-17 13:35:28', '2025-10-17 13:35:28'),
(24, 2, 'large', 12000.00, '2025-10-17 13:35:28', '2025-10-17 13:35:28');

-- --------------------------------------------------------

--
-- Table structure for table `product_wishlists`
--

CREATE TABLE `product_wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_wishlists`
--

INSERT INTO `product_wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(59, 2, 3, '2025-10-22 05:52:55', '2025-10-22 05:52:55');

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
('m2Pj6Cz7QIAwP9k8zI8igBm0YNVTztKkNQBDPtdT', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:144.0) Gecko/20100101 Firefox/144.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZHd3Qm0xYUFEVG56SlQ1Mkgxcnk1UVVaVW9ndjFmYUpxVG95TUpQZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91c2Vycy9mZXRjaC9yZXZpZXdzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1761917902),
('sIQxeOoCXk17ayfcLOWExRGpVzcbjRIoDqAI24Se', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMzRXRHY4V0g4OGltT09SM2JvdW5qS2RKZDlGRUc4RVFRU1dYM1NKeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0LWRldGFpbHMvNS9CYWdzLzEvYmVhdXR5LWFuZC1wZXJzb25hbC1jYXJlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1761920269);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_addresses`
--

CREATE TABLE `shipping_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_addresses`
--

INSERT INTO `shipping_addresses` (`id`, `user_id`, `name`, `email`, `phone`, `address`, `city`, `state`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 1, 'Marcus Rasford', 'martindennis10@gmail.com', '08102678284', '10 Ilipeju ave', 'Benin City', 'Edo', 'NIgeria', 1, '2025-10-23 08:26:11', '2025-10-30 19:31:29'),
(2, 3, 'Anthony Alfred', 'alfred@gmail.com', '+17075224321', 'Park Boulevard IIB 3720 S Dearborn St, Chicago, IL 60609', 'illinois', 'Abia', 'NIgeria', 1, '2025-10-29 05:28:00', '2025-10-29 05:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `description` mediumtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `user_id`, `topic`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Delivery', 'User', 'Delivery not coming in at stipulated time', '2025-10-30 22:03:41', '2025-10-30 22:03:41'),
(2, 1, 'User Experience', 'User', 'I dont quite understand this', '2025-10-30 22:06:00', '2025-10-30 22:06:00'),
(3, 1, 'Technical', 'User', 'I cant seem to login', '2025-10-30 22:13:30', '2025-10-30 22:13:30');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit` varchar(255) NOT NULL COMMENT 'kg,g,pc',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit`, `created_at`, `updated_at`) VALUES
(1, 'pc', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(2, 'Box', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(3, 'pair', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(4, 'bag', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(5, 'cm', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(6, 'dz', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(7, 'ft', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(8, 'g', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(9, 'in', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(10, 'kg', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(11, 'km', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(12, 'mg', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(13, 'yard', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(14, 'portion', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(15, 'bowl', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(16, 'carton', '2025-10-13 20:03:23', '2025-10-13 20:03:23'),
(17, 'bottle', '2025-10-13 20:03:23', '2025-10-13 20:03:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gender` longtext DEFAULT NULL,
  `preference` varchar(255) DEFAULT NULL,
  `last_online` timestamp NULL DEFAULT NULL,
  `isbanned` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `google_id`, `username`, `firstname`, `lastname`, `email_verified_at`, `password`, `phone`, `image`, `gender`, `preference`, `last_online`, `isbanned`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'micheal@gmail.com', NULL, 'Mic01', 'Micheal', 'Martinez', NULL, '$2y$12$M.9Y0EnyEM2QKWH3NuKgUOtFywCOWjWOAG2pD/GXD4gFnSvY60Y22', '+23455982850', 'uploads/users/1761642825.jpg', 'male', NULL, NULL, 0, NULL, '2025-10-15 01:45:47', '2025-10-30 20:47:35'),
(2, 'martindennis10@gmail.com', NULL, 'Silas010', NULL, NULL, NULL, '$2y$12$FK2lkE47SN.ZPwxP0kSH0e0rsrFvfM9S0D9fMBUZ56pG0ekRyBTKm', NULL, NULL, NULL, NULL, NULL, 0, NULL, '2025-10-22 05:50:34', '2025-10-22 05:50:34'),
(3, 'jordan@gmail.com', NULL, 'Jordan', 'Jordan', 'Keny', NULL, '$2y$12$0d73a3pmO4qqaSs.O4tiiuTWrW.Le3ExcihvZ9orQILvv2nAXAn8S', '08055841410', 'uploads/users/1761715448.jpg', 'male', NULL, NULL, 0, NULL, '2025-10-29 05:23:04', '2025-10-29 05:24:08');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gender` longtext DEFAULT NULL,
  `preference` varchar(255) DEFAULT NULL,
  `last_online` timestamp NULL DEFAULT NULL,
  `isbanned` tinyint(1) NOT NULL DEFAULT 0,
  `about` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `email`, `google_id`, `username`, `firstname`, `lastname`, `email_verified_at`, `password`, `phone`, `image`, `gender`, `preference`, `last_online`, `isbanned`, `about`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'claudio@gmail.com', NULL, NULL, 'Claudio', 'Martinez', NULL, '$2y$12$RfPQFHJvhMO5A/4./XaA/eDS07zow/KZGLQkewYeXdno4V19w.Z3G', '+23455982850', 'uploads/vendor-profile/1847247841777776.png', 'male', NULL, NULL, 0, '4', NULL, '2025-10-11 09:10:11', '2025-10-28 17:33:51');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_payouts`
--

CREATE TABLE `vendor_payouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `gross_amount` varchar(255) DEFAULT NULL,
  `fee_amount` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `paystack_transfer_id` varchar(255) DEFAULT NULL,
  `transfer_reference` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Failed',
  `paystack_response` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_payouts`
--

INSERT INTO `vendor_payouts` (`id`, `vendor_id`, `order_id`, `product_id`, `gross_amount`, `fee_amount`, `amount`, `paystack_transfer_id`, `transfer_reference`, `status`, `paystack_response`, `created_at`, `updated_at`) VALUES
(23, 1, 32, 5, '60000', '10', 59990.00, '906874513', 'ohgb9egtvyboc06xg8cd', 'success', '{\n    \"transfersessionid\": [],\n    \"transfertrials\": [],\n    \"domain\": \"test\",\n    \"amount\": 5999000,\n    \"currency\": \"NGN\",\n    \"reference\": \"ohgb9egtvyboc06xg8cd\",\n    \"source\": \"balance\",\n    \"source_details\": null,\n    \"reason\": \"Vendor payment for Order #ORD-ZIACTR82\",\n    \"status\": \"success\",\n    \"failures\": null,\n    \"transfer_code\": \"TRF_321gafnaq5tjquzw\",\n    \"titan_code\": null,\n    \"transferred_at\": null,\n    \"id\": 906874513,\n    \"integration\": 1087563,\n    \"request\": 1136484659,\n    \"recipient\": 101376738,\n    \"createdAt\": \"2025-10-29T17:00:18.000Z\",\n    \"updatedAt\": \"2025-10-29T17:00:18.000Z\",\n    \"recipient_details\": {\n        \"bank_name\": \"OPay Digital Services Limited (OPay)\",\n        \"account_number\": \"8102678284\",\n        \"account_name\": \"DENNIS SILAS MBAGWU\"\n    }\n}', '2025-10-29 17:00:20', '2025-10-29 17:00:20'),
(24, 1, 32, 6, '650', '10', 640.00, '906874530', 'vc5mcqzxhv2mlsldd1pr', 'success', '{\n    \"transfersessionid\": [],\n    \"transfertrials\": [],\n    \"domain\": \"test\",\n    \"amount\": 64000,\n    \"currency\": \"NGN\",\n    \"reference\": \"vc5mcqzxhv2mlsldd1pr\",\n    \"source\": \"balance\",\n    \"source_details\": null,\n    \"reason\": \"Vendor payment for Order #ORD-ZIACTR82\",\n    \"status\": \"success\",\n    \"failures\": null,\n    \"transfer_code\": \"TRF_5xl6j63vhb78kn3l\",\n    \"titan_code\": null,\n    \"transferred_at\": null,\n    \"id\": 906874530,\n    \"integration\": 1087563,\n    \"request\": 1136484673,\n    \"recipient\": 101376738,\n    \"createdAt\": \"2025-10-29T17:00:21.000Z\",\n    \"updatedAt\": \"2025-10-29T17:00:21.000Z\",\n    \"recipient_details\": {\n        \"bank_name\": \"OPay Digital Services Limited (OPay)\",\n        \"account_number\": \"8102678284\",\n        \"account_name\": \"DENNIS SILAS MBAGWU\"\n    }\n}', '2025-10-29 17:00:22', '2025-10-29 17:00:22'),
(25, 1, 33, 4, '70000', '10', 69990.00, '907410101', 'kh3f5ow7bzcxttye0fj5', 'success', '{\n    \"transfersessionid\": [],\n    \"transfertrials\": [],\n    \"domain\": \"test\",\n    \"amount\": 6999000,\n    \"currency\": \"NGN\",\n    \"reference\": \"kh3f5ow7bzcxttye0fj5\",\n    \"source\": \"balance\",\n    \"source_details\": null,\n    \"reason\": \"Vendor payment for Order #ORD-K0MF1D53\",\n    \"status\": \"success\",\n    \"failures\": null,\n    \"transfer_code\": \"TRF_u2unw96fl294d518\",\n    \"titan_code\": null,\n    \"transferred_at\": null,\n    \"id\": 907410101,\n    \"integration\": 1087563,\n    \"request\": 1137227474,\n    \"recipient\": 101376738,\n    \"createdAt\": \"2025-10-30T19:32:26.000Z\",\n    \"updatedAt\": \"2025-10-30T19:32:26.000Z\",\n    \"recipient_details\": {\n        \"bank_name\": \"OPay Digital Services Limited (OPay)\",\n        \"account_number\": \"8102678284\",\n        \"account_name\": \"DENNIS SILAS MBAGWU\"\n    }\n}', '2025-10-30 19:32:30', '2025-10-30 19:32:30'),
(26, 1, 34, 4, '35000', '10', 34990.00, '907560431', 'drdlk8pioz7pmgx5m-e3', 'success', '{\n    \"transfersessionid\": [],\n    \"transfertrials\": [],\n    \"domain\": \"test\",\n    \"amount\": 3499000,\n    \"currency\": \"NGN\",\n    \"reference\": \"drdlk8pioz7pmgx5m-e3\",\n    \"source\": \"balance\",\n    \"source_details\": null,\n    \"reason\": \"Vendor payment for Order #ORD-6S9CP703\",\n    \"status\": \"success\",\n    \"failures\": null,\n    \"transfer_code\": \"TRF_2l32buf7ib2c5sru\",\n    \"titan_code\": null,\n    \"transferred_at\": null,\n    \"id\": 907560431,\n    \"integration\": 1087563,\n    \"request\": 1137526414,\n    \"recipient\": 101376738,\n    \"createdAt\": \"2025-10-31T07:38:03.000Z\",\n    \"updatedAt\": \"2025-10-31T07:38:03.000Z\",\n    \"recipient_details\": {\n        \"bank_name\": \"OPay Digital Services Limited (OPay)\",\n        \"account_number\": \"8102678284\",\n        \"account_name\": \"DENNIS SILAS MBAGWU\"\n    }\n}', '2025-10-31 07:38:04', '2025-10-31 07:38:04');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_verifications`
--

CREATE TABLE `vendor_verifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `question` varchar(255) DEFAULT NULL,
  `cac` text DEFAULT NULL,
  `nin` text DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `web_url` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=pending, 1=approved, 2=rejected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_verifications`
--

INSERT INTO `vendor_verifications` (`id`, `vendor_id`, `name`, `question`, `cac`, `nin`, `video_url`, `web_url`, `address`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '1', 'uploads/vendor_docs/cac/1845679913924019.png', 'uploads/vendor_docs/nin/1845679913912879.png', 'https://chatgpt.com/c/68e77e7d-917c-8332-93a9-31fde0643e03', NULL, NULL, NULL, 1, '2025-10-11 09:12:10', '2025-10-11 09:12:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_details_vendor_id_foreign` (`vendor_id`);

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_ud_foreign` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_user_id_foreign` (`user_id`);

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
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_trackings`
--
ALTER TABLE `order_trackings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_otps`
--
ALTER TABLE `password_otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `platform_earnings`
--
ALTER TABLE `platform_earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_vendor_id_foreign` (`vendor_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_colors_product_id_foreign` (`product_id`),
  ADD KEY `product_colors_color_id_foreign` (`color_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_reviews_product_id_foreign` (`product_id`),
  ADD KEY `product_reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_sizes_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_wishlists`
--
ALTER TABLE `product_wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_wishlists_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shipping_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vendors_email_unique` (`email`);

--
-- Indexes for table `vendor_payouts`
--
ALTER TABLE `vendor_payouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor_verifications`
--
ALTER TABLE `vendor_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_verifications_vendor_id_foreign` (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bank_details`
--
ALTER TABLE `bank_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `order_trackings`
--
ALTER TABLE `order_trackings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `password_otps`
--
ALTER TABLE `password_otps`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `platform_earnings`
--
ALTER TABLE `platform_earnings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_colors`
--
ALTER TABLE `product_colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_wishlists`
--
ALTER TABLE `product_wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendor_payouts`
--
ALTER TABLE `vendor_payouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `vendor_verifications`
--
ALTER TABLE `vendor_verifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank_details`
--
ALTER TABLE `bank_details`
  ADD CONSTRAINT `bank_details_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_ud_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `vendors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_colors`
--
ALTER TABLE `product_colors`
  ADD CONSTRAINT `product_colors_color_id_foreign` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_colors_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_wishlists`
--
ALTER TABLE `product_wishlists`
  ADD CONSTRAINT `product_wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shipping_addresses`
--
ALTER TABLE `shipping_addresses`
  ADD CONSTRAINT `shipping_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vendor_verifications`
--
ALTER TABLE `vendor_verifications`
  ADD CONSTRAINT `vendor_verifications_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `vendors` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
