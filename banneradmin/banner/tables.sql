#
# Table structure for table 'banner_stat'
#

CREATE TABLE banner_stat (
   id int(11) NOT NULL auto_increment,
   bannerID int(11) DEFAULT '0' NOT NULL,
   clicks int(11) DEFAULT '0' NOT NULL,
   views int(11) DEFAULT '0' NOT NULL,
   date date DEFAULT '0000-00-00' NOT NULL,
   PRIMARY KEY (id)
);

#
# Table structure for table 'banners'
#

CREATE TABLE banners (
   bannerID mediumint(9) NOT NULL auto_increment,
   client varchar(200) NOT NULL,
   banner blob NOT NULL,
   width smallint(6) DEFAULT '0' NOT NULL,
   height smallint(6) DEFAULT '0' NOT NULL,
   format enum('gif','jpeg','png','html','url') DEFAULT 'gif' NOT NULL,
   url varchar(255) NOT NULL,
   src varchar(250) NOT NULL,
   alt varchar(255) NOT NULL,
   type varchar(20) NOT NULL,
   local_banner tinyint(4) DEFAULT '0' NOT NULL,
   date date DEFAULT '0000-00-00' NOT NULL,
   keyword varchar(255) NOT NULL,
   title varchar(255) NOT NULL,
   active enum('true','false') DEFAULT 'true' NOT NULL,
   PRIMARY KEY (bannerID)
);
