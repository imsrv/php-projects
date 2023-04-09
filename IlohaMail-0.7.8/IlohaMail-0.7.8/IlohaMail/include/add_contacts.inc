<?
/********************************************************
	include/add_contacts.inc
	
	(C) 2000-2002 Ryo Chijiiwa <Ryo@IlohaMail.org>

	This file is part of IlohaMail, and released under GPL.
	See COPYING, or http://www.fsf.org/copyleft/gpl.html
	
	PURPOSE:
		Shell for add_contacts.backend.inc

********************************************************/

include_once("../conf/conf.inc");

$ac_backend = $backend;
if ($ac_backend =="MySQL"){
	include_once("../conf/mysqlrc.inc");
	if ((!isset($mysql_contacts)) || (empty($mysql_contacts))) $ac_backend = "FS";
}

	if (strcmp($group,"_otr_")==0) $group=$other_group;
    $new_contact_array = array(
        "owner" => $session_dataID,
        "name" => $name,
        "email" => $email,
        "email2" => $email2,
        "grp" => $group,
        "aim" => $aim,
        "icq" => $icq,
        "phone" => $phone,
        "work" => $work,
        "cell" => $cell,
        "address" => $address,
        "url" => $url,
        "comments" => $comments
    );

include("../include/add_contacts.".$ac_backend.".inc");
?>