<?
function right()
{
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));
$recperpage=$rs0["recinpanel"];

?>
<table width="150" border="0" align="right" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="23"> <div align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/topshare.gif" width="163" height="25"></font></div></td>
  </tr>
  <tr> 
    <td><table width="150" border="0" cellpadding="1" cellspacing="0" bordercolor="#000000">
        <?
			  $shareware=mysql_query("select * from sbwmd_licence_types,sbwmd_softwares where sbwmd_softwares.lid=sbwmd_licence_types.id && licence_name='shareware' and approved='yes'  order by popularity");
			  $cnt=1;
			  while(   ($rst=mysql_fetch_array($shareware))  && ($cnt<=$recperpage))
			  {			  
			  ?>
        <tr> 
          <td > <table width="141" border="0" align="center" cellpadding="0" cellspacing="1">
              <tr> 
                <td>&nbsp;<a   class="sidelink" href="software-description.php?id=<? echo $rst["id"];?>"><? echo $rst["s_name"];?></a></td>
              </tr>
            </table></td>
        </tr>
        <?
			 $cnt++;
			 }//end while
			  ?>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td height="23"><div align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/topfree.gif" width="163" height="25"></font></div></td>
  </tr>
  <tr> 
    <td><table width="150" border="0" cellpadding="1" cellspacing="0" bordercolor="#000000">
        <?
			  $freeware=mysql_query("select * from sbwmd_licence_types,sbwmd_softwares where sbwmd_softwares.lid=sbwmd_licence_types.id && licence_name='freeware'  and approved='yes' order by popularity");
			  $cnt=1;
			  while(  ($rst=mysql_fetch_array($freeware))  && ($cnt<=$recperpage))
			  {			  
			  ?>
        <tr> 
          <td > <table width="142" border="0" align="center" cellpadding="0" cellspacing="1">
              <tr> 
                <td>&nbsp;<a   class="sidelink" href="software-description.php?id=<? echo $rst["id"];?>"><? echo $rst["s_name"];?></a></td>
              </tr>
            </table></td>
        </tr>
        <?
			 $cnt++;
			 }//end while
			  ?>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td height="23"><div align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><img src="images/sponsors.gif" width="163" height="25"> 
        </strong></font></div></td>
  </tr>
  <tr> 
    <td><table width="150" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td><table width="150" border="0" cellpadding="1" cellspacing="0" bordercolor="#000000">
              <?
			  $sponsered=mysql_query("select * from sbwmd_sideads ");
			  $cnt=1;
			  while($rst=mysql_fetch_array($sponsered))
			  {			  
			  ?>
              <tr> 
                <td ><table width="142" border="0" align="center" cellpadding="0" cellspacing="1">
                    <tr> 
                      <td>&nbsp;<a   class="sidelink" href="http://<? echo $rst["url"]; ?>" target="_blank"><? echo $rst["linktext"]; ?></a></td>
                    </tr>
                  </table></td>
              </tr>
              <?
			 $cnt++;
			 }//end while
			  ?>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<?
}// end right
?>