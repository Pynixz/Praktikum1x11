-- Database: artikel
-- Table structure for table `artikel`

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `isi` text DEFAULT NULL,
  `gambar` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `slug` varchar(200) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add primary key constraint
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

-- Add auto increment for id field
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- Add indexes for better performance
ALTER TABLE `artikel`
  ADD INDEX `idx_slug` (`slug`),
  ADD INDEX `idx_category` (`category`),
  ADD INDEX `idx_status` (`status`),
  ADD INDEX `idx_id_kategori` (`id_kategori`),
  ADD INDEX `idx_created_at` (`created_at`);
