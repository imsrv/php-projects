<?php
/*
 *  Statistics module for sendcard.
 *  Copyright Peter Bowyer <sendcard@f2s.com>, 2001.
 *  This script is released under the TrollTech QPL
 *  
 *  version 1.00
 *  
 */


include("prepend.php");

include (DOCROOT . "sendcard_setup.php");
include (DOCROOT . "include/".$dbfile);
include (DOCROOT . "include/template.inc");
include (DOCROOT . "functions.php");

$db = new DB_Sendcard;
$msg = "";

// If they are creating the statistics table, this code is executed.
if (isset($createtable)) {
$sql = "CREATE TABLE " . $tbl_name ."_stats (
  date char(20),
  image char(50),
  fontcolor char(15),
  fontface char(50),
  bgcolor char(15),
  template char(30),
  des char(30),
  music char(30),
  notify char(1),
  immediate_send char(1),
  applet_name char(30)
)";

$db->query($sql);

$sql="INSERT INTO " . $tbl_name ."_tables VALUES ('" . $tbl_name . "_stats')";
$db->query($sql);

$msg = "Table created!";
}

if($delete) {
	$db->query("DELETE from " . $tbl_name ."_stats");
	$msg = "Statistics have been reset";
}

if ($uninstall) {
	$db->query("DELETE from " . $tbl_name ."_tables WHERE tablename=" . $tbl_name ."_stats");
	$db->query("DROP TABLE " . $tbl_name ."_stats");
	$msg = "Tables removed";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>sendcard properties</title>
<script language="JavaScript">
<!--
// Nannette Thacker http://www.shiningstar.net
function confirmSubmit()
{
var agree=confirm("Are you sure you wish to continue?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
table {  border: #333333; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px}
tr { border: #333333; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px }
-->
</style>
</head>
<body bgcolor="#ffffff">
<?

$sql = "SELECT * FROM " . $tbl_name ."_tables";
$db->query($sql);

while ($db->next_record() ) {
	if ( $db->f("tablename") == $tbl_name . "_stats" ) {
		$tbl_exists = 1;
		break;
	}
		
} // End While

/************************
$db->table_names();

while ($db->next_record() ) {
	if ( $db->f("tablename") == $tbl_name . "_stats" ) {
		$tbl_exists = 1;
		break;
	}
		
} // End While
************************/
if ($tbl_exists) {


$sql = "select count(*) as count from " . $tbl_name . "_stats";
$db->query($sql);
while ($db->next_record() ) {
	$totalnumber = $db->f("count");
}


if($msg !="") {
echo("<h2 align=\"center\">$msg</h2>");
}
?>
<div align="center">Total number of cards sent: <?php echo $totalnumber;?> <br>
  <br>
</div>
<!-- Start of image stats table -->
<table width="90%" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr bgcolor="#99CC33">
    <td colspan="4">
      <div align="center">Image Files</div>
    </td>
  </tr>
  <?
$i="1";
$db->query("
     SELECT count(*) AS count,image
     FROM " . $tbl_name . "_stats
     GROUP BY image
     ORDER BY count DESC
     ");

while ($db->next_record()){

$count = $db->f("count");
$barwidth = ($count/$totalnumber) * 400;
?>
  <tr>
    <td width="20"><?php echo $i;?></td>
    <td width="20"><?php echo $count;?></td>
    <td width="300"><a href="images/<?php echo $db->f("image");?>"><?php echo $db->f("image");?></a></td>
    <td><img src="images/purple.gif" width="<?php echo $barwidth; ?>" height="20"></td>
  </tr>
  <?
     $i++;
}
?>
</table>
<!-- End of image stats table -->
<p>&nbsp;</p>
<?php
if($use_music != 0)
{
?>
<!-- Start of music stats table -->
<table width="90%" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr bgcolor="#99CC33">
    <td colspan="4">
      <div align="center">Music Files</div>
    </td>
  </tr>
  <?
$i="1";
$db->query("
     SELECT count(*) AS count,music
     FROM " . $tbl_name . "_stats
     GROUP BY music
     ORDER BY count DESC LIMIT 20
     ");

while ($db->next_record()){

$count = $db->f("count");
$barwidth = ($count/$totalnumber) * 400;
?>
  <tr>
    <td width="20"><?php echo $i;?></td>
    <td width="20"><?php echo $count;?></td>
    <td width="300"><? if($db->f("music") == ""){
echo"No Music</td>";
}else{
?> <a href="<?php echo $db->f("music");?>"><?php echo $db->f("music");?></a> <?}?> </td>
    <td><img src="images/purple.gif" width="<?php echo $barwidth; ?>" height="20"></td>
  </tr>
  <?
     $i++;
}
?>
</table>
<!-- End of music stats table -->
<p>&nbsp;</p>
<?php
}

if($use_fontface != 0)
{
?>
<!-- Start of font stats table -->
<table width="90%" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr bgcolor="#99CC33">
    <td colspan="4">
      <div align="center">Font Face</div>
    </td>
  </tr>
  <?
$i="1";
$db->query("
     SELECT count(*) AS count,fontface
     FROM " . $tbl_name . "_stats
     GROUP BY fontface
     ORDER BY count DESC LIMIT 20
     ");

while ($db->next_record()){

$count = $db->f("count");
$barwidth = ($count/$totalnumber) * 400;
?>
  <tr>
    <td width="20"><?php echo $i;?></td>
    <td width="20"><?php echo $count;?></td>
    <td width="300"><? if($db->f("fontface") == ""){
echo"Default font</td>";
}else{?>
<?php echo $db->f("fontface");?></td>
<?}?>
    <td><img src="images/purple.gif" width="<?php echo $barwidth; ?>" height="20"></td>
  </tr>
  <?
     $i++;
}
?>
</table>
<!-- End of font stats table -->
<p>&nbsp;</p>
<?php
}

if($use_fontcolor != 0)
{
?>
<!-- Start of fontcolor stats table -->
<table width="90%" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr bgcolor="#99CC33">
    <td colspan="4">
      <div align="center">Font Color</div>
    </td>
  </tr>
  <?
$i="1";
$db->query("
     SELECT count(*) AS count,fontcolor
     FROM " . $tbl_name . "_stats
     GROUP BY fontcolor
     ORDER BY count DESC LIMIT 20
     ");

while ($db->next_record()){

$count = $db->f("count");
$barwidth = ($count/$totalnumber) * 400;
?>
  <tr>
    <td width="20"><?php echo $i;?></td>
    <td width="20"><?php echo $count;?></td>
    <td width="300"><? if($db->f("fontcolor") == ""){
echo"Default font color</td>";
}else{?>
<?php echo $db->f("fontcolor");?></td>
<?}?>
    <td><img src="images/purple.gif" width="<?php echo $barwidth; ?>" height="20"></td>
  </tr>
  <?
     $i++;
}
?>
</table>
<!-- End of fontcolor stats table -->
<p>&nbsp;</p>
<?php
}

if($use_bgcolor != 0)
{
?>
<!-- Start of bgcolor stats table -->
<table width="90%" border="0" cellspacing="0" cellpadding="5" align="center">
  <tr bgcolor="#99CC33">
    <td colspan="4">
      <div align="center">Background Color</div>
    </td>
  </tr>
  <?
$i="1";
$db->query("
     SELECT count(*) AS count,bgcolor
     FROM " . $tbl_name . "_stats
     GROUP BY bgcolor
     ORDER BY count DESC LIMIT 20
     ");

while ($db->next_record()){

$count = $db->f("count");
$barwidth = ($count/$totalnumber) * 400;
?>
  <tr>
    <td width="20"><?php echo $i;?></td>
    <td width="20"><?php echo $count;?></td>
    <td width="300"><? if($db->f("bgcolor") == ""){
echo"Default font</td>";
}else{?>
<?php echo $db->f("bgcolor");?></td>
<?}?>
    <td><img src="images/purple.gif" width="<?php echo $barwidth; ?>" height="20"></td>
  </tr>
  <?
     $i++;
}
?>
</table>
<!-- End of bg color stats table -->
<?php
}
?>
<div align="center"> 
  <p><a onClick="return confirmSubmit()" href="mod_stats.php?delete=1">Reset the 
	statistics</a></p>
<?php
} // End if $tbl_exists
?>
  <p>To install:<br>
	<a href="mod_stats.php?createtable=1">Create the statistics table</a><br>
	<a href="mod_plugins.php">Install the stats_plugin</a><br>
     <a href="mod_properties.php">Tell sendcard you have created the table for the stats module</a></p>
<p>To uninstall:<br>
	<a href="mod_stats.php?uninstall=1">Remove the statistics table</a><br>
</div>
</body>
</html>
