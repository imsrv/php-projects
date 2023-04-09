<?php
/*
+-------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000 Murat Arslan <arslanm@cyberdude.com> |
+-------------------------------------------------------------------+
*/

// -- Index file -- cookie test and redirect to the launcher file
// -----------------------------------------------------------------

// load the master conf file
require("/usr/local/basilix/conf/basilix.conf");
// --

require("$BSX_CONFDIR/domain.conf");
require("$BSX_CONFDIR/global.conf");
require("$BSX_CONFDIR/request.conf");
require("$BSX_LIBDIR/util.inc");
require("$BSX_LIBDIR/testcookie.inc");

cookie_test();
?>
