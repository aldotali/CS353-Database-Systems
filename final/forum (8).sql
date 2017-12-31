-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2017 at 03:28 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forum`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getTheGuysIFollow` (IN `myId` INT UNSIGNED)  SELECT follow.followed_id
FROM `user` NATURAL JOIN follow 
WHERE U_id = follow.following_id AND U_id = myid$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getTop10NewsFeed` (IN `myId` INT)  SELECT * FROM user As S1 NATURAL JOIN topic AS T WHERE S1.U_id IN ( SELECT follow.followed_id FROM `user` NATURAL JOIN follow WHERE U_id =follow.following_id AND U_id = myid ) AND S1.U_id = T.create_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `A_id` int(32) NOT NULL,
  `A_adminDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`A_id`, `A_adminDate`) VALUES
(3, '2017-12-19');

-- --------------------------------------------------------

--
-- Table structure for table `ban`
--

CREATE TABLE `ban` (
  `A_id` int(32) NOT NULL,
  `U_id` int(32) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `C_id` int(32) NOT NULL,
  `A_id` int(32) NOT NULL,
  `date` date NOT NULL,
  `C_name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`C_id`, `A_id`, `date`, `C_name`) VALUES
(1, 3, '2017-12-17', 'Culinary'),
(2, 3, '2017-12-17', 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `Co_id` int(32) NOT NULL,
  `Co_text` text NOT NULL,
  `Co_date` date NOT NULL,
  `isReplyToCom` varchar(3) NOT NULL,
  `makeDate` date NOT NULL,
  `U_id` int(32) NOT NULL,
  `S_id` int(32) NOT NULL,
  `M_id` int(32) NOT NULL,
  `approve_status` varchar(16) DEFAULT NULL,
  `approve_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`Co_id`, `Co_text`, `Co_date`, `isReplyToCom`, `makeDate`, `U_id`, `S_id`, `M_id`, `approve_status`, `approve_date`) VALUES
(1, 'The best way to successed in a project is to try as best as possible. You will get a good grade. Arif Usta is a good man. He will b in a good mood. He will give group 09 full points 100/100.', '2017-12-20', 'NO', '2017-12-20', 3, 1, 2, 'approved', '2017-12-24'),
(46, 'gfdhg', '2017-12-24', 'NO', '2017-12-24', 1, 1, 2, 'approved', '2017-12-24'),
(47, 'sdfdsf', '2017-12-24', 'NO', '2017-12-24', 1, 1, 2, 'approved', '2017-12-24'),
(48, 'sddfsadfasd', '2017-12-24', 'NO', '2017-12-24', 1, 1, 2, 'approved', '2017-12-24');

--
-- Triggers `comment`
--
DELIMITER $$
CREATE TRIGGER `deleteComment` BEFORE DELETE ON `comment` FOR EACH ROW BEGIN
DELETE FROM likecomment
WHERE Co_id = old.Co_id;
DELETE FROM reportcomment
WHERE Co_id = old.Co_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `comtocom`
--

