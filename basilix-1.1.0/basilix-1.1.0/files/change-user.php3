<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Change the login name and the domain
// -----------------------------------------------------------------------

SetCookie("BSX_Domain");
SetCookie("BSX_User");
SetCookie("BSX_Lang");
SetCookie("BSX_Theme");
SetCookie("BSX_TestCookie");
url_redirect();
?>
