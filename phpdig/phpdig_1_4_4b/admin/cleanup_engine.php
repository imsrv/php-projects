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
?><html>
</head>
<title>PhpDig : Cleaning index</title>
<?
include "$relative_script_path/includes/style.php";
?>
</head>
<body bgcolor="white">
<h2>Cleaning index</h2>
<?
set_time_limit(3600);
print "wait...<br>";
//list of key_id's in engine table
$query = "SELECT key_id FROM engine GROUP BY key_id";
$id = mysql_query($query,$id_connect);
while (list($key_id) = mysql_fetch_row($id))
       {
       //search this id in the keywords table
       $query = "SELECT key_id FROM keywords WHERE key_id=$key_id";
       $id_key = mysql_query($query,$id_connect);
       if (mysql_num_rows($id_key) < 1)
           {
           //if non-existent, delete this useless id from the engine table
           $del ++;
           print "X ";
           $query_delete = "DELETE FROM engine WHERE key_id=$key_id";
           $id_del = mysql_query($query_delete,$id_connect);
           }
       else
           print ". ";
              mysql_free_result($id_key);
       }

//list of spider_id from engine table
$query = "SELECT spider_id FROM engine GROUP BY spider_id";
$id = mysql_query($query,$id_connect);
while (list($spider_id) = mysql_fetch_row($id))
       {
       $query = "SELECT spider_id FROM spider WHERE spider_id=$spider_id";
       $id_spider = mysql_query($query,$id_connect);
       if (mysql_num_rows($id_spider) < 1)
           {
           //if no-existent in the spider page, delete from engine
           $del ++;
           print "X ";
           $query_delete = "DELETE FROM engine WHERE spider_id=$spider_id";
           $id_del = mysql_query($query_delete,$id_connect);
           }
       else
           print "- ";
              mysql_free_result($id_spider);
       }

if ($del)
print "<br>$del index references targeted an inexistent keyword.";
else
print "<br>Engine is coherent.";
?>
<br>
<A href="index.php" target="_top">[Back]</A> to admin interface.
</body>
</html>