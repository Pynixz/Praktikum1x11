-- Database: user
-- Table structure for table `user`

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `useremail` varchar(200) DEFAULT NULL,
  `userpassword` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Add primary key constraint
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

-- Add auto increment for id field
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- Add indexes for better performance
ALTER TABLE `user`
  ADD INDEX `idx_username` (`username`),
  ADD INDEX `idx_useremail` (`useremail`);

-- Add unique constraints to prevent duplicate usernames and emails
ALTER TABLE `user`
  ADD UNIQUE KEY `unique_username` (`username`),
  ADD UNIQUE KEY `unique_useremail` (`useremail`);
