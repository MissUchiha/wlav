-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 28, 2016 at 12:14 PM
-- Server version: 5.5.49-0+deb8u1
-- PHP Version: 5.6.22-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wlav_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_access_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth2_access_tokens` (
`id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth2_access_tokens`
--

INSERT INTO `oauth2_access_tokens` (`id`, `client_id`, `user_id`, `token`, `expires_at`, `scope`) VALUES
(3, 1, 1, 'ZjkwNjY2NDJhODcyNjQ4M2EyNzAzMjJiNWU4NGU0NTYxZjY4MDIxZDNlYjFmN2E2NjAyZTNhNzgwYmZiODE5NA', 1466889560, NULL),
(4, 1, 1, 'ZWQxM2ZjOTc2YTA2MzcwMjk1ZTFmMjczNTBiNTkzZDBkOThiYWM2ZjY0N2RhYzAxYzA4MmE0NTU0ZTBkZTIxMw', 1466891769, NULL),
(5, 1, 1, 'OTY3NjkwNzM1MmNiMGMxZjk2NGVhYzUzZGZhNDA0NTRiOGM0NWIyMzE3NjcwMWRmZjBiZDlhYjhmYzY4OWMyNA', 1466892310, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_auth_codes`
--

CREATE TABLE IF NOT EXISTS `oauth2_auth_codes` (
`id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uri` longtext COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth2_auth_codes`
--

INSERT INTO `oauth2_auth_codes` (`id`, `client_id`, `user_id`, `token`, `redirect_uri`, `expires_at`, `scope`) VALUES
(1, 4, 1, 'ODBhYzNiMzBjNDYzYmExMzU3ODM0MWY5ZmZhNjM5ZGJhNTFmZDc0MjI0YjBjOGU3MTYyMGVmMGQzYjgyMjQyZQ', 'www.client3.com', 1466884071, 'code'),
(2, 4, 12, 'ZmUyZmFmZGNhYjgzZDY4YTNkNDMxZDg4OTUxMGIxZTQ0NzE1OTE2ODlmZDczMTFkMjEyYTZiYmEzNDM1ZDU4OA', 'www.client3.com', 1466884071, 'code');

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_clients`
--

CREATE TABLE IF NOT EXISTS `oauth2_clients` (
`id` int(11) NOT NULL,
  `random_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `redirect_uris` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `secret` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `allowed_grant_types` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth2_clients`
--

INSERT INTO `oauth2_clients` (`id`, `random_id`, `redirect_uris`, `secret`, `allowed_grant_types`) VALUES
(1, '3iih0fevrh8gkkgwk4s080844s8w08o0w8gsksk4gs8kkgs0g8', 'a:1:{i:0;s:15:"www.client1.com";}', '13beqvq1sju8s0swsowogok48o4wggsgww8wck0008css8wowc', 'a:3:{i:0;s:8:"password";i:1;s:5:"token";i:2;s:13:"refresh_token";}'),
(4, '40g76vb7fj6s408ow8owkck8g04cwk808wws48k8ckwwocwco0', 'a:1:{i:0;s:15:"www.client3.com";}', '5d88w5xtads8k4occ0kcs0kgw0wgs8sk4c0ko88skg44kw04gk', 'a:1:{i:0;s:4:"code";}');

-- --------------------------------------------------------

--
-- Table structure for table `oauth2_refresh_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth2_refresh_tokens` (
`id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expires_at` int(11) DEFAULT NULL,
  `scope` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oauth2_refresh_tokens`
--

INSERT INTO `oauth2_refresh_tokens` (`id`, `client_id`, `user_id`, `token`, `expires_at`, `scope`) VALUES
(1, 1, 1, 'ZjFiZGE1OGEzNTdhY2I3MDQxMDUyYzUxZjhhZTE5YWY4OTNiNmE1ZjNlODZhODQ4ODMwMmJjYzhjOGIwZjc3OA', 1468095560, NULL),
(3, 1, 1, 'MGI5OWQ3NWNiMGNlMmExODg0YTcwOTY3OWQyYzE0MWU5MDRhY2VjM2UxZmE2OGQ1MWM5YjA4MjIyMjgyMWYwNA', 1468098310, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `program_source`
--

CREATE TABLE IF NOT EXISTS `program_source` (
`id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `program_source`
--

INSERT INTO `program_source` (`id`, `user_id`, `name`, `created_at`) VALUES
(4, 1, 'nekiprogram', '2016-06-21 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `firstName`, `lastName`) VALUES
(1, 'ana', 'ana', 'ana@ana.com', 'ana@ana.com', 1, 'lyx1fmprmcgkg8ws4oc40co8okwg8ww', '$2y$13$SSRE2mmFbmzT9ohy7tcecO2nVAPfWdpg8g7FSoSPNpVbx/g70AYo.', '2016-06-24 15:15:57', 0, 0, NULL, NULL, NULL, 'a:2:{i:0;s:9:"ROLE_USER";i:1;s:10:"ROLE_ADMIN";}', 0, NULL, 'ana', 'ana'),
(12, 'Maja', 'maja', 'maja@maja.com', 'maja@maja.com', 1, 'cn99e6pkq1sk8wc844kkgc04ccosc0g', '$2y$13$EYXMkG4MY3IXulPezjod4u8Q55KImFpDVD1lq5sFs0o2R.YBQviWu', '2016-06-24 19:20:33', 0, 0, NULL, NULL, NULL, 'a:2:{i:0;s:9:"ROLE_USER";i:1;s:10:"ROLE_ADMIN";}', 0, NULL, 'Maja', 'Maja');

-- --------------------------------------------------------

--
-- Table structure for table `verification_call`
--

CREATE TABLE IF NOT EXISTS `verification_call` (
`id` int(11) NOT NULL,
  `flags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stdoutMsg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stderrMsg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `errorMsg` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `programSource_id` int(11) DEFAULT NULL,
  `output` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `verification_call`
--

INSERT INTO `verification_call` (`id`, `flags`, `stdoutMsg`, `stderrMsg`, `errorMsg`, `status`, `created_at`, `programSource_id`, `output`) VALUES
(1, '{}', '', '', '', 'false', '2016-06-16 00:00:00', 4, 'Line: 23 unsafe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `oauth2_access_tokens`
--
ALTER TABLE `oauth2_access_tokens`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_D247A21B5F37A13B` (`token`), ADD KEY `IDX_D247A21B19EB6921` (`client_id`), ADD KEY `IDX_D247A21BA76ED395` (`user_id`);

--
-- Indexes for table `oauth2_auth_codes`
--
ALTER TABLE `oauth2_auth_codes`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_A018A10D5F37A13B` (`token`), ADD KEY `IDX_A018A10D19EB6921` (`client_id`), ADD KEY `IDX_A018A10DA76ED395` (`user_id`);

--
-- Indexes for table `oauth2_clients`
--
ALTER TABLE `oauth2_clients`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth2_refresh_tokens`
--
ALTER TABLE `oauth2_refresh_tokens`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_D394478C5F37A13B` (`token`), ADD KEY `IDX_D394478C19EB6921` (`client_id`), ADD KEY `IDX_D394478CA76ED395` (`user_id`);

--
-- Indexes for table `program_source`
--
ALTER TABLE `program_source`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_BCA4129A76ED395` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`), ADD UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`);

--
-- Indexes for table `verification_call`
--
ALTER TABLE `verification_call`
 ADD PRIMARY KEY (`id`), ADD KEY `IDX_53BADC39B8382797` (`programSource_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `oauth2_access_tokens`
--
ALTER TABLE `oauth2_access_tokens`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `oauth2_auth_codes`
--
ALTER TABLE `oauth2_auth_codes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `oauth2_clients`
--
ALTER TABLE `oauth2_clients`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `oauth2_refresh_tokens`
--
ALTER TABLE `oauth2_refresh_tokens`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `program_source`
--
ALTER TABLE `program_source`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `verification_call`
--
ALTER TABLE `verification_call`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `oauth2_access_tokens`
--
ALTER TABLE `oauth2_access_tokens`
ADD CONSTRAINT `FK_D247A21B19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
ADD CONSTRAINT `FK_D247A21BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `oauth2_auth_codes`
--
ALTER TABLE `oauth2_auth_codes`
ADD CONSTRAINT `FK_A018A10D19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
ADD CONSTRAINT `FK_A018A10DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `oauth2_refresh_tokens`
--
ALTER TABLE `oauth2_refresh_tokens`
ADD CONSTRAINT `FK_D394478C19EB6921` FOREIGN KEY (`client_id`) REFERENCES `oauth2_clients` (`id`),
ADD CONSTRAINT `FK_D394478CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `program_source`
--
ALTER TABLE `program_source`
ADD CONSTRAINT `FK_BCA4129A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `verification_call`
--
ALTER TABLE `verification_call`
ADD CONSTRAINT `FK_53BADC39B8382797` FOREIGN KEY (`programSource_id`) REFERENCES `program_source` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
