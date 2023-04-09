# phpMyAdmin MySQL-Dump
# version 2.5.0
# http://www.phpmyadmin.net/ (download page)
#
# Sunucu:: localhost
# ��kt� Tarihi: Ocak 18, 2004 at 02:14 PM
# Server s�r�m�: 4.0.14
# PHP S�r�m�: 4.3.4
# Veritaban� : `guneselmas_sms`
# --------------------------------------------------------

#
# Tablo i�in tablo yap�s� `firmalar`
#
# Creation: Ocak 17, 2004 at 04:31 AM
# Last update: Ocak 17, 2004 at 04:31 AM
#

CREATE TABLE `firmalar` (
  `id` int(11) NOT NULL auto_increment,
  `kullaniciadi` varchar(32) NOT NULL default '',
  `sifre` varchar(32) NOT NULL default '',
  `klasor` varchar(255) NOT NULL default '',
  `ad` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `kullaniciadi` (`kullaniciadi`)
) TYPE=MyISAM AUTO_INCREMENT=2 ;

#
# Tablo d�k�m verisi `firmalar`
#

INSERT INTO `firmalar` VALUES (1, 'elmasgunes', 'deneme', 'elmasgunes.net', 'elmasg�ne�.net');

