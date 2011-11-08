--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(40) NOT NULL,
  `okay` tinyint(1) default NULL,
  `value` char(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------
--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL auto_increment,
  `menu_id` varchar(1) NOT NULL,
  `number` int(2) NOT NULL,
  `name` varchar(40) NOT NULL,
  `date` datetime default NULL,
  `visible` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_id` varchar(100) DEFAULT NULL,
  `date` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL auto_increment,
  `date` datetime NOT NULL,
  `type` varchar(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `filename` (`filename`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL auto_increment,
  `menu_id` varchar(1) NOT NULL,
  `number` int(2) NOT NULL,
  `name` varchar(40) NOT NULL,
  `url` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `visible` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL auto_increment,
  `created` datetime NOT NULL,
  `username` varchar(30) character set latin1 collate latin1_general_cs NOT NULL,
  `password` text NOT NULL,
  `email` varchar(50) NOT NULL,
  `member` char(42) NOT NULL,
  `newpass` tinyint(1) NOT NULL,
`dbsalt` char(39) NOT NULL,
  `admin_rights` tinyint(1) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

