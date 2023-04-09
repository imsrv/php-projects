<?php
												include ("config.php"); 
											mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error()); 
											mysql_select_db($db_name) or die(mysql_error());

												$result = mysql_query("SELECT * FROM video order by id desc LIMIT 5");
												while($r=mysql_fetch_array($result))
												{
												$video=$r["video"];
												$artist=$r["artist"];
												$id=$r["id"];
												$img=$r["img"];
												?>
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>

<table width="406" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td colspan="2" rowspan="7" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <!--DWLayoutTable-->
        <tr>
          <td width="121" height="126" valign="top" background="images/1_back3.jpg"><p>&nbsp;</p>            <p align="center"><? echo "<img border='0' src="; if ($img=="") { echo 'images/nopic.gif'; } else { echo "$img"; }  echo" width='70' height='60'>"; ?></p></td>
        </tr>
        <tr>
          <td height="18" valign="top" background="images/1_back3.jpg"><div align="center"><?=$artist?>
          </div></td>
        </tr>
        <tr>
          <td height="1"></td>
        </tr>
        <tr>
          <td height="19" valign="top" bgcolor="#000000"><div align="center"><?=$video?>
          </div></td>
        </tr>
            </table></td>
    <td width="17" height="17"></td>
    <td width="10"></td>
    <td width="11"></td>
    <td colspan="3" valign="top"><div align="center" class="style1">Video Details </div></td>
    <td width="10"></td>
    <td width="40"></td>
  </tr>
  <tr>
    <td height="16"></td>
    <td></td>
    <td></td>
    <td width="75"></td>
    <td width="100"></td>
    <td width="23"></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td height="19">&nbsp;</td>
    <td colspan="3" valign="top"><span class="style1">Artist : </span></td>
    <td valign="top"><?=$artist?>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td height="7"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td height="19">&nbsp;</td>
    <td colspan="3" valign="top"><span class="style1">Video Name : </span></td>
    <td valign="top"><?=$video?>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td height="68"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td height="19"></td>
    <td>&nbsp;</td>
    <td colspan="5" valign="top"><span class="style1"><a href="vdownload.php?id=<?=$id?>">Click Here To Watch 
      <?=$video?> 
    Video </a></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="13" height="10"></td>
    <td width="107"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td height="5"></td>
    <td colspan="9" valign="top"><img src="images/hl.gif" width="393" height="1"></td>
  </tr>
  <tr>
    <td height="8"></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
 <? } ?>
 <?php	mysql_close(); ?>