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
<title>PhpDig : Cleaning dictionnary</title>
<?
include "$relative_script_path/includes/style.php"
?>
</head>
<body bgcolor="white">
<h2>Cleaning dictionnary</h2>
<?
set_time_limit(3600);
print "wait...<br>";
//list of keyword's id's
$query = "SELECT key_id FROM keywords";
$id = mysql_query($query,$id_connect);
while (list($key_id) = mysql_fetch_row($id))
       {
       $query = "SELECT key_id FROM engine WHERE key_id=$key_id";
       $id_key = mysql_query($query,$id_connect);
       if (mysql_num_rows($id_key) < 1)
           {
           //if this key_id is not in engine database, delete it
           print "X ";
           $query_delete = "DELETE FROM keywords WHERE key_id=$key_id";
           $id_del = mysql_query($query_delete,$id_connect);
           $del++;
           }
       else
           print ". ";

       mysql_free_result($id_key);
       }
if ($del)
print "<br>$del keywords where not in one page at least.";
else
print "<br>All keywords are in one or more page.";
?>
<br>
<A href="index.php" target="_top">[Back]</A> to admin interface.
</body>
</html>