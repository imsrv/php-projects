<?php
/* vim: set foldmethod=marker: */
/* Swobodin's Chicken 0.2  Copyright (C) 2005 Swobodin
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA */

error_reporting(E_ALL ^ E_NOTICE);//Got enough :-/
include "class.chicken.php";
include "config.php";
$chicken = new chicken();
$chicken->host = $host;
$chicken->user = $user;
$chicken->password = $password;
$chicken->db = $db;
$chicken->connection();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <title>Why did the chicken cross the road?</title>


  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

  <link rel="stylesheet" type="text/css" href="layout_deneva.css" media="screen"/>

  <link rel="stylesheet" type="text/css" href="style_deneva.css" media="screen" />

</head>


	<body>

<div class="banner">Swobodin's Chicken <?=version?></div>

<div class="navigation"> <a href=".">home</a>
/ <a href="?topic=ans&amp;action=view">View answers</a>
</div>

<div class="content_main">
<div class="content_left">
<div class="box">
<div class="header">Answers</div>

<p>View answers</p>

<ul>

<li><a href="?topic=ans&amp;action=view">All</a></li>

  <li><a href="?topic=ans&amp;action=view&amp;mode=lang">By language</a></li>
  
  <?php
	 $r3 = $chicken->show_lang();
	 print "<li>\n<ul>\n";
	  while ($row = mysql_fetch_row($r3)) {
		  print "<li><a href=\"?topic=ans&amp;action=view&amp;mode=lang&amp;sel=$row[1]\">$row[2]</a></li>\n";
	  }
	  $chicken->free($r3);
		  print "</ul>\n</li>\n";
  

 print "<li><a href=\"?topic=ans&amp;action=view&amp;mode=cat\">By category</a></li>\n";
	 $r4 = $chicken->show_cat();
	 print "<li>\n<ul>\n";
	  while ($row = mysql_fetch_row($r4)) {
		  print "<li><a href=\"?topic=ans&amp;action=view&amp;mode=cat&amp;sel=$row[1]\">$row[2]</a></li>\n";
		  }
	  $chicken->free($r4);
		  print "</ul>\n</li>\n";
		  print  "<li><a href=\"?topic=ans&amp;action=view&amp;mode=rand\">Random answer</a></li>\n";
?>
</ul>

<p><a href="?topic=ans&amp;action=add">Add answer</a></p>
</div>

<div class="box">
<div class="header">Languages</div>

<ul>

<li><a href="?topic=lang&amp;action=add">Add language</a></li>

<li><a href="?topic=lang&amp;action=view">View / edit languages</a></li>

</ul>

</div>

<div class="box">
<div class="header">Categories</div>

<ul>

  <li><a href="?topic=cat&amp;action=add">Add category</a></li>

  <li><a href="?topic=cat&amp;action=view">View / edit categories</a></li>

</ul>

</div>
<div class="box">
<div class="header">Search</div>
<form method="get" action="?topic=search">
<input type="hidden" name="topic" value="search" />
<p><input type="text" name="q"/></p>
<p><input type="radio" name="where" value="who"/>Topics only<br />
<input type="radio" name="where" value="what"/>Answers only<br />
<input type="radio" name="where" value="both" checked="checked" />Both<br />
</p>
<p><input type="submit" value="Go!" /></p>
</form>
</div>
</div>
</div>

