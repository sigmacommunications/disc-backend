-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 21, 2026 at 03:35 PM
-- Server version: 10.3.39-MariaDB
-- PHP Version: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spotify`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_date` date DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `artist_id`, `title`, `release_date`, `cover_image`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nulla eum molestias', '1992-07-02', 'albums/cover_images/L2U7787iy3P4jVgL7jyWIYj3W30GB772k2v455fR.png', '2024-12-04 17:32:35', '2024-12-04 17:32:35'),
(2, 1, 'Dangerous', '2024-12-12', 'albums/cover_images/F0oiUNT0QVH5BJofE0McNOU1Ozj82i2vqmQJAHul.jpg', '2024-12-10 18:31:57', '2024-12-10 18:31:57'),
(3, 1, 'Dangerous 2024', '2024-12-11', 'albums/cover_images/5pcI34rz473iSS2XmCAeD2cqzCHQj2qiV1ybu1GM.jpg', '2024-12-10 19:19:16', '2024-12-10 19:19:16'),
(4, 1, 'Herman Spira', '2025-05-07', 'albums/cover_images/GToeRrA057ZkwvVqQ26KH7pn0Iv2JrbYMkQLeyQT.jpg', '2025-06-25 19:10:06', '2025-06-25 19:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `bio` text DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `user_id`, `bio`, `twitter`, `instagram`, `facebook`, `created_at`, `updated_at`) VALUES
(1, 3, 'Exercitation dolores', 'Optio vitae blandit', 'Laboris assumenda vo', 'Lorem reprehenderit', '2024-11-19 15:42:00', '2024-11-19 15:42:00');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 'wwwwwwwwww', 'wwwwwwwwwwwwwwwwwwww', 'blog-1_images/1745619318.jpg', '2025-04-25 22:15:18', '2025-04-25 22:15:18');

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
  `merch_item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `printify_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `merch_item_id`, `quantity`, `printify_data`, `created_at`, `updated_at`) VALUES
(3, 2, 11, 1, NULL, '2025-06-19 19:04:54', '2025-06-19 19:04:54'),
(4, 1, 11, 1, NULL, '2025-11-04 14:13:55', '2025-11-04 14:13:55'),
(5, 1, 3, 1, '{\"external_id\":\"f94e2947-180a-4245-a83b-4894bcf31484\",\"line_items\":[{\"product_id\":\"6824c03604479021a2045a00\",\"print_provider_id\":99,\"blueprint_id\":145,\"variant_id\":\"63300\",\"print_areas\":[{\"position\":\"neck\",\"images\":[{\"id\":\"5941187eb8e7e37b3f0e62e5\",\"name\":\"text_layer.svg\",\"type\":\"text\\/plain\",\"height\":100,\"width\":100,\"x\":0.5,\"y\":0.5,\"scale\":1,\"angle\":0,\"font_family\":\"\",\"font_size\":0,\"font_weight\":0,\"font_color\":\"\",\"font_style\":\"normal\",\"input_text\":\"\",\"text_align\":\"left\"}],\"decoration_method\":\"dtf\"},{\"position\":\"front\",\"images\":[{\"id\":\"6824bd0416457c95c8473c56\",\"name\":\"imgpsh_fullsize_anim.png\",\"type\":\"image\\/png\",\"height\":1080,\"width\":1920,\"x\":0.5000000000000004,\"y\":0.5000000000000001,\"scale\":2.1057851073739093,\"angle\":0,\"src\":\"https:\\/\\/pfy-prod-image-storage.s3.us-east-2.amazonaws.com\\/22935765\\/a2a06067-29e5-471e-bb22-6dca96b20665\"}],\"decoration_method\":\"dtg\"},{\"position\":\"back\",\"images\":[],\"decoration_method\":\"dtg\"}]}],\"shipping_method\":1,\"send_shipping_notification\":true}', '2025-11-04 14:43:11', '2025-11-04 14:43:11'),
(6, 1, 20, 1, '{\"external_id\":\"93ac4b9e-cc4d-4342-9688-d229efd0c0c9\",\"line_items\":[{\"product_id\":\"68543377457b9bc9a4053a53\",\"print_provider_id\":10,\"blueprint_id\":243,\"variant_id\":\"41694\",\"print_areas\":[{\"position\":\"front\",\"images\":[{\"id\":\"ce876a4e-742e-cbe7-d731-ba3e315ba6c2\",\"name\":\"\",\"type\":\"text\\/svg\",\"height\":1,\"width\":1,\"x\":0.46292803619949346,\"y\":0.4909395641428574,\"scale\":1.6379284628291695,\"angle\":270,\"font_family\":\"Rubik Spray Paint\",\"font_size\":200,\"font_weight\":400,\"font_color\":\"#000000\",\"font_style\":\"normal\",\"input_text\":\"NEW\",\"text_align\":\"center\"}],\"decoration_method\":\"dye-sublimation\"}]}],\"shipping_method\":1,\"send_shipping_notification\":true}', '2025-11-04 14:47:12', '2025-11-04 14:47:12');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `artist_response` text DEFAULT NULL,
  `responded_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `artist_id`, `created_by`, `title`, `description`, `status`, `artist_response`, `responded_at`, `created_at`, `updated_at`) VALUES
(1, '1', '1', 'Pariatur Dolor opti', 'Aut incidunt rerum', 'resolved', 'Recusandae Suscipit', '2024-12-10 19:16:21', '2024-12-10 19:14:44', '2025-01-30 22:03:48'),
(2, '1', '1', 'abuse language', 'its resolved', 'resolved', 'nio its dummy', '2025-04-25 22:07:43', '2025-04-25 22:06:50', '2025-04-25 22:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` varchar(255) NOT NULL,
  `contract_name` varchar(255) NOT NULL,
  `contract_details` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `artist_id`, `contract_name`, `contract_details`, `start_date`, `end_date`, `file_path`, `created_at`, `updated_at`) VALUES
(1, '1', 'dummy contract', 'asdsfsdgdfgd', '2025-04-25', '2026-08-07', 'contracts/0MaKvEujEKHkvvVb6VbJ5peWP6iTucYN2ORoilOi.docx', '2025-04-25 22:05:28', '2025-04-25 22:05:28');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `event_date` datetime NOT NULL,
  `ticket_link` varchar(255) DEFAULT NULL,
  `promotional_details` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `artist_id`, `title`, `image`, `event_date`, `ticket_link`, `promotional_details`, `created_at`, `updated_at`) VALUES
