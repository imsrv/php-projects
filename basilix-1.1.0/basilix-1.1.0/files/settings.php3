<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// User settings
// -----------------------------------------------------------------------

// get the values of the user
require("$BSX_LIBDIR/getvals.inc");

$sql->open();
$theme_stats = theme_usage();

// show settings form
$pagehdr_msg = $lng->p(106);
settings_form();
// -
?>
