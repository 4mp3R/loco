CREATE DATABASE `loco`;
USE `loco`;

DROP TABLE IF EXISTS `profile`;
CREATE TABLE `profile` (
  `username` varchar(128) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(256) NOT NULL UNIQUE,
  `name` varchar(128) NOT NULL,
  `surname` varchar(128) DEFAULT NULL,
  `birth` date NOT NULL,
  `sex` char(1) NOT NULL,
  `cf` char(16) NOT NULL,
  `profile_image` blob,
  `role` varchar(16) NOT NULL,
  `phone` varchar(16) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `accomodation_type`;
CREATE TABLE `accomodation_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `accomodation`;
CREATE TABLE `accomodation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `lesser` varchar(256) NOT NULL,
  `available_from` date NOT NULL,
  `available_untill` date NOT NULL,
  `zone` varchar(64) NOT NULL,
  `address` varchar(256) NOT NULL,
  `fee` decimal(6,2) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `lesser` (`lesser`),
  CONSTRAINT `accomodation_ibfk_1` FOREIGN KEY (`type`) REFERENCES `accomodation_type` (`id`),
  CONSTRAINT `accomodation_ibfk_2` FOREIGN KEY (`lesser`) REFERENCES `profile` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `accomodation_feature`;
CREATE TABLE `accomodation_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `data_type` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  CONSTRAINT `accomodation_feature_ibfk_1` FOREIGN KEY (`type`) REFERENCES `accomodation_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `accomodation_data`;
CREATE TABLE `accomodation_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accomodation` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `feature_value` varchar(4096) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accomodation` (`accomodation`),
  KEY `feature_id` (`feature_id`),
  CONSTRAINT `accomodation_data_ibfk_1` FOREIGN KEY (`accomodation`) REFERENCES `accomodation` (`id`),
  CONSTRAINT `accomodation_data_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `accomodation_feature` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` varchar(256) NOT NULL,
  `recipient` varchar(256) NOT NULL,
  `send_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`),
  KEY `recipient` (`recipient`),
  CONSTRAINT `message_ibfk_1` FOREIGN KEY (`sender`) REFERENCES `profile` (`username`),
  CONSTRAINT `message_ibfk_2` FOREIGN KEY (`recipient`) REFERENCES `profile` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `photo`;
CREATE TABLE `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accomodation` int(11) NOT NULL,
  `photo` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accomodation` (`accomodation`),
  CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`accomodation`) REFERENCES `accomodation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `faq`;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(256) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `option`;
CREATE TABLE `option` (
  `lessee` varchar(128) NOT NULL,
  `accomodation` int(11) NOT NULL,
  PRIMARY KEY (`lessee`, `accomodation`),
  KEY `lessee` (`lessee`),
  KEY `accomodation` (`accomodation`),
  CONSTRAINT `option_ibfk_1` FOREIGN KEY (`lessee`) REFERENCES `profile` (`username`),
  CONSTRAINT `option_ibfk_2` FOREIGN KEY (`accomodation`) REFERENCES `accomodation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;