<?php 

												$id = $_GET['id'];
												include("config.php");
												mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error()); 
												mysql_select_db($db_name) or die(mysql_error());
												$result = mysql_query("SELECT * FROM mp3 WHERE id LIKE '$id'");
												while($r=mysql_fetch_array($result))
												{
												$video=$r["video"];
												$artist=$r["artist"];
												$id=$r["id"];
												$link=$r["link"];	

echo '<table width="326" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>';
    echo '<td width="326" height="500" valign="top"><div align="center">';
        echo '<p>$artist;</p>';
        echo '<p align="left">Video Name : $video;</p>';
        echo '<p align="left">Artist : $artist;</p>';
        echo '<p align="left"><embed name="PersianMP3Player" src="$link;" type="application/x-mplayer2" width="320" height="300" showc.."1" showstatusbar="1" loop="true" enablec.."0" displaysize="0" pluginspage="http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/"></embed>
        </p>';
        echo '<p align="center">HTML CODE :</p>';
       echo '<p align="center">';
          echo '<textarea name="textarea"><embed name="PersianMP3Player" src="$link;" type="application/x-mplayer2" width="320" height="300" showc.."1" showstatusbar="1" loop="true" enablec.."0" displaysize="0" pluginspage="http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/"></embed><br>
<a href="$siteurl" target="_blank">Video provided by $sitename_www;</a>
</textarea>'; 
          echo '<br>
                </p>
    </div></td>
  </tr>
  <tr>
    <td height="35">&nbsp;</td>
  </tr>
</table>';
}
?>
<?php mysql_close(); ?>