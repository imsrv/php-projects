# phpMyAdmin MySQL-Dump
# http://phpwizard.net/phpMyAdmin/
#
# Serveur: localhost Base de données: newsletter
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

INSERT INTO nlconfig VALUES ( '1', '', '', '', '', '3', '', '', '', '', '', '', '', 'nlconfig', 'password', '3', 'http://mydomain.com/', 'phpMyNewsletter_v0.6/', 'lang-french.php3', 'Bienvenue', 'Bienvenue dans la newsletter', 'Bonjour
vous venez de demander votre inscription à la lettre d\\\'information', 'contact <webmaster@mydomain.com
http://www.mydomain.com', '1');
