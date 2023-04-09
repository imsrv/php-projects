<br><br>
<center>
<form method="<? print($method) ?>" action="<? print($SCRIPT_NAME)?>">
<?
/*
This program is copywrite Eyekon, 1998, All rights
reserved. You may not sell, distribute, or give away
any copy of this program without the express consent
or Eyekon. This notice must remain in the top of every
document included in this distribution.
*/
 EchoFormVars(); ?>
<table border="1" cellspacing="0" cellpadding="1" align="center" bgcolor="<? print($tbl_bgcolor)?>" width="90%">
    <script language="php">
if(isset($varietal)){
	echo "<tr><th colspan='6' bgcolor='$hdr_bgcolor'>Now Viewing Varietal: $varietal</th></tr>\n";
}else{
	echo "<tr><th colspan='6' bgcolor='$hdr_bgcolor'>Now Viewing Winery: $winery</th></tr>\n";
}
</script>

    <tr>
      <th colspan="6"><script language="php">EchoFormVars();


if(isset($varietal)){
	$column = "varietal";
}else{
	$column = "winery";
}

$query = "Select record_id FROM $table where $column = '".$$column."'";
$select = mysql($database,$query);
$numrows = mysql_numrows($select);

// Set limit to display XX records per page

if(!isset($limit)){
	$limit=20;
}

if(!isset($offset)){
	$offset = 0;
}

if($limit > $numrows){
	$limit = $numrows;
}

$query = "Select * FROM $table where $column = '".$$column."' ORDER BY $column LIMIT $offset,$limit";
$select = mysql($database,$query);

if($debug == 1){
	echo $query;
}

$row=0;
$rows = mysql_numrows($select);
</script><br> Displaying <script language="php">echo ($offset + 1)."- ";
echo ($offset + $limit);
echo " OF $numrows Wines";</script>
      <br><small>(price reflects $25 Markup)</small><br></th>
    </tr>
    <tr>
      <th><small>Quantity</small></th>
      <script language="php">
if(isset($varietal)){
	echo "<th><small>Winery</small></th>\n";
}else{
	echo "<th><small>Varietal</th>\n";
}
</script>
<th><small>Appellation</small></th>
      <th><small>Vintage</small></th>
      <th><small>Price</small></th>
      <th><small>Notes</small></th>
    </tr>
    <script language="php">
while($row<$rows){

$item_id=mysql_result($select,$row,$item_label);

echo "<tr height=25>\n";
echo "<td width=50 height=25 align='center'>\n";
echo "<input type='hidden' name='item_id[]' value='$item_id'>\n";
echo "<p><input type='text' size='2' name='quantity[]' value=''></p>\n";
echo "</td>\n";

if(isset($varietal)){
	$win=mysql_result($select,$row,"winery");
	echo "<td align='left'><small>$win</small>&nbsp;</td>\n";
}else{
	$varet=mysql_result($select,$row,"varietal");
	echo "<td align='left'><small>$varet</small>&nbsp;</td>\n";
}
?>
    <td align="left"><small><? print(mysql_result($select,$row,"appellation"))?></small>&nbsp;</td>
    <td align="center"><small><? print(mysql_result($select,$row,"vintage"))?></small>&nbsp;</td>
    <td align="right"><small>$<? print(mysql_result($select,$row,"price")+25.00)?></small>&nbsp;</td>
    <td align="center"><small><? print(mysql_result($select,$row,"note"))?></small>&nbsp;</td>
  </tr>
<?
	$row++;
} // Endwhile
?>
    <tr>
      <td colspan="6" align="center"><input type="submit" name="action" value="Order Items"></td>
    </tr>
<?
</script>

  </table>
  </center></div>
</form>
<div align="center"><center>

<table border="0" width="462" cellspacing="0" cellpadding="0" height="52">
  <tr>
    <th width="50%" valign="middle" height="50"><form method="<? print($method) ?>" action="<? print($SCRIPT_NAME)?>">
      <p><script language="php">
$back = $offset-$limit;
$forth = $offset+$limit;
if($offset > 0){
EchoFormVars();
echo "<input type='hidden' name='offset' value='$back'>";
echo "<input type='hidden' name='action' value='View'>";
echo "<input type='hidden' name='varietal' value='$varietal'>";
echo "<input type='submit' value='&lt;&lt; Prev $limit' name='direction'>";
}</script></p>
    </form>
    </th>
    <th width="50%" valign="middle" height="50"><form method="<? print($method) ?>" action="<? print($SCRIPT_NAME)?>">
      <p><script language="php">
if(($numrows - $forth) < $limit){
	$num_forth = ($numrows - $forth);
}else{
	$num_forth = $limit;
}
if($forth < $numrows){
EchoFormVars();
echo "<input type='hidden' name='offset' value='$forth'>";
echo "<input type='hidden' name='action' value='View'>";
echo "<input type='hidden' name='varietal' value='$varietal'>";
echo "<input type='submit' value='Next $num_forth &gt;&gt;' name='direction'>";
}</script></p>
    </form>
    </th>
  </tr>
</table>
</center>