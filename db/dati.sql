USE `loco`;

INSERT INTO `accomodation_type` (`id`, `name`) VALUES
(1, 'Singola'),
(2, 'Doppia'),
(3, 'Appartamento'),
(4, 'Villetta');

INSERT INTO `accomodation_feature` (`id`, `type`, `name`, `data_type`) VALUES
(1, 1, 'Con 2 finestre', 'bool'),
(2, 1, 'Con letto matrimoniale', 'bool'),
(3, 2, 'Con 2 cucine e 2 bagni', 'bool');


INSERT INTO `profile` (`username`, `password`, `email`, `name`, `surname`, `birth`, `sex`, `cf`, `profile_image`, `role`, `phone`) VALUES
('admin', 'pass', 'admin@loco.it', 'Luca', 'Verdi', '2014-05-13', 'M', '9637418521237895', NULL, 'admin', '3331725333'),
('latario', 'pass', 'latario.rossi@gmail.com', 'Latario', 'Rossi', '2014-05-01', 'M', '7891234569638527', NULL, 'lessee', '3334465777'),
('latore', 'pass', 'latore.pallini@gmail.com', 'Latore', 'Pallini', '2013-01-01', 'M', '1234567891234567', NULL, 'lesser', '3331725887'),
('maria', '1234', 'maria@gmail.com', 'Maria', 'Rossi', '1960-06-04', 'F', 'abcdefg123456789', NULL, 'lessor', '087123455644');

INSERT INTO `accomodation` (`id`, `type`, `title`, `description`, `lesser`, `available_from`, `available_untill`, `zone`, `address`, `fee`, `views`) VALUES
(1, 1, 'Camera singla ampia e luminosa', 'Turnip greens yarrow ricebean rutabaga endive cauliflower sea lettuce kohlrabi amaranth water spinach avocado daikon napa cabbage asparagus winter purslane kale. Celery potato scallion desert raisin horseradish spinach carrot soko. Lotus root water spinach fennel kombu maize bamboo shoot green bean swiss chard seakale pumpkin onion chickpea gram corn pea. Brussels sprout coriander water chestnut gourd swiss chard wakame kohlrabi beetroot carrot watercress. Corn amaranth salsify bunya nuts nori azuki bean chickweed potato bell pepper artichoke. ', 'latario', '2014-06-03', '2014-08-29', 'Piazza cavour', 'via del pane 222', '190.00', 0),
(2, 2, 'Doppia spaziosa', 'Turnip greens yarrow ricebean rutabaga endive cauliflower sea lettuce kohlrabi amaranth water spinach avocado daikon napa cabbage asparagus winter purslane kale. Celery potato scallion desert raisin horseradish spinach carrot soko. Lotus root water spinach fennel kombu maize bamboo shoot green bean swiss chard seakale pumpkin onion chickpea gram corn pea. Brussels sprout coriander water chestnut gourd swiss chard wakame kohlrabi beetroot carrot watercress. Corn amaranth salsify bunya nuts nori azuki bean chickweed potato bell pepper artichoke. ', 'maria', '2014-06-01', '2015-02-20', 'Piazza ugo bassi', 'via del pepe 23', '300.00', 0),
(3, 3, 'Appartamento a piano terra', 'Turnip greens yarrow ricebean rutabaga endive cauliflower sea lettuce kohlrabi amaranth water spinach avocado daikon napa cabbage asparagus winter purslane kale. Celery potato scallion desert raisin horseradish spinach carrot soko. Lotus root water spinach fennel kombu maize bamboo shoot green bean swiss chard seakale pumpkin onion chickpea gram corn pea. Brussels sprout coriander water chestnut gourd swiss chard wakame kohlrabi beetroot carrot watercress. Corn amaranth salsify bunya nuts nori azuki bean chickweed potato bell pepper artichoke. ', 'maria', '2014-06-11', '2014-12-25', 'passetto', 'via della pizza 2', '1000.00', 10);

INSERT INTO `accomodation_data` (`id`, `accomodation`, `feature_id`, `feature_value`) VALUES
(1, 2, 2, 'boooo'),
(2, 1, 2, 'asd');



