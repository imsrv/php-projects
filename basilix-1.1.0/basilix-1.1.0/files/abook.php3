<?php
/*
+----------------------------------------------------------------------+
| BasiliX - Copyright (C) 2000-2002 Murat Arslan <arslanm@basilix.org> |
+----------------------------------------------------------------------+
*/

// Address book routines
// -----------------------------------------------------------------------

require("$BSX_LIBDIR/abook.inc");
require("$BSX_LIBDIR/getvals.inc");
// --

$add_nick = decode_strip($add_nick);
$add_email = decode_strip($add_email);
$add_name = decode_strip($add_name);
$add_tel = decode_strip($add_tel);
$add_fax = decode_strip($add_fax);
$add_note = decode_strip($add_note);
$grpName = decode_strip($grpName);
// --

// functions stay in $BSX_LIBDIR/abook.inc
// --

// add a new user
if(!empty($addEntry)) abook_addentry();

// modifying an existing user
if(!empty($modEntry)) abook_modentry();
if(!empty($modItem)) abook_moditem();

// delete user from the addressbook
if(!empty($delItem)) abook_delitem();

// show the members of a group
if(!empty($grpShowMembers)) abook_grpshowmembers();

// add a new user to a group
if(!empty($grpAddMember)) abook_grpaddmember();

// update the memberlist (via javascript)
if(!empty($grpUpdate)) abook_grpupdatemembers();

// delete user from a group
if(!empty($grpDelMember)) abook_grpdelmember();

// create a new group
if(!empty($grpAdd)) abook_grpadd();

// delete an existing group
if(!empty($grpDel)) abook_grpdel();

// import the old db from 0.9.7
if(!empty($importold)) do_import();


$grpItem = "yes";

// load the addressbook
load_abook();

// and print
$pagehdr_msg = $lng->p(105);
push_abook();
// --
?>
