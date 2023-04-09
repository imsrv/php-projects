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
 if($_SESSION['auth'] && $_SESSION['level']==200 && $_SESSION['progcode']=='squitogallery')
                        {


    $obj = new Photo();
    $obj->set_db($db_host,$db_user,$db_pass,$database,'photodir');
    
if(isset($_POST['subUpdate']))
{
$query = 'update prefs set default_uploads="'.$_POST['default_uploads'].'", voting="'.$_POST['voting'].'", anonymous_comments = "'.$_POST['anonymous_comments'].'", per_col = "'.$_POST['form_per_col'].'", per_row = "'.$_POST['form_per_row'].'", photo_per_col = "'.$_POST['form_photo_per_col'].'", photo_per_row = "'.$_POST['form_photo_per_row'].'" where id = "1"';
//echo $query;
$obj->query($query);
mysql_close();
}
    $obj->get_default_uploads();
    $obj->set_display(3,0,$webimageroot,$images,$thumbnails,$photoroot);

 	$myrow = $obj->get_defaults();
	echo '<form method="post" action=""><table><tr><td>';
	echo 'Columns of Albums </td><td><select name="form_per_col">'."\n";
	for($x=1; $x<15; $x++)
	{
	  echo '<option value="'.$x.'"';
	  if($x == $myrow['per_col']) echo ' selected';
	  echo '>'.$x.'</option>'."\n";
	}
	echo '</select></td></tr><tR><td>';
	echo ' Rows of Albums </td><td><select name="form_per_row">'."\n";
	for($x=1; $x<15; $x++)
	{
	  echo '<option value="'.$x.'"';
	  if($x == $myrow['per_row']) echo ' selected';
	  echo '>'.$x.'</option>'."\n";
	}
	echo '</select></td></tr><tR><td>';
	echo ' Columns of Photos </td><td><select name="form_photo_per_col">'."\n";
	for($x=1; $x<15; $x++)
	{
	  echo '<option value="'.$x.'"';
	  if($x == $myrow['photo_per_col']) echo ' selected';
	  echo '>'.$x.'</option>'."\n";
	}
	echo '</select></td></tr><tR><td>';
	echo ' Rows of Photos </td><td><select name="form_photo_per_row">'."\n";
	for($x=1; $x<15; $x++)
	{
	  echo '<option value="'.$x.'"';
	  if($x == $myrow['photo_per_row']) echo ' selected';
	  echo '>'.$x.'</option>'."\n";
	}
	echo '</select></td></tr><tR><td>';
	echo  'Allow anonymous comments? </td><td><select name="anonymous_comments"><option value="1" ';
	if($myrow['anonymous_comments']) echo 'selected';
	echo '>Yes</option>';
	echo '<option value="0" ';
	if(!$myrow['anonymous_comments']) echo 'selected';
	echo '>No</option></select></td></tr><tR><td>';
	echo  'Allow voting? </td><td><select name="voting"><option value="1" ';
	if($myrow['voting']) echo 'selected';
	echo '>Yes</option>';
	echo '<option value="0" ';
	if(!$myrow['voting']) echo 'selected';
	echo '>No</option></select></td></tr><tR><td colspan="2">';	
		echo 'Default Upload Album ';
	echo '<select name="default_uploads">';
	echo $obj->get_ancester_droplist_prefs(0);
	echo '</select>';
	echo '<br><input type="submit" name="subUpdate" value="Save"></td></tr></table>'."\n";
echo '</form>';
/*echo '<form name="delq" action="" method="post">';
$query = 'select question,id from fileinfo_q order by id asc';
$result = $obj->query($query);
echo '<table>';
while($myrow = mysql_fetch_array($result))
{
echo '<tr><td>'.$myrow['question'].'<input type="hidden" name="delete_q" value="0"><input type="hidden" name="q_id" value="'.$myrow['id'].'"></td><td><a href="" onclick="delq.delete_q.value=\'1\'; delq.submit(); return false;">Delete</a> | <a href="admin.php?menu=fileinfo_q&q_id='.$myrow['id'].'">Edit</a> </td></tr>'."\n";
}
echo '</table></form>';*/
	}
?>