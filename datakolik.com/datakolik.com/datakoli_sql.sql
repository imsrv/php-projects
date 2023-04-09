-- MySQL dump 10.9
--
-- Host: localhost    Database: datakoli_berko
-- ------------------------------------------------------
-- Server version	4.1.21-standard

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `anket`
--

DROP TABLE IF EXISTS `anket`;
CREATE TABLE `anket` (
  `id` int(11) NOT NULL auto_increment,
  `ad` varchar(50) NOT NULL default '',
  `oy` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anket`
--

LOCK TABLES `anket` WRITE;
/*!40000 ALTER TABLE `anket` DISABLE KEYS */;
INSERT INTO `anket` (`id`, `ad`, `oy`) VALUES (51,'Reklamlardan',1),(48,'Arama Sitelerinden',0),(49,'Arkada? Tavsiyesiyle',1),(50,'S?rf yaparken',0);
/*!40000 ALTER TABLE `anket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `anketler`
--

DROP TABLE IF EXISTS `anketler`;
CREATE TABLE `anketler` (
  `id` int(11) NOT NULL auto_increment,
  `soru` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anketler`
--

LOCK TABLES `anketler` WRITE;
/*!40000 ALTER TABLE `anketler` DISABLE KEYS */;
INSERT INTO `anketler` (`id`, `soru`) VALUES (1,'Sitemize nas?l ula?t?n?z...');
/*!40000 ALTER TABLE `anketler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arsiv`
--

DROP TABLE IF EXISTS `arsiv`;
CREATE TABLE `arsiv` (
  `id` int(11) NOT NULL auto_increment,
  `sureadi` varchar(50) NOT NULL default '',
  `kat_id` varchar(10) NOT NULL default '',
  `video` varchar(100) NOT NULL default '',
  `boyut` varchar(10) NOT NULL default '',
  `hit` int(10) NOT NULL default '0',
  `tarih` date NOT NULL default '0000-00-00',
  `aciklama` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `arsiv`
--

LOCK TABLES `arsiv` WRITE;
/*!40000 ALTER TABLE `arsiv` DISABLE KEYS */;
INSERT INTO `arsiv` (`id`, `sureadi`, `kat_id`, `video`, `boyut`, `hit`, `tarih`, `aciklama`) VALUES (1,'01','68','01.wma','',8,'2005-05-23','  '),(2,'02','68','02.wma','',0,'2005-05-23','  '),(3,'03','68','03.wma','',0,'2005-05-23','  '),(4,'04','68','04.wma','',0,'2005-05-23','  '),(5,'05','68','05.wma','',1,'2005-05-23','  '),(6,'06','68','06.wma','',0,'2005-05-23','  '),(7,'07','68','07.wma','',0,'2005-05-23','  '),(8,'08','68','08.wma','',0,'2005-05-23','  '),(9,'09','68','09.wma','',1,'2005-05-23','  '),(10,'10','68','10.wma','',0,'2005-05-23','  '),(11,'11','68','11.wma','',1,'2005-05-23','  '),(12,'12','68','12.wma','',0,'2005-05-23','  '),(13,'13','68','13.wma','',1,'2005-05-23','  '),(14,'14','68','14.wma','',0,'2005-05-23','  '),(15,'15','68','15.wma','',0,'2005-05-23','  '),(16,'16','68','16.wma','',0,'2005-05-23','  '),(17,'17','68','17.wma','',0,'2005-05-23','  '),(18,'18','68','18.wma','',0,'2005-05-23','  '),(19,'19','68','19.wma','',0,'2005-05-23','  '),(20,'20','68','20.wma','',0,'2005-05-23','  '),(21,'21','68','21.wma','',0,'2005-05-23','  '),(22,'22','68','22.wma','',0,'2005-05-23','  '),(23,'23','68','23.wma','',1,'2005-05-23','  '),(24,'01-Tahir hoca_Ladik','66','01-Tahir hoca_Ladik.wma','',1,'2005-05-23','  '),(25,'02-Tahir hoca','66','02-Tahir hoca.wma','',1,'2005-05-23','  '),(26,'03-Tahir hoca','66','03-Tahir hoca.wma','',0,'2005-05-23','  '),(27,'04-Tahir hoca','66','04-Tahir hoca.wma','',0,'2005-05-23','  '),(28,'01 - En ?yi Sabahlar - A','69','--A--EN IYI SABAHLAR.wma','',1,'2005-05-24','  '),(29,'01 - En ?yi Sabahlar - B','69','--B--EN IYI SABAHLAR.wma','',0,'2005-05-24','  '),(30,'01 - G?n Bat?m? - A','69','A---GUN BATIMI.wma','',0,'2005-05-24','  '),(31,'01 - G?n Bat?m? - B','69','B---GUN BATIMI.wma','',0,'2005-05-24','    '),(32,'02 - En ?yi Sabahlar - A','69','--A--EN IYI SABAHLAR - 02.wma','',0,'2005-05-24','  '),(33,'02 - En ?yi Sabahlar - B','69','--B--EN IYI SABAHLAR - 02.wma','',0,'2005-05-24','  '),(34,'02 - G?n Bat?m? - A','69','A---GUN BATIMI - 02.wma','',0,'2005-05-24','  '),(35,'02 - G?n Bat?m? - B','69','B---GUN BATIMI - 02.wma','',0,'2005-05-24','  '),(36,'Edeb?l M?fred - 01','70','Edebul Mufred  1.wma','',0,'2005-05-24','      '),(37,'Edeb?l M?fred - 02','70','Edebul Mufred  2.wma','',0,'2005-05-24','  '),(38,'Edeb?l M?fred - 03','70','Edebul Mufred  3.wma','',0,'2005-05-24','  '),(39,'Edeb?l M?fred - 04','70','Edebul Mufred  4.wma','',0,'2005-05-24','  '),(40,'Edeb?l M?fred - 05','70','Edebul Mufred  5.wma','',0,'2005-05-24','  '),(41,'01 - Semadan Damlalar','71','01 - Semadan Damlalar.wma','',0,'2005-05-24','  '),(42,'02 - Semadan Damlalar','71','02 - Semadan Damlalar.wma','',0,'2005-05-24','  '),(43,'03 - Semadan Damlalar','71','03 - Semadan Damlalar.wma','',0,'2005-05-24','  '),(44,'04 - Semadan Damlalar','71','04 - Semadan Damlalar.wma','',0,'2005-05-24','  '),(45,'05 - Semadan Damlalar','71','05 - Semadan Damlalar.wma','',0,'2005-05-24','  '),(46,'01 - Rahmete Do?ru: B?l?m - 01','72','1_bolum_01.wma','',1,'2005-05-24','  '),(47,'01 - Rahmete Do?ru: B?l?m - 02','72','2_bolum_01.wma','',0,'2005-05-24','  '),(48,'02 - Rahmete Do?ru: B?l?m - 01','72','1_bolum_02.wma','',0,'2005-05-24','  '),(49,'02 - Rahmete Do?ru: B?l?m - 02','72','2_bolum_02.wma','',0,'2005-05-24','  '),(50,'03 - Rahmete Do?ru: B?l?m - 01','72','1_bolum_03.wma','',0,'2005-05-24','    '),(51,'03 - Rahmete Do?ru: B?l?m - 02','72','2_bolum_03.wma','',0,'2005-05-24','  '),(52,'04 - Rahmete Do?ru: B?l?m - 01','72','1_bolum_04.wma','',0,'2005-05-24','  '),(53,'04 - Rahmete Do?ru: B?l?m - 02','72','04_02_2005 2_bolum rahmete dogru_04.wma','',0,'2005-05-24','  '),(54,'05 - Rahmete Do?ru: B?l?m - 01','72','1_bolum_05.wma','',0,'2005-05-24','  '),(55,'05 - Rahmete Do?ru: B?l?m - 02','72','2_bolum_05.wma','',0,'2005-05-24','  '),(56,'Cennetim Olurmusun','75','cennetim olurmusun.wma','',0,'2005-05-24','  ');
/*!40000 ALTER TABLE `arsiv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arsiv_kat`
--

DROP TABLE IF EXISTS `arsiv_kat`;
CREATE TABLE `arsiv_kat` (
  `id` int(11) NOT NULL auto_increment,
  `ad` varchar(50) NOT NULL default '',
  `sira` int(3) NOT NULL default '1',
  `ana_id` int(11) NOT NULL default '0',
  `grup` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `arsiv_kat`
--

LOCK TABLES `arsiv_kat` WRITE;
/*!40000 ALTER TABLE `arsiv_kat` DISABLE KEYS */;
INSERT INTO `arsiv_kat` (`id`, `ad`, `sira`, `ana_id`, `grup`) VALUES (74,'YAS?R ?NL? RAHMETE DO?RU',1,0,''),(75,'CENNET?M OLURMUSUN',1,0,''),(67,'R?BATFM ETK?NL?KLER',1,0,''),(68,'ABDULLAH B?Y?K',1,0,''),(69,'PROGRAMLAR - DURAN ?AH?N',1,0,''),(70,'PROGRAMLAR - HAL?L ATALAY',1,0,''),(71,'PROGRAMLAR - MESUT KARAK?SE',1,0,''),(72,'PROGRAMLAR - YAS?R ?NL',1,0,''),(73,'EDEB?L M?FRET HAD?S SOHBET',1,0,''),(66,'TAH?R B?Y?KK?R?KC',1,0,'');
/*!40000 ALTER TABLE `arsiv_kat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ayetler`
--

DROP TABLE IF EXISTS `ayetler`;
CREATE TABLE `ayetler` (
  `id` int(10) NOT NULL auto_increment,
  `ayet` text NOT NULL,
  `tarih` date NOT NULL default '0000-00-00',
  `hit` int(11) NOT NULL default '0',
  `sure` varchar(20) NOT NULL default '',
  `ayetno` int(4) NOT NULL default '0',
  `tefsir` text NOT NULL,
  `cuz` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ayetler`
--

LOCK TABLES `ayetler` WRITE;
/*!40000 ALTER TABLE `ayetler` DISABLE KEYS */;
INSERT INTO `ayetler` (`id`, `ayet`, `tarih`, `hit`, `sure`, `ayetno`, `tefsir`, `cuz`) VALUES (7,'Ramazan ay?, insanlara yol g?sterici, do?runun ve do?ruyu e?riden ay?rman?n a??k delilleri olarak kur\'an\'?n indirildi?i ayd?r. ?yle ise sizden ramazan ay?n? idrak edenler onda oru? tutsun. Kim o anda hasta veya yolcu olursa (tutamad??? g?nler say?s?nca) ba?ka g?nlerde kaza etsin. Allah sizin i?in kolayl?k ister, zorluk istemez. B?t?n bunlar, say?y? tamamlaman?z ve size do?ru yolu g?stermesine kar??l?k, Allah\'? tazim etmeniz, ??kretmeniz i?indir. ','0000-00-00',0,'BAKARA',185,'',0),(5,'\\\'\\\'O kitap (kur\\\'an); onda asla ??phe yoktur. O, m?ttak?ler (sak?nanlar ve ar?nmak isteyenler) i?in bir yol g?stericidir. \\\'\\\'','0000-00-00',0,'BAKARA',2,'',0),(6,'De ki: Cebrail\'e kim d??man ise ?unu iyi bilsin ki Allah\'?n izniyle kur\'an\'? senin kalbine bir hidayet rehberi, ?nce gelen kitaplar? do?rulay?c? ve m?minler i?in de m?jdeci olarak o indirmi?tir. ','0000-00-00',0,'BAKARA',97,'',0),(8,'?man etmedik?e putperest kad?nlarla evlenmeyin. Be?enseniz bile, putperest bir kad?ndan, imanl? bir c?riye kesinlikle daha iyidir. ?man etmedik?e putperest erkekleri de (k?zlar?n?zla) evlendirmeyin. Be?enseniz bile, putperest bir ki?iden inanm?? bir k?le kesinlikle daha iyidir. Onlar (m??rikler) cehenneme ?a??r?r. Allah ise, izni (ve yard?m?) ile cennete ve ma?firete ?a??r?r. Allah, d???n?p anlas?nlar diye ?yetlerini insanlara a??klar. ','0000-00-00',0,'BAKARA',221,'',0),(11,'Kim bir k?t?l?k i?lerse, onun kadar ceza g?r?r. Kim de kad?n veya erkek, m?min olarak faydal? bir i? yaparsa i?te onlar, cennete girecekler, orada onlara hesaps?z r?z?k verilecektir. ','0000-00-00',0,'M?M?N',40,'',0),(12,'Onlara (d??manlara) kar?? g?c?n?z yetti?i kadar kuvvet ve cihad i?in ba?lan?p beslenen atlar haz?rlay?n, onunla Allah\'?n d??man?n?, sizin d??man?n?z? ve onlardan ba?ka sizin bilmedi?iniz, Allah\'?n bildi?i (d??man) kimseleri korkutursunuz. Allah yolunda ne harcarsan?z size eksiksiz ?denir, siz asla haks?zl??a u?rat?lmazs?n?z. ','0000-00-00',0,'ENFAL',60,'',0);
/*!40000 ALTER TABLE `ayetler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `haber`
--

DROP TABLE IF EXISTS `haber`;
CREATE TABLE `haber` (
  `haber_id` int(11) NOT NULL auto_increment,
  `baslik` varchar(50) NOT NULL default '',
  `tarih` date NOT NULL default '0000-00-00',
  `govde` text NOT NULL,
  `detay` text NOT NULL,
  PRIMARY KEY  (`haber_id`,`tarih`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `haber`
--

LOCK TABLES `haber` WRITE;
/*!40000 ALTER TABLE `haber` DISABLE KEYS */;
INSERT INTO `haber` (`haber_id`, `baslik`, `tarih`, `govde`, `detay`) VALUES (4,'DataKolik Internet Bilisim Hizmetleri','2006-08-10','DataKolik internet Bilisim Hizmetleri Online 24 Saat Destegi ile Müsteri Memnuniyeti\r\n\r\n','Müsterilerimizin sorunlarina çözüm bulmak ve verdigimiz hizmetin kalitesini DataKolik kalitesine laik bir ?ekilde yapabilmek için, MSN basta olmak üzere bir çok iletisim araclari ile (Telefon,Mail) yardim vermekteyiz. \r\nGüveninizi Kaybetmektense, Para Kaybetmeyi Tercih Ediyoruz.\r\n...Kayitsiz sartsiz 24 Saat Destek Ve Hizmet Veriyoruz....\r\n'),(0,'DataKolik Dnsleri','2006-08-10','DataKolik dnslerimiz\r\nns1.datakolik.com\r\nns2.datakolik.com\r\n','dns problemlerinizde sitenin iletiSim kismindan bizlere ulasabilirsiniz');
/*!40000 ALTER TABLE `haber` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `makale`
--

DROP TABLE IF EXISTS `makale`;
CREATE TABLE `makale` (
  `haber_id` int(11) NOT NULL auto_increment,
  `baslik` varchar(50) NOT NULL default '',
  `tarih` date NOT NULL default '0000-00-00',
  `govde` text NOT NULL,
  `detay` text NOT NULL,
  `resim1` varchar(30) NOT NULL default '',
  `slogan` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`haber_id`,`tarih`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `makale`
--

LOCK TABLES `makale` WRITE;
/*!40000 ALTER TABLE `makale` DISABLE KEYS */;
INSERT INTO `makale` (`haber_id`, `baslik`, `tarih`, `govde`, `detay`, `resim1`, `slogan`) VALUES (11,'HAYATI KU?ATAN RADYO, R?BAT FM','2003-10-20','Tarih: 04 12 1995 Karapinar\\\'da halkin isteklerini, taleplerini yerine getirmeyi ve temiz radyoculugu ilke edinen bir radyo yayin hayatina basladi sertti, soguktu sartlar teknolojinin ekonomik ?ekilmezligi, kalitenin bir t?rl? yakalanilamayan ka?isi, kirizlerin, d?s?slerin, baskilarin omuzlardaki agir y?k? olsa da, y?r?y?s bitmemeli bu ses kisilmamaliydi. Alinan bir karar, sol g?g?s altinda duran bir inan?, atalarimizdan ?grendigimiz bir azim vardi omuzlardaki y?k? azaltan. Y?netimi devraldigimizda tazelemistik t?m temiz duygularimizi kararliydik bir yil i?inde FURKAN FM\\\' i gelistirecek ve teknolojinin enlerini hakeden bu radyoyu hakettigi sartlara ulastiracak kazananin yine halk olmasini saglayacaktik. Kalbe inanci, kazanca bereketi, y?reklere azmi nakseden RAB\\\'a s?k?rler olsun ki FURKAN FM hakettigi noktaya geldi. Y?r?y?s?m?z devam ediyor...\r\n','Tarih: 04 12 1995 Karapinar\\\'da halkin isteklerini, taleplerini yerine getirmeyi ve temiz radyoculugu ilke edinen bir radyo yayin hayatina basladi sertti, soguktu sartlar teknolojinin ekonomik ?ekilmezligi, kalitenin bir t?rl? yakalanilamayan ka?isi, kirizlerin, d?s?slerin, baskilarin omuzlardaki agir y?k? olsa da, y?r?y?s bitmemeli bu ses kisilmamaliydi. Alinan bir karar, sol g?g?s altinda duran bir inan?, atalarimizdan ?grendigimiz bir azim vardi omuzlardaki y?k? azaltan. Y?netimi devraldigimizda tazelemistik t?m temiz duygularimizi kararliydik bir yil i?inde FURKAN FM\\\' i gelistirecek ve teknolojinin enlerini hakeden bu radyoyu hakettigi sartlara ulastiracak kazananin yine halk olmasini saglayacaktik. Kalbe inanci, kazanca bereketi, y?reklere azmi nakseden RAB\\\'a s?k?rler olsun ki FURKAN FM hakettigi noktaya geldi. Y?r?y?s?m?z devam ediyor...\r\nsimdiye kadar bizimle y?r?yen sadik, liyakatli ve kadirsinas halkimiz eminiz bu devam eden y?r?y?s?m?zde de bizimle birlikte y?r?yecektir.\r\n\r\nBizimle y?r?rm?s?n?z....\r\n G?nesin batmadigi, daglarin y?r?d?g?, gece ile g?nd?z?n biribirine karistigi safak g?n?ne kadar BIZIMLE Y?R?RM?S?N?Z...\r\n\r\n Y?r?y?s bazen arabayla seyehat esnasinda, bazen bir bardak demli ?ayla, bazen sanal ortamdadir...\r\n  ?nemli olan do&#240;ru yolda y?r?mektir... \r\n\r\n                                                                                                                                                    FURKAN FM Y?NETIM KURULU BASKANI\r\n                                                                                                                                                    YAKUP YAZAR \r\n\r\n\r\n \r\n','','');
/*!40000 ALTER TABLE `makale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sayac`
--

DROP TABLE IF EXISTS `sayac`;
CREATE TABLE `sayac` (
  `sayac_id` int(11) NOT NULL auto_increment,
  `tarih` date NOT NULL default '0000-00-00',
  `adet` int(11) NOT NULL default '0',
  `ip` varchar(50) NOT NULL default '',
  `browser` varchar(50) NOT NULL default '',
  `isletim` varchar(50) NOT NULL default '',
  `cozunurluk` varchar(50) NOT NULL default '',
  `ulke` varchar(50) NOT NULL default '',
  `yayin` int(11) NOT NULL default '0',
  PRIMARY KEY  (`sayac_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sayac`
--

LOCK TABLES `sayac` WRITE;
/*!40000 ALTER TABLE `sayac` DISABLE KEYS */;
INSERT INTO `sayac` (`sayac_id`, `tarih`, `adet`, `ip`, `browser`, `isletim`, `cozunurluk`, `ulke`, `yayin`) VALUES (1,'2005-06-18',1,'','','','','',0),(2,'2005-07-13',1,'','','','','',0),(3,'2005-10-01',1,'','','','','',0),(4,'2005-10-02',2,'','','','','',0),(5,'2005-10-06',1,'','','','','',0),(6,'0000-00-00',1,'','','','','',0),(7,'0000-00-00',1,'','','','','',0),(8,'0000-00-00',1,'','','','','',0),(9,'0000-00-00',1,'','','','','',0),(10,'0000-00-00',1,'','','','','',0);
/*!40000 ALTER TABLE `sayac` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `urun_kategori`
--

DROP TABLE IF EXISTS `urun_kategori`;
CREATE TABLE `urun_kategori` (
  `id` int(11) NOT NULL auto_increment,
  `ad` varchar(50) NOT NULL default '',
  `sira` int(3) NOT NULL default '1',
  `ana_id` int(11) NOT NULL default '0',
  `grup` varchar(25) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=174 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urun_kategori`
--

LOCK TABLES `urun_kategori` WRITE;
/*!40000 ALTER TABLE `urun_kategori` DISABLE KEYS */;
INSERT INTO `urun_kategori` (`id`, `ad`, `sira`, `ana_id`, `grup`) VALUES (166,'Radyo',1,0,''),(167,'Tv',1,0,''),(168,'Gazete',1,0,''),(169,'E-Ticaret',1,0,''),(170,'Multimedya',1,0,''),(171,'Portal',1,0,''),(172,'Firma',1,0,''),(173,'Kisisel',1,0,'');
/*!40000 ALTER TABLE `urun_kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `urunler`
--

DROP TABLE IF EXISTS `urunler`;
CREATE TABLE `urunler` (
  `id` int(11) NOT NULL auto_increment,
  `kategori_id` int(11) NOT NULL default '0',
  `isim` varchar(70) NOT NULL default '',
  `ozet` text NOT NULL,
  `detay` text NOT NULL,
  `hit` int(10) NOT NULL default '0',
  `kresim` varchar(50) NOT NULL default '',
  `tur` varchar(80) NOT NULL default '',
  `web` varchar(50) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `yetkili` varchar(50) NOT NULL default '',
  `il` varchar(50) NOT NULL default '',
  `tel` text NOT NULL,
  `link` varchar(60) NOT NULL default '',
  `grup` varchar(20) NOT NULL default '',
  `tasarim` varchar(50) NOT NULL default '',
  `sira` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=129 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `urunler`
--

LOCK TABLES `urunler` WRITE;
/*!40000 ALTER TABLE `urunler` DISABLE KEYS */;
INSERT INTO `urunler` (`id`, `kategori_id`, `isim`, `ozet`, `detay`, `hit`, `kresim`, `tur`, `web`, `email`, `yetkili`, `il`, `tel`, `link`, `grup`, `tasarim`, `sira`) VALUES (122,166,'AsiTurk','','',235,'asi.gif','','http://www.asiturk.org','ya.sen.ya.olum@gmail.com','','Iskenderun','','','Portal','DataKolik',536),(124,166,'TurkDDL.Com','','',269,'turk.gif','','http://www.turkddl.com','destek@turkddl.com','','','','','Portal','DataKolik',535),(125,166,'ForumPassman','','',296,'passman.gif','','http://www.forumpassman.com','msn@forumpassman.com','','Hatay','','','Portal','DataKolik',538),(127,167,'Sanal Facia','','',2,'facia.gif','','http://www.sanalfacia.com','destek@sanalfacia.com','Deepsilver','Hatay','','','Forum','',0),(126,167,'Online Radyo Tv','','',397,'radyo.gif','','http://www.onlineradyo.tv','bilgi@onlineradyo.tv','','','','','TV','DataKolik',539),(128,166,'TurkDDL.Org','','',317,'turk1.gif','','http://www.turkddl.org','destek@turkddl.org','','','','','Warez','DataKolik',540);
/*!40000 ALTER TABLE `urunler` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uye`
--

DROP TABLE IF EXISTS `uye`;
CREATE TABLE `uye` (
  `id` int(11) NOT NULL auto_increment,
  `kad` varchar(20) NOT NULL default '',
  `sifre` varchar(20) NOT NULL default '',
  `ad` varchar(20) NOT NULL default '',
  `sad` varchar(20) NOT NULL default '',
  `firma` varchar(30) NOT NULL default '',
  `tel` varchar(20) NOT NULL default '',
  `fax` varchar(20) NOT NULL default '',
  `adres` varchar(100) NOT NULL default '',
  `adres1` varchar(50) NOT NULL default '',
  `pkodu` varchar(10) NOT NULL default '',
  `il` varchar(25) NOT NULL default '',
  `ulke` varchar(25) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `dt` varchar(30) NOT NULL default '',
  `gsm` varchar(50) NOT NULL default '',
  `tarih` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uye`
--

LOCK TABLES `uye` WRITE;
/*!40000 ALTER TABLE `uye` DISABLE KEYS */;
INSERT INTO `uye` (`id`, `kad`, `sifre`, `ad`, `sad`, `firma`, `tel`, `fax`, `adres`, `adres1`, `pkodu`, `il`, `ulke`, `email`, `dt`, `gsm`, `tarih`) VALUES (1,'1','2','222','65','4','654','65','54','','65','46','54','65','','46','2005-05-23'),(2,'12','12','12','12','12','12','12','12','','12','12','12','12','','12','2005-06-03');
/*!40000 ALTER TABLE `uye` ENABLE KEYS */;
UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

