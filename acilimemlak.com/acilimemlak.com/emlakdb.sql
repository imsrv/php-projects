-- Script-tr.Org Katk�lar�yla :)


-- --------------------------------------------------------

-- 
-- Tablo yapısı : `gayrimenkul`
-- 

CREATE TABLE `gayrimenkul` (
  `id` int(11) NOT NULL auto_increment,
  `satis` varchar(20) NOT NULL default '',
  `kategori` varchar(10) NOT NULL default '',
  `sehir` varchar(20) NOT NULL default '',
  `semt` varchar(20) NOT NULL default '',
  `adres` text,
  `fiyat` int(11) NOT NULL default '0',
  `alan` int(11) default NULL,
  `oda` int(11) default NULL,
  `salon` int(11) default NULL,
  `banyo` int(11) default NULL,
  `kat` varchar(15) default NULL,
  `asansor` varchar(5) default NULL,
  `isinma` varchar(15) default NULL,
  `dogalgaz` varchar(5) default NULL,
  `balkon` varchar(5) default NULL,
  `bahce` varchar(5) default NULL,
  `otopark` varchar(25) default NULL,
  `mobilya` varchar(5) default NULL,
  `insatarihi` date default NULL,
  `aciklamalar` text,
  `resim` text,
  `saticiadi` varchar(50) NOT NULL default '',
  `saticitelefonsabit` varchar(15) NOT NULL default '',
  `saticitelefonmobil` varchar(15) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=103 ;

-- 
-- Tablo döküm verisi `gayrimenkul`
-- 

INSERT INTO `gayrimenkul` (`id`, `satis`, `kategori`, `sehir`, `semt`, `adres`, `fiyat`, `alan`, `oda`, `salon`, `banyo`, `kat`, `asansor`, `isinma`, `dogalgaz`, `balkon`, `bahce`, `otopark`, `mobilya`, `insatarihi`, `aciklamalar`, `resim`, `saticiadi`, `saticitelefonsabit`, `saticitelefonmobil`) VALUES (71, 'Satýlýk', 'Daire', 'ÝZMÝR', 'ATAKENT KARÞISI', '6440/3 Sokak No:26 Kat:8', 215000, 250, 3, 1, 2, '8Katlýnýn8.Katý', 'Var', 'Kat Kaloriferi', 'Var', 'Var', '', 'Otopark', '', '1998-01-01', 'Çelik Kapý,Islak Zeminler Seramik,\r\nOdalar Parke,Duvarlar Saten,Amerikan Kapý,Aliminyum Doðrama,Odalarda Klima,Hazýr Mutfak,Ebeveyn Banyo,Büyük Balkon Panjur,Küçük Balkon Camekan,Kiler,Park Cepheli,Deniz Manzaralý.', NULL, 'Kemal EYÝEVCÝM', '330 84 94', '0555 268 01 37'),
(68, 'Satýlýk', 'Daire', 'Ýzmir', 'BOSTANLI BAÐCI PARKI', '1771 SOKAK No:15 TANIN Apt.D:2 BAÐCI PARKI KARÞISI', 105000, 110, 2, 1, 1, 'zemin', 'Yok', 'yok', 'Yok', 'Var', 'Var', 'Otopark', 'Var', '1990-01-01', '3+1 DAÝRE ODANIN BÝRÝ MUTFAÐA ÝLAVE EDÝLEREK 2+1 E DÖNÜÞTÜRÜLMÜÞ,FERFORJE DEMÝR KORUMALI,PARK (BAÐCI) CEPHELÝ,ÝÞYERÝ OLAMAYA UYGUN.', NULL, 'ÞERÝFE AÞKIN', '0 232 330 91 29', '0 544 599 51 81'),
(67, 'Satýlýk', 'Daire', 'ÝZMÝR', 'ATAKENT KARÞISI', '', 90000, 90, 2, 1, 1, '5KATLININ2.KATI', 'Yok', '', '', 'Var', '', '', '', '0000-00-00', 'ÇELÝK KAPI', NULL, 'KEMAL EYÝEVCÝM', '3308494', '0555 268 01 37'),
(65, 'Satýlýk', 'Daire', 'ÝZMÝR', 'ATAKENT KARÞISI', 'EGEMYAMANLAR Apt. ', 130000, 120, 3, 1, 2, '9KATLININZEMÝNÝ', 'Var', '', '', 'Var', 'Var', 'Otopark', '', '0000-00-00', 'ZEMÝNLER PARKE,YATAK ODASI GÖMME DOLAP,HAZIR MUTFAKLI,BALKONLAR FERFORJE ÝLE KAPALI.', NULL, 'ZEKERÝYA SOMEK', '336 07 31', '0535 609 14 35'),
(58, 'Satýlýk', 'Daire', 'ÝZMÝR', 'ATAKENT KARÞISI', '6488 Sk. No:3 D:9 ', 110000, 100, 3, 1, 1, '5Katlýnýn5.Katý', 'Yok', '', '', 'Var', 'Var', 'Kapalý Garaj', '', '2000-01-01', 'Duvarlar Saten,Oturma odasý parke,diðer zeminler seramik,Amerikan mutfak,Karanlýk odasý bulunmayan kullanýþlý bir daire...', NULL, 'Mustafa CÖMERT', '336 85 40', '0542 486 35 17'),
(63, 'Satýlýk', 'Daire', 'ÝZMÝR', 'MAVÝÞEHÝR 1. ETAP', 'SELÇUK 8', 340000, 220, 4, 1, 2, '15KATLININ1.KAT', 'Var', 'MERKEZÝ', 'Var', 'Var', 'Var', 'Otopark', '', '0000-00-00', 'GÜVENLÝK,ÞAHSÝ KARTLI OTOPARK,HÝLTON BANYO,BALKONLAR KOMPLE ÇÝFT CAM PVC KAPALI,DENÝZ MANZARASI,ÖNÜ AÇIK ARSA CEPHELÝ,ÇÝFT CEPHELÝ BALKON,BÝNA GÝRÝÞÝ MERMER,DOÐALGAZ BAÐLANTILI.', NULL, 'DEVRÝM BÜYÜKSAVAÞ', '3242544', '05325912939'),
(96, 'Satýlýk', 'Yazlýk', 'ÝZMÝR', 'ÇEÞME-DALYANKÖY', '', 425000, 210, 3, 1, 2, '', 'Yok', 'KAT KALORÝFERÝ', '', 'Var', 'Var', '', '', '2006-10-01', '210 m2 BÜRÜT,3+1,2 BÜYÜK TERAS,MÜSTAKÝL HAVUZ,ARTEZYEN,KAT KALORÝFERÝ,ELEKTRÝKLÝ ÞOFBEN,ELEKTRÝKLÝ ALÜMÝNYUM PANJUR,ALÜMÝNYUM DOÐRAMA,ÇÝFT CAM,ÞÖMÝNE,JAKUZÝ,UYDU ANTEN.', NULL, 'MUSTAFA KARALI', '02323308895', '123456789'),
(83, 'Satýlýk', 'Arsa', 'ÝZMÝR', 'MENDERES', '', 3000000, 461000, 0, 0, 0, '', '', '', '', '', '', '', '', '0000-00-00', 'TAMAMEN ORGANÝK TARIM YAPMAYA ELVERÝÞLÝ\r\n461 DÖNÜM HERYERÝ ÝÞLENEBÝLÝR\r\nTAMAMI TEL ÖRGÜ VE TAÞ DUVAR ÝLE ÇEVRÝLÝ\r\nÝÇERÝSÝNDE;\r\n3 ADET TRÝPLEX 300 M2 YUZME HAVUZU 4 TANE 4 ÝNÇ SU\r\nYER ALTINDAN ISITMA TARIM ALANI ÝÇÝN YERALTINDAN SULAMA TESÝSATLI\r\nÖZEL KORUMASI YAPILMIS ÝÇÝNDEN AKARSU GEÇÝYOR\r\nKENDÝNE AÝT ÖZEL TRAFOSU VAR\r\nSAHANIN TAMAMI AYDINLATMALI DÝREKLERÝ DÝKÝLÝ ÇALIÞIR VAZÝYETTE 250+100+50 TON SU DEPOLARI HAZIR KULLANILIR VAZÝYETTE\r\nHÝDROFOR+GÜNEÞ ENERJÝ SÝSTEMLERÝ+UYDU\r\nSAMAN VE YEM SAKLAMA DEPOLARI ÝLE BÝRLÝKTE 150 BÜYÜK BAÞ HAYVAN KAPASÝTELÝ DAM\r\n60 ATLIK DAM\r\nBAKICI EVLERÝ\r\n150/200 DONUMUNE YULAF EKÝLÝYOR 2000 AÐAÇ MANDALÝN+ERÝK+ARMUT+NAR VAR YAKLASIK 50 TON MAHSUL VERÝR VAZÝYETTE\r\nÜZÜM BAÐLARI\r\nULAÞIM ÇOK BASÝT HAVAALANI VE DENIZ''E 15 DAKÝKA MESAFADE.', NULL, 'ADNAN SERVETÇÝOÐLU', '1234567', '1234567'),
(102, 'Satýlýk', 'Daire', 'izmir', 'Atakent  karþýyaka', '6470/12   YALI MAHALLESÝ', 130000, 140, 3, 1, 1, '4', 'Var', 'YOK', 'Yok', 'Var', 'Var', 'Yok', 'Yok', '1995-01-01', 'açýk mutfak doðu batý ve güney cepheli', NULL, 'Cengiz özkan', '3303505', '0537 281 50 56'),
(89, 'Satýlýk', 'Daire', 'ÝZMÝR', 'ATAKENT KARÞISI', '6437 SOKAK No:12 D:3', 95000, 100, 2, 1, 1, '5KATLININ3.KATI', 'Yok', '', '', 'Var', 'Var', 'Kapalý Garaj', '', '0000-00-00', 'ÜÇ CEPHELÝ,HAZIR MUTFAK', NULL, 'A.KADÝR KEKÝLLÝOÐLU', '0 232 274 26 26', '0 532 749 35 16'),
(90, 'Satýlýk', 'Daire', 'ÝZMÝR', 'EVKA-2 TRT KOOP', '', 185000, 140, 3, 1, 1, '', '', 'KLÝMA', '', 'Var', 'Var', '', '', '1994-01-01', 'OYAK SÝTESÝ ve KÖRFEZKÖY BÝTÝÞÝÐÝ,3 KAT+BODRUM,60 m2 BAHÇESÝ BULUNAN,ALATURKA TUVALET,ÇOK ÖZEL TRÝPLEX', NULL, 'GÜRSAN ELMAN', '0 232 370 42 22', '0 536 569 03 31'),
(92, 'Satýlýk', 'Daire', 'ÝZMÝR', 'YALI MAH.', '', 110000, 135, 3, 1, 1, '5KATLININ5.KATI', 'Var', '', 'Var', 'Var', '', 'Kapalý Garaj', '', '1998-01-01', 'ÝÇÝ TEMÝZ MASRAFSIZ DAÝRE.', NULL, 'MUSTAFA KARALI', '0 232 330 88 95', '1234567'),
(93, 'Satýlýk', 'Daire', 'ÝZMÝR', 'YALI MAH.', '', 115000, 135, 3, 1, 1, '5KATLININ2.KATI', 'Yok', '', '', 'Var', '', '', '', '1999-01-01', 'ÝÇÝ SIFIRLANMIÞ,ÖNÜ AÇIK DAÝRE.', NULL, 'MUSTAFA KARALI', '0 232 330 88 95', '1234567'),
(94, 'Satýlýk', 'Daire', 'ÝZMÝR', 'YALI MAH.', '', 85000, 125, 3, 1, 1, '5KATLININ5.KATI', 'Yok', '', '', 'Var', '', '', '', '1998-01-01', 'AÇIK MUTFAK', NULL, 'MUSTAFA KARALI', '0 232 330 88 95', '1234567');
