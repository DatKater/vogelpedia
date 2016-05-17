-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Mai 2016 um 08:28
-- Server-Version: 10.1.10-MariaDB
-- PHP-Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `vogelpedia`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bird`
--

CREATE TABLE `bird` (
  `idbird` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `name_latin` varchar(75) NOT NULL,
  `description` mediumtext,
  `min_livestock` int(11) DEFAULT NULL,
  `max_livestock` int(11) DEFAULT NULL,
  `min_length` int(11) DEFAULT NULL,
  `max_length` int(11) DEFAULT NULL,
  `min_wingspread` int(11) DEFAULT NULL,
  `max_wingspread` int(11) DEFAULT NULL,
  `min_weight` int(11) DEFAULT NULL,
  `max_weight` int(11) DEFAULT NULL,
  `life_expectancy` int(11) DEFAULT NULL,
  `breeding_duration` int(11) DEFAULT NULL,
  `image_path` varchar(100) DEFAULT NULL,
  `red_list` tinyint(1) DEFAULT NULL,
  `family_idfamily` int(11) NOT NULL,
  `breeding_place_idbreeding_place` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `bird`
--

INSERT INTO `bird` (`idbird`, `name`, `name_latin`, `description`, `min_livestock`, `max_livestock`, `min_length`, `max_length`, `min_wingspread`, `max_wingspread`, `min_weight`, `max_weight`, `life_expectancy`, `breeding_duration`, `image_path`, `red_list`, `family_idfamily`, `breeding_place_idbreeding_place`) VALUES
(3, 'Amsel', 'Turdus merula', 'Die Amsel ist mit ihrem melodischen, wohlklingenden Flöten, das manchmal schon im Januar erklingt, einer der ersten Frühlingsboten. Sie singt gerne an exponierten Stellen, auf Dachfirsten oder Baumwipfeln, so dass ihr Gesang weithin zu hören ist. Das liebliche, gedämpfte Schlussmotiv wird bei geschlossenem Schnabel gesummt und klingt wie ein entferntes Echo. Die Amsel war ursprünglich eine scheue Bewohnerin dichter, unterholzreicher Wälder. Erst im Lauf der letzten 100 Jahre ist sie so zahlreich in Siedlungen und Städte vorgedrungen, dass sie heute in Europa zu den häufigsten und am weitesten verbreiteten Brutvögeln gehört.', 400000, 600000, 24, 29, 34, 34, 80, 110, 14, 14, 'http://www.vogelwarte.ch/assets/images/voegel/vds/artbilder/700px/4240_0.jpg', 0, 1, 1),
(4, 'Pirol', 'Oriolus oriolus', 'Die nächsten Verwandten des exotisch aussehenden Pirols leben in den Tropen in Afrika und Asien. Trotz seines auffälligen gelbschwarzen Gefieders ist er in den lichtdurchfluteten Baumkronen wegen seiner versteckten Lebensweise nicht leicht zu entdecken. Am einfachsten ist er anhand des wohlklingenden Gesangs nachzuweisen. Den Flötenrufen verdankt der Pirol neben dem deutschen Artnamen und der wissenschaftlichen Bezeichnung Oriolus auch den französischen Namen «Loriot». Oft wird der Gesang allerdings vom Star treffend ähnlich nachgeahmt. Der Pirol hält sich im eigentlichen Brutgebiet nur drei Monate auf, bevor er wieder in die Winterquartiere aufbricht.', 1000, 2000, 22, 25, 44, 44, 65, 67, 7, 15, 'http://www.vogelwarte.ch/assets/images/voegel/vds/artbilder/700px/3660_0.jpg', 0, 2, 1),
(5, 'Singdrossel', 'Turdus philomelus', 'Der Gesang der Singdrossel vermittelt Vorfrühlingsstimmung. Bereits früh im März hallen die Wälder in der Dämmerung von den Wiederholungen der lauten und klaren Motive wider. Bekannt ist die Singdrossel vor allem wegen ihrer Drosselschmieden: An geeigneten, regelmässig genutzten Steinen zertrümmert sie das Gehäuse von Schnecken, um an den weichen Körper zu gelangen.', 200000, 250000, 21, 24, 33, 36, 65, 90, 12, 13, 'http://www.vogelwarte.ch/assets/images/voegel/vds/artbilder/700px/4310_0.jpg', NULL, 1, 1),
(6, 'Steinkauz', 'Athene noctua', 'Der Steinkauz hat bei uns seit Jahrhunderten in unmittelbarer Nachbarschaft des Menschen gelebt, oft als Untermieter in Scheunen und Ruinen. In der bäuerlichen Bevölkerung galt er mit seinen mysteriösen nächtlichen Rufen als «Totenvogel», bei den alten Griechen war er das Sinnbild der Göttin Athene, was im wissenschaftlichen Namen zum Ausdruck kommt. Durch den Rückgang extensiv bewirtschafteter Obstgärten setzte ab den Fünfzigerjahren ein schneller Rückgang ein, und heute sind die kleinen Kobolde grösstenteils verschwunden.', 80, 110, 21, 23, 54, 58, 140, 200, 11, 27, 'http://www.vogelwarte.ch/assets/images/voegel/vds/artbilder/700px/3130_0.jpg', 0, 3, 1),
(7, 'Waldohreule', 'Asio otus', 'Die dumpfen Balzrufe der Waldohreule, die in Februar- und Märznächten vorgetragen werden, sind nicht weit hörbar. Tagsüber sind die Vögel wegen ihres rindenfarbenen Gefieders kaum zu entdecken. Am ehesten verraten die oft die ganze Nacht über laut fiependen Jungeulen die Anwesenheit der Art. Die namensgebenden «Ohren» sind lediglich verlängerte Kopffedern.', 2500, 3000, 35, 37, 90, 90, 210, 330, 27, 27, 'http://www.vogelwarte.ch/assets/images/voegel/vds/artbilder/700px/3170_0.jpg', 0, 3, 1),
(8, 'Sumpfohreule', 'Asio flammeus', 'Die teilweise tagaktive Sumpfohreule hat im Gegensatz zur Waldohreule nur rudimentäre Federohren, was ihr den englischen Artnamen eingebracht hat. Die äussere schwarze Augenumrandung, die gelbe Iris und der auffällige Gesichtsschleier gibt ihr einen «übernächtigten» Gesichtsausdruck. Wegen der Tarnfärbung und der Musterung des Gefieders ist sie an den Bodenruheplätzen kaum zu entdecken.', 0, 0, 33, 40, 95, 105, 260, 350, 21, 26, 'http://www.vogelwarte.ch/assets/images/voegel/vds/artbilder/700px/3180_0.jpg', NULL, 3, 5),
(9, 'Zwergohreule', 'Otus scops', 'Der monoton flötende Gesang der Zwergohreule, der in windstillen Frühlingsnächten pausenlos ertönen kann, könnte bei uns bald nicht mehr zu hören sein. Die Erweiterung von Weinbergen, Bautätigkeit und der Rückgang von Grossinsekten entziehen der wärmeliebenden Art die Lebensbedingungen immer mehr. Derzeit gibt es nur noch ein kleines Restvorkommen im Mittelwallis. Die Vögel sind dank ihres rindenfarbigen Gefieders tagsüber kaum zu entdecken und die einzigen Langstreckenzieher unter den einheimischen Eulen.', 20, 30, 19, 20, 53, 63, 75, 63, 7, 24, 'http://www.vogelwarte.ch/assets/images/voegel/vds/artbilder/700px/3080_0.jpg', NULL, 3, 4),
(10, 'Stockente', 'Anas platyrhynchos', 'Die Stockente ist für viele die Wildente schlechthin. Sie ist die am weitesten verbreitete Gründelente der Welt und die Stammform unserer Hausente. Stockenten sind ausserordentlich anpassungsfähig und brüten in einer Vielzahl von Lebensräumen von Sibirien bis in die Subtropen. Zudem haben sie nur wenig Scheu vor Menschen, lassen sich füttern und nisten auch mitten in der Stadt in Blumenkisten auf Dachterrassen und Balkonen. Oftmals treten abweichend gefärbte Enten mit weissen oder dunklen Federpartien auf. Dabei handelt es sich um Bastarde zwischen Stockenten und Hausentenrassen.', 10000, 20000, 50, 65, 81, 98, 850, 1400, 26, 28, 'http://www.vogelwarte.ch/assets/images/voegel/vds/artbilder/700px/0720_0.jpg', NULL, 10, 5),
(11, 'Uhu', 'Bubo bubo', 'Der Uhu ist eine imposante Erscheinung. Tagsüber ruht er gerne an störungsarmen, deckungsreichen Stellen in Felswänden, von wo er sein Revier überblicken kann. Er kommt sowohl über der Waldgrenze als auch in den Niederungen vor und ist recht anspruchslos, sofern das Gebiet reich an Beutetieren ist. Heute hat sich der Brutbestand in unserem Land zwar wieder etwas erholt, aber der Uhu erleidet durch die Verkabelung und Verdrahtung der Landschaft sowie durch den Verkehr hohe Verluste.', 100, 140, 60, 75, 160, 160, 1500, 3000, 25, 35, 'http://www.vogelwarte.ch/assets/images/voegel/vds/artbilder/700px/3090_0.jpg', 1, 3, 2),
(12, 'Bienenfresser', 'Merops Apiaster', 'xyyzz', 66, 77, 27, 29, 44, 44, 45, 75, NULL, 21, 'http://www.grauer-kranich.de/bilder/merops-apiaster-013.jpg', 1, 27, 7);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bird_has_color`
--

