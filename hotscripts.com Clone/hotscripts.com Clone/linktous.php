<? 
include_once "config.php";
include "session.php";

?> 
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td></td>
  </tr>
  <tr> 
    <td height="25"> <a href="index.php"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#000000">HOME</font></strong></font></a> 
      <strong><font color="#000000" size="2" >&gt; LINK TO US</font></strong>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td><br>
      <table width="95%" border="0" cellspacing="0" cellpadding="3" >
        <tr> 
          <td><div align="justify"></div>
            <?
			
	$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));
	
	 $sql=mysql_query("select * from sbwmd_banners");
	  while($banners=mysql_fetch_array($sql))
	  {
	  ?>
        <tr> 
          <td><div align="center"><img src='<? echo $banners["img_url"];?>'></div></td>
        </tr>
        <tr> 
          <td><div align="center"> 
              <textarea name="src" cols="60" ><a href='<? echo $rs0["site_addrs"] ?>'><img src='<? echo $banners["img_url"];?>' border=0></a></textarea>
              <br>
              <br>
            </div></td>
        </tr>
        <?
	  }// end while
	  ?>
      </table> </td>
  </tr>
</table>

