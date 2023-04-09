<?//-*- C++ -*-
/*   ********************************************************************   **
**   Copyright (C) 1995-2000 Mirko Giese                                    **
**   Copyright (C) 2000-     PHPOpenChat Development Team                   **
**   http://www.ortelius.de/phpopenchat/                                    **
**                                                                          **
**   This program is free software. You can redistribute it and/or modify   **
**   it under the terms of the PHPOpenChat License Version 1.0              **
**                                                                          **
**   This program is distributed in the hope that it will be useful,        **
**   but WITHOUT ANY WARRANTY, without even the implied warranty of         **
**   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                   **
**                                                                          **
**   You should have received a copy of the PHPOpenChat License             **
**   along with this program.                                               **
**   ********************************************************************   */
include 'defaults_inc.php';
//start session
if($ENABLE_SESSION){
  @session_start();
}
if(!check_permissions($nick,$pruef)){
  //the user has no access permission for this page
  header("Status: 204 OK\r\n");//browser don't refresh his content
  exit;
}
?>
<!DOCTYPE HTML PUBLIC "-//AdvaSoft//DTD HTML 3.2 extended 961018//EN">
<HTML>
<HEAD>
 <TITLE>Blackboard</TITLE>
</HEAD>

<BODY BGCOLOR="WHITE" FGCOLOR="BLACK" BACKGROUND="<?echo$BACKGROUNDIMAGE?>">
<BR>
      <DIV ALIGN=center>
	<H1>Blackboard</H1> 
<?
$nickcode=urlencode($nick);

if($ENABLE_SESSION){
  echo '<a href="links.'.$FILE_EXTENSION.'?'.session_name().'='.session_id().'" target="links">'.$FORUM[all_themes].'</a>';
}else{
  echo '<a href="links.'.$FILE_EXTENSION.'?nick='.$nickcode.'&pruef='.$pruef.'" target="links">'.$FORUM[all_themes].'</a>';
}
?>
<HR NOSHADE SIZE="1">
</DIV>
<?
/*
 * Open a database connection
 * The following include returns a database handle
 */
include ('connect_db_inc.php');
$db_handle=connect_db($DATABASEHOST,$DATABASEUSER,$DATABASEPASSWD);
if(!$db_handle){
  exit;
}

if (isset($ping))
{
	$ausgabe=mysql_query("select * from chat_forum where Nummer='$ping'",$db_handle);
	$a=mysql_fetch_array($ausgabe);
	echo  $a[DATE].'; ';
	echo '<b>'.$a[NAME].'</b> '.$FORUM[wrote].':<BR>';
	echo $a[KOMMENTAR].'<BR>';
	echo '<B>EMAIL: </b>'; 
	$email=$a[EMAIL];
	if(ereg('@',$email))
        {
		echo '<a href="mailto:'.$email.'">'.$email.'</a>';
        }
	else
        {
		echo $email;
	}
	echo '<BR>';
	$homepage=$a[HOMEPAGE];
	echo '<b>Homepage:</b>'; 
	if(ereg('http://',$homepage))
        {
		echo '<a href="'.$homepage.'" TARGET="new">'.$homepage.'</a>';
        }
	else
        {
		echo $homepage;
	}
	echo '<BR>';
	
	echo '<B>'.$HOST.': </b>'.$a[HOST].'<BR>';	
}
else
{
	echo $FORUM[welcome];
}
mysql_close($db_handle);
?>
</BODY>
</HTML>
