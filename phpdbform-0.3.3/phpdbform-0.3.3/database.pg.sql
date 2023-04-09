/*
# phpMyAdmin MySQL-Dump
# http://phpwizard.net/phpMyAdmin/
#
# Host: localhost Database : phpdbform

#
# Table structure for table 'contact'
#*/

CREATE TABLE contact (
   cod int4 PRIMARY KEY DEFAULT nextval('contact_s'),
   name varchar(30) NOT NULL,
   email varchar(50) NOT NULL,
   sex varchar(6) DEFAULT 'male' NOT NULL,
   type int4 DEFAULT '0' NOT NULL,
   tdate date NOT NULL,
   obs text NOT NULL
);

/*
#
# Dumping data for table 'contact'
#*/

INSERT INTO contact VALUES ( '1', 'Paulo ASSIS', 'paulo@coral.com.br', 'male', '1', '', 'Creator of the wonderfull phpDBform script.');
INSERT INTO contact VALUES ( '2', 'Eric KASTLER', 'free.sites@surlewoueb.com', 'male', '2', '', 'French froggy. Has translated phpDBform in French and made the french mirror site at http://phpdbform.surlewoueb.com');
INSERT INTO contact VALUES ( '3', 'Marcin Chojnowski', 'martii@obgyn.edu.pl', 'male', '2', '', 'Has translated phpDBform in Polish and added support for charset');
INSERT INTO contact VALUES ( '4', 'Roberto Rosario', 'skeletor@iname.com', 'male', '2', '', 'Implemented a couple of cool features for phpdbform. Support for combo boxes with fixed list and listing 2 or more fields in the select form.');
INSERT INTO contact VALUES ( '5', 'Tom Vander Aa', 'Tom.VanderAa@esat.kuleuven.ac.be', 'male', '2', '', 'Added support for PostgreSQL database in phpdbform. Now phpdbform works with two databases!');
INSERT INTO contact VALUES ( '6', 'Other person', 'nobody@nowhere.com', 'male', '4', '', 'I don\'t know... This is a test. Perhaps it can be you in the next release ;-)');


/*
# --------------------------------------------------------
#
# Table structure for table 'type'
#*/

CREATE TABLE type (
   cod int4 PRIMARY KEY DEFAULT nextval('type_s'),
   type varchar(20) NOT NULL,
   business int2 NOT NULL
);

/*
#
# Dumping data for table 'type'
#*/

INSERT INTO type VALUES( '1', 'Personal', '0');
INSERT INTO type VALUES( '2', 'Business', '1');
INSERT INTO type VALUES( '3', 'School', '0');
INSERT INTO type VALUES( '4', 'Events', '1');

/*
#
# Table structure for table 'photos'
#*/

CREATE TABLE photos (
   cod int4 PRIMARY KEY DEFAULT nextval('photos_s'),
   name varchar(30) NOT NULL,
   image_ctrl varchar(11),
   image text
);