(1, 1, 'Concert', NULL, '2024-12-10 00:00:00', NULL, NULL, '2024-12-10 18:30:41', '2024-12-10 18:30:41'),
(2, 1, 'Christmas Concert', NULL, '2024-12-10 00:36:00', 'https://www.facebook.com/', 'Voluptatem Sed ipsu', '2024-12-10 19:17:32', '2024-12-10 19:18:26');

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
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Pop', '2024-11-19 15:41:27', '2024-11-19 15:41:27'),
(2, 'Rock', '2024-11-19 15:41:27', '2024-11-19 15:41:27'),
(3, 'Hip-Hop', '2024-11-19 15:41:28', '2024-11-19 15:41:28'),
(4, 'Jazz', '2024-11-19 15:41:28', '2024-11-19 15:41:28'),
(5, 'Classical', '2024-11-19 15:41:28', '2024-11-19 15:41:28'),
(6, 'Electronic', '2024-11-19 15:41:28', '2024-11-19 15:41:28'),
(7, 'Country', '2024-11-19 15:41:28', '2024-11-19 15:41:28'),
(8, 'R&B', '2024-11-19 15:41:28', '2024-11-19 15:41:28'),
(9, 'Reggae', '2024-11-19 15:41:28', '2024-11-19 15:41:28'),
(10, 'Blues', '2024-11-19 15:41:28', '2024-11-19 15:41:28'),
(11, 'Bertel', '2024-12-10 19:21:04', '2024-12-10 19:21:04');

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
-- Table structure for table `liked_songs`
--

CREATE TABLE `liked_songs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `track_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `liked_songs`
--

INSERT INTO `liked_songs` (`id`, `user_id`, `track_id`, `created_at`, `updated_at`) VALUES
(2, 2, 4, '2025-04-07 19:44:49', '2025-04-07 19:44:49');

-- --------------------------------------------------------

--
-- Table structure for table `merch_items`
--

CREATE TABLE `merch_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `printify_product_id` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `trending` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merch_items`
--

