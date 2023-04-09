<?php
												include ("config.php"); 
											mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error()); 
											mysql_select_db($db_name) or die(mysql_error());

												$result = mysql_query("SELECT * FROM mp3 order by id desc LIMIT 5");
												while($r=mysql_fetch_array($result))
												{
												$album=$r["album"];
												$artist=$r["artist"];
												$id=$r["id"];
												$img=$r["img"];
												
echo '<table width="185" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>';
    echo '<td width="185" height="109" valign="top">'; echo "<p> <img border='0' src="; if ($img=="") { echo 'images/nopic.gif'; } else { echo "$img"; }  echo" width='70' height='60'> </p>"; echo '<p><img src="/images/1_w1.gif" width="23" height="23">'; echo '$artist'; echo '</p>';      
	echo '<p'; echo 'align='; echo '"center">'; echo '$album</p>';    
	  echo '<p align="center">'; echo '<a href="download.php?id=$id">'; echo 'Click Here To Download</a></p></td>';
  echo '</tr>';
echo '</table>';
}
?>
<?php	mysql_close(); ?>