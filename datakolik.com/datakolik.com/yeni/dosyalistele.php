<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Dosya Adý</td>
    <td width="120">Ýndirme</td>
  </tr>
<?php

//SQL Baðlantýsý
if ( !@mysql_connect('localhost', 'turk1ddl_berk', 'derbeder') ) die(mysql_error());
if ( !@mysql_select_db('turk1ddl_portal') ) die(mysql_error());

$result = mysql_query('SELECT * FROM `dosyalar` ORDER BY `sayac` DESC');
while ( $row = mysql_fetch_assoc($result) ) echo '  <tr>
    <td><a href="dosyaindir.php?id=' . $row['id'] . '">' . $row['adi'] . '</a></td>
    <td width="120">' . $row['indirme'] . '</td> bu $row['sayac']
  </tr>';

?>
</table>