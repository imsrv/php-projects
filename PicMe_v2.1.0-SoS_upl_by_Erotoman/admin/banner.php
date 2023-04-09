<?php
/*
#
#	$Id: BANNER.PHP
#	Version 2.0.0
#
*/
session_start();
include "top.inc.php";
include "../settings.php";
include "../functions.php";
include "main.php";
?>
<br><br>
<TABLE width="100%" align=center bgColor=#3366CC border=0>
  <TBODY>
  <TR>
    <TD class="link" width="200"><? echo (date("M d, Y")); ?></TD>
    <TD class="head" align="center"><? echo "$sitename"; ?> :: Banner Admin Section </TD>
    <TD class="link" width="200" align="right"><a href="<? echo"$PHP_SELF" ?>" class="link">[ Main ]</a>
    <a href="<? echo "$PHP_SELF" ?>?banners=view" class="link">[ Banners ] </a>
    <a href="<? echo "$PHP_SELF" ?>?add=banner" class="link">[ Add ] </a>
    <a href="<? echo "$PHP_SELF" ?>?stats=view" class="link">[ Stats ]</a></TD>
  </TR></TBODY></TABLE><BR>
    <?
  if ($stats) {
  ?>
  <div align="center" class="link">
<?
$resulta = mysql_query("SELECT SUM(hits) as hit_totals FROM banimp");
$totalsa = mysql_fetch_array($resulta);
$hits = $totalsa["hit_totals"];
$resultb = mysql_query("SELECT SUM(clicks) as click_totals FROM banclk");
$totalsb = mysql_fetch_array($resultb);
$clicks = $totalsb["click_totals"];
if ($hits == 0) {
}
else {
$per = (($clicks/$hits)*100);
$per = round($per, 2);
}
?>
Total Banner Impressions todate : <? echo"$hits"; ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Total Banner Clicks todate : <? echo"$clicks"; ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Click through percentage : <? echo"$per"; ?> %
</div>
<p>
<table valign="top" width="100%" class="list">
<tr><td width="24">id</td>
<td width="468">
Banner Details</td>
<td width="60">Imp</td>
<td width="60">Clks</td>
<td width="60">Percent</td>
<td width="60">% Imp of Tot</td>
</tr>
<?php
$result = mysql_query("SELECT ban.*, clk.clicks, imp.hits FROM banners ban, banclk clk, banimp imp WHERE Active = '1' AND Visible = '1' AND ban.id = imp.bannerid AND ban.id = clk.bannerid");
$list = mysql_num_rows($result);
while ($i < $list) {
$row = mysql_fetch_array($result);
$id = $row["id"];
$name = $row["name"];
$det = $row["details"];
$imgage = $row["img"];
$height = $row["height"];
$width = $row["width"];
$bps = $row["bps"];
$alt = $row["details"];
$url = $row["url"];
$hit = $row["hits"];
$clk = $row["clicks"];
$perc = (($clk/$hit)*100);
$perc = round($perc, 2);
$over = (($hit/$hits)*100);
$over = round($over, 2);
if ($bps!='no') {
echo"<tr><td>$id</td>";
echo"<td width=\"468\">$name - $det<br><img src=\"$imgage\" height=\"$height\" width=\"$width\"></td>";
echo"<td>$hit</td>";
echo"<td>$clk</td>";
echo"<td>$perc %</td>";
echo"<td>$over</td></tr>";
$i++;
}
else {
echo"<tr><td>$id</td>";
echo"<td width=\"468\">$name - $det<br><img src=\"$imgloc$imgage\" height=\"$height\" width=\"$width\"></td>";
echo"<td>$hit</td>";
echo"<td>$clk</td>";
echo"<td>$perc %</td>";
echo"<td>$over</td></tr>";
$i++;
}
}
?>
</table>
<?
}

