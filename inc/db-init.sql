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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cookies`
--

LOCK TABLES `cookies` WRITE;
INSERT INTO `cookies` VALUES (1,'http://www.google.com','testcookie=testdata','192.168.59.130'),(2,'http://www.owasp.org','testcookie=testdata','192.168.59.16'),(4,'http://www.owasp.org','testcookie=testdata','192.168.59.26'),(5,'http://www.owasp.org','testcookie=testdata','192.168.59.130'),(13,'http://banksite.com/','testing','192.168.59.1');
UNLOCK TABLES;