INSERT INTO `merch_items` (`id`, `printify_product_id`, `user_id`, `name`, `description`, `price`, `approved`, `trending`, `created_at`, `updated_at`) VALUES
(2, NULL, 1, 'PS5', 'SONY Playstation 5 Pro Disc, 4TB SSD + Game EA Sports FC 25 + Extra Controller, Game Consulate', 2222.00, 1, 1, '2025-04-25 22:20:06', '2025-04-28 15:18:23'),
(3, '6824c03604479021a2045a00', 1, 'Test', 'Quae ex natus sint', 760.00, 1, 0, '2025-06-12 16:04:28', '2025-06-12 16:04:28'),
(11, NULL, 1, 'Trendy Polycotton Towel with Bold \'NEW\' Design, Perfect for Beach Days, Gym, Pool Parties, Gift for Friends', 'Introducing our stylish and versatile Polycotton Towel, perfect for enhancing any bathroom or beach day. This towel exudes a modern vibe with its bold, contemporary design, making it a fantastic addition to your home decor or gym bag. Whether you’re drying off after a refreshing swim or adding a fun touch to your kitchen, it brings a splash of personality to everyday activities. Ideal for everyone who appreciates functionality and style, this towel is a great gift for friends and family during housewarming parties, beach outings, or holidays like summer vacations and pool parties. Embrace comfort and individuality with each use!<br/><br/>Product features<br/>- Durable polyester print side that retains shape and dries quickly<br/>- Soft and absorbent combed cotton loop backing<br/>- Hemmed edges for enhanced durability<br/>- Blend of 50% polyester and 50% cotton<br/>- One-sided print with vibrant design<br/><br/>Care instructions<br/>- Wash the item only cold machine wash with similar colors garments using a gentle cycle. Tumble dry on low settings or hang dry. Do not bleach or dry clean. <br/>', 53.38, 1, 1, '2025-06-19 15:58:43', '2025-06-19 16:01:11'),
(12, '6824c1d396d2cb0a4f0546f2', 1, 'Crown Logo Ceramic Mug | Perfect Gift for Music Lovers, Studio Enthusiasts, Coffee Addicts, Unique Home Decor, Birthday Presents', 'Introducing a stunning Ceramic Mug that’s perfect for your daily coffee or tea ritual! This mug radiates a bright and cheerful vibe with its vibrant colors, making it a delightful addition to your kitchenware. Its glossy finish enhances your favorite designs, ensuring every sip brings joy. Ideal for anyone who appreciates unique drinkware, this mug makes a thoughtful gift for friends, family, or that special someone. It\'s perfect for celebrating occasions like birthdays, holidays, or simply a cozy evening at home. Enjoy your drinks in style and elevate your sipping experience with this beautiful mug!<br/><br/>Product features<br/>- Made from durable, glossy ceramic for long-lasting use.<br/>- Features vibrant colors using advanced printing techniques.<br/>- Microwave-safe for easy heating of beverages and food.<br/>- Dishwasher-safe for effortless cleaning.<br/>- Available in two convenient sizes: 11oz and 15oz.<br/><br/>Care instructions<br/>- Clean in dishwasher or wash by hand with warm water and dish soap<br/>', 7.68, 1, 0, '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(13, '6824c1908de41e64de022c4c', 1, 'Crowned Record Accent Coffee Mug - 11 & 15oz', 'This Accent Coffee Mug is the perfect blend of style and functionality. With its vibrant colors and glossy finish, it serves not only as a practical drinking vessel but also as a statement piece for your kitchen or office. Whether you\'re enjoying your morning coffee, afternoon tea, or cozy hot chocolate, this mug enhances every sip with its eye-catching design.<br/><br/>Ideal for coffee lovers, artists, or anyone who appreciates unique home decor, this mug makes a great gift for birthdays, holidays, or just because! Perfect for cozying up at home or taking that much-needed coffee break at work, it invites warmth and creativity into your everyday routine. Celebrate special occasions or treat yourself to a touch of elegance with this stylish accessory.<br/><br/>Product features<br/>- Microwave-safe for easy heating<br/>- Dishwasher-safe for effortless cleaning<br/>- Vibrant colors with crisp designs<br/>- Made from white ceramic with colored accents<br/>- Available in two convenient sizes<br/><br/>Care instructions<br/>- Clean in dishwasher or wash by hand with warm water and dish soap<br/>', 9.20, 1, 0, '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(14, '6824c1419c4aa669bd08afbc', 1, 'Crowned Music Mug | 11oz Coffee Cup for Music Lovers | Perfect Gift for Musicians, Music Events, Birthdays, Holidays', 'Enjoy your favorite beverage in this stylish and unique mug. Made from high-quality white ceramic, this 11oz cup features a distinctive design, perfect for music lovers and creative souls. Its rounded corners and comfortable C-handle provide a pleasant sipping experience. Whether you’re at home or at the office, this mug adds a touch of personality to your daily routine. It’s an ideal gift for birthdays, holidays, or any occasion that calls for a thoughtful surprise. Perfect for friends, family, or colleagues who appreciate art and music, this mug is sure to brighten anyone\'s day!<br/><br/>Product features<br/>- Microwave-safe for easy heating<br/>- Dishwasher-safe for effortless cleaning<br/>- Made of durable white ceramic<br/>- Comfortable C-handle for easy grip<br/>- Lead and BPA-free for safe use<br/><br/>Care instructions<br/>- Clean in dishwasher or wash by hand with warm water and dish soap<br/>', 8.98, 1, 0, '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(15, '6824c0e253dde11bbf0a0fc0', 1, 'DJ Studio Crown Black Mug - Perfect Gift for Musicians & Music Lovers', 'Enjoy your favorite beverages in style with this sleek ceramic mug. Perfect for coffee, tea, or any hot drink, it exudes elegance with its glossy black finish. This mug is not just a drinkware; it’s a statement piece that can elevate your morning routine or cozy up your office space. Ideal for adults who appreciate quality and design, this mug makes for an excellent gift for birthdays, anniversaries, or holidays. Delight your loved ones during celebrations or simply enjoy a quiet moment of self-care with this essential accessory, designed for those who value both functionality and aesthetics.<br/><br/>Product features<br/>- Glossy ceramic material for a sleek look<br/>- Vibrant colors printed using advanced techniques<br/>- Microwave-safe for reheating beverages<br/>- Dishwasher-safe for easy cleaning<br/>- Lead and BPA-free for health and safety<br/><br/>Care instructions<br/>- Clean in dishwasher (put the product on top rack), or wash  by hand with warm water and dish soap<br/>', 11.48, 1, 0, '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(16, '6824bf5e4b4738d716039d01', 1, 'Unisex Oversized Boxy Tee with D.I.S.C. Design - Casual Streetwear, Comfortable Everyday Wear, Gift for Music Lovers, Graphic Tee, [...]', 'Introducing our stylish Unisex Oversized Boxy Tee, perfect for anyone seeking comfort and individuality in their wardrobe. This tee exudes a laid-back vibe, making it an essential choice for casual outings or lounging at home. Its relaxed fit and dropped shoulders create an effortlessly cool look that pairs well with jeans, shorts, or even loungewear. Ideal for fashion-forward individuals who appreciate quality and comfort, this tee is also a thoughtful gift for friends and loved ones on special occasions like birthdays, holidays, or just because! Whether it\'s summer soirées or cozy fall layering, it complements every season, making it a versatile addition to any closet.<br/><br/>Product features<br/>- 100% cotton for solid colors; poly blend for Athletic Heather.<br/>- Dropped shoulders for a relaxed fit.<br/>- Durable double needle stitching on sleeves and hem.<br/>- Airlume combed and ring-spun cotton for exceptional softness.<br/>- Medium fabric weight at 6.0 oz/yd² for everyday wear.<br/><br/>Care instructions<br/>- Machine wash: cold (max 30C or 90F)<br/>- Non-chlorine: bleach as needed<br/>- Tumble dry: low heat<br/>- Iron, steam or dry: low heat<br/>- Do not dryclean<br/>', 29.25, 1, 0, '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(17, '6824be8cda25f028ba0f30c0', 1, 'Unisex Heavy Blend™ Hooded Sweatshirt - Vintage Bass Drummer Design', 'This cozy and stylish Hoodie is perfect for those chilly days when you want to feel both warm and fashionable. With its unisex design, it\'s a versatile wardrobe staple that fits seamlessly into any casual outing. The spacious kangaroo pocket keeps your hands warm, while the adjustable drawstring hood allows for a customizable fit, making it ideal for relaxing at home or heading out with friends. Perfect for music lovers, sports fans, or anyone who enjoys a laid-back vibe, this hoodie makes a great gift for birthdays, holidays, or just because. Whether it’s a cozy night in or a fun day out, this hoodie will keep you comfortable and stylish. Celebrate life’s moments, big or small, with this essential piece!<br/><br/>Product features<br/>- Spacious kangaroo pocket for warmth and convenience<br/>- Adjustable drawstring hood for a comfortable fit<br/>- Made from a strong and smooth 50% cotton, 50% polyester blend<br/>- Available with stylish DTF sleeve prints and optional embroidery<br/>- Ethically produced, meeting high safety and environmental standards<br/><br/>Care instructions<br/>- Tumble dry: medium<br/>- Iron, steam or dry: low heat<br/>- Do not dryclean<br/>- Machine wash: cold (max 30C or 90F)<br/>- Non-chlorine: bleach as needed<br/>', 46.97, 1, 0, '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(18, '6824bd20f6f9085eb7030ed1', 1, 'Stylish D.I.S.C. Trucker Cap for Outdoor Enthusiasts', 'Introducing our stylish Trucker Caps, perfect for any casual occasion. These caps bring a modern edge to your outfit while providing comfort and breathability. The vibrant colors and sharp designs add a pop of personality, making them an essential accessory for outdoor adventures, festivals, or just a day out with friends. Whether you\'re tailgating at a game or enjoying a summer picnic, these caps fit right in, exuding a laid-back, trendy vibe.<br/><br/>Ideal for adults who appreciate style and functionality, these caps are suitable for birthdays, holiday gatherings, and special events. Complete your look, and stand out with a touch of flair!<br/><br/>Product features<br/>- Adjustable strap closure for a perfect fit from 20” to 24”<br/>- Professionally printed with vibrant colors that resist fading<br/>- Color-matched components for a cohesive look<br/>- Available in seven stylish color combinations<br/>- Made from 100% polyester foam and nylon mesh for durability<br/><br/>Care instructions<br/>- Use warm water and dish soap and clean spots off your hat. It\'s not necessary to soak the whole item. For hard to clean spots use a soft bristled brush.<br/>', 19.38, 1, 0, '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(19, '68545dc711ec59a77702adf9', 1, 'Tough Phone Cases', '<p>Protect your phone in custom style with this tough phone case. This lightweight phone case is impact-resistant thanks to its TPU lining and Polycarbonate shell. Meanwhile, the interior rubber liner adds an extra layer of protection to your phone for total peace of mind. Compatible with iPhone and Samsung smartphones. Check sizes for all available phone models. (iPhone 16 model now available).</p><br/><p>.: Materials: polycarbonate (shell), TPU (lining)<br/>.: 2-piece design with impact resistance and shock dispersion<br/>.: Interior rubber liner for extra protection (appearance may vary across phone models)<br/>.: Glossy finish<br/>.: Supports wireless charging (not including MagSafe)</p>', 18.23, 1, 1, '2025-06-19 19:00:43', '2025-06-19 19:03:34'),
(20, '68543377457b9bc9a4053a53', 1, 'Trendy Polycotton Towel with Bold \'NEW\' Design, Perfect for Beach Days, Gym, Pool Parties, Gift for Friends', 'Introducing our stylish and versatile Polycotton Towel, perfect for enhancing any bathroom or beach day. This towel exudes a modern vibe with its bold, contemporary design, making it a fantastic addition to your home decor or gym bag. Whether you’re drying off after a refreshing swim or adding a fun touch to your kitchen, it brings a splash of personality to everyday activities. Ideal for everyone who appreciates functionality and style, this towel is a great gift for friends and family during housewarming parties, beach outings, or holidays like summer vacations and pool parties. Embrace comfort and individuality with each use!<br/><br/>Product features<br/>- Durable polyester print side that retains shape and dries quickly<br/>- Soft and absorbent combed cotton loop backing<br/>- Hemmed edges for enhanced durability<br/>- Blend of 50% polyester and 50% cotton<br/>- One-sided print with vibrant design<br/><br/>Care instructions<br/>- Wash the item only cold machine wash with similar colors garments using a gentle cycle. Tumble dry on low settings or hang dry. Do not bleach or dry clean. <br/>', 53.38, 1, 0, '2025-06-19 19:00:43', '2025-06-19 19:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `merch_item_images`
--

CREATE TABLE `merch_item_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merch_item_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merch_item_images`
--

INSERT INTO `merch_item_images` (`id`, `merch_item_id`, `image_path`, `created_at`, `updated_at`) VALUES
(3, 2, 'images/merch/MOmi1jvE11M74iJLbsttx02eFX03XPmjDaFq7rEy.jpg', '2025-04-25 22:22:36', '2025-04-25 22:22:36'),
(4, 3, 'images/merch/m8kXY9of8Bgd0JuQl9gVfxGQsLzO6uHFI3MZnTuP.png', '2025-06-12 16:04:28', '2025-06-12 16:04:28'),
(12, 11, 'https://images-api.printify.com/mockup/68543377457b9bc9a4053a53/41694/437/trendy-polycotton-towel-with-bold-new-design-perfect-for-beach-days-gym-pool-parties-gift-for-friends.jpg?camera_label=front', '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(13, 12, 'https://images-api.printify.com/mockup/6824c1d396d2cb0a4f0546f2/65216/6310/crown-logo-ceramic-mug-perfect-gift-for-music-lovers-studio-enthusiasts-coffee-addicts-unique-home-decor-birthday-presents.jpg?camera_label=front', '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(14, 13, 'https://images-api.printify.com/mockup/6824c1908de41e64de022c4c/72180/102752/crowned-record-accent-coffee-mug-11-15oz.jpg?camera_label=front', '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(15, 14, 'https://images-api.printify.com/mockup/6824c1419c4aa669bd08afbc/33719/6400/crowned-music-mug-11oz-coffee-cup-for-music-lovers-perfect-gift-for-musicians-music-events-birthdays-holidays.jpg?camera_label=front', '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(16, 15, 'https://images-api.printify.com/mockup/6824c0e253dde11bbf0a0fc0/65217/6405/dj-studio-crown-black-mug-perfect-gift-for-musicians-music-lovers.jpg?camera_label=front', '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(17, 16, 'https://images-api.printify.com/mockup/6824bf5e4b4738d716039d01/103548/100285/unisex-oversized-boxy-tee-with-disc-design-casual-streetwear-comfortable-everyday-wear-gift-for-music-lovers-graphic-tee.jpg?camera_label=front', '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(18, 17, 'https://images-api.printify.com/mockup/6824be8cda25f028ba0f30c0/32912/98424/unisex-heavy-blend-hooded-sweatshirt-vintage-bass-drummer-design.jpg?camera_label=front', '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(19, 18, 'https://images-api.printify.com/mockup/6824bd20f6f9085eb7030ed1/84650/102749/stylish-disc-trucker-cap-for-outdoor-enthusiasts.jpg?camera_label=front', '2025-06-19 15:58:44', '2025-06-19 15:58:44'),
(20, 19, 'https://images-api.printify.com/mockup/68545dc711ec59a77702adf9/93905/70787/tough-phone-cases.jpg?camera_label=front-and-side', '2025-06-19 19:00:43', '2025-06-19 19:00:43'),
(21, 20, 'https://images-api.printify.com/mockup/68543377457b9bc9a4053a53/41694/437/trendy-polycotton-towel-with-bold-new-design-perfect-for-beach-days-gym-pool-parties-gift-for-friends.jpg?camera_label=front', '2025-06-19 19:00:43', '2025-06-19 19:00:43');

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
(4, '2024_10_14_120812_create_permission_tables', 1),
(5, '2024_11_05_170116_create_artists_table', 1),
(6, '2024_11_05_170413_create_albums_table', 1),
(7, '2024_11_05_170550_create_events_table', 1),
(8, '2024_11_07_171939_create_genres_table', 1),
(9, '2024_11_08_170438_create_tracks_table', 1),
(10, '2024_11_15_184046_create_contracts_table', 1),
(11, '2024_11_18_162641_create_cases_table', 1),
(12, '2024_11_25_170051_create_support_tickets_table', 2),
(13, '2024_11_25_170113_create_support_responses_table', 2),
(14, '2024_11_25_170411_create_royalties_table', 2),
(15, '2024_12_02_154851_create_playlists_table', 2),
(17, '2024_12_02_155011_create_song_plays_table', 3),
(18, '2024_12_20_171107_create_liked_songs_table', 3),
(19, '2024_12_23_143915_add_column_to_tracks', 3),
(20, '2024_12_23_160707_create_customer_columns', 3),
(21, '2024_12_23_160708_create_subscriptions_table', 3),
(22, '2024_12_23_160709_create_subscription_items_table', 3),
(23, '2024_12_23_175625_create_plans_table', 3),
(24, '2025_01_07_174027_create_plan_features_table', 3),
(25, '2025_01_20_161930_create_blogs_table', 4),
(26, '2025_01_22_151433_add_image_to_events_table', 4),
(35, '2025_01_23_130406_create_merch_items_table', 5),
(36, '2025_01_23_130429_create_merch_item_images_table', 5),
(37, '2025_01_23_164048_create_carts_table', 5),
(38, '2025_01_23_164058_create_wishlists_table', 5),
(39, '2025_03_28_000000_create_orders_table', 6),
(40, '2025_04_03_120942_create_order_items_table', 6),
(41, '2025_04_24_124407_add_trending_to_merch_items_table', 7),
(42, '2025_04_24_163806_update_merch_items_replace_artist_id', 8),
(43, '2025_05_09_160711_rename_stripe_charge_id_to_paypal_order_id', 8),
(44, '2025_05_26_114613_add_sku_nullable_to_merch_items_table', 9),
(45, '2025_05_26_170639_add_column_nullable_to_carts_table', 9),
(46, '2025_05_28_132128_add_printify_data_to_order_items', 9),
(47, '2025_06_16_182655_add_cascade_delete_to_order_items_merch_item_fk', 10),
(48, '2025_07_15_142300_create_tags_table', 11),
(49, '2025_07_15_142640_tag_track', 11);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `billing_name` varchar(255) DEFAULT NULL,
  `billing_phone` varchar(255) DEFAULT NULL,
  `billing_address1` varchar(255) DEFAULT NULL,
  `billing_address2` varchar(255) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_zip` varchar(255) DEFAULT NULL,
  `shipping_name` varchar(255) DEFAULT NULL,
  `shipping_address1` varchar(255) DEFAULT NULL,
  `shipping_address2` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_state` varchar(255) DEFAULT NULL,
  `shipping_zip` varchar(255) DEFAULT NULL,
  `shipping_method` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `paypal_order_id` text DEFAULT NULL,
  `printify_order_id` varchar(255) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `email`, `billing_name`, `billing_phone`, `billing_address1`, `billing_address2`, `billing_city`, `billing_state`, `billing_zip`, `shipping_name`, `shipping_address1`, `shipping_address2`, `shipping_city`, `shipping_state`, `shipping_zip`, `shipping_method`, `payment_status`, `paypal_order_id`, `printify_order_id`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 2, 'koditirej@mailinator.com', 'Raja Rice', '+1 (156) 496-5283', '714 Rocky New Lane', 'Ea ea sed odit in al', 'Ipsum sed quis mini', 'Et voluptatibus et l', '69172', 'Raja Rice', '714 Rocky New Lane', 'Ea ea sed odit in al', 'Ipsum sed quis mini', 'Et voluptatibus et l', '69172', 'free', 'paid', 'ch_3RH4RdK7gtqB72uY0sXZ6QwM', NULL, 600000.00, '2025-04-23 14:38:25', '2025-04-23 14:38:38'),
(2, 2, 'vehas@mailinator.com', 'Sharon Wade', '+1 (929) 244-2602', '971 Oak Street', 'Totam hic velit quia', 'Aperiam pariatur Re', 'Facere sunt occaeca', '55465', 'Sharon Wade', '971 Oak Street', 'Totam hic velit quia', 'Aperiam pariatur Re', 'Facere sunt occaeca', '55465', 'free', 'pending', NULL, NULL, 22220.00, '2025-04-25 22:25:00', '2025-04-25 22:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `merch_item_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `printify_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `merch_item_id`, `name`, `printify_data`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(2, 2, 2, 'PS5', NULL, 10, 2222.00, '2025-04-25 22:25:00', '2025-04-25 22:25:00');

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `stripe_plan` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `duration` enum('mon','yr') NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `offer_text` varchar(255) DEFAULT NULL,
  `included_title` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `slug`, `stripe_plan`, `price`, `description`, `duration`, `subtitle`, `offer_text`, `included_title`, `created_at`, `updated_at`) VALUES
(1, 'Basic', 'basic', 'price_1OEudAK7gtqB72uYBZLutAO4', 29, 'Basic plan description upgraded.', 'mon', 'FOR INDIVIDUALS & SMALL BUSINESSES', 'Get Your First 3 Months For $1/Mo', 'What\'s Included On Basic', '2025-01-08 16:57:06', '2025-04-25 22:12:51'),
(2, 'Premium', 'Premium', 'price_1OEudAK7gtqB72uYBZLutAO4', 200, 'Premium plan description.', 'yr', 'FOR INDIVIDUALS & SMALL BUSINESSES', 'Get Your First 3 Months For $1/Mo', 'What\'s Included On Premium', '2025-01-08 16:57:06', '2025-04-25 22:29:20'),
(3, 'Christmas', 'christamas', 'price_1OEudAK7gtqB72uYBZLutAO4', 1, 'Free!!!!', 'mon', 'Free!!!!!', 'Free!!!!!', 'All', '2025-04-25 22:44:27', '2025-08-08 20:00:18'),
(4, 'Boris Shepard', 'Sint totam doloribus', '353', 735, 'Velit, nulla non ame.Velit, nulla non ame.Velit, nulla non ame.', 'mon', 'Veritatis veniam ha', 'Modi est at optio v', 'Eveniet consequatur', '2025-08-11 23:18:12', '2025-08-11 23:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `plan_features`
--

CREATE TABLE `plan_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `plan_id` bigint(20) UNSIGNED NOT NULL,
  `feature` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plan_features`
--

INSERT INTO `plan_features` (`id`, `plan_id`, `feature`, `created_at`, `updated_at`) VALUES
(16, 1, 'Basic reports', '2025-04-25 22:12:51', '2025-04-25 22:12:51'),
(17, 1, 'Up to 1,0000 inventory locations', '2025-04-25 22:12:51', '2025-04-25 22:12:51'),
(18, 1, '20 staff accounts', '2025-04-25 22:12:51', '2025-04-25 22:12:51'),
(19, 2, 'Premium reports', '2025-04-25 22:29:20', '2025-04-25 22:29:20'),
(20, 2, 'Up to 1,000 inventory locations', '2025-04-25 22:29:20', '2025-04-25 22:29:20'),
(21, 2, '2 staff accounts', '2025-04-25 22:29:20', '2025-04-25 22:29:20'),
(26, 3, 'Free!!!!!', '2025-08-08 20:00:18', '2025-08-08 20:00:18'),
(28, 4, 'Culpa cum distinctio', '2025-08-11 23:19:26', '2025-08-11 23:19:26'),
(29, 4, 'Velit, nulla non ame.Velit, nulla non ame.Velit, nulla non ame.', '2025-08-11 23:19:26', '2025-08-11 23:19:26'),
(30, 4, 'Velit, nulla non ame.Velit, nulla non ame.Velit, nulla non ame.', '2025-08-11 23:19:26', '2025-08-11 23:19:26'),
(31, 4, 'Velit, nulla non ame.Velit, nulla non ame.Velit, nulla non ame.', '2025-08-11 23:19:26', '2025-08-11 23:19:26'),
(32, 4, 'Velit, nulla non ame.Velit, nulla non ame.Velit, nulla non ame.', '2025-08-11 23:19:26', '2025-08-11 23:19:26');

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `name`, `description`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'new', NULL, 2, '2024-12-16 17:05:52', '2024-12-16 17:05:52'),
(2, 'Alex', NULL, 2, '2024-12-16 20:06:31', '2024-12-16 20:06:31'),
(3, 'Bertel', NULL, 2, '2025-01-30 22:06:50', '2025-01-30 22:06:50'),
(4, 'Herman', NULL, 2, '2025-06-25 19:05:12', '2025-06-25 19:05:12');

-- --------------------------------------------------------

--
-- Table structure for table `playlist_track`
--

CREATE TABLE `playlist_track` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `playlist_id` bigint(20) UNSIGNED NOT NULL,
  `track_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playlist_track`
--

INSERT INTO `playlist_track` (`id`, `playlist_id`, `track_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2024-11-19 15:41:26', '2024-11-19 15:41:26'),
(2, 'user', 'web', '2024-11-19 15:41:26', '2024-11-19 15:41:26'),
(3, 'artist', 'web', '2024-11-19 15:41:26', '2024-11-19 15:41:26');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `royalties`
--

CREATE TABLE `royalties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `earned_at` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
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
('2Q3p39qDtMQCf31cN1uFaV9PkwFQr41v9eguaowj', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVmVkVTM2SG13UlRTeUhscGZiQjRYVHNsdFZGVmVRZW9CaDdtUUVkOCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MDoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L3RyYWNrcy9jcmVhdGUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MDoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L3RyYWNrcy9jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1768905660),
('31Zyr18y1OLcvLRwSJEfCyfkP4kHr1J07CY1bmqw', NULL, '34.248.51.144', 'Plesk screenshot bot https://support.plesk.com/hc/en-us/articles/10301006946066', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieWd4RFA1NUdWY1psa05IN3hjWjgxdXlEbXhUNlR5dlpEYzN3SUJyUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769009696),
('7pAUcFlbbBkAO5yPKli3yN296HD5Jl2ZDPQII3Pj', NULL, '52.2.214.255', 'Iframely/1.3.1 (+https://iframely.com/docs/about) Atlassian', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMjd1M3d4SGtvWWlFUEZTR3Vib1VRVkc3TTBjN0RVSFRaYWljU1l3NSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL3Rlcm1zLWNvbmRpdGlvbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769003244),
('7Ub9DBeBGbUvW1UoAPSmv4KbCpYBA95VKyNyY1iT', NULL, '44.194.139.157', 'Iframely/1.3.1 (+https://iframely.com/docs/about) Atlassian', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoianVnb0RnU3g0S3EyU21oNXpINkN6NTAxU05ZOE1nWWk2ajZSM3RNdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL3ByaXZhY3ktcG9saWN5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769003244),
('ah6Dyrmt8JvGjEj5yPzrODVKAitENnYNojuClskX', NULL, '184.72.115.35', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYkJSdzJpRWo5eWt4clhiV2pBTnlVWGRTM296dWI1WTZkc01HQzdSSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('B0AxwPwUsAStXAL8L7vHn1eyTZgI5nB64ORlI2bb', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidGpnS2tsV1ZJc2RENUcxMVpob29oamg0MmVwRHczdWhBRGxPVWZKaCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L2Nhc2VzIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2FydGlzdC9jYXNlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768905660),
('BQLM23YSA5YmEaZxDKrlNtqYVTgNA3hN4V1ZaVrZ', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoib1dHZjFhSExZT2pNWlIzenA3Rm1MdlZ5d0NHa0VFZVdxUlZ5QVZVUCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MzoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L2V2ZW50cyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwczovL3Nwb3RpZnkuY3N0bXBhbmVsLmNvbS9hcnRpc3QvZXZlbnRzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('cw9O7v9lpxQoTFxWPBmb3N8bHTg35UY9OHuCZSgE', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYnN3ZGVPZGFSU295cTdPUWRVWXFVRGdkekQ5SUxUMDRLaUk5Vm9BOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('Faj1JJl92U3IFTk1oT7aSLXckrZ3hzvxwGCiWoHe', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNklaQ0pmSGNyWDhNZVFnaVN5VEFBME5xN3l0d2pMeWJTN0ZZekV6ayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('fzrCKDX8W4XExA5rTctKDZOM5z891W5H73iDCOte', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOWgzOE8xQnhpVXFaVWh1U2lDU0tXS3VBU0lJMXBtVnJkcEVLeExzeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('gQbusFJeuPu9blzvYNBejHUZWMxKl1QxJeNEkyql', NULL, '54.209.60.63', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlZWSTU5TUNVMGNHZ3JSVHVMS3dhTW5RYWc1SzVNZXl3OGpLN3lrdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('i9wm6KuOSFKOWEoor5gRqXCxS88DfNH9uQfVWyY6', NULL, '54.209.60.63', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicE1uRFBSUFZnNlV4UnpUS2xJREtiaTVBaEgxaHF2RlptRkN0WEZHbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('iAMzpGMfWorGIp03mAg5cFWg0mslcL4TFTiBxcf4', NULL, '184.72.115.35', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUDNydHZLajRwNGdISjJMc0lmWHRMS2R1amNUTzdSUFdpT0FBazRRaSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MzoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L3RyYWNrcyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwczovL3Nwb3RpZnkuY3N0bXBhbmVsLmNvbS9hcnRpc3QvdHJhY2tzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('j3TOv4gHlKfoS9H08XiIKhF7U6xUuuTl6o02GJWM', NULL, '23.95.96.140', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 15_7_3) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0 Safari/605.1.15', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibm83alhGRHVMVldIQXpyeFdBcktnaUVKZ1g3SjFKbjZ5c3RCMUF2ZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjk6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1769006966),
('kcdzVqsJQSFupYaE42FsezlK92e1pHowZc2PIhwY', NULL, '142.248.80.57', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSHNiV0pxMWVWMjhsYnRCODNpQ1RLdjNVTFV1aUhqRFZXMXEzQkx1YyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tP2F1dGhvcj0yIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768977004),
('lagBXIkJ34WQc5mxujihx84AeNRm2A6WfF17Xp1L', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ0FQWUZ5UG1UenQyUE1ETVRaM1I4bmxDOWxSS1J4dWU1VWpERGJVeCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NjoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwczovL3Nwb3RpZnkuY3N0bXBhbmVsLmNvbS9hcnRpc3QvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('M065ayddiE9HZhVx8KcbVGmKyvtWishgWqqnvv9t', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiallCcU1rV0RJQkNua3RJUDkzQzhQVEJCaWJ1Z2M5cUxZZ05xVkw1QSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('S6S3mvQo2VesgNmotk0az1WAWDcLoNVsEEmgYWWO', NULL, '54.209.60.63', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWVJ5S3JkY0dHTVg0RjVJMGY3M2VSN1o0eEZJeEtZSHM5dzhSZkJKdCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1MDoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L3RyYWNrcy9jcmVhdGUiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MDoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L3RyYWNrcy9jcmVhdGUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1768905660),
('U4KItnEZGznYFQF6VozoG16GMAgW6RLZ0xngzWOd', NULL, '54.209.60.63', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibmIxdjVqNUVwQzNNRHFWR0pUbWFmb0R6S1R0S0JuWkJDazdMWkpueCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L2Nhc2VzIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2FydGlzdC9jYXNlcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1768905660),
('uDgPNvT5tzoXVlwZykfd9nLXJ54LjsODjCGmU1B2', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUJQOGpoZlFsVGl4UklvZVBEeld2RkMyOWQ5Tm8yOHI4YkplM21NMyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('UDS2BJQgj9r5hxlGUKwUqtNIqVvyoTfYTD1qz2a5', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRzBENWlPRGpSbENPODRrdWV5eXN1N3d6NGhBZ29KeTRPQWxiSGJrVCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NjoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwczovL3Nwb3RpZnkuY3N0bXBhbmVsLmNvbS9hcnRpc3QvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('W19kBNrNasGwXgQgBnjXK0AyVfx921dGk6DA5GfR', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYlFkZTFXZUFncWMzN2x4cEJ4UUtROFN3Rlh3OVNtUnRRUGJ6b1FGTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('wp7lvuJD0J8kcFPNuPbYkU84MlocTRwEDk6lE3qJ', NULL, '184.72.115.35', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia0ljRVNZaXRrRWd3REM2SWtkbGtNbmVhZjhmN3pIQ0pBWkxBMmZxMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('X9N2is1s1SW8y3baXoq8uos71ceRk7B4IPi1A5KX', NULL, '184.72.121.156', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTUxFRHRIeHA3YTZjY1g0djhqVUphb3kwMERWUEROUlRnbFRmQUR3NyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MzoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L3RyYWNrcyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQzOiJodHRwczovL3Nwb3RpZnkuY3N0bXBhbmVsLmNvbS9hcnRpc3QvdHJhY2tzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660),
('xcK7u3cnghKY0mmY0UMWpodAwYCddMcVTMzk8DFx', NULL, '74.7.241.9', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.3; +https://openai.com/gptbot)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSExBdm00R0RLRDBYWkdiSEVjQnJMRmlPMTYxU3gxYzFrckZ4U2pvTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vc3BvdGlmeS5jc3RtcGFuZWwuY29tL2xvZ2luL2ZhY2Vib29rIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1OiJzdGF0ZSI7czo0MDoiaE0wVTl4QzVQdnd5WjUxWTRBOXY5UWQwYjlZMjlmblAyZ1Q2M3dVMSI7fQ==', 1768906856),
('ZqZHTCv4I8zbSSAGIg4AJad1TXZegYTD5DagyYWW', NULL, '184.72.115.35', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/600.1.25 (KHTML, like Gecko) Version/8.0 Safari/600.1.25', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicndJVVgwbGFuZk1SZUpqNHBxWldIS1ZQNXNwTjUwTlRRdzlNbEpXbiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NjoiaHR0cHM6Ly9zcG90aWZ5LmNzdG1wYW5lbC5jb20vYXJ0aXN0L2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwczovL3Nwb3RpZnkuY3N0bXBhbmVsLmNvbS9hcnRpc3QvZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1768905660);

-- --------------------------------------------------------

--
-- Table structure for table `song_plays`
--

CREATE TABLE `song_plays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `track_id` bigint(20) UNSIGNED NOT NULL,
  `played_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `song_plays`
--

INSERT INTO `song_plays` (`id`, `user_id`, `track_id`, `played_at`, `created_at`, `updated_at`) VALUES
(1, 2, 3, '2025-01-08 17:02:08', '2025-01-08 17:02:08', '2025-01-08 17:02:08'),
(2, 2, 2, '2025-04-07 19:44:37', '2025-04-07 19:44:37', '2025-04-07 19:44:37'),
(3, 2, 5, '2025-06-27 23:24:49', '2025-06-27 23:24:49', '2025-06-27 23:24:49'),
(4, 2, 5, '2025-06-28 00:47:02', '2025-06-28 00:47:02', '2025-06-28 00:47:02'),
(5, 2, 5, '2025-06-28 00:51:14', '2025-06-28 00:51:14', '2025-06-28 00:51:14'),
(6, 2, 5, '2025-06-30 17:24:53', '2025-06-30 17:24:53', '2025-06-30 17:24:53'),
(7, 2, 5, '2025-06-30 17:28:29', '2025-06-30 17:28:29', '2025-06-30 17:28:29'),
(8, 2, 5, '2025-06-30 17:30:20', '2025-06-30 17:30:20', '2025-06-30 17:30:20');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `stripe_status` varchar(255) NOT NULL,
  `stripe_price` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `user_id`, `type`, `stripe_id`, `stripe_status`, `stripe_price`, `quantity`, `trial_ends_at`, `ends_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'default', 'sub_1Qf2c3K7gtqB72uYRnK6AM6V', 'trialing', 'price_1OEudAK7gtqB72uYBZLutAO4', 1, '2025-04-08 17:00:09', NULL, '2025-01-08 17:00:12', '2025-01-08 17:00:12'),
(2, 2, 'default', 'sub_1RBLcyK7gtqB72uYkzJLrLEX', 'active', 'price_1OEudAK7gtqB72uYBZLutAO4', 1, NULL, NULL, '2025-04-07 19:46:42', '2025-04-07 19:46:44');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_items`
--

CREATE TABLE `subscription_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `subscription_id` bigint(20) UNSIGNED NOT NULL,
  `stripe_id` varchar(255) NOT NULL,
  `stripe_product` varchar(255) NOT NULL,
  `stripe_price` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscription_items`
--

INSERT INTO `subscription_items` (`id`, `subscription_id`, `stripe_id`, `stripe_product`, `stripe_price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 'si_RY8tMTRAlbeiOo', 'prod_P30edVabjtqCjU', 'price_1OEudAK7gtqB72uYBZLutAO4', 1, '2025-01-08 17:00:13', '2025-01-08 17:00:13'),
(2, 2, 'si_S5WgaBeqPW1J4K', 'prod_P30edVabjtqCjU', 'price_1OEudAK7gtqB72uYBZLutAO4', 1, '2025-04-07 19:46:42', '2025-04-07 19:46:42');

-- --------------------------------------------------------

--
-- Table structure for table `support_responses`
--

CREATE TABLE `support_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `support_ticket_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_responses`
--

INSERT INTO `support_responses` (`id`, `support_ticket_id`, `user_id`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'you will', 1, '2025-01-30 22:05:17', '2025-01-30 22:05:33'),
(2, 2, 1, 'okay its tested', 0, '2025-04-25 22:13:56', '2025-04-25 22:13:56'),
(3, 2, 1, 'okay its tested', 0, '2025-04-25 22:13:58', '2025-04-25 22:13:58');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'open',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `artist_id`, `subject`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'i didnt recieved my Royality', 'i didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royalityi didnt recieved my Royality', 'closed', '2025-01-30 22:04:55', '2025-01-30 22:05:33'),
(2, 1, 'i am testing this only', 'sfsfdsfgsdg', 'closed', '2025-04-25 22:13:35', '2025-04-25 22:14:03');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tag_track`
--

CREATE TABLE `tag_track` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `track_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE `tracks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `album_id` bigint(20) UNSIGNED NOT NULL,
  `artist_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `duration` varchar(255) NOT NULL,
  `genre_id` bigint(20) UNSIGNED NOT NULL,
  `audio_file_path` varchar(255) NOT NULL,
  `cover_image_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `royalty_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `play_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`id`, `album_id`, `artist_id`, `title`, `duration`, `genre_id`, `audio_file_path`, `cover_image_path`, `description`, `approved`, `created_at`, `updated_at`, `royalty_amount`, `play_count`) VALUES
(1, 1, 1, 'Enim natus eligendi', '33:33', 9, 'tracks/audio/qGj6hnTAnNYbtmXgaaay0NXaHTBfCSsnPvPHQ30O.mp3', 'tracks/covers/XnexkZpWDXufB4lzTnEdruOrRQJCzAmvcrzhZdWO.png', 'Aut reprehenderit am', 1, '2024-12-04 17:34:31', '2024-12-04 17:35:05', 0.00, 0),
(2, 2, 1, 'They dont really care about us', '04:42', 1, 'tracks/audio/15A6yIzVFFKywAncZNDI2HH2dXdS2gsMSI36F1HY.mp3', 'tracks/covers/STIWaKjIaKZ6vKaXIrwIj3jamRIfqOK2ZAPa3Ghu.jpg', NULL, 1, '2024-12-10 18:35:58', '2024-12-10 18:36:07', 0.00, 0),
(3, 3, 1, 'They dont really care about us 2024', '04:42', 11, 'tracks/audio/5lvmjbC4Za9FFP4GucR4gs6nbPZD4tB1Q2CQP80r.mp3', 'tracks/covers/Ecjavsd1Nktk2r0F5zgfjHFhGib42CAyH6g39YBw.jpg', NULL, 1, '2024-12-10 19:21:40', '2024-12-10 19:22:33', 0.00, 0),
(4, 2, 1, 'xyz', '05:20', 5, 'tracks/audio/EGsrSKTQr7vPKrOlNGgGV6xTW2vRbi3JNwdOl7pA.mp3', 'tracks/covers/aTyfwq8O6kbfdK1D4a1eOyOyvMpT3UocZuTdNIjb.jpg', NULL, 1, '2025-01-30 21:56:05', '2025-04-25 22:03:47', 5.00, 1006),
(5, 3, 1, 'Herman', '11:11', 11, 'tracks/audio/Di5RZwIsbPcVeP44Yxi9dWuX9gRhx0LTzjieLvIZ.mp3', 'tracks/covers/hengjgW0ne20kCZOVKrRMxmDGv3ogGprzw106mtQ.jpg', NULL, 1, '2025-06-27 23:22:18', '2025-06-28 00:50:42', 1.11, 22);

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
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `profile_image` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) DEFAULT NULL,
  `pm_type` varchar(255) DEFAULT NULL,
  `pm_last_four` varchar(4) DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_active`, `profile_image`, `remember_token`, `created_at`, `updated_at`, `stripe_id`, `pm_type`, `pm_last_four`, `trial_ends_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$5k5qK/YSmHKnPXc7wQmHfeWzsNVbIFXClsfS6szD4DS3uYCyy4fIK', 1, NULL, NULL, '2024-11-19 15:41:26', '2024-11-19 15:41:26', NULL, NULL, NULL, NULL),
(2, 'user', 'user@gmail.com', NULL, '$2y$12$JpgPfiAGNAO2QTncfp4Tdubj1tcUxCP0d2I5fbwlUv0XKcdgn3hai', 1, NULL, NULL, '2024-11-19 15:41:27', '2025-01-08 17:00:10', 'cus_RY8tLXJyuuZT3t', 'visa', '4242', NULL),
(3, 'artist', 'artist@gmail.com', NULL, '$2y$12$2qkKz.bFUQxIpymDi7g43eFoF/db0abNmCNwYJt97G0eSCZI2BsqS', 1, 'users/profile_images/igsGTOXWFJA7Arda3ASAhvhRfLxKE31HnrMbqzkd.png', NULL, '2024-11-19 15:41:27', '2025-01-30 22:02:09', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `merch_item_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `merch_item_id`, `created_at`, `updated_at`) VALUES
(3, 2, 2, '2025-08-06 15:46:28', '2025-08-06 15:46:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`),
  ADD KEY `albums_artist_id_foreign` (`artist_id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `artists_user_id_foreign` (`user_id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_merch_item_id_foreign` (`merch_item_id`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_artist_id_foreign` (`artist_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `genres_name_unique` (`name`);

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
-- Indexes for table `liked_songs`
--
ALTER TABLE `liked_songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `liked_songs_user_id_foreign` (`user_id`),
  ADD KEY `liked_songs_track_id_foreign` (`track_id`);

--
-- Indexes for table `merch_items`
--
ALTER TABLE `merch_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merch_items_user_id_foreign` (`user_id`);

--
-- Indexes for table `merch_item_images`
--
ALTER TABLE `merch_item_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merch_item_images_merch_item_id_foreign` (`merch_item_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_merch_item_id_foreign` (`merch_item_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_features`
--
ALTER TABLE `plan_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_features_plan_id_foreign` (`plan_id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `playlists_user_id_foreign` (`user_id`);

--
-- Indexes for table `playlist_track`
--
ALTER TABLE `playlist_track`
  ADD PRIMARY KEY (`id`),
  ADD KEY `playlist_track_playlist_id_foreign` (`playlist_id`),
  ADD KEY `playlist_track_track_id_foreign` (`track_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `royalties`
--
ALTER TABLE `royalties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `royalties_artist_id_foreign` (`artist_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `song_plays`
--
ALTER TABLE `song_plays`
  ADD PRIMARY KEY (`id`),
  ADD KEY `song_plays_user_id_foreign` (`user_id`),
  ADD KEY `song_plays_track_id_foreign` (`track_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscriptions_stripe_id_unique` (`stripe_id`),
  ADD KEY `subscriptions_user_id_stripe_status_index` (`user_id`,`stripe_status`);

--
-- Indexes for table `subscription_items`
--
ALTER TABLE `subscription_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscription_items_stripe_id_unique` (`stripe_id`),
  ADD KEY `subscription_items_subscription_id_stripe_price_index` (`subscription_id`,`stripe_price`);

--
-- Indexes for table `support_responses`
--
ALTER TABLE `support_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_responses_support_ticket_id_foreign` (`support_ticket_id`),
  ADD KEY `support_responses_user_id_foreign` (`user_id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_tickets_artist_id_foreign` (`artist_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`);

--
-- Indexes for table `tag_track`
--
ALTER TABLE `tag_track`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tag_track_tag_id_foreign` (`tag_id`),
  ADD KEY `tag_track_track_id_foreign` (`track_id`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tracks_album_id_foreign` (`album_id`),
  ADD KEY `tracks_artist_id_foreign` (`artist_id`),
  ADD KEY `tracks_genre_id_foreign` (`genre_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_stripe_id_index` (`stripe_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_merch_item_id_foreign` (`merch_item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `liked_songs`
--
ALTER TABLE `liked_songs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `merch_items`
--
ALTER TABLE `merch_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `merch_item_images`
--
ALTER TABLE `merch_item_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `plan_features`
--
ALTER TABLE `plan_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `playlist_track`
--
ALTER TABLE `playlist_track`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `royalties`
--
ALTER TABLE `royalties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `song_plays`
--
ALTER TABLE `song_plays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `subscription_items`
--
ALTER TABLE `subscription_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `support_responses`
--
ALTER TABLE `support_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tag_track`
--
ALTER TABLE `tag_track`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `albums_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `artists`
--
ALTER TABLE `artists`
  ADD CONSTRAINT `artists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_merch_item_id_foreign` FOREIGN KEY (`merch_item_id`) REFERENCES `merch_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `liked_songs`
--
ALTER TABLE `liked_songs`
  ADD CONSTRAINT `liked_songs_track_id_foreign` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `liked_songs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `merch_items`
--
ALTER TABLE `merch_items`
  ADD CONSTRAINT `merch_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `merch_item_images`
--
ALTER TABLE `merch_item_images`
  ADD CONSTRAINT `merch_item_images_merch_item_id_foreign` FOREIGN KEY (`merch_item_id`) REFERENCES `merch_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_merch_item_id_foreign` FOREIGN KEY (`merch_item_id`) REFERENCES `merch_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `plan_features`
--
ALTER TABLE `plan_features`
  ADD CONSTRAINT `plan_features_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `playlists`
--
ALTER TABLE `playlists`
  ADD CONSTRAINT `playlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `playlist_track`
--
ALTER TABLE `playlist_track`
  ADD CONSTRAINT `playlist_track_playlist_id_foreign` FOREIGN KEY (`playlist_id`) REFERENCES `playlists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `playlist_track_track_id_foreign` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `royalties`
--
ALTER TABLE `royalties`
  ADD CONSTRAINT `royalties_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `song_plays`
--
ALTER TABLE `song_plays`
  ADD CONSTRAINT `song_plays_track_id_foreign` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `song_plays_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_responses`
--
ALTER TABLE `support_responses`
  ADD CONSTRAINT `support_responses_support_ticket_id_foreign` FOREIGN KEY (`support_ticket_id`) REFERENCES `support_tickets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `support_responses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD CONSTRAINT `support_tickets_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tag_track`
--
ALTER TABLE `tag_track`
  ADD CONSTRAINT `tag_track_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tag_track_track_id_foreign` FOREIGN KEY (`track_id`) REFERENCES `tracks` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `tracks_album_id_foreign` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tracks_artist_id_foreign` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tracks_genre_id_foreign` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`);

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_merch_item_id_foreign` FOREIGN KEY (`merch_item_id`) REFERENCES `merch_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
