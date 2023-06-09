# phpMyAdmin MySQL-Dump
# version 2.2.4
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# ����: 127.0.0.1
# ����� ��������: ��� 11 2002 �., 02:41
# ������ �������: 3.23.49
# ������ PHP: 4.1.2
# �� : `testing`
# --------------------------------------------------------

#
# ��������� ������� `manufacturer`
#

CREATE TABLE manufacturer (
  id int(11) NOT NULL auto_increment,
  manufacturer char(255) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# ��������� ������� `products`
#

CREATE TABLE products (
  id int(11) NOT NULL auto_increment,
  available int(12) NOT NULL default '0',
  manufacturer varchar(255) NOT NULL default '',
  modelnumber varchar(255) NOT NULL default '',
  litdescr varchar(255) NOT NULL default '',
  bigdescr text NOT NULL,
  picture varchar(255) NOT NULL default '',
  html text NOT NULL,
  orprice int(12) NOT NULL default '0',
  ouprice int(12) NOT NULL default '0',
  makeopt char(3) NOT NULL default '0',
  hiddenopt char(3) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