INSERT INTO `contract` (`id`, `lesser`, `lessee`, `iban`, `fee`, `beginning`, `ending`, `address`, `state`) VALUES
(1, 'latore', 'latario', '102039394848939290029384', '200.00', '2014-06-02', '2014-06-28', 'via del pane 1111', 0),
(3, 'latario', 'maria', '020202020202020200202200202', '200.00', '2014-06-10', '2014-06-28', 'via del pozzo 22', 1);

INSERT INTO `faq` (`id`, `question`, `answer`) VALUES
(1, 'Domanda Uno', 'Bacon ipsum dolor sit amet pig shankle pork chop corned beef sirloin, pancetta ham capicola pork rump boudin filet mignon fatback. Jerky salami meatball beef ribs shank fatback pastrami ribeye frankfurter venison bresaola sirloin ham hock bacon ground round. Meatball corned beef biltong pork loin. Tri-tip fatback doner chuck, meatloaf pig shankle boudin brisket shoulder short ribs tongue.'),
(2, 'DOmanda Due', 'Bacon ipsum dolor sit amet pig shankle pork chop corned beef sirloin, pancetta ham capicola pork rump boudin filet mignon fatback. Jerky salami meatball beef ribs shank fatback pastrami ribeye frankfurter venison bresaola sirloin ham hock bacon ground round. Meatball corned beef biltong pork loin. Tri-tip fatback doner chuck, meatloaf pig shankle boudin brisket shoulder short ribs tongue.'),
(3, 'Domanda Tre', 'Doner meatball sausage, ball tip turducken pork chop leberkas turkey t-bone strip steak kielbasa pork loin hamburger bacon shank. Biltong rump chuck tongue beef ribs fatback pork chop corned beef jowl meatball tri-tip pancetta tenderloin capicola. Tri-tip fatback pork drumstick swine pork loin pork belly shank jerky meatloaf capicola brisket. Ham pork boudin pork chop filet mignon capicola turkey drumstick pig bacon hamburger fatback short loin leberkas. Prosciutto rump biltong meatloaf, pork chop ribeye chuck jowl shoulder ham hock drumstick swine. Ground round biltong tenderloin salami prosciutto pastrami shank shankle. Fatback tenderloin tail filet mignon bresaola rump ribeye swine landjaeger ball tip chuck flank.'),
(4, 'Domanda Quattro', 'Pork chop beef sausage swine tongue. Ribeye andouille corned beef rump landjaeger porchetta ham tail pig turducken swine. Leberkas drumstick pork chop, corned beef tri-tip pork loin kevin rump pancetta flank. Bacon jowl pancetta, pork loin swine hamburger frankfurter boudin ball tip pork belly t-bone biltong salami. Hamburger filet mignon short ribs, shankle cow chicken doner flank.');


INSERT INTO `message` (`id`, `sender`, `recipient`, `send_date`, `content`) VALUES
(1, 'admin', 'latario', '2014-06-01 17:28:18', 'salve'),
(2, 'latario', 'latore', '2014-06-01 17:52:33', 'la ringrazio'),
(3, 'latore', 'maria', '2014-06-01 17:29:28', 'Ciao'),
(4, 'latario', 'admin', '2014-06-04 22:00:00', 'Turnip greens yarrow ricebean rutabaga endive cauliflower sea lettuce kohlrabi amaranth water spinach avocado daikon napa cabbage asparagus winter purslane kale. Celery potato scallion desert raisin horseradish spinach carrot soko. Lotus root water spinach fennel kombu maize bamboo shoot green bean swiss chard seakale pumpkin onion chickpea gram corn pea. Brussels sprout coriander water chestnut gourd swiss chard wakame kohlrabi beetroot carrot watercress. Corn amaranth salsify bunya nuts nori azuki bean chickweed potato bell pepper artichoke. '),
(5, 'latario', 'admin', '2014-06-04 22:00:00', 'Turnip greens yarrow ricebean rutabaga endive cauliflower sea lettuce kohlrabi amaranth water spinach avocado daikon napa cabbage asparagus winter purslane kale. Celery potato scallion desert raisin horseradish spinach carrot soko. Lotus root water spinach fennel kombu maize bamboo shoot green bean swiss chard seakale pumpkin onion chickpea gram corn pea. Brussels sprout coriander water chestnut gourd swiss chard wakame kohlrabi beetroot carrot watercress. Corn amaranth salsify bunya nuts nori azuki bean chickweed potato bell pepper artichoke. ');

