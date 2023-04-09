#
#      PhotoSeek Database Definition(s)
#              for PostgreSQL
# code    : jeff b (jeff@univrel.pr.uconn.edu)
# licence : GPL, v2
#

# create the database to hold all of this
CREATE DATABASE photoseek;

# use this as the default database
USE photoseek;

# create table for users
CREATE TABLE users (
   username                         VARCHAR(20) NOT NULL,
   userdesc                         VARCHAR(20),
   userpass                         VARCHAR(20),
   userlevel                        INT UNSIGNED,
   id                               INT NOT NULL AUTO_INCREMENT,
   PRIMARY KEY (id),
   UNIQUE (username)
);

# create table for repositories
CREATE TABLE repositories (
   rname                            VARCHAR(100),
   rdesc                            VARCHAR(100),
   rpath                            VARCHAR(100),
   rlevel                           INT UNSIGNED,
   id                               INT NOT NULL AUTO_INCREMENT,
   PRIMARY KEY (id)
);

# create the record for images in the database
CREATE TABLE images (
          ### LINK TO REPOSITORY ###
   repository                       INT UNSIGNED,
          ### FILENAME / IMAGE TYPE ###
   fullfilename                     VARCHAR(255),
   imagetype                        CHAR(4),
   lastmodified                     VARCHAR(30),
        ### IMAGE THUMBNAIL INFORMATION ###
   thumbnail                        BLOB,
   largethumbnail                   BLOB,
            ### DESCRIPTION FIELDS ###
   caption                          BLOB,
   caption_writer                   VARCHAR(128),
   headline                         VARCHAR(128),
   special_instructions             VARCHAR(128),
   byline                           VARCHAR(128),
   byline_title                     VARCHAR(128),
   credit                           VARCHAR(128),
   image_source                     VARCHAR(128),
   object_name                      VARCHAR(128),
   date_created                     DATE,
   city                             VARCHAR(128),
   state                            VARCHAR(128),
   country                          VARCHAR(128),
   original_transmission_reference  VARCHAR(128),
   categories                       BLOB,
   keywords                         BLOB,
   copyright_notice                 VARCHAR(128),
               ### KEY INFORMATION ###
   id                               INT UNSIGNED NOT NULL AUTO_INCREMENT,
   PRIMARY KEY                      (id)
 );
