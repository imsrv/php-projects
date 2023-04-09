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
settype($delete,'string');

if ($delete)
    {
    settype($site_id,'integer');
    $query = "SELECT spider_id FROM spider WHERE site_id=$site_id";
    $result_id = mysql_query($query,$id_connect);

    if (mysql_num_rows($result_id) > 0)
        {
        $in = "IN (0";
        $ftp_id = phpdig_ftp_connect();
        while (list($spider_id) = mysql_fetch_row($result_id))
               {
               delete_text_content($relative_script_path,$spider_id,$ftp_id);
               $in .= ",$spider_id";
               }
        phpdig_ftp_close($ftp_id);
        $in .= ")";
        $query = "DELETE FROM engine WHERE spider_id $in";
        $result_id = mysql_query($query,$id_connect);

        $query = "DELETE FROM spider WHERE site_id=$site_id";
        $result_id = mysql_query($query,$id_connect);

        }

    $query = "DELETE FROM sites WHERE site_id=$site_id";
    $result_id = mysql_query($query,$id_connect);

    header ("location:index.php");
    }
if (!$site_id)
      header ("location:index.php");
?>
<html>
<head>
</head>
<FRAMESET COLS="50%,50%" BORDER="0" FRAMESPACING="0">
<FRAME SRC="update.php?site_id=<? print $site_id ?>" NAME="tree" NORESIZE frameborder="NO">
<FRAME SRC="files.php" NAME="files" RESIZE frameborder="NO">
</FRAMESET>
<noframes>
</noframes>
</html>