CREATE TABLE `bird_has_color` (
  `bird_idbird` int(11) NOT NULL,
  `color_idcolor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `bird_has_color`
--

INSERT INTO `bird_has_color` (`bird_idbird`, `color_idcolor`) VALUES
(3, 1),
(4, 1),
(4, 2),
(5, 4),
(6, 3),
(6, 4),
(7, 4),
(8, 4),
(9, 3),
(9, 4),
(10, 1),
(10, 2),
(10, 3),
(10, 4),
(10, 5),
(10, 6),
(10, 7),
(10, 9),
(11, 4),
(12, 1),
(12, 2),
(12, 4),
(12, 6),
(12, 8),
(12, 9);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bird_has_food`
--

CREATE TABLE `bird_has_food` (
  `bird_idbird` int(11) NOT NULL,
  `food_idfood` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `bird_has_food`
--

INSERT INTO `bird_has_food` (`bird_idbird`, `food_idfood`) VALUES
(3, 1),
(3, 2),
(4, 2),
(4, 3),
(4, 4),
(5, 1),
(5, 2),
(5, 4),
(6, 1),
(6, 2),
(6, 5),
(6, 7),
(7, 5),
(7, 6),
(8, 5),
(8, 6),
(9, 2),
(10, 2),
(10, 8),
(10, 9),
(10, 10),
(11, 5),
(11, 6),
(12, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bird_has_habitat`
--

CREATE TABLE `bird_has_habitat` (
  `bird_idbird` int(11) NOT NULL,
  `habitat_idhabitat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `bird_has_habitat`
--

INSERT INTO `bird_has_habitat` (`bird_idbird`, `habitat_idhabitat`) VALUES
(3, 1),
(3, 2),
(4, 2),
(5, 1),
(5, 2),
(6, 3),
(6, 5),
(7, 1),
(7, 2),
(7, 3),
(8, 3),
(8, 6),
(9, 3),
(9, 5),
(10, 3),
(10, 4),
(10, 6),
(10, 7),
(10, 8),
(11, 1),
(12, 25);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `breeding_place`
--

CREATE TABLE `breeding_place` (
  `idbreeding_place` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `breeding_place`
--

INSERT INTO `breeding_place` (`idbreeding_place`, `name`, `description`) VALUES
(1, 'Bäume', 'Auf grossen verholzten Pflanzen'),
(2, 'Gebäude', 'In Gebäudenischen'),
(3, 'Sträucher', 'In dichten Hecken und Feldgehölzen'),
(4, 'Baumhöhlen', NULL),
(5, 'Boden', NULL),
(6, 'Gebäude', NULL),
(7, 'Steilwände', NULL),
(8, 'Felsnischen', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `color`
--

CREATE TABLE `color` (
  `idcolor` int(11) NOT NULL,
  `color_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `color`
--

INSERT INTO `color` (`idcolor`, `color_name`) VALUES
(5, 'blau'),
(4, 'braun'),
(2, 'gelb'),
(3, 'grau'),
(9, 'grün'),
(6, 'orange'),
(8, 'rot'),
(1, 'schwarz'),
(7, 'weiss');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `family`
--

CREATE TABLE `family` (
  `idfamily` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `order_idorder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `family`
--

INSERT INTO `family` (`idfamily`, `name`, `order_idorder`) VALUES
(1, 'Drosseln', 1),
(2, 'Pirole', 1),
(3, 'Eigentliche Eulen', 16),
(4, 'Schleiereulen', 16),
(5, 'Störche', 4),
(6, 'Reiher', 4),
(7, 'Ibisse & Löffler', 4),
(8, 'Schuhschnabel', 4),
(9, 'Hammerkopf', 4),
(10, 'Entenvögel', 2),
(11, 'Wiedehopfe', 19),
(12, 'Nashornvögel', 19),
(13, 'Eigentliche Falken', 17),
(14, 'Habichtartige', 15),
(15, 'Fischadler', 15),
(16, 'Neuweltgeier', 15),
(17, 'Grossfusshühner', 3),
(18, 'Fasanenartige', 3),
(19, 'Kraniche', 9),
(20, 'Rallen', 9),
(21, 'Kuckucke', 12),
(22, 'Flamingos', 23),
(23, 'Lappentaucher', 22),
(24, 'Eisvögel', 21),
(25, 'Erdracken', 21),
(26, 'Racken', 21),
(27, 'Bienenfresser', 21),
(28, 'Alkenvögel', 11),
(29, 'Raubmöwen', 11),
(30, 'Möwen', 11),
(31, 'Schnepfenvögel', 11),
(32, 'Regenpfeifer', 11),
(33, 'Säbelschnäbler', 11),
(34, 'Austernfischer', 11),
(35, 'Nachtschwalben', 13),
(36, 'Seetaucher', 7),
(37, 'Segler', 14),
(53, 'Spechte', 20),
(54, 'Rabenvögel', 1),
(55, 'Würger', 1),
(56, 'Goldhähnchen', 1),
(57, 'Zaunkönige', 1),
(58, 'Baumläufer', 1),
(59, 'Kleiber', 1),
(60, 'Seidenschwänze', 1),
(61, 'Stare', 1),
(62, 'Wasseramseln', 1),
(63, 'Stelzen', 1),
(64, 'Fliegenschnäpper', 1),
(65, 'Braunellen', 1),
(66, 'Meisen', 1),
(67, 'Sperlinge', 1),
(84, 'Ammern', 1),
(85, 'Finken', 1),
(86, 'Lerchen', 1),
(87, 'Schwalben', 1),
(88, 'Grasmückenartige', 1),
(89, 'Halmsängerartige', 1),
(90, 'Feldtauben', 10),
(91, 'Turteltauben', 10);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `food`
--

CREATE TABLE `food` (
  `idfood` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `food`
--

INSERT INTO `food` (`idfood`, `name`) VALUES
(11, 'Aas'),
(13, 'Abfall'),
(15, 'Allesfresser'),
(16, 'Amphibien'),
(18, 'Arvennüsse'),
(20, 'Beeren'),
(50, 'Brot'),
(42, 'Fichtensamen'),
(17, 'Fische'),
(3, 'Früchte'),
(19, 'Haselnüsse'),
(2, 'Insekten'),
(5, 'Kleinsäuger'),
(12, 'Knochen'),
(41, 'Knospen'),
(43, 'Krebstiere'),
(48, 'Krustentiere'),
(44, 'Muscheln'),
(8, 'Pflanzen'),
(49, 'Plankton'),
(46, 'Quallen'),
(7, 'Reptilien'),
(9, 'Samen'),
(14, 'Säuger'),
(10, 'Schnecken'),
(4, 'Spinnen'),
(45, 'Tintenfische'),
(6, 'Vögel'),
(47, 'Wasserpflanzen'),
(52, 'Wespenbruten'),
(51, 'Wirbellose'),
(1, 'Würmer');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `habitat`
--

CREATE TABLE `habitat` (
  `idhabitat` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `habitat`
--

INSERT INTO `habitat` (`idhabitat`, `name`) VALUES
(9, 'Felsen'),
(10, 'Felsensteppe'),
(11, 'felsige Inseln'),
(6, 'Feuchtgebiete'),
(7, 'Fliessgewässer'),
(14, 'Gebirge'),
(12, 'Gebüschwald'),
(15, 'Halbwüste'),
(17, 'Hecken'),
(20, 'kahle Bergrücken'),
(21, 'Kastanienwald'),
(13, 'Kiesgruben'),
(3, 'Kulturland'),
(2, 'Laubwald'),
(22, 'Nadelwald'),
(5, 'Obstgärten'),
(18, 'Ödland'),
(23, 'Rebberge'),
(8, 'Seen'),
(4, 'Siedlungen'),
(24, 'Steinbrüche'),
(16, 'Steppe'),
(1, 'Wald'),
(19, 'Waldrand'),
(26, 'Weiden'),
(25, 'Wiesen'),
(27, 'Wüsten');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `order`
--

CREATE TABLE `order` (
  `idorder` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `order`
--

INSERT INTO `order` (`idorder`, `name`) VALUES
(19, 'Bucerotiformes'),
(16, 'Eulen'),
(17, 'Falkenartige'),
(2, 'Gänsevögel'),
(15, 'Greifvögel'),
(3, 'Hühnervögel'),
(9, 'Kranichvögel'),
(12, 'Kuckucksvögel'),
(18, 'Papageien'),
(23, 'Phoenicopteriformes'),
(6, 'Pinguine'),
(22, 'Podicipediformes'),
(21, 'Rackenvögel'),
(11, 'Regepfeiferartige'),
(8, 'Röhrennasen'),
(4, 'Schreitvögel'),
(13, 'Schwalmartige'),
(7, 'Seetaucher'),
(14, 'Seglervögel'),
(20, 'Spechtvögel'),
(1, 'Sperlingsvögel'),
(10, 'Taubenvögel'),
(5, 'Tropikvögel');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `iduser` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_has_bird`
--

CREATE TABLE `user_has_bird` (
  `user_iduser` int(11) NOT NULL,
  `bird_idbird` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bird`
--
ALTER TABLE `bird`
  ADD PRIMARY KEY (`idbird`),
  ADD UNIQUE KEY `idbird_UNIQUE` (`idbird`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD UNIQUE KEY `name_latin_UNIQUE` (`name_latin`),
  ADD KEY `fk_bird_family_idx` (`family_idfamily`),
  ADD KEY `fk_bird_breeding_place1_idx` (`breeding_place_idbreeding_place`);

--
-- Indizes für die Tabelle `bird_has_color`
--
ALTER TABLE `bird_has_color`
  ADD PRIMARY KEY (`bird_idbird`,`color_idcolor`),
  ADD KEY `fk_bird_has_color_color1_idx` (`color_idcolor`),
  ADD KEY `fk_bird_has_color_bird1_idx` (`bird_idbird`);

--
-- Indizes für die Tabelle `bird_has_food`
--
ALTER TABLE `bird_has_food`
  ADD PRIMARY KEY (`bird_idbird`,`food_idfood`),
  ADD KEY `fk_bird_has_food_food1_idx` (`food_idfood`),
  ADD KEY `fk_bird_has_food_bird1_idx` (`bird_idbird`);

--
-- Indizes für die Tabelle `bird_has_habitat`
--
ALTER TABLE `bird_has_habitat`
  ADD PRIMARY KEY (`bird_idbird`,`habitat_idhabitat`),
  ADD KEY `fk_bird_has_habitat_habitat1_idx` (`habitat_idhabitat`),
  ADD KEY `fk_bird_has_habitat_bird1_idx` (`bird_idbird`);

--
-- Indizes für die Tabelle `breeding_place`
--
ALTER TABLE `breeding_place`
  ADD PRIMARY KEY (`idbreeding_place`);

--
-- Indizes für die Tabelle `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`idcolor`),
  ADD UNIQUE KEY `color_name_UNIQUE` (`color_name`);

--
-- Indizes für die Tabelle `family`
--
ALTER TABLE `family`
  ADD PRIMARY KEY (`idfamily`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`),
  ADD KEY `fk_family_order1_idx` (`order_idorder`);

--
-- Indizes für die Tabelle `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`idfood`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indizes für die Tabelle `habitat`
--
ALTER TABLE `habitat`
  ADD PRIMARY KEY (`idhabitat`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indizes für die Tabelle `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`idorder`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `iduser_UNIQUE` (`iduser`);

--
-- Indizes für die Tabelle `user_has_bird`
--
ALTER TABLE `user_has_bird`
  ADD PRIMARY KEY (`user_iduser`,`bird_idbird`),
  ADD KEY `fk_user_has_bird_bird1_idx` (`bird_idbird`),
  ADD KEY `fk_user_has_bird_user1_idx` (`user_iduser`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bird`
--
ALTER TABLE `bird`
  MODIFY `idbird` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT für Tabelle `breeding_place`
--
ALTER TABLE `breeding_place`
  MODIFY `idbreeding_place` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT für Tabelle `color`
--
ALTER TABLE `color`
  MODIFY `idcolor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `family`
--
ALTER TABLE `family`
  MODIFY `idfamily` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
--
-- AUTO_INCREMENT für Tabelle `food`
--
ALTER TABLE `food`
  MODIFY `idfood` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT für Tabelle `order`
--
ALTER TABLE `order`
  MODIFY `idorder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `bird`
--
ALTER TABLE `bird`
  ADD CONSTRAINT `fk_bird_breeding_place1` FOREIGN KEY (`breeding_place_idbreeding_place`) REFERENCES `breeding_place` (`idbreeding_place`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bird_family` FOREIGN KEY (`family_idfamily`) REFERENCES `family` (`idfamily`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `bird_has_color`
--
ALTER TABLE `bird_has_color`
  ADD CONSTRAINT `fk_bird_has_color_bird1` FOREIGN KEY (`bird_idbird`) REFERENCES `bird` (`idbird`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bird_has_color_color1` FOREIGN KEY (`color_idcolor`) REFERENCES `color` (`idcolor`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `bird_has_food`
--
ALTER TABLE `bird_has_food`
  ADD CONSTRAINT `fk_bird_has_food_bird1` FOREIGN KEY (`bird_idbird`) REFERENCES `bird` (`idbird`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bird_has_food_food1` FOREIGN KEY (`food_idfood`) REFERENCES `food` (`idfood`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `bird_has_habitat`
--
ALTER TABLE `bird_has_habitat`
  ADD CONSTRAINT `fk_bird_has_habitat_bird1` FOREIGN KEY (`bird_idbird`) REFERENCES `bird` (`idbird`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bird_has_habitat_habitat1` FOREIGN KEY (`habitat_idhabitat`) REFERENCES `habitat` (`idhabitat`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `family`
--
ALTER TABLE `family`
  ADD CONSTRAINT `fk_family_order1` FOREIGN KEY (`order_idorder`) REFERENCES `order` (`idorder`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `user_has_bird`
--
ALTER TABLE `user_has_bird`
  ADD CONSTRAINT `fk_user_has_bird_bird1` FOREIGN KEY (`bird_idbird`) REFERENCES `bird` (`idbird`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_has_bird_user1` FOREIGN KEY (`user_iduser`) REFERENCES `user` (`iduser`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
