DROP DATABASE IF EXISTS loco;

CREATE DATABASE IF NOT EXISTS `loco` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `loco`;

CREATE TABLE IF NOT EXISTS `accomodation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `created` date NOT NULL,
  `lesser` varchar(256) NOT NULL,
  `available_from` date NOT NULL,
  `available_untill` date NOT NULL,
  `zone` varchar(64) NOT NULL,
  `address` varchar(256) NOT NULL,
  `fee` decimal(6,2) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `assigned` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `lesser` (`lesser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;


CREATE TABLE IF NOT EXISTS `accomodation_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accomodation` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `feature_value` varchar(4096) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `accomodation` (`accomodation`),
  KEY `feature_id` (`feature_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;


CREATE TABLE IF NOT EXISTS `accomodation_feature` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `data_type` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


CREATE TABLE IF NOT EXISTS `accomodation_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


CREATE TABLE IF NOT EXISTS `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(256) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;



CREATE TABLE IF NOT EXISTS `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` varchar(256) NOT NULL,
  `recipient` varchar(256) NOT NULL,
  `send_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`),
  KEY `recipient` (`recipient`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;


CREATE TABLE IF NOT EXISTS `option` (
  `lessee` varchar(128) NOT NULL,
  `accomodation` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `state` varchar(16) NOT NULL,
  PRIMARY KEY (`lessee`,`accomodation`),
  KEY `lessee` (`lessee`),
  KEY `accomodation` (`accomodation`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `accomodation` int(11) NOT NULL,
  `photo` mediumblob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `accomodation` (`accomodation`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;


CREATE TABLE IF NOT EXISTS `profile` (
  `username` varchar(128) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(256) NOT NULL,
  `name` varchar(128) NOT NULL,
  `surname` varchar(128) DEFAULT NULL,
  `birth` date NOT NULL,
  `sex` char(1) NOT NULL,
  `cf` char(16) NOT NULL,
  `profile_image` blob,
  `role` varchar(16) NOT NULL,
  `phone` varchar(16) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
