CREATE TABLE banners (
  Id int(6) unsigned NOT NULL auto_increment,
  banImg varchar(255) NOT NULL default '',
  banUrl varchar(255) NOT NULL default '',
  banEx int(11) unsigned default '0',
  banCl int(11) unsigned default '0',
  banW int(3) unsigned default '0',
  banH int(3) unsigned default '0',
  PRIMARY KEY  (Id),
  KEY Id (Id)
) TYPE=MyISAM;
INSERT INTO banners VALUES("10", "./html/imagens/banneris.gif", "http://www.ironscripts.tk", "1235", "3", "468", "60");

CREATE TABLE cadastros (
  Id int(11) unsigned NOT NULL auto_increment,
  cadNome varchar(150) NOT NULL default '',
  cadEmail varchar(100) NOT NULL default '',
  cadSnome varchar(150) NOT NULL default '',
  cadDesc text NOT NULL,
  cadUrl varchar(255) NOT NULL default '',
  cadCategoria tinyint(4) unsigned NOT NULL default '0',
  cadSenha varchar(10) NOT NULL default '',
  Votos int(7) unsigned NOT NULL default '0',
  DataCadastro timestamp(14) NOT NULL,
  Cliques int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (Id),
  KEY Id (Id),
  FULLTEXT KEY search_idx (cadSnome,cadDesc,cadUrl)
) TYPE=MyISAM;

CREATE TABLE categorias (
  Id int(4) unsigned NOT NULL auto_increment,
  catNome varchar(100) NOT NULL default '0',
  PRIMARY KEY  (Id),
  KEY Id (Id)
) TYPE=MyISAM;

INSERT INTO categorias VALUES("1", "Artes");
INSERT INTO categorias VALUES("2", "Cultura");
INSERT INTO categorias VALUES("3", "Internet");
INSERT INTO categorias VALUES("4", "Jogos");
INSERT INTO categorias VALUES("5", "Esporte");
INSERT INTO categorias VALUES("6", "Pessoal");
INSERT INTO categorias VALUES("7", "Música");
INSERT INTO categorias VALUES("22", "Informática");


CREATE TABLE log (
  Id int(11) unsigned NOT NULL default '0',
  Ip varchar(20) NOT NULL default '',
  Time bigint(15) default NULL
) TYPE=MyISAM;