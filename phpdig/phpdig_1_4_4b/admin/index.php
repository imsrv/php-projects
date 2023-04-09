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
?>
<html>
</head>
<title>PhpDig : <? pmsg('admin') ?></title>
<?
include "$relative_script_path/includes/style.php";
?>
</head>
<body bgcolor="white">
<div align='center'>
<img src="../phpdiglogo.gif" width="246" height="77" alt="PhpDig <? print $phpdig_version ?>"><br>

<h3><? pmsg('index_uri') ?></h3>
<form action='spider.php' method='post'>
<input type='text' name='url' value='http://' size='64'>
<BR>
<? pmsg('spider_depth') ?> :
<select name='limit'>
<?
//select list for the depth limit of spidering
for($i = 1; $i <= $spider_max_limit; $i++)
{
print "\t<option value='$i'>$i</option>\n";
} ?>
</select>

<input type='submit' name='spider' value='Dig this !'>
</form>
</div>

<P style='background-color:#CCDDFF;'>
<?
print msg('warning')." ".msg('spider_warn');
?>
</P>
<HR>
<div align='center'>
<h3><? pmsg('site_update') ?></h3>
<FORM action="update_frame.php" >
<SELECT NAME="site_id" size='10'>
<?
//list of sites in the database
$query = "SELECT site_id,site_url,port FROM sites ORDER BY site_url";
$result_id = mysql_db_query($database,$query,$id_connect);
while (list($id,$url,$port) = mysql_fetch_row($result_id))
    {
    if ($port)
        $d_port = " (port #$port)";
    else
        $d_port = '';
    print "\t<OPTION value='$id'>$url$d_port</OPTION>\n";
    }
?>
</SELECT>
<BR>
<INPUT TYPE="submit" name="update" value="Update form" >
<INPUT TYPE="submit" name="delete" value="Delete site" >
</FORM>
<br>
<a href='cleanup_engine.php'><? print msg('clean')." ".msg('t_index'); ?></a><br>
<a href='cleanup_keywords.php'><? print msg('clean')." ".msg('t_dic'); ?></a><br>
<a href='cleanup_common.php'><? print msg('clean')." ".msg('t_stopw'); ?></a><br>
<a href='statistics.php'><? pmsg('statistics') ?></a><br>
</DIV>
</body>
</html>