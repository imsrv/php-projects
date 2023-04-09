<style type="text/css">
<!--
a {
	font-family: Arial, Helvetica, sans-serif;
}
-->
</style><?php

//SQL Baðlantýsý
if ( !@mysql_connect('localhost', 'turk1ddl_berk', 'derbeder') ) die(mysql_error());
if ( !@mysql_select_db('turk1ddl_portal') ) die(mysql_error());

echo '<ol>';
$result = mysql_query('SELECT `id`, `baslik` FROM `dokumanlar` ORDER BY `id` DESC LIMIT 50');
while ( $row = mysql_fetch_assoc($result) ) echo '<li><a href="dokuman.php?id=' . $row['id'] . '">' . $row['baslik'] . '</a></li>';
echo '</ol>';

?>