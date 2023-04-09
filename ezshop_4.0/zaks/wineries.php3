<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
$link_vars = EchoLinkVars();
// Find total number of records
$query = "Select DISTINCT winery FROM $table";
$select = mysql($database,$query);
my_error(mysql_error());
$numrows = mysql_numrows($select);
my_error(mysql_error());

// Set limit to display XX records per page
if(!isset($limit)){
	$limit=($numrows/2);
}

if(!isset($offset)){
	$offset = 0;
}

$query = "Select DISTINCT winery from $table order by winery limit $offset,$limit";
$select = mysql($database,$query);
$row=0;
$rows=mysql_numrows($select);
?>
<center>
<table border="0" width="90%" cellpadding="3" cellspacing="0" align="center">
  <tr>
    <td width="455" colspan="2" bgcolor="<? print($hdr2_bgcolor)?>"><small><font face="Arial">List of Wineries.
    Click on a winery name to view products available.</font></small></td>
  </tr>
  <tr>
    <td width="50%" bgcolor="<? print($bdy2_bgcolor)?>"><font face="Arial" size="2"><script language="php">while($row<($rows/2)){
	$winery = mysql_result($select,$row,"winery");
	$winery_link = urlencode($winery);
	echo "<a href='$SCRIPT_NAME?$link_vars&action=View&winery=$winery_link'>$winery</a><br>\n";
	$row++;
}
</script>
    </font></td>
    <td width="50%" bgcolor="<? print($bdy2_bgcolor)?>"><font face="Arial" size="2"><script language="php">while($row<$rows){
	$winery = mysql_result($select,$row,"winery");
	$winery_link = urlencode($winery);
	echo "<a href='$SCRIPT_NAME?$link_vars&action=View&winery=$winery_link'>$winery</a><br>\n";
	$row++;
}
</script>
    </font></td>
  </tr>
</table>

<table border="0" width="462" cellspacing="0" cellpadding="0" height="52">
  <tr>
    <th width="154" valign="middle" height="50"><small><font face="Arial"><script
    language="php">echo "<form method='POST'>\n";
$back = $offset-$limit;
$forth = $offset+$limit;
if($offset > 0){
echo "<input type='hidden' name='offset' value='$back'>";
echo "<input type='submit' value='&lt;&lt; Prev $limit' name='action'>";
}
echo "</form>\n";</script></font></small></th>
    <th width="154" valign="middle" height="50"><small><font face="Arial"><script
    language="php">
echo "<form method='POST'>\n";
// echo "View&nbsp;<input type='text' name='limit' size='2' value='$limit'>&nbsp;at a time.\n";
</script></font></small></th>
    <th width="154" valign="middle" height="50"><small><font face="Arial"><script
    language="php">
if(($numrows - $forth) < $limit){
	$num_forth = ($numrows - $forth);
}else{
	$num_forth = $limit;
}
if($forth < $numrows){
echo "<input type='hidden' name='offset' value='$forth'>";
echo "<input type='submit' value='Next $num_forth &gt;&gt;' name='action'>";
}
echo "</form>\n";</script></font></small></th>
  </tr>
</table>
</center>
</body>
</html>
