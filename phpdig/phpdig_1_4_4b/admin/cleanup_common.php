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
<title>PhpDig : Cleanup common words</title>
<?
include "$relative_script_path/includes/style.php";
?>
</head>
<body bgcolor="white">
<h2>Clean common words</h2>
<?
//set the max time to an hour
set_time_limit(3600);
$numtot = 0;
$common_words = common_words("$relative_script_path/includes/common_words.txt");
while (list($common) = each($common_words))
       {
       //list of common words in the keywords table
       $query = "select key_id from keywords where keyword like '$common'";
       $res = mysql_query($query,$id_connect);
       if ($res)
       {
       while (list($key_id) = mysql_fetch_row($res))
              {
              //delete references to this keyword in the engine table
              $query = "DELETE FROM engine WHERE key_id=$key_id";
              mysql_query($query,$id_connect);
              $numdel = mysql_affected_rows($id_connect);
              print "$numdel deleted for $common ($key_id)<br>";
              $numtot += $numdel;
              }
       //delete this common word from the keywords table
       $query = "DELETE from keywords where keyword like '$common'";
       }
       mysql_query($query,$id_connect);
       }
print "<h3>Total $numtot cleaned.</h3>";
?>
<br>
<A href="index.php" target="_top">[Back]</A> to admin interface.
</body>
</html>