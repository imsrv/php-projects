###############################################################################
# 452 Productions Internet Group (http://452productions.com)
# 452 Multi-MAIL  v1.6 BETA
#    This script is freeware and is realeased under the GPL
#    Copyright (C) 2000, 2001  452 Productions
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
#    Or just download it http://fsf.org/
################################################################################
# --------------------------------------------------------
#
# Table structure for table 'lists'
#

CREATE TABLE lists (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   list_name varchar(255) NOT NULL,
   description varchar(255) NOT NULL,
	 welcome text NOT NULL,
   footer text NOT NULL,
   PRIMARY KEY (id),
   UNIQUE id (id),
   UNIQUE list_name (list_name)
);
# --------------------------------------------------------
#
# Table structure for table 'mail_list'
#

CREATE TABLE mail_list (
   id bigint(20) DEFAULT '0' NOT NULL auto_increment,
   email varchar(255) NOT NULL,
   list_names text NOT NULL,
   PRIMARY KEY (id),
   UNIQUE id_2 (id),
   UNIQUE email (email)
);


# --------------------------------------------------------
#
# Table structure for table 'mail_sent'
#

CREATE TABLE mail_sent (
   id bigint(20) DEFAULT '0' NOT NULL auto_increment,
   subject varchar(255) NOT NULL,
   mail text NOT NULL,
   user_id varchar(255) NOT NULL,
   list_names varchar(255) NOT NULL,
   date varchar(255) NOT NULL,
   PRIMARY KEY (id),
   KEY id (id),
   UNIQUE id_2 (id)
);
# --------------------------------------------------------
#
# Table structure for table 'muser'
#

CREATE TABLE muser (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   user_id varchar(255) NOT NULL,
   user_pass varchar(255) NOT NULL,
   PRIMARY KEY (user_id),
   UNIQUE user_id (user_id),
   UNIQUE id (id)
);
