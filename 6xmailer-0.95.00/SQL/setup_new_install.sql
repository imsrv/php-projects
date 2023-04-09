# // ==========================================================
# // This file creates the database and tables needed for
# // 6XMailer
# // ==========================================================

# // Replace 6xmailer_data with the name you wish to you for your copy,
# // but remember to change the $QLDatabase to match this in the
# // config.php file.
CREATE DATABASE IF NOT EXISTS 6xmailer_data;
USE 6xmailer_data;

CREATE TABLE IF NOT EXISTS userdata(
	UID BIGINT UNSIGNED DEFAULT '0' NOT NULL AUTO_INCREMENT,
	Username CHAR (50) NOT NULL,
	DisplayName CHAR (50),
	Theme CHAR (25) DEFAULT 'default' NOT NULL,
	Language CHAR (50) DEFAULT 'English',
	PRIMARY KEY(UID),
	UNIQUE(UID,Username),
	INDEX(UID)
);

CREATE TABLE IF NOT EXISTS addressbook(
	EID BIGINT UNSIGNED DEFAULT '0' NOT NULL AUTO_INCREMENT,
	UID BIGINT UNSIGNED DEFAULT '0' NOT NULL,
	NameL CHAR (25),
	NameF CHAR (25),
	Display CHAR (50),
	E_Mail CHAR (100) NOT NULL,
	Address CHAR (50),
	Address2 CHAR (50),
	City CHAR (30),
	State CHAR (2),
	Zip CHAR (10),
	Country CHAR (50),
	Phone CHAR (14),
	Biz_Address CHAR (50),
	Biz_Address2 CHAR (50),
	Biz_City CHAR (30),
	Biz_State CHAR (2),
	Biz_Zip CHAR (10),
	Biz_Country CHAR (50),
	Biz_Phone CHAR (14),
	Mobile_Phone CHAR (14),
	PRIMARY KEY(EID),
	UNIQUE(EID),
	INDEX(EID,UID,NameL,NameF,Display,E_Mail)
);

CREATE TABLE IF NOT EXISTS themes(
	Name CHAR (25) NOT NULL,
	Dir CHAR (25) NOT NULL, PRIMARY KEY(Name),
	UNIQUE(Name,Dir),
	INDEX(Name)
);

CREATE TABLE IF NOT EXISTS languages(
	Language CHAR (50) NOT NULL,
	Dir CHAR (25) NOT NULL,
	PRIMARY KEY(Language),
	UNIQUE(Language,Dir),
	INDEX(Language)
);

INSERT INTO languages VALUES('English', 'English')
INSERT INTO themes VALUES('Outlook', 'default')