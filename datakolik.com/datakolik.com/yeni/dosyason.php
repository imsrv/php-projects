    <th width="633" align="left" valign="top" nowrap="nowrap" bordercolor="#FF0000" bgcolor="#FF0000">Dosya Adý</th>
    <td width="153">&nbsp;</td>
  </tr>
<?php

//SQL Baðlantýsý
if ( !@mysql_connect('localhost', 'turk1ddl_berk', 'derbeder') ) die(mysql_error());
if ( !@mysql_select_db('turk1ddl_portal') ) die(mysql_error());

$result = mysql_query('SELECT * FROM `dosyalar` ORDER BY `sayac` DESC');
while ( $row = mysql_fetch_assoc($result) ) echo '  <tr>
    <td><a href="dosyaindir.php?id=' . $row['id'] . '">' . $row['adi'] . '</a></td>
    <td width="200">' . $row['indirme'] . '</td>
  </tr>';

?>
</table>