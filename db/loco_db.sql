DROP DATABASE IF EXISTS `loco`;
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

INSERT INTO `profile` (`username`, `password`, `email`, `name`, `surname`, `birth`, `sex`, `cf`, `profile_image`, `role`, `phone`) VALUES
  ('admin', 'pass', 'admin@loco.it', 'Luca', 'Verdi', '2014-05-13', 'M', '9637418521237895', NULL, 'admin', '3331725333'),
  ('latario', 'pass', 'latario.rossi@gmail.com', 'Latario', 'Rossi', '2014-05-01', 'M', '7891234569638527', NULL, 'lessee', '3334465777'),
  ('latore', 'pass', 'latore.pallini@gmail.com', 'Latore', 'Pallini', '2013-01-01', 'M', '1234567891234567', NULL, 'lesser', '3331725887');


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

DROP TABLE IF EXISTS `contract`;
CREATE TABLE `contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lesser` varchar(256) NOT NULL,
  `lessee` varchar(256) NOT NULL,
  `iban` varchar(34) NOT NULL,
  `fee` decimal(6,2) DEFAULT NULL,
  `beginning` date DEFAULT NULL,
  `ending` date DEFAULT NULL,
  `address` varchar(256) NOT NULL,
  `state` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `lesser` (`lesser`),
  KEY `lessee` (`lessee`),
  CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`lesser`) REFERENCES `profile` (`username`),
  CONSTRAINT `contract_ibfk_2` FOREIGN KEY (`lessee`) REFERENCES `profile` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `message`;
CREATE TABLE `message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` varchar(256) NOT NULL,
  `recipient` varchar(256) NOT NULL,
  `send_date` datetime NOT NULL,
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


INSERT INTO `faq` (`id`, `question`, `answer`) VALUES
  (1, 'Domanda Uno', 'Bacon ipsum dolor sit amet pig shankle pork chop corned beef sirloin, pancetta ham capicola pork rump boudin filet mignon fatback. Jerky salami meatball beef ribs shank fatback pastrami ribeye frankfurter venison bresaola sirloin ham hock bacon ground round. Meatball corned beef biltong pork loin. Tri-tip fatback doner chuck, meatloaf pig shankle boudin brisket shoulder short ribs tongue.'),
  (2, 'DOmanda Due', 'Bacon ipsum dolor sit amet pig shankle pork chop corned beef sirloin, pancetta ham capicola pork rump boudin filet mignon fatback. Jerky salami meatball beef ribs shank fatback pastrami ribeye frankfurter venison bresaola sirloin ham hock bacon ground round. Meatball corned beef biltong pork loin. Tri-tip fatback doner chuck, meatloaf pig shankle boudin brisket shoulder short ribs tongue.'),
  (3, 'Domanda Tre', 'Doner meatball sausage, ball tip turducken pork chop leberkas turkey t-bone strip steak kielbasa pork loin hamburger bacon shank. Biltong rump chuck tongue beef ribs fatback pork chop corned beef jowl meatball tri-tip pancetta tenderloin capicola. Tri-tip fatback pork drumstick swine pork loin pork belly shank jerky meatloaf capicola brisket. Ham pork boudin pork chop filet mignon capicola turkey drumstick pig bacon hamburger fatback short loin leberkas. Prosciutto rump biltong meatloaf, pork chop ribeye chuck jowl shoulder ham hock drumstick swine. Ground round biltong tenderloin salami prosciutto pastrami shank shankle. Fatback tenderloin tail filet mignon bresaola rump ribeye swine landjaeger ball tip chuck flank.'),
  (4, 'Domanda Quattro', 'Pork chop beef sausage swine tongue. Ribeye andouille corned beef rump landjaeger porchetta ham tail pig turducken swine. Leberkas drumstick pork chop, corned beef tri-tip pork loin kevin rump pancetta flank. Bacon jowl pancetta, pork loin swine hamburger frankfurter boudin ball tip pork belly t-bone biltong salami. Hamburger filet mignon short ribs, shankle cow chicken doner flank.');
