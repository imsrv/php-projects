</div>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>

<br><br><div align=center>
<?
/* nulled by [GTT] :) */    
db_connect();
$sql = "SELECT * FROM banner_index";
$result = mysql_query($sql);
if (!$result)
{
}
else
{
  if (mysql_num_rows($result) > 0)
  {
     $i=0;
     while ($row = mysql_fetch_array($result))
     {
        $rowset[$i] = $row;
        $i++;
     }
     $rand = rand (0, count($rowset)-1);
     $row = $rowset[$rand];
     echo "<a href='".$row['link_url']."'><img src='".$row['banner_url']."' border=0></a>";
  }
}
?>
</div><br>

</td></tr></table></td></tr>
<tr><td colspan=2 bgcolor=#0D004C align=right height=18 class=menu>
<a href=index.php class=menu>Home</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href=index.php?a=programs class=menu>About programs</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href=index.php?a=register class=menu>Register now!</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href=index.php?a=faq class=menu>FAQ</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href=index.php?a=terms class=menu>Terms and Conditions</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
<a href="mailto:admin@null.ru" class=menu>Contact us</a>&nbsp;&nbsp;&nbsp;&nbsp;
</td></tr>
</table>
</center>
</body>
</html>