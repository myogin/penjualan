-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2019 at 07:47 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'berisi nama file image saja tanpapath',
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `created_by`, `updated_by`, `deleted_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Ate bag', 'category_images/uyiUPFKJLoCufIAj2meXavIkLquBaYKG9ETBKctq.jpeg', 1, NULL, NULL, NULL, '2019-12-13 07:00:13', '2019-12-13 07:00:13'),
(2, 'Rotan', 'category_images/zQvdwefVH1E7jsZ8KGbkmvyp3gQra1hAeoI3Luvz.jpeg', 1, NULL, NULL, NULL, '2019-12-13 07:00:24', '2019-12-13 07:00:24'),
(4, 'qwerty', 'category_images/LY2BlQup8V8o19p8TBTZCsx9VHkaZBnp9e8WdjKS.jpeg', 1, NULL, NULL, NULL, '2019-12-17 07:50:59', '2019-12-17 07:50:59');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perusahaan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `nama`, `email`, `perusahaan`, `phone`, `address`, `avatar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Keren', 'Keren@gmail.com', 'Singapore', '215421521', 'qweqweqwe', 'avatars/zVNEswgwdyY6fWzZTkTsz8FIVslbsRSLLHqSYGQM.jpeg', 'ACTIVE', '2019-12-13 06:59:46', '2019-12-13 06:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '2014_10_12_000000_create_users_table', 1),
(14, '2014_10_12_100000_create_password_resets_table', 1),
(15, '2019_09_11_020957_penyesuaian_table_users', 1),
(16, '2019_09_28_053110_create_customers_table', 1),
(17, '2019_09_28_053546_create_suppliers_table', 1),
(18, '2019_11_02_071218_create_categories_table', 1),
(19, '2019_11_05_071920_create_products_table', 1),
(20, '2019_11_05_071931_create_stocks_table', 1),
(21, '2019_11_25_010129_create_penjualans_table', 1),
(22, '2019_12_05_210808_create_pembelians_table', 1),
(23, '2019_12_08_060822_create_penjualan_product_table', 1),
(24, '2019_12_08_065736_create_pembelian_product_table', 1),
(25, '2019_12_16_161654_create_pembelians_table', 2),
(26, '2019_12_16_161719_create_pembelian_product_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembelians`
--

CREATE TABLE `pembelians` (
  `id` int(10) UNSIGNED NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `invoice_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status` enum('PROCESS','FINISH','CANCEL') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembelians`
--

INSERT INTO `pembelians` (`id`, `tanggal_transaksi`, `user_id`, `supplier_id`, `invoice_number`, `total_harga`, `status`, `created_at`, `updated_at`) VALUES
(1, '2019-12-17', 1, 1, '201912160001', 5100, 'PROCESS', '2019-12-16 08:59:13', '2019-12-16 09:14:33'),
(2, '2019-12-17', 1, 1, '201912160002', 7500, 'PROCESS', '2019-12-16 08:59:40', '2019-12-16 08:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_product`
--

CREATE TABLE `pembelian_product` (
  `pembelian_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembelian_product`
--

INSERT INTO `pembelian_product` (`pembelian_id`, `product_id`, `qty`, `harga_jual`, `harga_beli`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2000, 1000, '2019-12-16 09:14:32', '2019-12-16 09:14:32'),
(1, 2, 5, 1000, 500, '2019-12-16 09:14:32', '2019-12-16 09:14:32'),
(1, 3, 2, 1000, 800, '2019-12-16 09:14:32', '2019-12-16 09:14:32'),
(2, 1, 5, 2000, 1000, '2019-12-16 08:59:40', '2019-12-16 08:59:40'),
(2, 2, 5, 1000, 500, '2019-12-16 08:59:40', '2019-12-16 08:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `penjualans`
--

CREATE TABLE `penjualans` (
  `id` int(10) UNSIGNED NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `invoice_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_harga` int(11) NOT NULL,
  `profit` int(11) NOT NULL,
  `shipping` int(11) NOT NULL,
  `status` enum('SUBMIT','PROCESS','FINISH','CANCEL') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penjualans`
--

INSERT INTO `penjualans` (`id`, `tanggal_transaksi`, `user_id`, `customer_id`, `invoice_number`, `total_harga`, `profit`, `shipping`, `status`, `created_at`, `updated_at`) VALUES
(5, '2019-12-13', 1, 1, '201912130005', 2000, 1000, 0, 'PROCESS', '2019-12-13 07:27:18', '2019-12-13 07:27:18'),
(6, '2019-12-15', 1, 1, '201912130006', 17000, 7000, 0, 'FINISH', '2019-12-13 15:00:09', '2019-12-16 10:23:40'),
(8, '2019-12-14', 1, 1, '201912140007', 10000, 5000, 0, 'FINISH', '2019-12-14 07:34:24', '2019-12-14 07:34:24'),
(11, '2019-12-16', 1, 1, '201912160011', 1000, 200, 0, 'PROCESS', '2019-12-16 06:57:34', '2019-12-16 06:57:45'),
(12, '2019-08-05', 1, 1, '201912160012', 2000, 1000, 0, 'FINISH', '2019-12-16 06:59:00', '2019-12-16 06:59:00'),
(13, '2019-12-17', 1, 1, '201912170013', 12000, 6000, 0, 'PROCESS', '2019-12-17 07:33:40', '2019-12-17 07:33:41'),
(14, '2019-12-17', 1, 1, '201912170014', 6000, 3000, 0, 'PROCESS', '2019-12-17 07:34:34', '2019-12-17 07:34:35'),
(15, '2019-12-17', 1, 1, '201912170015', 4000, 2000, 0, 'FINISH', '2019-12-17 07:35:06', '2019-12-17 07:35:06'),
(16, '2019-12-17', 1, 1, '201912170016', 11000, 5500, 20000, 'PROCESS', '2019-12-17 07:44:42', '2019-12-17 07:44:42'),
(17, '2019-12-19', 1, 1, '201912190017', 10000, 5000, 5, 'PROCESS', '2019-12-18 20:59:12', '2019-12-18 20:59:12'),
(18, '2019-07-08', 1, 1, '201912190018', 52000, 26000, 5, 'FINISH', '2019-12-18 20:59:30', '2019-12-18 20:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_product`
--

CREATE TABLE `penjualan_product` (
  `penjualan_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penjualan_product`
--

INSERT INTO `penjualan_product` (`penjualan_id`, `product_id`, `qty`, `harga_jual`, `harga_beli`, `created_at`, `updated_at`) VALUES
(5, 1, 1, 2000, 1000, '2019-12-13 07:27:18', '2019-12-13 07:27:18'),
(6, 1, 5, 2000, 1000, '2019-12-16 10:23:40', '2019-12-16 10:23:40'),
(6, 2, 2, 1000, 500, '2019-12-16 10:23:40', '2019-12-16 10:23:40'),
(6, 3, 5, 1000, 800, '2019-12-16 10:23:40', '2019-12-16 10:23:40'),
(8, 1, 5, 2000, 1000, '2019-12-14 07:34:24', '2019-12-14 07:34:24'),
(9, 3, 3, 1000, 800, '2019-12-16 06:54:49', '2019-12-16 06:54:49'),
(10, 2, 5, 1000, 500, '2019-12-16 06:56:30', '2019-12-16 06:56:30'),
(10, 3, 5, 1000, 800, '2019-12-16 06:56:30', '2019-12-16 06:56:30'),
(11, 3, 1, 1000, 800, '2019-12-16 06:57:45', '2019-12-16 06:57:45'),
(12, 1, 1, 2000, 1000, '2019-12-16 06:59:00', '2019-12-16 06:59:00'),
(13, 1, 6, 2000, 1000, '2019-12-17 07:33:41', '2019-12-17 07:33:41'),
(14, 1, 3, 2000, 1000, '2019-12-17 07:34:35', '2019-12-17 07:34:35'),
(15, 2, 4, 1000, 500, '2019-12-17 07:35:06', '2019-12-17 07:35:06'),
(16, 1, 3, 2000, 1000, '2019-12-17 07:44:42', '2019-12-17 07:44:42'),
(16, 2, 5, 1000, 500, '2019-12-17 07:44:42', '2019-12-17 07:44:42'),
(17, 1, 5, 2000, 1000, '2019-12-18 20:59:12', '2019-12-18 20:59:12'),
(18, 2, 52, 1000, 500, '2019-12-18 20:59:30', '2019-12-18 20:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `nama_produk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_produk` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `satuan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_dasar` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `gambar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `nama_produk`, `kode_produk`, `keterangan`, `satuan`, `harga_dasar`, `harga_jual`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ate', 'Ate', 'rwqeqe', 'wqeqw', 1000, 2000, 'products/kYLgJJbI7GxEcET9mYEfBpbzZQq6XmmC6JlNN6gc.jpeg', '2019-12-13 07:00:52', '2019-12-13 07:00:52'),
(2, 2, 'rotan', 'rotan', 'weqeqwe', 'wqeqwe', 500, 1000, 'products/DIvFYaO8q6AMOXEhmZWTQoxvuuaQrlqpLifROCsD.jpeg', '2019-12-13 07:01:23', '2019-12-13 07:01:23'),
(3, 1, 'gendit', 'gendit', 'wqewqe', 'wqewe', 800, 1000, 'products/w0P22X14S60AT8wLSiZVXN4uWspA3XnHiX82bcRU.jpeg', '2019-12-13 07:01:48', '2019-12-13 07:01:48');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `stok` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `stok`, `created_at`, `updated_at`) VALUES
(1, 1, 900, '2019-12-13 07:00:52', '2019-12-18 20:59:12'),
(2, 2, 905, '2019-12-13 07:01:23', '2019-12-18 20:59:30'),
(3, 3, 6, '2019-12-13 07:01:48', '2019-12-16 10:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perusahaan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `nama`, `email`, `perusahaan`, `phone`, `address`, `avatar`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Ahyar', 'ahyar@gmail.com', 'sukawati', '02183219841904', 'sukawati', 'avatars/lCubC87peaoKfK8JtWIENnN0THPPN8L1kJQRZO0P.jpeg', 'ACTIVE', '2019-12-13 10:00:45', '2019-12-13 10:00:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('ACTIVE','INACTIVE') COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `username`, `roles`, `address`, `phone`, `avatar`, `status`) VALUES
(1, 'Made Yogi Nugraha', 'yoginugraha19@gmail.com', NULL, '$2y$10$g7x7qyiCBhQIEp7aiNRSWO27COzlEJ6R0FcvnMW3Xt0q24kw1eRRS', NULL, '2019-12-13 06:58:17', '2019-12-13 13:10:14', 'Yogi Nugraha', '[\"ADMIN\"]', 'Sarmili, Bintaro, Tangerang Selatan', '089468416847', 'avatars/TuTiOkqQVDgS20dKHibg3TymbL7EixkeLTDpTb0P.jpeg', 'ACTIVE'),
(2, 'luthvi', 'luthvi@gmail.com', NULL, '$2y$10$ATkkxaluxkgvkwpckkYQt.AwCX2QPr286mdMZRbTuOO4L.rmqInHO', NULL, '2019-12-13 11:19:14', '2019-12-16 09:29:17', 'luthvi', '[\"KASIR\"]', 'wqewqeqweqwe qwe qw eqw ewq eqw e', '089468416847', 'avatars/d7mqaQNpADNOO2IchprXsXsNgTvHob67mkyCWM4N.jpeg', 'ACTIVE'),
(3, 'gudang', 'gudang@gmail.com', NULL, '$2y$10$O0g7W3Cy5JkGkPUdBfao9./u/yJyxoGJX.xwrV736ijX9J7n9CGXq', NULL, '2019-12-16 09:31:04', '2019-12-16 09:31:04', 'gudang', '[\"GUDANG\"]', 'qwe qwe qwe qwe eqw eqw eqw eqw eqw e', '089468416847', 'avatars/5YaGfecLMtYTNGOzJbtAKvlIAN2dvkcSO00d2Ul4.jpeg', 'ACTIVE'),
(4, 'windu ambara', 'windu@gmail.com', NULL, '$2y$10$w/FYnm5d0siLciZeW1VLx.WANp2b0x6hxqNNovXYjaFTPwXs.K/ny', NULL, '2019-12-17 13:27:36', '2019-12-17 13:27:36', 'windu', '[\"ADMIN\",\"KASIR\",\"GUDANG\"]', 'jalan narakesuma gang ii a', '089468416847', 'avatars/ETuGcGvHIIRLikg2XKmKCiSgn6eztp2CeUzRRL2I.jpeg', 'ACTIVE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pembelians`
--
ALTER TABLE `pembelians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembelians_supplier_id_foreign` (`supplier_id`),
  ADD KEY `pembelians_user_id_foreign` (`user_id`);

--
-- Indexes for table `pembelian_product`
--
ALTER TABLE `pembelian_product`
  ADD PRIMARY KEY (`pembelian_id`,`product_id`);

--
-- Indexes for table `penjualans`
--
ALTER TABLE `penjualans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penjualans_customer_id_foreign` (`customer_id`),
  ADD KEY `penjualans_user_id_foreign` (`user_id`);

--
-- Indexes for table `penjualan_product`
--
ALTER TABLE `penjualan_product`
  ADD PRIMARY KEY (`penjualan_id`,`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stocks_product_id_unique` (`product_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `pembelians`
--
ALTER TABLE `pembelians`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penjualans`
--
ALTER TABLE `penjualans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembelians`
--
ALTER TABLE `pembelians`
  ADD CONSTRAINT `pembelians_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `pembelians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `penjualans`
--
ALTER TABLE `penjualans`
  ADD CONSTRAINT `penjualans_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `penjualans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `stocks`
--
ALTER TABLE `stocks`
  ADD CONSTRAINT `stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
