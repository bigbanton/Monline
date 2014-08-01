-- MySQL Administrator dump 1.4

--

-- ------------------------------------------------------

-- Server version	5.0.77mm0.1-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

--

-- Definition of table `poi`

--

DROP TABLE IF EXISTS `poi`;

CREATE TABLE `poi` (

  `id` int(5) NOT NULL auto_increment,

  `lat` float(15,10) NOT NULL,

  `lng` float(15,10) NOT NULL,

  `title` text,

  `address` text,

  `url` text,

  `html` text,

  `category` text,

  `marker` text,

  PRIMARY KEY  (`id`)

) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

--

-- Dumping data for table `poi`

--

/*!40000 ALTER TABLE `poi` DISABLE KEYS */;

INSERT INTO `poi` (`id`,`lat`,`lng`,`title`,`address`,`url`,`html`,`category`,`marker`) VALUES 

 (39,-37.9104156494,145.0614471436,'Lollipops Playland & Cafe','234 East Boundary Rd, Bentleigh East, 3165 ph: (03) 9579 7491','#','234 East Boundary Rd, Bentleigh East, 3165 ph: (03) 9579 7491','playground',''),

 (40,-37.8159828186,144.9493408203,'Monkey Mania','Docklands, 3008 ph: (03) 9600 3772','#','Docklands, 3008 ph: (03) 9600 3772','playground',''),

 (41,-37.6848449707,144.5960083008,'Mumbo Jumbo Children\'s Indoor Play Centre & Cafe','High St, Melton, 3337 ph: (03) 9746 0400','#','High St, Melton, 3337 ph: (03) 9746 0400','playground',''),

 (42,-37.8694229126,145.2097625732,'Planet Play','Pumps Rd, Wantirna South, 3152 ph: (03) 9801 3200','#','Pumps Rd, Wantirna South, 3152 ph: (03) 9801 3200','playground',''),

 (44,-37.8483695984,145.0766601562,'Rare Bears','1134 Toorak Rd, Camberwell, 3124 ph: (03) 9889 9444','#','1134 Toorak Rd, Camberwell, 3124 ph: (03) 9889 9444','playground',''),

 (55,-37.7107467651,145.1524658203,'Your Own Botanical Wonderland','1 Grove Street, ELTHAM, vic','http://www.domain.com.au/Property/For-Sale/House/VIC/Eltham/?adid=2008395767','<p>Only 400 meters (approx) from Eltham shops, station and schools on a huge 1485mz allotment with a town park at your front gate.</p>','property','grove'),

 (46,-37.6460838318,145.0125274658,'Rumbles Indoor Playcentre and Cafe','30 Yale Drv, Epping, 3076 ph: (03) 9408 4250','#','30 Yale Drv, Epping, 3076 ph: (03) 9408 4250','playground',''),

 (47,-38.1328773499,145.1279754639,'Saxon Sports Frankston','4 New St, Frankston, 3199 ph: (03) 9783 6066','#','4 New St, Frankston, 3199 ph: (03) 9783 6066','playground',''),

 (48,-37.8907165527,145.3001861572,'Time Out 4 Kids','1140 Burwood Hwy, Ferntree Gully, 3156 ph: (03) 9753 6488','#','1140 Burwood Hwy, Ferntree Gully, 3156 ph: (03) 9753 6488','playground',''),

 (49,-37.8497085571,144.8750915527,'Tumbles Playhouse','197 Champion Rd, Williamstown, 3016 ph: (03) 9397 0811','#','197 Champion Rd, Williamstown, 3016 ph: (03) 9397 0811','playground',''),

 (50,-37.8718528748,144.7286834717,'Wonderland Indoor Children\'s Playcentre','55 Graham Crt, Hoppers Crossing, 3029 ph: (03) 9931 0770','#','55 Graham Crt, Hoppers Crossing, 3029 ph: (03) 9931 0770','playground',''),

 (51,-37.7016067505,145.0719604492,'Wriggle It','445 Grimshaw St, Bundoora, 3803 ph: (03) 9466 9502','#','445 Grimshaw St, Bundoora, 3803 ph: (03) 9466 9502','playground',''),

 (52,-38.1511878967,145.1653900146,'Wriggle It','197 Karingal Drv, Karingal, 3199 ph: (03) 9789 8434','#','197 Karingal Drv, Karingal, 3199 ph: (03) 9789 8434','playground',''),

 (53,-38.0044136047,145.2573394775,'Xanadu Children\'s Indoor Playcentre','151 Princes Hwy, Hallam, 3803 ph: (03) 8795 7772','#','151 Princes Hwy, Hallam, 3803 ph: (03) 8795 7772','playground',''),

 (54,-37.8689918518,145.2478942871,'Yoyos Playland','108 Lewis Rd, Wantirna South, 3152 ph: (03) 9801 6488','#','108 Lewis Rd, Wantirna South, 3152 ph: (03) 9801 6488','playground',''),

 (56,-37.7085151672,145.1552276611,'The Look, The Location And The Lifestyle','34 Stanley Avenue ELTHAM, vic','http://www.domain.com.au/Property/For-Sale/House/VIC/Eltham/?adid=2008395053','<p>This recently renovated home blends sought after features of decorative cornice, metal framed windows and polished timber floors</p><img src=\"http://images.domain.com.au/img/2010528/4241/2008395053_1_TE.JPG?mod=100530-094714\" height=100/>','property','stanleyst'),

 (9,-37.7025070190,145.1057128906,'Eltham, Victoria','Main St, Eltham, Vic','#','<strong>Eltham Town</strong>','town','town'),

 (10,-37.7162246704,145.1454467773,'Eltham Central Park, Car Park','Panther Place, Eltham, Vic','#','Between Library and Playground - 40 spaces','parking','parking'),

 (11,-37.7143898010,145.1498107910,'Safeway Carpark','19 Arthur St, Eltham, Vic','#','Double storey Carpark - 120 spaces','parking','parking'),

 (12,-37.7126502991,145.1511077881,'Dan Murphys Carpark','20 Luck St, Eltham, Vic','#','40 Spaces - also used for ALDI customers','parking','parking'),

 (13,-37.7168197632,145.1457214355,'Eltham Town Park Playground','14 Panther Pl, Eltham Vic','#','Swings,slides, duck feeding','playground',''),

 (14,-37.7146301270,145.1520385742,'Alan Marshall Park','110 Bible St, Eltham, Vic','#','See Saw and Swings','playground','playground'),

 (15,-37.7152290344,145.1469116211,'Eltham Football Club Playground','16 Library Place, Eltham, Vic','#','16 Library Place, Eltham, Vic','playground',''),

 (16,-37.6956672668,145.0687866211,'Old Grimshaw Primary School Park','Hastings St / Fotini Gdns, Bundoora, Vic','#','Hastings St / Fotini Gdns, Bundoora, Vic','playground','playground'),

 (17,-37.8341674805,145.1653289795,'Amber\'s Playhouse','270 Canterbury Rd, Forest Hill, 3131','#','270 Canterbury Rd, Forest Hill, 3131 ph: (03) 9878 7468','playground',''),

 (18,-37.8245391846,145.3064117432,'Awesome Fun','11, 257 Colchester Rd, Kilsyth, 3137','#','11, 257 Colchester Rd, Kilsyth, 3137 ph: (03) 9720 4833','playground',''),

 (19,-37.8219032288,145.0353240967,'Billy Lids Indoor Play Centre','86 Lynch St, Hawthorn, 3122','#','86 Lynch St, Hawthorn, 3122 ph: (03) 9818 2225','playground',''),

 (20,-37.9086532593,145.0113525391,'Bonkers Indoor Playcentre & Cafe','497 Nepean Hwy, Brighton East, 3187','#','497 Nepean Hwy, Brighton East, 3187 ph: (03) 9530 6601','playground',''),

 (21,-37.9148101807,144.6611480713,'Bumblebeez Indoor Playcentre and Cafe','27 Loop Rd, Werribee, 3030 ph: (03) 9742 2255','#','27 Loop Rd, Werribee, 3030 ph: (03) 9742 2255','playground',''),

 (22,-38.1644668579,145.1367492676,'Buzy Kidz','124 Frankston Flinders Rd, Frankston, 3199 ph: (03) 9783 3444','#','124 Frankston Flinders Rd, Frankston, 3199 ph: (03) 9783 3444','playground',''),

 (23,-37.6572723389,145.0802612305,'Buzy Kidz','3 Development Blvd, Mill Park, 3082 ph: (03) 9437 7727','#','3 Development Blvd, Mill Park, 3082 ph: (03) 9437 7727','playground',''),

 (24,-37.7145538330,144.9881591797,'Chuckles Children\'s Play and Party Centre','263 Edwardes St, Reservoir, 3073 ph: (03) 9462 3980','#','263 Edwardes St, Reservoir, 3073 ph: (03) 9462 3980','playground',''),

 (25,-37.7691497803,144.9982757568,'Clowning Around Play Centre','2 Arthurton Rd, Northcote, 3070 ph: (03) 9489 8085','#','2 Arthurton Rd, Northcote, 3070 ph: (03) 9489 8085','playground',''),

 (26,-37.8562355042,144.9968566895,'Day Dreamers','71 Mcilwrick St, Windsor, 3181 (03) 9521 2170','#','71 Mcllwrick St, Windsor, 3181 ph: (03) 9521 2170','playground',''),

 (27,-37.7869491577,144.8892669678,'Dizzy\'s Castle','1 Mephan St, Maribyrnong, 3032 ph: (03) 9318 1110','#','1 Mephan St, Maribyrnong, 3032 ph: (03) 9318 1110','playground',''),

 (28,-37.8907165527,145.3001861572,'Eco-playscape','1140 Burwood Hwy, Ferntree Gully, 3156 ph: (03) 9753 6488','#','1140 Burwood Hwy, Ferntree Gully, 3156 ph: (03) 9753 6488','playground',''),

 (29,-37.6907348633,145.0132904053,'Fantasy World','Abruzzo Cres, Thomastown, 3074 ph: (03) 9464 6199','#','Abruzzo Cres, Thomastown, 3074 ph: (03) 9464 6199','playground',''),

 (30,-37.6861114502,144.8823242188,'Jump \'N\' Jiggle','217 Mickleham Rd, Tullamarine, 3043 ph: (03) 9330 0181','#','217 Mickelham Rd, Tullamarine, 3043 ph: (03) 9330 0181','playground',''),

 (31,-37.7025070190,144.7966461182,'Junglemania','100 Village Ave, Taylors Lakes, 3038 ph: (03) 9449 8822','#','100 Village Ave, Taylors Lakes, 3038 ph: (03) 9449 8822','playground',''),

 (32,-38.0161514282,145.2643432617,'Kids Space Indoor Play & Party Centre','79 Star Cres, Hallam, 3803 ph: (03) 8786 3909','#','79 Star Cres, Hallam, 3803 ph: (03) 8786 3909','playground',''),

 (33,-38.1059150696,145.1654510498,'Kidz Corner Peninsula','2 Amayla Cres, Carrum Downs, 3201 ph: (03) 9773 6844','#','2 Amayla Cres, Carrum Downs, 3201 ph: (03) 9773 6844','playground',''),

 (35,-38.3138008118,145.1805114746,'Kidz World Indoor Playcentre','8 Bray St, Hastings, 3915 ph: (03) 5979 3200','#','8 Bray St, Hastings, 3915 ph: (03) 5979 3200','playground',''),

 (36,-37.7491836548,144.9650268555,'Kidz Zone','219 Sydney Rd, Coburg, 3058 ph: (03) 9383 1977','#','219 Sydney Rd, Coburg, 3058 ph: (03) 9383 1977','playground',''),

 (37,-37.7946777344,144.8628845215,'Kidzmania Indoor Playcentre and Cafe','Ashley St, West Footscray, 3012','#','South Rd / Ashley St, West Footscray, 3012 ph: (03) 9689 9800','playground',''),

 (38,55.6441421509,11.8611001968,'Koko Jumbo','Unit 6, East Court, 101-155 Beresford Rd, Lilydale, 3140 ph: (03) 9735 0881','#','Unit 6, East Court, 101-155 Beresford Rd, Lilydale, 3140 ph: (03) 9735 0881','playground',''),

 (57,-37.7062950134,145.1560668945,'A Home Full Of Rewards','35 Helene Street ELTHAM','http://www.domain.com.au/Property/For-Sale/House/VIC/Eltham/?adid=2008360680','<p>Filled with charm and character, this house will appeal to anyone looking for a warm and comfortable place to call home. Beautifully renovated throughout, superbly located</p><img src=\"http://images.domain.com.au/img/2010524/6223/2008360680_2_TE.JPG?mod=100530-094714\"  height=100 />','property','helenest'),

 (58,-37.7132110596,145.1387481689,'Modern Master Piece.','2A Bird Street ELTHAM','http://www.domain.com.au/Property/For-Sale/Townhouse/VIC/Eltham/?adid=2008337542','<p>Master built by the Diamond Valley\'s own North Eastern Developments, renowned for their quality finishes, innovative style and eye for detail this stunning townhouse is bound to impress.</p><img src=\"http://images.domain.com.au/img/2010428/6223/2008337542_1_TE.JPG?mod=100530-094714\" height=100 />','property','birdst'),

 (59,-37.7151679993,145.1522369385,'Taldamar Cottage (Circa 1930)','106 Bible St Eltham','http://www.domain.com.au/Property/For-Sale/House/VIC/Eltham/?adid=2008398242','<p>In Walking Distance, to the Eltham Cafes, the Shops & the Station, This Fully Renovated 3 Bedroom California Bungalow Period Cottage has both Formal & Informal Living Rooms.</p><img src=\"http://images.domain.com.au/img/2010528/11252/2008398242_1_TE.JPG?mod=100530-100106\" height=100/>','property','106biblest'),

 (60,-37.7121887207,145.1457672119,'Waterfall','43 Diamond St, Eltham','#','<img src=\"demo/waterfall1.jpg\" height=172 />','photo','waterfall1'),

 (61,-37.7133903503,145.1445922852,'Horse','20 Handfield St, Eltham, Vic','#','<img src=\"demo/horse1.jpg\" height=172 />','photo','horse1'),

 (62,-37.7119636536,145.1507110596,'Plant','12 Cecil St Eltham','#','<img src=\"demo/plant1.jpg\" height=172 />','photo','plant1');

/*!40000 ALTER TABLE `poi` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

