<?php 
# ---------------------------------------------------------------
# phpop
# A WWW based POP3 basic mail user agent (MUA)
# Copyright (C) 1999  Padraic Renaghan
# Licensed under terms of GNU General Public License
# (see http://www.renaghan.com/phpop/source/LICENSE)
# ---------------------------------------------------------------
# $Id: logout.php3,v 1.6 2000/07/06 15:08:47 prenagha Exp $
# ---------------------------------------------------------------
include(dirname(__FILE__)."/lib/poprepend.inc");
page_open(array( "sess" => "pop_sess"
          ,"auth" => "pop_auth"));
				  
# close up the pop connection
$pop3->quit;

# kill the user login authorization object
$auth->unauth();

# kill the session object
$sess->delete();

$tpl->set_file(array(
 standard   => "common.standard.tpl",
 body       => "logout.body.tpl"
));

set_standard("logout", &$tpl);

$tpl->parse(BODY, "body");
$tpl->parse(MAIN, "standard");
$tpl->p(MAIN);
?>