elseif($add)   {
?>
 <div align="center" class="details">
Add New Banner
</div>
<p>
<form method="post" action="<?php echo $PHP_SELF?>">
<table width="75%" align="center" valign="top" class="details">
<input type=hidden name="id" value="<?php echo $id ?>">
<tr><td valign="top">Name :</td><td width="50%"><input type="text" name="name" value="<?php echo $name ?>"><div class="link">Used in alt tag</div></td></tr>
<tr><td valign="top">Details :</td><td width="50%"><input type="text" name="details" value="<?php echo $details ?>"></td></tr>
<tr><td valign="top">Image :</td><td width="50%"><input type="text" name="img" value="<?php echo $img ?>"><div class="link">If using banner scheme will need location of full URL if image</div></td></tr>
<tr><td valign="top">Banner Scheme :</td><td width="50%"><input type="text" name="bps" value="no"><div class="link">no if own banner/blank if agency ie doubleclick</div></td></tr>
<tr><td valign="top">Width :</td><td width="50%"><input type="text" name="width" value="468"></td></tr>
<tr><td valign="top">Height :</td><td width="50%"><input type="text" name="height" value="60"></td></tr>
<tr><td valign="top">Level :</td><td width="50%"><input type="text" name="level" value="1"><div class="link">Use levels to vary banner styles: Level 1 468x60, Level 2 Boxed Banners Width 100, Hight ???</div></td></tr>
<tr><td valign="top">URL :</td><td width="50%"><input type="text" name="url" value="<?php echo $url ?>"><div class="link">If left blank no URL link and clicks not recorded</div></td></tr>
<tr><td></td><td width="50%"><input type="submit" name="submit" value="submit">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value="reset"></td></tr>
</table>
</form>
<?
}

elseif ($submit) {
  $sql = "INSERT INTO banners (name,details,img,bps,width,height,url,level,active,visible) VALUES ('$name','$details','$img','$bps','$width','$height','$url','$level','1','1')";
   // run SQL against the DB
  $result = mysql_query($sql);
  $result = mysql_query("SELECT * FROM banners ORDER BY ID DESC LIMIT 1");
  $row = mysql_fetch_array($result);
  $id = $row["id"];

  $sqla ="INSERT INTO banimp (bannerid,hits) VALUES ('$id','1')";
  $resulta = mysql_query($sqla);

  $sqlb ="INSERT INTO banclk (bannerid,clicks) VALUES ('$id','1')";
  $resultb = mysql_query($sqlb);

  echo "<div align=\"center\" class=\"details\"> Record submitted</div><p>";
  ?>
<table width="75%" align="center" valign="top" class="details">
<input type=hidden name="id" value="<?php echo $id ?>">
<tr><td width="50%">Name :</td><td width="50%"><input type="text" name="name" value="<?php echo $name ?>"></td></tr>
<tr><td width="50%">Details :</td><td width="50%"><input type="text" name="details" value="<?php echo $details ?>"></td></tr>
<tr><td width="50%">Image :</td><td width="50%"><input type="text" name="img" value="<?php echo $img ?>"></td></tr>
<tr><td width="50%">Banner Scheme :</td><td width="50%"><input type="text" name="bps" value="<?php echo $bps ?>"></td></tr>
<tr><td width="50%">Width :</td><td width="50%"><input type="text" name="width" value="<?php echo $width ?>"></td></tr>
<tr><td width="50%">Height :</td><td width="50%"><input type="text" name="height" value="<?php echo $height ?>"></td></tr>
<tr><td width="50%">Level :</td><td width="50%"><input type="text" name="level" value="<?php echo $level ?>"></td></tr>
<tr><td width="50%">URL :<br><br><br></td><td width="50%"><input type="text" name="url" value="<?php echo $url ?>"><br><br><br></td></tr>
</table>
<?
  }

