<?php
# ---------------------------------------------------------------
# phpop
# A WWW based POP3 basic mail user agent (MUA)
# Copyright (C) 1999  Padraic Renaghan
# Licensed under terms of GNU General Public License
# (see http://www.renaghan.com/phpop/source/LICENSE)
# ---------------------------------------------------------------
# $Id: poprepend.inc,v 1.6 2000/07/06 15:08:50 prenagha Exp $
# ---------------------------------------------------------------
# the following files are required for the correct
# operation of PHPLIB and phpop
#

define ("LIBDIR", dirname(__FILE__)."/");
define ("PHPLIBDIR", LIBDIR."phplib/");
define ("TEMPLATEDIR", LIBDIR."templates");

# when using a database for session storage, uncomment
# the following two lines
require(PHPLIBDIR . "db_mysql.inc");
require(PHPLIBDIR . "ct_sql.inc");

# if you try and use the dbm file method for session storage,
# uncomment this next line.
#require(PHPLIBDIR . "ct_dbm.inc");


require(PHPLIBDIR . "session.inc");
require(PHPLIBDIR . "auth.inc");
require(PHPLIBDIR . "template.inc");
require(LIBDIR . "class.Validator.inc");
require(LIBDIR . "class.pop3.inc");
require(LIBDIR . "poplocal.inc");
require(LIBDIR . "phpop.inc");
require(PHPLIBDIR . "page.inc");
require(LIBDIR . "email.inc");
?>
