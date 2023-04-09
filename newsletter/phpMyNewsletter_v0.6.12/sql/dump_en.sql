# phpMyAdmin MySQL-Dump
# http://phpwizard.net/phpMyAdmin/
#
# Serveur: localhost Base de données: newsletter

# --------------------------------------------------------
#
# Structure de la table 'log'
#

CREATE TABLE log (
   id tinyint(255) NOT NULL auto_increment,
   date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
   type varchar(4) NOT NULL,
   sujet text NOT NULL,
   message text NOT NULL,
   PRIMARY KEY (id)
);

#
# Contenu de la table 'log'
#


# --------------------------------------------------------
#
# Structure de la table 'news'
#

CREATE TABLE news (
   email char(255) NOT NULL,
   PRIMARY KEY (email),
   UNIQUE email (email)
);

#
# Contenu de la table 'news'
#


# --------------------------------------------------------
#
# Structure de la table 'nlconfig'
#

CREATE TABLE nlconfig (
   id tinyint(4) DEFAULT '1' NOT NULL,
   nomnews varchar(255) NOT NULL,
   hebergeur varchar(255) NOT NULL,
   fromc varchar(255) NOT NULL,
   fromonline varchar(255) NOT NULL,
   limitconf tinyint(2) DEFAULT '3' NOT NULL,
   host varchar(255) NOT NULL,
   user varchar(255) NOT NULL,
   passwd varchar(255) NOT NULL,
   db varchar(255) NOT NULL,
   tablenews varchar(255) NOT NULL,
   tabletemp varchar(255) NOT NULL,
   tablelog varchar(255) NOT NULL,
   tableconfig varchar(255) NOT NULL,
   admin_pass varchar(255) NOT NULL,
   limitlog tinyint(2) DEFAULT '10' NOT NULL,
   url varchar(255) NOT NULL,
   pathtopmn varchar(255) NOT NULL,
   langfile varchar(255) NOT NULL,
   welcome_subj varchar(255) NOT NULL,
   welcome_msg text NOT NULL,
   sub_msg text NOT NULL,
   pied tinytext NOT NULL,
   validation tinyint(1) DEFAULT '1' NOT NULL
);

#
# Contenu de la table 'nlconfig'
#

INSERT INTO nlconfig VALUES ( '1', '', '', '', '', '3', '', '', '', '', '', '', '', 'nlconfig', 'password', '3', 'http://mydomain.com/', 'phpMyNewsletter_v0.6/', 'lang-en.php3', 'Welcome', 'Welcome to the NEwsletter', 'Hello
you request a subscription to the newletter', 'contact <webmaster@mydomain.com
http://www.mydomain.com', '1');

# --------------------------------------------------------
#
# Structure de la table 'temp'
#

CREATE TABLE temp (
   id int(11) NOT NULL auto_increment,
   email char(255) NOT NULL,
   date date DEFAULT '0000-00-00' NOT NULL,
   PRIMARY KEY (id),
   UNIQUE id (id)
);

#
# Contenu de la table 'temp'
#