<div class="content_right">
<h1>Why did the chicken cross the road?</h1>
<?php
switch ($_GET['topic']) {
	case "cat":
	// {{{ cat_table
	switch ($_GET['action']) {
		case "view":
		$r1 = $chicken->show_cat();
		$color="#CCDDEE";
		while ($row = mysql_fetch_row($r1)) {
		print "<div style=\"background-color: $color\">".$row[2]."&nbsp;<a href=\"?topic=".$_GET['topic']."&amp;action=edit&amp;hash=".$row[1]."\">Edit</a>
		<span style=\"background-color: #FF0000\"><a href=\"?topic=".$_GET['topic']."&amp;action=delete&amp;hash=".$row[1]."\">Delete</a></span></div>\n";
		if ($color == "#CCDDEE") 
			$color = "#CCEEDD";
			else
			$color = "#CCDDEE";
		}
		
	  $chicken->free($r1);
		break;
		case "add":
			if (!isset ($_POST["sub"]) || !isset($_POST["catname"])) {
						
		?>
		<div>
		<h2>Type category to add</h2>
		<form action="?topic=cat&amp;action=add" method="post">
		<p><input type="text" name="catname" /></p>
		<p><input type="submit" name="sub" /></p>
		
		</form>
		</div>
		<?php
			}
			else {
				if ($chicken->add_cat($_POST['catname'])) {
					print "<h3>Category ".stripslashes($_POST['catname'])." successfully added!</h3>\n";
				}
				else {
					print "<h3>Category ".stripslashes($_POST['catname'])." not added :-(</h3>\n";
				}
				
			}
		break;
	case "edit":
		print "<h1>Edit category</h1>\n";
		$r2 = $chicken->show_cat($_GET['hash']);
		if (mysql_num_rows($r2) == 0) {
			print "<h2>No such category</h2>\n";
		}
		else {
			if (!isset ($_POST["sub"]) || !isset($_POST["cated"])) {
			$row = mysql_fetch_object($r2);
		?>
		<div>
		<form action="?topic=cat&amp;action=edit" method="post">
		<h2>New name</h2>
	<p><input type="text" name="cated" value="<?=$row->name_cat?>" /></p>
	<p><input type="submit" value="Submit" name="sub" /><input type="hidden" name="hash" value="<?=$row->md5_cat?>"/></p>
		</form>
	</div>
		<?php
			}
			else {
			if(	$chicken->edit_cat($_POST["cated"],$_POST["hash"])) {
				print "<h2>Successfully renamed category to \"".stripslashes($_POST['cated'])."\"</h2>\n";
			}
			else print "<h2>Could not update category :-( Reason: <p>".mysql_error()."</p></h2>";
			}
		}
		break;
		case "delete":
			$del = $chicken->del_cat($_GET['hash']);
			if ($del) { print "<h2>Category successfully deleted</h2>\n";}
			else {
				print "Could not delete category, reason: ".mysql_error()."\n";
			}
		break;
	}
	print "</div>\n";
	// }}}
	break;

	case "lang":
// {{{ lang_table
	switch ($_GET['action']) {
		case "view":
		$r1 = $chicken->show_lang();
		$color="#CCDDEE";
		while ($row = mysql_fetch_row($r1)) {
		print "<div style=\"background-color: $color\">".$row[2]."&nbsp;<a href=\"?topic=".$_GET['topic']."&amp;action=edit&amp;hash=".$row[1]."\">Edit</a>
		<span style=\"background-color: #FF0000\"><a href=\"?topic=".$_GET['topic']."&amp;action=delete&amp;hash=".$row[1]."\">Delete</a></span></div>\n";
		if ($color == "#CCDDEE") 
			$color = "#CCEEDD";
			else
			$color = "#CCDDEE";
		}
		
		break;
		case "add":
			if (!isset ($_POST["sub"]) || !isset($_POST["langname"])) {
						
		?>
		<div>
		<h2>Type language to add</h2>
		<form action="?topic=lang&amp;action=add" method="post">
		<p><input type="text" name="langname" /></p>
		<p><input type="submit" name="sub" /></p>
		
		</form>
		</div>
		<?php
			}
			else {
				if ($chicken->add_lang($_POST['langname'])) {
					print "<h3>Language ".stripslashes($_POST['langname'])." successfully added!</h3>\n";
				}
				else {
					print "<h3>Language ".stripslashes($_POST['catname'])." not added :-(</h3>\n";
				}
				
			}
		break;
	case "edit":
		print "<h1>Edit language</h1>\n";
		$r2 = $chicken->show_lang($_GET['hash']);
		if (mysql_num_rows($r2) == 0) {
			print "<h2>No such language</h2>\n";
		}
		else {
			if (!isset ($_POST["sub"]) || !isset($_POST["langed"])) {
			$row = mysql_fetch_object($r2);
		?>
		<div>
		<form action="?topic=lang&amp;action=edit" method="post">
		<h2>New name</h2>
	<p><input type="text" name="langed" value="<?=$row->lang?>" /></p>
	<p><input type="submit" value="Submit" name="sub" /><input type="hidden" name="hash" value="<?=$row->md5_lang?>"/></p>
		</form>
	</div>
		<?php
			}
			else {
			if(	$chicken->edit_lang($_POST["langed"],$_POST["hash"])) {
				print "<h2>Successfully renamed language to \"".stripslashes($_POST['langed'])."\"</h2>\n";
			}
			else print "<h2>Could not update language :-( Reason: <p>".mysql_error()."</p></h2>";
			}
		}
	  $chicken->free($r2);
		break;
		case "delete":
			$del = $chicken->del_lang($_GET['hash']);
			if ($del) { print "<h2>Language successfully deleted</h2>\n";}
			else {
				print "Could not delete language, reason: ".mysql_error()."\n";
			}
		break;
	}
	// }}}
	print "</div>\n";
	break;
	
	case "ans":
// ans_table {{{
	switch ($_GET['action']) {
	case "add":
		if (isset ($_POST['who']) && isset ($_POST['ans']) && isset ($_POST['sub']) ) {
	$added = $chicken->add_ans($_POST['who'], $_POST['def'], $_POST['ans'], $_POST['cat'], $_POST['lang']);
	if ($added) {
		print "<h1>Answer successfully added</h1>\n";
	}
	else print "Could not add answer :-( . Reason: ".mysql_error()."\n";
		}
	?>
	<h1>Add answer</h1>
	<div>
	<form action="?topic=ans&amp;action=add" method="post">
	<h2>Character</h2>
	<p><input type="text" name="who"/></p>
	<?php
	
	print "<h2>Category</h2>
	<p><select name=\"cat\">\n";
		$r5 = $chicken->show_cat();
		while ($row = mysql_fetch_row($r5)) {
			print "<option value=\"$row[1]\">$row[2]</option>\n";
		}
	  $chicken->free($r5);
	print "</select></p>
	<h2>Language</h2>
	<p><select name=\"lang\">\n";
	$r6 = $chicken->show_lang();
		while ($row = mysql_fetch_row($r6)) {
			print "<option value=\"$row[1]\">$row[2]</option>\n";
		}	
	  $chicken->free($r6);
	print "</select></p>\n";
	?>
	<h2>Definition</h2>
	<p><textarea cols="50" rows="5" name="def"></textarea></p>
	<h2>Answer</h2>
	<p><textarea cols="50" rows="20" name="ans"></textarea></p>
	<input type="submit" name="sub" value="submit"/>
	</form>
	</div>
	<?php
		break;
		case "view":
		switch ($_GET['mode']) {
			case "lang":
				print "<div>\n";
			if (isset ($_GET['sel'])) {
				$r9 = $chicken->show_ans('',"lang",$_GET['sel']);
			$act_color="#CCDDEE";
			print "<div>\n";
			while ($row = mysql_fetch_row($r9)) {
		if ($act_color == "#CCDDEE") 
			$act_color = "#CCEEDD";
			else
			$act_color = "#CCDDEE";
	$row[5] = nl2br($row[5]);	
				if ($row[4] !=NULL) {
					$def = "<span style=\"font-style: italic; font-size: small\">&nbsp;($row[4])</span>\n";
				}
				else {
					$def = NULL;
					}
print <<<BEGIN
<div style="background-color: $act_color">
<div><span style="font-size: 120%; color: navy; font-weight: bolder">$row[3]</span>$def</div>
<div>$row[5]</div>
<div><a href="?topic=ans&amp;action=edit&amp;item=$row[1]">Edit</a>
<span style="background-color: #FF0000"><a href="?topic=ans&amp;action=delete&amp;item=$row[1]">Delete</a></span></div>
</div>

BEGIN;
		
		}
					print "</div>\n";
	  $chicken->free($r9);
		
				
			}
			else {
				$r8 = $chicken->show_lang();
				while ($row = mysql_fetch_row($r8)) {
					print "<p><a href=\"?topic=ans&amp;action=view&amp;mode=lang&amp;sel=$row[1]\">$row[2]</a></p>\n";
				}
	  $chicken->free($r8);
	//			print "</div></div>\n";
				
			}
			/*print "</div>
				</div>\n";*/
			break;
			case "cat":
			print "<div>\n";
			if (isset ($_GET['sel'])) {
				$r10 = $chicken->show_ans('',"cat",$_GET['sel']);
			$act_color="#CCDDEE";
			print "<div>\n";
			while ($row = mysql_fetch_row($r10)) {
		if ($act_color == "#CCDDEE") 
			$act_color = "#CCEEDD";
			else
			$act_color = "#CCDDEE";
	$row[5] = nl2br($row[5]);	
		
				if ($row[4] !=NULL) {
					$def = "<span style=\"font-style: italic; font-size: small\">&nbsp;($row[4])</span>\n";
				}
				else {
					$def = NULL;
					}
print <<<BEGIN
<div style="background-color: $act_color">
<div><span style="font-size: 120%; color: navy; font-weight: bolder">$row[3]</span>$def</div>
<div>$row[5]</div>
<div><a href="?topic=ans&amp;action=edit&amp;item=$row[1]">Edit</a>
<span style="background-color: #FF0000"><a href="?topic=ans&amp;action=delete&amp;item=$row[1]">Delete</a></span></div>
</div>

BEGIN;
		
		}
	  $chicken->free($r10);
		print "</div>\n";
		
				
			}
			else {
				$r11 = $chicken->show_cat();
				while ($row = mysql_fetch_row($r11)) {
					print "<p><a href=\"?topic=ans&amp;action=view&amp;mode=cat&amp;sel=$row[1]\">$row[2]</a></p>\n";
				}
	  $chicken->free($r11);
//				print "</div>\n</div>\n";
				
			}
			/*print "</div>
				</div>\n";*/
			break;
		case "rand":
			$r20 = $chicken->show_ans('',"rand");
			$row = mysql_fetch_object($r20);
			if ($row[4] !=NULL) {
				$def = "<span style=\"font-style: italic; font-size: small\">&nbsp;($row->def)</span>\n";
				#$def = "<div style=\"font-style: italic\">$row->def</div>\n";
				}
			 else {
				 $def = NULL;
			}		
			$row->ans = nl2br($row->ans);	
print <<<BEGIN
<div style="background-color: #CCDDEE">
<div><span style="font-size: 120%; color: navy; font-weight: bolder">$row->who</span>$def</div>
<div>$row->ans</div>
<div><a href="?topic=ans&amp;action=edit&amp;item=$row->md5_ans">Edit</a>
<span style="background-color: #FF0000"><a href="?topic=ans&amp;action=delete&amp;item=$row->md5_ans">Delete</a></span></div>
BEGIN;
		break;
			
		default: 

			$r7 = $chicken->show_ans();
			$act_color="#CCDDEE";
			print "<div>\n";
			while ($row = mysql_fetch_row($r7)) {
		if ($act_color == "#CCDDEE") 
			$act_color = "#CCEEDD";
			else
			$act_color = "#CCDDEE";
		
				if ($row[4] !=NULL) {
					$def = "<span style=\"font-style: italic; font-size: small\">&nbsp;($row[4])</span>\n";
//					$def = "<div style=\"font-style: italic\">$row[4]</div>\n";
				}
				else {
					$def = NULL;
					}
			$r16 = $chicken->show_lang($row[7]);
			$row_lang=mysql_fetch_object($r16);
			$r17 = $chicken->show_cat($row[6]);
			$row_cat=mysql_fetch_object($r17);
	$row[5] = nl2br($row[5]);	
print <<<BEGIN
<div style="background-color: $act_color">
<div> <span style="font-size: 120%; color: navy; font-weight: bolder">$row[3]</span>$def<br />
<span style="font-style: italic; font-size: xx-small; font-weight: 100; color: #333333">(
	<a href="?topic=ans&amp;action=view&amp;mode=lang&amp;sel=$row[7]">$row_lang->lang</a> :: <a href="?topic=ans&amp;action=view&amp;mode=cat&amp;sel=$row[6]">$row_cat->name_cat</a>)</span>
</div>
<div>$row[5]</div>
<div><a href="?topic=ans&amp;action=edit&amp;item=$row[1]">Edit</a>
<span style="background-color: #FF0000"><a href="?topic=ans&amp;action=delete&amp;item=$row[1]">Delete</a></span></div>
</div>
BEGIN;
		
	
		
		}
	  $chicken->free($r7);
	  $chicken->free($r16);
	  $chicken->free($r17);
	}
	print "</div>\n";
		break;
		case "edit":
			if (isset ($_POST['sub'])) {
				$r21 = $chicken->edit_ans($_POST['auth'], $_POST['def'], $_POST['ans'], $_POST['cated'], $_POST['langed'], $_GET['item']);
				if ($r21 == true) {
					print "<h2>Successfully updated!</h2>\n";
				}
				else print "<h2>Failed :-( due to the following problem: ".mysql_error()."</h2>\n";
			}
		$row->who = stripslashes($row->who);
		$row->def = stripslashes($row->def);
		$row->ans = stripslashes($row->ans);
		$r13=$chicken->show_ans($_GET['item']);
		$row = mysql_fetch_object($r13);
		$item=$_GET['item'];
print <<<STARTEDIT
<div>
<h1>Edit answer</h1>
<form action="?topic=ans&amp;action=edit&amp;item=$item" method="post">
<h2>Author</h2>
<p><input type="text" name="auth" value="$row->who" /></p>
STARTEDIT;
print "<h2>Category</h2>\n<select name=\"cated\">\n";
$r14 = $chicken->show_cat();
while ($row_1 = mysql_fetch_row($r14)) {
	if ($row->cat == $row_1[1]) {
		$default=" selected ";
		}
		else {
		$default = NULL;
		}
	print "<option value=\"".$row_1[1]."\"$default>".$row_1[2]."</option>\n";
}
	  $chicken->free($r14);
print "</select>";
print "<h2>Language</h2><select name=\"langed\">\n";
$r15 = $chicken->show_lang();
while ($row_1 = mysql_fetch_row($r15)) {
	if ($row->lang == $row_1[1]) {
		$default=" selected ";
		}
		else {
		$default = NULL;
		}
	print "<option value=\"".$row_1[1]."\"$default>".$row_1[2]."</option>\n";
}
	  $chicken->free($r15);
print "</select>";
print <<<FOLLOWEDIT
	<h2>Definition</h2>
	<p><textarea cols="50" rows="5" name="def">$row->def</textarea></p>
	<h2>Answer</h2>
	<p><textarea cols="50" rows="20" name="ans">$row->ans</textarea></p>
	<input type="submit" name="sub" value="submit"/>
</form>
</div>
FOLLOWEDIT;
			
	  $chicken->free($r13);
		break;
		
		case "delete":
		$r23 = $chicken->delete_ans($_GET['item']);
		if ($r23 == true) print "<h2>Entry successfully deleted!</h2>\n";
		else print "<h2>Entry not deleted for the following reasons: ".mysql_error()."</h2>\n";
			break;
		
	}
// }}}	
	break;
	case "search":
		print "<h1>Search result</h1>\n";
		$r23 = $chicken->search_ans($_GET['q'], $_GET['where']); 
		if (! $r23) print mysql_error();
		if (mysql_num_rows($r23) == 0) {
			print "<h2>No such result</h2>\n";
		}
		else {
		$color = "#CCEEDD";
		while ($row = mysql_fetch_row($r23)) {
	$row[5] = nl2br($row[5]);	
		$auth = eregi_replace($_GET['q'],"<span style=\"background-color: #FFFFCC\">".$_GET['q']."</span>",$row[3]);
		$content = eregi_replace($_GET['q'],"<span style=\"background-color: #FFFFCC\">".$_GET['q']."</span>",$row[5]);
print <<<BEGIN
<div style="background-color: $color">
<div><span style="font-size: 120%; color: navy; font-weight: bolder">$auth</span>$def</div>
<div>$content</div>
<div><a href="?topic=ans&amp;action=edit&amp;item=$row[1]">Edit</a>
<span style="background-color: #FF0000"><a href="?topic=ans&amp;action=delete&amp;item=$row[1]">Delete</a></span></div>
</div>
BEGIN;
			if ($color == "#CCEEDD") {
				$color="#CCDDEE"; }
				else $color = "#CCEEDD";
		}
		mysql_free_result($r23);
		}
	break;
	}



?>
</div>




<div class="footer"> No copyright | Public Domain | <a href="http://selenasol.com/selena/extropia/intellectual_property.html">Information
wants to be free</a> </div>

</body>
</html>