elseif ($modify) {
  $result = mysql_query("SELECT * FROM banners WHERE id='$id'");
  $row = mysql_fetch_array($result);
  $id = $row["id"];
  $name = $row["name"];
  $details = $row["details"];
  $bps = $row["bps"];
  $img = $row["img"];
  $height = $row["height"];
  $width = $row["width"];
  $alt = $row["details"];
  $level = $row["level"];
  $url = $row["url"];
?>
<div align="center" class="details">
Modify Banner
</div>
<p>
<form method="post" action="<?php echo $PHP_SELF?>">
<table width="75%" align="center" valign="top" class="details">
<input type=hidden name="id" value="<?php echo $id ?>">
<tr><td width="50%">Name :</td><td width="50%"><input type="text" name="name" value="<?php echo $name ?>"></td></tr>
<tr><td width="50%">Details :</td><td width="50%"><input type="text" name="details" value="<?php echo $details ?>"></td></tr>
<tr><td width="50%">Image :</td><td width="50%"><input type="text" name="img" value="<?php echo $img ?>"></td></tr>
<tr><td width="50%">Banner Scheme :</td><td width="50%"><input type="text" name="bps" value="<?php echo $bps ?>"></td></tr>
<tr><td width="50%">Width :</td><td width="50%"><input type="text" name="width" value="<?php echo $width ?>"></td></tr>
<tr><td width="50%">Height :</td><td width="50%"><input type="text" name="height" value="<?php echo $height ?>"></td></tr>
<tr><td width="50%">Level :</td><td width="50%"><input type="text" name="level" value="<?php echo $level ?>"></td></tr>
<tr><td width="50%">URL :<br><br><br></td><td width="50%"><input type="text" name="url" value="<?php echo $url ?>"><br><br><br></td></tr>
<tr><td width="50%"></td><td width="50%"><input type="submit" name="update" value="update">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>
</table>
</form>
<?
}

elseif ($update) {
    echo "<div align=\"center\" class=\"details\"> Record modified</div><p>";
?>
<table width="75%" align="center" valign="top" class="details">
<input type=hidden name="id" value="<?php echo $id ?>">
<tr><td width="50%">Name :</td><td width="50%"><input type="text" name="name" value="<?php echo $name ?>"></td></tr>
<tr><td width="50%">Details :</td><td width="50%"><input type="text" name="details" value="<?php echo $details ?>"></td></tr>
<tr><td width="50%">Image :</td><td width="50%"><input type="text" name="img" value="<?php echo $img ?>"></td></tr>
<tr><td width="50%">Banner Scheme :</td><td width="50%"><input type="text" name="bps" value="<?php echo $bps ?>"></td></tr>
<tr><td width="50%">Width :</td><td width="50%"><input type="text" name="width" value="<?php echo $width ?>"></td></tr>
<tr><td width="50%">Height :</td><td width="50%"><input type="text" name="height" value="<?php echo $height ?>"></td></tr>
<tr><td width="50%">Level :</td><td width="50%"><input type="text" name="level" value="<?php echo $level ?>"></td></tr>
<tr><td width="50%">URL :<br><br><br></td><td width="50%"><input type="text" name="url" value="<?php echo $url ?>"><br><br><br></td></tr>
</table>
<p>
<?
$sqlx = "UPDATE banners SET name='$name',details='$details',img='$img',bps='$bps',width='$width',height='$height',url='$url',level='$level' WHERE id=$id";
   // run SQL against the DB
$resultx = mysql_query($sqlx);
}

