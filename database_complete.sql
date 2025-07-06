-- Database: sukses
-- Complete database setup with all tables

-- Create database if not exists
CREATE DATABASE IF NOT EXISTS `sukses` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `sukses`;

-- --------------------------------------------------------

-- Table structure for table `kategori`
CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `slug_kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

-- Table structure for table `user`
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `useremail` varchar(200) DEFAULT NULL,
  `userpassword` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

-- Add primary keys and constraints

-- Primary key for kategori
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `unique_slug_kategori` (`slug_kategori`),
  ADD INDEX `idx_nama_kategori` (`nama_kategori`);

-- Primary key for user
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD UNIQUE KEY `unique_useremail` (`useremail`),
  ADD INDEX `idx_username` (`username`),
  ADD INDEX `idx_useremail` (`useremail`);

-- Primary key for artikel
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD INDEX `idx_slug` (`slug`),
  ADD INDEX `idx_category` (`category`),
  ADD INDEX `idx_status` (`status`),
  ADD INDEX `idx_id_kategori` (`id_kategori`),
  ADD INDEX `idx_created_at` (`created_at`);

-- --------------------------------------------------------

-- Add auto increment

-- Auto increment for kategori
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

-- Auto increment for user
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- Auto increment for artikel
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

-- Add foreign key constraint (optional)
-- ALTER TABLE `artikel`
--   ADD CONSTRAINT `fk_artikel_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE;

-- --------------------------------------------------------

-- Insert sample data for testing

-- Sample categories
INSERT INTO `kategori` (`nama_kategori`, `slug_kategori`) VALUES
('Teknologi', 'teknologi'),
('Bisnis', 'bisnis'),
('Lifestyle', 'lifestyle'),
('Pendidikan', 'pendidikan');

-- Sample user
INSERT INTO `user` (`username`, `useremail`, `userpassword`) VALUES
('admin', 'admin@example.com', 'admin123');

-- Sample articles
INSERT INTO `artikel` (`judul`, `isi`, `gambar`, `status`, `slug`, `category`, `title`, `image`, `content`, `id_kategori`) VALUES
('Artikel Pertama', 'Ini adalah isi artikel pertama', 'image1.jpg', 1, 'artikel-pertama', 'teknologi', 'Artikel Pertama', 'image1.jpg', 'Ini adalah konten artikel pertama', 1),
('Artikel Kedua', 'Ini adalah isi artikel kedua', 'image2.jpg', 1, 'artikel-kedua', 'bisnis', 'Artikel Kedua', 'image2.jpg', 'Ini adalah konten artikel kedua', 2);