CREATE TABLE `comtocom` (
  `add_Com` int(32) NOT NULL,
  `belong_Com` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `countfollowers`
-- (See below for the actual view)
--
CREATE TABLE `countfollowers` (
`U_id` int(32)
,`counter` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `countfollowing`
-- (See below for the actual view)
--
CREATE TABLE `countfollowing` (
`U_id` int(32)
,`counter` bigint(21)
);

-- --------------------------------------------------------

--
-- Table structure for table `deletesubtopic`
--

CREATE TABLE `deletesubtopic` (
  `S_id` int(32) NOT NULL,
  `T_id` int(32) NOT NULL,
  `U_id` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deletetopic`
--

CREATE TABLE `deletetopic` (
  `T_id` int(32) NOT NULL,
  `U_id` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `follow`
--

CREATE TABLE `follow` (
  `following_id` int(32) NOT NULL,
  `followed_id` int(32) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `follow`
--

INSERT INTO `follow` (`following_id`, `followed_id`, `date`) VALUES
(3, 2, '2017-12-17'),
(1, 2, '0000-00-00'),
(1, 3, '0000-00-00'),
(1, 2, '2017-12-24'),
(1, 3, '2017-12-25');

-- --------------------------------------------------------

--
-- Table structure for table `includes`
--

CREATE TABLE `includes` (
  `C_id` int(32) NOT NULL,
  `T_id` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `includes`
--

INSERT INTO `includes` (`C_id`, `T_id`) VALUES
(1, 3),
(2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `likecomment`
--

CREATE TABLE `likecomment` (
  `U_id` int(32) NOT NULL,
  `Co_id` int(32) NOT NULL,
  `date` date NOT NULL,
  `voteType` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likecomment`
--

INSERT INTO `likecomment` (`U_id`, `Co_id`, `date`, `voteType`) VALUES
(1, 1, '2017-12-24', '-1'),
(1, 47, '2017-12-24', '1'),
(2, 1, '2017-12-24', '');

-- --------------------------------------------------------

--
-- Table structure for table `makeadmin`
--

CREATE TABLE `makeadmin` (
  `A_id` int(32) NOT NULL,
  `M_id` int(32) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `makemoderator`
--

CREATE TABLE `makemoderator` (
  `A_id` int(32) NOT NULL,
  `U_id` int(32) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `moderator`
--

CREATE TABLE `moderator` (
  `U_id` int(32) NOT NULL,
  `start_date` date NOT NULL,
  `last_login_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `moderator`
--

INSERT INTO `moderator` (`U_id`, `start_date`, `last_login_date`) VALUES
(2, '2017-12-17', '2017-12-17');

-- --------------------------------------------------------

--
-- Table structure for table `regularuser`
--

CREATE TABLE `regularuser` (
  `U_id` int(32) NOT NULL,
  `Status` varchar(16) NOT NULL DEFAULT 'free',
  `Visibility` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reportcomment`
--

CREATE TABLE `reportcomment` (
  `Co_id` int(32) NOT NULL,
  `U_id` int(32) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subtopic`
--

CREATE TABLE `subtopic` (
  `S_id` int(32) NOT NULL,
  `S_name` varchar(64) NOT NULL,
  `S_description` varchar(255) NOT NULL,
  `S_icon` varchar(255) NOT NULL,
  `T_id` int(32) NOT NULL,
  `createDate` date NOT NULL,
  `U_id` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subtopic`
--

INSERT INTO `subtopic` (`S_id`, `S_name`, `S_description`, `S_icon`, `T_id`, `createDate`, `U_id`) VALUES
(1, 'Using wooden knives makes cutting beef extra hard.', 'I a\\m a houswife and I have been using the knives fro more than 1000 yeas. I do not know how old I am but we can talk about that hellloooo write smth.', 'This is the icon', 3, '2017-12-20', 2);

--
-- Triggers `subtopic`
--
DELIMITER $$
CREATE TRIGGER `deleteSubtopic` BEFORE DELETE ON `subtopic` FOR EACH ROW BEGIN
DELETE FROM comment
WHERE S_id = old.S_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `suspend`
--

CREATE TABLE `suspend` (
  `A_id` int(32) NOT NULL,
  `U_id` int(32) NOT NULL,
  `reactivationDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE `topic` (
  `T_id` int(32) NOT NULL,
  `T_name` varchar(64) NOT NULL,
  `T_createDate` date NOT NULL,
  `T_description` text NOT NULL,
  `T_icon` varchar(255) NOT NULL,
  `approveStatus` varchar(32) DEFAULT NULL,
  `approveDate` date DEFAULT NULL,
  `M_id` int(32) NOT NULL,
  `create_id` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`T_id`, `T_name`, `T_createDate`, `T_description`, `T_icon`, `approveStatus`, `approveDate`, `M_id`, `create_id`) VALUES
(3, 'FOOD', '2017-12-17', 'This is a case of study on GMO Food in the world.', 'Icon goes here', 'approved', '2017-12-17', 2, 2),
(4, 'Sport', '2017-12-16', 'I am you. you are me. Footbal is what we speak of.', 'Icon is missing wooooah', 'approved', '2017-12-24', 3, 3),
(18, 'sddf', '2017-12-24', 'sdfs', 'sdfsdf', 'approved', '2017-12-24', 2, 2);

--
-- Triggers `topic`
--
DELIMITER $$
CREATE TRIGGER `deleteTopic` BEFORE DELETE ON `topic` FOR EACH ROW BEGIN
DELETE FROM subtopic
WHERE T_id = old.T_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `U_id` int(32) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  `U_username` varchar(255) NOT NULL,
  `U_mail` varchar(64) NOT NULL,
  `U_password` varchar(64) NOT NULL,
  `U_city` varchar(64) NOT NULL,
  `U_registration-date` date NOT NULL,
  `U_picture` varchar(255) NOT NULL,
  `U_type` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`U_id`, `nickname`, `U_username`, `U_mail`, `U_password`, `U_city`, `U_registration-date`, `U_picture`, `U_type`) VALUES
(1, 'aldo', 'aldotali', 'aldo@gmail.com', 'aldo', 'Ankara', '2017-12-17', '\"your picture baby\"', 'regular'),
(2, 'furkan', 'furkantaskale', 'furkan@gmail.com', 'furkan', 'Ankara', '2017-12-17', '\"your picture baby\"', 'moderator'),
(3, 'mustafa', 'mustafaculban', 'mustafa@gmail.com', 'mustafa', 'Ankara', '2017-12-17', 'Picture here', 'admin');

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `DeleteUser` BEFORE DELETE ON `user` FOR EACH ROW BEGIN
DELETE FROM likecomment
    WHERE U_id = old.U_id;
IF old.U_id = moderator.U_id THEN
	DELETE FROM moderator
    WHERE U_id = old.U_id;
END IF;
IF old.U_id = admin.U_id THEN
	DELETE FROM admin
    WHERE U_id = old.U_id;
END IF;
DELETE FROM comment
WHERE U_id = old.U_id;
DELETE FROM subtopic
WHERE U_id = old.U_id;
DELETE FROM topic
WHERE U_id = old.U_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `countfollowers`
--
DROP TABLE IF EXISTS `countfollowers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `countfollowers`  AS  select `user`.`U_id` AS `U_id`,count(`follow`.`followed_id`) AS `counter` from (`user` join `follow`) where (`user`.`U_id` = `follow`.`followed_id`) group by `user`.`U_id` ;

-- --------------------------------------------------------

--
-- Structure for view `countfollowing`
--
DROP TABLE IF EXISTS `countfollowing`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `countfollowing`  AS  select `user`.`U_id` AS `U_id`,count(`follow`.`following_id`) AS `counter` from (`user` join `follow`) group by `user`.`U_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`A_id`);

--
-- Indexes for table `ban`
--
ALTER TABLE `ban`
  ADD PRIMARY KEY (`U_id`),
  ADD KEY `A_id` (`A_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`C_id`),
  ADD KEY `A_id` (`A_id`),
  ADD KEY `cname_index` (`C_name`) USING BTREE;

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`Co_id`),
  ADD KEY `S_id` (`S_id`),
  ADD KEY `M_id` (`M_id`),
  ADD KEY `comment_ibfk_1` (`U_id`);

--
-- Indexes for table `comtocom`
--
ALTER TABLE `comtocom`
  ADD PRIMARY KEY (`belong_Com`),
  ADD KEY `add_Com` (`add_Com`);

--
-- Indexes for table `deletesubtopic`
--
ALTER TABLE `deletesubtopic`
  ADD PRIMARY KEY (`S_id`,`T_id`),
  ADD KEY `T_id` (`T_id`),
  ADD KEY `U_id` (`U_id`);

--
-- Indexes for table `deletetopic`
--
ALTER TABLE `deletetopic`
  ADD PRIMARY KEY (`T_id`),
  ADD KEY `deletetopic_ibfk_2` (`U_id`);

--
-- Indexes for table `follow`
--
ALTER TABLE `follow`
  ADD KEY `followed_id` (`followed_id`),
  ADD KEY `following_id` (`following_id`);

--
-- Indexes for table `includes`
--
ALTER TABLE `includes`
  ADD PRIMARY KEY (`C_id`,`T_id`),
  ADD KEY `T_id` (`T_id`);

--
-- Indexes for table `likecomment`
--
ALTER TABLE `likecomment`
  ADD PRIMARY KEY (`U_id`,`Co_id`),
  ADD KEY `Co_id` (`Co_id`);

--
-- Indexes for table `makeadmin`
--
ALTER TABLE `makeadmin`
  ADD PRIMARY KEY (`M_id`);

--
-- Indexes for table `makemoderator`
--
ALTER TABLE `makemoderator`
  ADD PRIMARY KEY (`U_id`),
  ADD KEY `A_id` (`A_id`);

--
-- Indexes for table `moderator`
--
ALTER TABLE `moderator`
  ADD PRIMARY KEY (`U_id`);

--
-- Indexes for table `regularuser`
--
ALTER TABLE `regularuser`
  ADD PRIMARY KEY (`U_id`);

--
-- Indexes for table `reportcomment`
--
ALTER TABLE `reportcomment`
  ADD PRIMARY KEY (`Co_id`,`U_id`),
  ADD KEY `U_id` (`U_id`);

--
-- Indexes for table `subtopic`
--
ALTER TABLE `subtopic`
  ADD PRIMARY KEY (`S_id`) USING BTREE,
  ADD KEY `U_id` (`U_id`),
  ADD KEY `T_id` (`T_id`);

--
-- Indexes for table `suspend`
--
ALTER TABLE `suspend`
  ADD PRIMARY KEY (`U_id`),
  ADD KEY `A_id` (`A_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`T_id`),
  ADD KEY `create_id` (`create_id`),
  ADD KEY `tname_index` (`T_name`) USING BTREE;

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`U_id`),
  ADD KEY `usernickname_index` (`nickname`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `Co_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `subtopic`
--
ALTER TABLE `subtopic`
  MODIFY `S_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
  MODIFY `T_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `U_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`A_id`) REFERENCES `user` (`U_id`);

--
-- Constraints for table `ban`
--
ALTER TABLE `ban`
  ADD CONSTRAINT `ban_ibfk_1` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ban_ibfk_2` FOREIGN KEY (`A_id`) REFERENCES `admin` (`A_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`A_id`) REFERENCES `admin` (`A_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`M_id`) REFERENCES `moderator` (`U_id`);

--
-- Constraints for table `deletetopic`
--
ALTER TABLE `deletetopic`
  ADD CONSTRAINT `deletetopic_ibfk_2` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`) ON UPDATE CASCADE;

--
-- Constraints for table `follow`
--
ALTER TABLE `follow`
  ADD CONSTRAINT `follow_ibfk_1` FOREIGN KEY (`followed_id`) REFERENCES `user` (`U_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `follow_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `user` (`U_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `includes`
--
ALTER TABLE `includes`
  ADD CONSTRAINT `includes_ibfk_1` FOREIGN KEY (`C_id`) REFERENCES `category` (`C_id`),
  ADD CONSTRAINT `includes_ibfk_2` FOREIGN KEY (`T_id`) REFERENCES `topic` (`T_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likecomment`
--
ALTER TABLE `likecomment`
  ADD CONSTRAINT `likecomment_ibfk_2` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likecomment_ibfk_3` FOREIGN KEY (`Co_id`) REFERENCES `comment` (`Co_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `makeadmin`
--
ALTER TABLE `makeadmin`
  ADD CONSTRAINT `makeadmin_ibfk_1` FOREIGN KEY (`M_id`) REFERENCES `moderator` (`U_id`);

--
-- Constraints for table `makemoderator`
--
ALTER TABLE `makemoderator`
  ADD CONSTRAINT `makemoderator_ibfk_1` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `makemoderator_ibfk_2` FOREIGN KEY (`A_id`) REFERENCES `admin` (`A_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `moderator`
--
ALTER TABLE `moderator`
  ADD CONSTRAINT `moderator_ibfk_1` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `regularuser`
--
ALTER TABLE `regularuser`
  ADD CONSTRAINT `regularuser_ibfk_1` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`);

--
-- Constraints for table `reportcomment`
--
ALTER TABLE `reportcomment`
  ADD CONSTRAINT `reportcomment_ibfk_2` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`),
  ADD CONSTRAINT `reportcomment_ibfk_3` FOREIGN KEY (`Co_id`) REFERENCES `comment` (`Co_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subtopic`
--
ALTER TABLE `subtopic`
  ADD CONSTRAINT `subtopic_ibfk_2` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subtopic_ibfk_3` FOREIGN KEY (`T_id`) REFERENCES `topic` (`T_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suspend`
--
ALTER TABLE `suspend`
  ADD CONSTRAINT `suspend_ibfk_1` FOREIGN KEY (`U_id`) REFERENCES `user` (`U_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `suspend_ibfk_2` FOREIGN KEY (`A_id`) REFERENCES `admin` (`A_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`create_id`) REFERENCES `user` (`U_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
