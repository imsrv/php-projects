<p><small><font face="Arial"><script language="php">
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
$link_vars = EchoLinkVars();
$query = "Select DISTINCT varietal from $table order by varietal";
$select = mysql($database,$query);
$row=0;
$rows=mysql_numrows($select);</script></font></small></p>
<div align="center"><center>

<table border="0" width="90%" cellpadding="3" cellspacing="0">
  <tr>
    <td width="455" colspan="2" bgcolor="<? print($hdr2_bgcolor)?>"><small><font face="Arial">List of Varietals:
    Click on a varietal to view products available.</font></small></td>
  </tr>
  <tr>
    <td width="50%" bgcolor="<? print($bdy2_bgcolor)?>"><font face="Arial" size="2"><script language="php">while($row<($rows/2)){
	$varietal = mysql_result($select,$row,"varietal");
	$varietal_link = urlencode($varietal);
	echo "<a href='$SCRIPT_NAME?$link_vars&action=View&varietal=$varietal_link'>$varietal</a><br>\n";
	$row++;
}
</script>
    </font></td>
    <td width="50%" bgcolor="<? print($bdy2_bgcolor)?>"><font face="Arial" size="2"><script language="php">while($row<$rows){
	$varietal = mysql_result($select,$row,"varietal");
	$varietal_link = urlencode($varietal);
	echo "<a href='$SCRIPT_NAME?$link_vars&action=View&varietal=$varietal_link'>$varietal</a><br>\n";
	$row++;
}</script>
    </font></td>
  </tr>
</table>
</center>
</div>
