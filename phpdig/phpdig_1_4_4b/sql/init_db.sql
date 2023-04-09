# phpMyAdmin MySQL-Dump
# http://phpwizard.net/phpMyAdmin/
#
# Serveur: localhost Base de données: phpdig

# --------------------------------------------------------
#
# Structure de la table 'engine'
#

CREATE TABLE engine (
   spider_id mediumint(9) DEFAULT '0' NOT NULL,
   key_id mediumint(9) DEFAULT '0' NOT NULL,
   weight smallint(4) DEFAULT '0' NOT NULL,
   KEY spider_id (spider_id),
   KEY key_id (key_id)
);


# --------------------------------------------------------
#
# Structure de la table 'keywords'
#

CREATE TABLE keywords (
   key_id mediumint(9) NOT NULL auto_increment,
   twoletters char(2) NOT NULL,
   keyword varchar(64) NOT NULL,
   UNIQUE key_id_2 (key_id),
   UNIQUE keyword (keyword),
   KEY twoletters (twoletters)
);


# --------------------------------------------------------
#
# Structure de la table 'sites'
#

CREATE TABLE sites (
   site_id mediumint(9) NOT NULL auto_increment,
   site_url varchar(127) NOT NULL,
   upddate timestamp(14),
   username varchar(32),
   password varchar(32),
   port smallint(6),
   UNIQUE site_id (site_id)
);


# --------------------------------------------------------
#
# Structure de la table 'spider'
#

CREATE TABLE spider (
   spider_id mediumint(9) NOT NULL auto_increment,
   file varchar(127) NOT NULL,
   first_words text NOT NULL,
   upddate timestamp(14),
   md5 varchar(50),
   site_id mediumint(9) DEFAULT '0' NOT NULL,
   path varchar(127) NOT NULL,
   num_words int(11) DEFAULT '1' NOT NULL,
   last_modified timestamp(14),
   PRIMARY KEY (spider_id),
   KEY site_id (site_id)
);


# --------------------------------------------------------
#
# Structure de la table 'tempspider'
#

CREATE TABLE tempspider (
   file text NOT NULL,
   id mediumint(11) NOT NULL auto_increment,
   level tinyint(6) DEFAULT '0' NOT NULL,
   path text NOT NULL,
   site_id mediumint(9) DEFAULT '0' NOT NULL,
   indexed tinyint(1) DEFAULT '0' NOT NULL,
   upddate timestamp(14),
   error tinyint(4) DEFAULT '0' NOT NULL,
   UNIQUE id (id)
);