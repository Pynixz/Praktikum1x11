-- Database: kategori
-- Table structure for table `kategori`

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `slug_kategori` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add primary key constraint
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

-- Add auto increment for id_kategori field
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT;

-- Add indexes for better performance
ALTER TABLE `kategori`
  ADD INDEX `idx_nama_kategori` (`nama_kategori`),
  ADD INDEX `idx_slug_kategori` (`slug_kategori`);

-- Add unique constraint for slug_kategori to prevent duplicate slugs
ALTER TABLE `kategori`
  ADD UNIQUE KEY `unique_slug_kategori` (`slug_kategori`);
