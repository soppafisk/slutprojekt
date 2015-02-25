-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 26 feb 2015 kl 00:41
-- Serverversion: 5.6.17
-- PHP-version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `trasig`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET latin1 NOT NULL,
  `fullName` varchar(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=5 ;

--
-- Dumpning av Data i tabell `categories`
--

INSERT INTO `categories` (`id`, `name`, `fullName`) VALUES
(1, 'all', 'Allt'),
(2, 'data', 'Data och IT'),
(3, 'trams', 'Trams'),
(4, 'ovrigt', '&#214;vrigt'),
(5, 'fritid', 'Sport och fritid');

-- --------------------------------------------------------

--
-- Tabellstruktur `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` varchar(2000) NOT NULL,
  `edited_date` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `comment_user` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumpning av Data i tabell `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `parent_id`, `comment_date`, `content`, `edited_date`) VALUES
(9, 4, 2, 0, '2015-02-25 16:06:37', 'tydligen ska man behÃ¶va kommentera', '0000-00-00 00:00:00'),
(10, 4, 2, 0, '2015-02-25 16:06:46', 'blablalbalskbaspajs japsjf askasjsfpaÃ¤Ã¥jpasoj pajsfaposjfaÃ¤p jaÃ¤o jÃ¤pajsÃ¤fpajfpas', '0000-00-00 00:00:00'),
(11, 4, 7, 0, '2015-02-25 21:19:56', 'ojojoj kommentar', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Tabellstruktur `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `content` varchar(2000) NOT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nsfw` tinyint(1) DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `edited_date` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `posts_user` (`user_id`),
  KEY `posts_category` (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumpning av Data i tabell `posts`
--

INSERT INTO `posts` (`id`, `title`, `link`, `content`, `post_date`, `nsfw`, `user_id`, `cat_id`, `edited_date`, `deleted`) VALUES
(2, 'hasfhaÃ¤', 'Ã¤askfÃ¤paok', 'Ã¤aoskfÃ¤pa', '2014-12-15 23:47:33', 0, 4, 1, '0000-00-00 00:00:00', 0),
(4, 'Google assÃ¥!', 'http://www.google.se', 'ojoj den hÃ¤r sidan Ã¤r asbra!', '2015-01-09 15:57:53', 1, 6, 1, '0000-00-00 00:00:00', 0),
(5, 'HEJEHEJEHJ', 'http://hej.se', 'HEJHEJ DET HÃ„R Ã„R MITT FJÃ„RDE MEDDELANDE OJOJOJ PUSSPUSS!', '2015-01-09 17:55:51', 0, 7, 1, '0000-00-00 00:00:00', 0),
(6, 'google igen?', 'http://google.se', 'hÃ¤r Ã¤r google igen. Testar dupecheck', '2015-01-14 23:28:41', 0, 4, 1, '0000-00-00 00:00:00', 0),
(7, 'google', 'http://google.com', 'google test', '2015-01-14 23:30:30', 0, 4, 1, '2015-02-25 21:30:23', 1),
(8, 'OJoj testar en lÃ¤nk i data och it!', 'http://www.reddit.com/r/webdev', 'vÃ¤rsta grejen va!', '2015-01-19 20:15:53', 0, 4, 2, '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(70) NOT NULL,
  `account_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profilePicture` varchar(30) NOT NULL DEFAULT 'profile.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `account_date`, `profilePicture`) VALUES
(4, 'hej', '$2y$10$uA/myiHpic5rCrH94ecHV.FIV5PL25/w4t1obkfhMBAQBGVFtjpmK', 'hej', '2014-12-11 15:08:20', 'mhslu34468.png'),
(5, 'admin', '$2y$10$rVHs/AcfVVKCPw0FLAEd0e3G4cycr3BV3wPXlfj/B/JRvPvvVeZ9a', 'jensimalmaback@hotmail.com', '2014-12-11 17:21:33', 'profile.png'),
(6, 'ojoj', '$2y$10$dvn7faw/8urRnYYsNrSAuuF2tZRBrMqeN5TulOtqTNk52qBQ4ecV2', 'hej@jenserik.se', '2015-01-09 15:57:02', 'profile.png'),
(7, 'splurgen', '$2y$10$dhf3TmLgWY4iuKrcA5caretfUyFOk28s4FByvHX7gTVGDVVdu9nNy', 'hellin@kent.nu', '2015-01-09 17:52:58', 'profile.png'),
(9, 'hejsan', '$2y$10$dPRhR3ZN8nmwnz//4W3ziOeuq9zo6xGWWBEk/PJoOMOU7Ez.IkqBS', 'hejsan@hejsan.se', '2015-01-15 14:18:37', 'profile.png');

-- --------------------------------------------------------

--
-- Tabellstruktur `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `value` tinyint(1) NOT NULL,
  `post_id` int(11) NOT NULL,
  `vote_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `vote_user` (`user_id`),
  KEY `vote_post` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Dumpning av Data i tabell `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `value`, `post_id`, `vote_date`) VALUES
(20, 4, 1, 4, '2015-02-25 21:19:37'),
(21, 4, 1, 7, '2015-02-25 21:19:52'),
(22, 4, -1, 5, '2015-02-25 23:25:29');

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Restriktioner för tabell `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`cat_id`) REFERENCES `categories` (`id`);

--
-- Restriktioner för tabell `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