elseif ($banners) {
?>
<table valign="top" width="100%" class="list">
<tr><td width="24">id</td>
<td width="468">
Banner Details</td>
<td width="60">Added</td>
<td width="60">Level</td>
<td width="30">Live</td>
<td width="30"></td>
<td width="30"></td>
<td width="30"></td>
</tr>
<?
$result = mysql_query("SELECT id, name, details, img, bps, height, width, level, Active, DATE_FORMAT(datecreate, '%d %m %Y') as datecreate FROM banners WHERE Visible = '1'");
$list = mysql_num_rows($result);
while ($i < $list) {
$row = mysql_fetch_array($result);
$id = $row["id"];
$name = $row["name"];
$det = $row["details"];
$image = $row["img"];
$height = $row["height"];
$width = $row["width"];
$alt = $row["details"];
$date = $row["datecreate"];
$level = $row["level"];
$bps = $row["bps"];
$act = $row["Active"];
if ($bps!='no') {
echo"<tr><td>$id</td>";
echo"<td width=\"468\">$name - $det<br><img src=\"$image\" height=\"$height\" width=\"$width\"></td>";
echo"<td>$date</td>";
echo"<td>level $level</td>";
if ($act=='1') {
echo"<td>Yes</td>";
echo"<td><a href=\"$PHP_SELF?active=2&id=$id\">No</a></td>";
}
else {
echo"<td><a href=\"$PHP_SELF?active=1&id=$id\">Yes</a></td>";
echo"<td>No</td>";
}
echo"<td><a href=\"$PHP_SELF?id=$id&modify=yes\">[MOD]</a></td>";
echo"<td><a href=\"$PHP_SELF?id=$id&delete=yes\">[DEL]</a></td>";
echo"</tr>";
$i++;
}
else {
echo"<tr><td>$id</td>";
echo"<td width=\"468\">$name - $det<br><img src=\"$imgloc$image\" height=\"$height\" width=\"$width\"></td>";
echo"<td>$date</td>";
echo"<td>level $level</td>";
if ($act=='1') {
echo"<td>Yes</td>";
echo"<td><a href=\"$PHP_SELF?active=2&id=$id\">No</a></td>";
}
else {
echo"<td><a href=\"$PHP_SELF?active=1&id=$id\">Yes</a></td>";
echo"<td>No</td>";
}
echo"<td><a href=\"$PHP_SELF?id=$id&modify=yes\">[MOD]</a></td>";
echo"<td><a href=\"$PHP_SELF?id=$id&delete=yes\">[DEL]</a></td>";
echo"</tr>";
$i++;
}
}
?>
</table>
<?
}
elseif ($active) {
mysql_query("UPDATE banners SET Active='$active' WHERE id='$id'");
?>
  <BR><BR><BR><br><br><br>
  <div align="center" class="head">
  Banner activity level changed !!
  </div>
    <BR><BR><BR><br><br><br>
    <?
}

elseif ($delete) {
mysql_query("UPDATE banners SET Visible='0' WHERE id='$id'");
?>
  <BR><BR><BR><br><br><br>
  <div align="center" class="head">
  Banner deleted !!
  </div>          <br>
   <div align="center" class="list">
  Although currently visibility set to off, figures for this banner still included in stats todate.  </div>
    <BR><BR><BR><br><br><br>
 <?
 }
else {
?>
<BR><BR><BR><BR><BR><BR>
<?
$resultc = mysql_query("SELECT * FROM banners WHERE Active='1' AND Visible='1'");
$num_rows = mysql_num_rows($resultc);
$resulta = mysql_query("SELECT SUM(hits) as hit_totals FROM banimp");
$totalsa = mysql_fetch_array($resulta);
$hits = $totalsa["hit_totals"];
$resultb = mysql_query("SELECT SUM(clicks) as click_totals FROM banclk");
$totalsb = mysql_fetch_array($resultb);
$clicks = $totalsb["click_totals"];
if ($num_rows == 0) {
}
else {
$per = (($clicks/$hits)*100);
$per = round($per, 2);
}
?>
<DIV class=details align=center>
  <TABLE width="60%">
    <TBODY>
    <TR>
      <TD>Current Live Banners</TD>
      <TD><? echo"$num_rows"; ?></TD>
    </TR>
    <TR>
      <TD>&nbsp;</TD>
      <TD>&nbsp;</TD>
    </TR>
    <TR>
      <TD>Banner Impressions todate</TD>
      <TD><? echo"$hits"; ?></TD>
    </TR>
    <TR>
      <TD>Banner Clicks todate</TD>
      <TD><? echo"$clicks"; ?> </TD>
    </TR>
    <TR>
      <TD>&nbsp;</TD>
      <TD>&nbsp;</TD>
    </TR>
    <TR>
      <TD>% click through</TD>
      <TD><? echo"$per"; ?> %</TD>
    </TR>
    </TBODY>
  </TABLE>
  <BR><BR><BR><br><br><br>
  <?
  }
  ?>
  <br>
  <TABLE width="100%" align=center bgColor=#3366CC border=0>
    <TBODY>
    <TR>
      <TD align=right></TD>
    </TR></TBODY></TABLE></DIV></BODY></HTML>