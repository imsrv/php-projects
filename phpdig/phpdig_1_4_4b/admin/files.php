<?
/*
--------------------------------------------------------------------------------
PhpDig 1.4.x
This program is provided under the GNU/GPL license.
See LICENSE file for more informations
All contributors are listed in the CREDITS file provided with this package

PhpDig Website : http://phpdig.toiletoine.net/
Contact email : phpdig@toiletoine.net
Author and main maintainer : Antoine Bajolet (fr) bajolet@toiletoine.net
--------------------------------------------------------------------------------
*/
$relative_script_path = '..';
include "$relative_script_path/includes/config.php";
include "$relative_script_path/libs/auth.php";
include "$relative_script_path/admin/robot_functions.php";

settype($spider_id,'integer');
settype($spider,'integer');
settype($sup,'integer');
settype($site_id,'integer');

if ($spider_id)
{
$query = "SELECT site_id,path,file FROM spider where spider_id=$spider_id";
     $result_id = mysql_query($query,$id_connect);
     if (mysql_num_rows($result_id))
         list($site_id,$path,$file) = mysql_fetch_row($result_id);

     if ($spider)
        {
         $query = "DELETE FROM tempspider WHERE site_id=$site_id";
         $result_id = mysql_query($query,$id_connect);
         $query = "INSERT INTO tempspider SET site_id=$site_id,path='$path',file='$file'";
         $result_id = mysql_query($query,$id_connect);
         header ("location:spider.php?site_id=$site_id&mode=small&spider_root_id=$spider_id");
         }
      if ($sup)
         {
         $ftp_id = phpdig_ftp_connect();
         delete_spider_reccord($database,$id_connect,$spider_id,$ftp_id);
         phpdig_ftp_close($ftp_id);
         }
}
if ($site_id)
{
$query = "SELECT site_url,port FROM sites WHERE site_id=$site_id";
$result_id = mysql_query($query,$id_connect);
list ($url,$port) = @mysql_fetch_row($result_id);
if ($port)
    $url = ereg_replace('/$',":$port/",$url);

$query = "SELECT file,spider_id FROM spider WHERE site_id=$site_id AND path like '$path' ORDER by file";
$result_id = mysql_query($query,$id_connect);
$num = mysql_num_rows($result_id);
if ($num < 1)
    mysql_free_result($result_id);

}
?>
<html>
</head>
<title><? pmsg('files') ?></title>
<? include "$relative_script_path/includes/style.php"; ?>
</head>
<body bgcolor="white">
<img src="fill.gif" width="246" height="77"><br>
<? pmsg('branch_start') ?>
<hr>
<? if (!$site_id) { ?>
<P style='background-color:#CCDDFF;'>
<? pmsg('branch_help1') ?><BR>
</P>
<? } else { ?>
<a name="AAA">
<h3><? print $num ?> pages</h3>
<P style='background-color:#CCDDFF;'>
<? pmsg('branch_help2'); ?><BR>
<B><? pmsg('warning') ?> </B><? pmsg('branch_warn') ?>
</P>
<P>
<?
$aname = "AAA";
for ($n = 0; $n<$num; $n++)
    {
    $aname2 = $spider_id;
    if ($n == 0) $aname2="AAA";
    list($file_name,$spider_id)=mysql_fetch_row($result_id);
    print "<A NAME='$aname'>\n";
    $href=$url.$path.$file_name;
    print "<A HREF='files.php?spider_id=$spider_id&sup=1#$aname2'><img src='no.gif' width='10' height='10' border='0' align='middle'></A>&nbsp;\n";
    print "<A HREF='files.php?spider_id=$spider_id&spider=1' target='_top' ><img src='yes.gif' width='10' height='10' border='0' align='middle'></A>&nbsp;\n";
    print "<A HREF='$href' target='_blank'><code>".rawurldecode($file_name)."&nbsp;</code></A><BR>\n";
    }
?>
</P>
<hr>
<? } ?>
</body>
</html>