<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

require("$BSX_LIBDIR/testcookie.class");

// -----------------------------------------------------------------------
function cookie_test() {
    global $BSX_BASEHREF, $BSX_PHP_EXTENSION, $BSX_LAUNCHER, $BSX_TestCookie, $testCookie;
    $cookie_obj = new test_cookie();
    $cookie_enabled = $cookie_obj->do_test($BSX_TestCookie, $testCookie);
    if($cookie_enabled == true) url_redirect($BSX_BASEHREF . "/" . $BSX_LAUNCHER);
    else url_redirect($BSX_BASEHREF . "/" . $BSX_LAUNCHER . "?is_nocookie=1");
}
?>
