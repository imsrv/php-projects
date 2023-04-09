<?
// mcNews 1.3 Marc Cagninacci marc@phpforums.net
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Install mcNews</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
a:actif {  font-family: Verdana, Arial; color:gray; text-decoration: none}
a:link {  font-family: Verdana, Arial; color: gray; text-decoration: none}
a:visited {  font-family: verdana, Arial; color: gray; text-decoration: none}
a:hover {  font-family: Verdana, Arial; color: #333333; text-decoration: none}
-->
</style>
</head>

<body bgcolor="#cococo" text="black">

<?
include ("../conf.inc.php");
   $connect= mysql_connect($host,$login,$pass);
   mysql_select_db($base,$connect);
   $result = mysql_list_tables ($base);
  $i = 0;
  while ($i < mysql_num_rows($result)) {
    $tb_names[$i] = mysql_tablename ($result, $i);
    if ($tb_names[$i]=="mcnews_design") $table=1;
    $i++;
  }

   if ($table==1)
   {
   include($l);
    echo  '<a href="index.php">'.$lGoAdmin.'</a>';
   }
   else {
if ($c==1)
{
$connect= mysql_connect($host,$login,$pass);
 mysql_select_db($base,$connect);

$sql="DROP TABLE IF EXISTS mcnews_news;";
 mysql_query($sql,$connect);
$sql="CREATE TABLE mcnews_news (
  id int(4) NOT NULL auto_increment,
  date date NOT NULL default '0000-00-00',
  titre varchar(35) NOT NULL default '',
  auteur varchar(30) NOT NULL default '',
  site varchar(50) NOT NULL default '',
  email varchar(50) NOT NULL default '',
  texte longtext NOT NULL,
  lien1 varchar(50) NOT NULL default '',
  descr1 varchar(20) NOT NULL default '',
  lien2 varchar(50) NOT NULL default '',
  descr2 varchar(20) NOT NULL default '',
  lien3 varchar(50) NOT NULL default '',
  descr3 varchar(20) NOT NULL default '',
  valid char(1) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=MyISAM;";
mysql_query($sql,$connect);

$sql="DROP TABLE IF EXISTS mcnews_comment;";
mysql_query($sql,$connect);
$sql="CREATE TABLE mcnews_comment (
  id int(4) NOT NULL auto_increment,
  idnews int(4) NOT NULL default '0',
  date date NOT NULL default '0000-00-00',
  auteur varchar(30) NOT NULL default '',
  site varchar(50) NOT NULL default '',
  email varchar(50) NOT NULL default '',
  texte longtext NOT NULL,
  lien1 varchar(50) NOT NULL default '',
  descr1 varchar(20) NOT NULL default '',
  lien2 varchar(50) NOT NULL default '',
  descr2 varchar(20) NOT NULL default '',
  lien3 varchar(50) NOT NULL default '',
  descr3 varchar(20) NOT NULL default '',
  valid char(1) NOT NULL default '',
  KEY id (id)
) TYPE=MyISAM;";

mysql_query($sql,$connect);

$sql="DROP TABLE IF EXISTS mcnews_design;";
mysql_query($sql,$connect);
$sql="CREATE TABLE mcnews_design (
  id int(2) NOT NULL auto_increment,
  skin varchar(20) NOT NULL default '',
  lang varchar(20) NOT NULL default '',
  nbnews int(3) NOT NULL default '0',
  nbliste int(3) NOT NULL default '0',
  emailadmin varchar(50) NOT NULL default '',
  nomadmin varchar(30) NOT NULL default '',
  urlsite varchar(50) NOT NULL default '',
  valnews smallint(1) NOT NULL default '1',
  valcom smallint(1) NOT NULL default '1',
  KEY id (id)
) TYPE=MyISAM;";
mysql_query($sql,$connect);

$sql="INSERT INTO mcnews_design VALUES (1,'skin/mcNews.php','$l','','','','','','','')";

mysql_query($sql,$connect);
include ($l);
echo '<center><br><br><br><br><br><br><br><font face="verdana" size="2">';
$result = mysql_list_tables ($base);
  $i = 0;
  while ($i < mysql_num_rows($result)) {
    $tb_names[$i] = mysql_tablename ($result, $i);
    if (($tb_names[$i]=="mcnews_news")||($tb_names[$i]=="mcnews_comment")||($tb_names[$i]=="mcnews_design"))  echo $tb_names[$i].': OK<br>';
    $i++;
  }

echo '<br>'.$lTablesOk.' <br><br><a href="index.php">'.$lGoAdmin.'</a>';
echo '</font></center>';
}
else
{
  if (!$l)
   {
   echo '<center><br><br><br><br><br><br><br><br><br><br><font size="2">';

         $aryLangs = array();
         $dirCurrent = dir(lang);
         while($strFile=$dirCurrent->read()) {
           if (is_file('lang/'.$strFile)) {
             $aryLangs[] = 'lang/'.$strFile;
           }
         }
         $dirCurrent->close();

         if (count($aryLangs) > 1) { sort ($aryLangs); }

         $file = current($aryLangs);
         while ($file) {
           if($file!="lang/blank.php"){
             $intStartLang = strpos($file, '/') + 1;
             $intLengthLang = strrpos($file, '.') - $intStartLang;
             $text=ucwords(substr($file,$intStartLang,$intLengthLang));
             echo '<a href="install.php?l='.$file.'">'.$text.'</a><br>';
           }
           $file = next($aryLangs);
         }
         echo '</font></center>';
  }
  else
{

include ($l);
echo '<p align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#000000"><b>'.$lAccueil.'</b></font></p><hr>';
echo '<p align="right"><font face="verdana" size="2">';
@$connect= mysql_connect($host,$login,$pass);
  if (!$connect)
  {
  echo $lConHost.' <b>'.$host.'</b> '.$lImpossible;
  }
  else
  {
  echo $lConHost.' <b>'.$host.'</b>: '.$lOk.'<br>';

  @$result = mysql_select_db($base,$connect);
   if(!$result)
   {
   echo $lConBase.' <b>'.$base.'</b> '.$lImpossible;
   }
   else
   {
   echo $lConBase.' <b>'.$base.'</b>: '.$lOk;
   }
  }
echo '</font></p>';

         if(($connect)&&($result))
         {
?>
<br><br>
<p align="center"><font face="verdana" size="2"><? echo $lCreTables; ?> :</font></p>
<div align="center">
<ul>
<li><font face="verdana" size="2"><b>mcnews_comment</b></font></li>
<li><font face="verdana" size="2"><b>mcnews_design</b></font></li>
<li><font face="verdana" size="2"><b>mcnews_news</b></font></li>
</ul>
</div>
<p align="center"><font face="verdana" size="2"><? echo $lDropTables; ?></font></p>
<p align="center"><font face="verdana" size="2"><a href="install.php?c=1&amp;l=<? echo $l; ?>"><b><? echo $lOk; ?></b></a></font></p>

<?
         }
}
}
}
?>
</body></html>
