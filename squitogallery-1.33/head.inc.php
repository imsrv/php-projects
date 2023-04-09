<?php
/*
    
	Squito Gallery 1.33
    Copyright (C) 2002-2003  SquitoSoft and Tim Stauffer

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/
session_start();
if(!isset($_SESSION['language'])) $_SESSION['language']='english';
$_SESSION['error']='';
include('formhandler.inc.php');
clearstatcache();
if(!file_exists('./config.inc.php'))
{
echo 'please run <a href="setup.php">setup.php</a> before you continue';
exit;
}
include('./config.inc.php');
include('./dbfns.inc.php');
if(!isset($_SESSION['lastpage']))
{
$_SESSION['lastpage'] = $_SERVER['REQUEST_URI'];
}
if(isset($_POST['form_language']))
$_SESSION['language'] = $_POST['form_language'];

require($photoroot.'lang/'.$_SESSION['language'].'.inc.php');
$_SESSION['lang'] = $lang;
$_SESSION['lastpage']=$_SERVER['REQUEST_URI'];

include($photoroot.'whoson.class.php');
$sess_obj = new Whoson();
$sess_obj->get_language();
$sess_obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
if(!isset($_SESSION['time'])) $_SESSION['time'] = 0;
$_SESSION['time']=$sess_obj->clean_sessions($_SESSION['time']);
if(!isset($_SESSION['squitoid'])) $_SESSION['squitoid']='';
if(isset($_COOKIE['PHPSESSID']))
$sess_obj->set_session($_COOKIE['PHPSESSID'],$_SESSION['squitoid']);
require($photoroot.'photo.class.php');
$obj = new Photo();
$obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
if(isset($_POST['submitComment']))
{
$obj->add_comment($_POST['form_photo_id'],$_POST['form_name'],$_POST['form_email'],$_POST['form_comment']);
}
if(isset($_POST['subSendMessage']))
{
$obj->set_homeurl($homeURL);
$obj->set_display(0,0,0,0,0,$webimageroot,$images,$thumbnails,$photoroot,$imagemagickpath, $os, $lang, $thumbsize);
$obj->send_message($_POST['to'],$_POST['from'],$_POST['subject'],$_POST['body']);
}
?>