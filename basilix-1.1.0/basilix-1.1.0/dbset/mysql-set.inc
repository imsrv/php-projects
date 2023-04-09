<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/
//
// DB username and password for MySQL
// $BSX_DB_USER is the username
// $BSX_DB_PASS is the password
// $BSX_DB_NAME is the db name
// $BSX_DB_HOST is the host serves our db
// -----------------------------------------------------------------------
// DO NOT FORGET TO ENTER THE FOLLOWING COMMANDS
// chown nobody mysql-set.inc
// chmod 700 mysql-set.inc

// --
$BSX_DB_USER = "bsxuser";
$BSX_DB_PASS = "bsxpass";
$BSX_DB_NAME = "BASILIX";
$BSX_DB_HOST = "localhost";
// --

// simple encryption for the password which will be kept in the db
function pwencrypt($pwd) {
    return base64_encode($pwd);
}
function pwdecrypt($pwd) {
    return base64_decode($pwd);
}
?>
