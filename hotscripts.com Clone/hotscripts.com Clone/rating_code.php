<?
include "logincheck.php";
include_once "config.php";
include_once "left_mem.php";

function main()
{

$strpass="";

if ( isset($_REQUEST["id"] ) )
{
$strpass=$strpass . "&id=" . $_REQUEST["id"];
}
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));
$recperpage=$rs0["recperpage"];
$sql="select *,UNIX_TIMESTAMP(date_submitted) as ds,UNIX_TIMESTAMP(date_approved) as da from sbwmd_softwares where uid=".$_SESSION["userid"];
$sql.= " order by popularity desc" ;
$rs_query=mysql_query($sql);
///////////////////////////////////PAGINATION /////////
	if(!isset($_REQUEST["pg"]))
	{
			$pg=1;
	}
	else 
	{
	$pg=$_REQUEST["pg"];
	}
$rcount=mysql_num_rows($rs_query);
if ($rcount==0 )
{ 
	$pages=0;
}	
else
{
	$pages=floor($rcount / $recperpage);
	if  (($rcount%$recperpage) > 0 )
	{
		$pages=$pages+1;
	}
}
$jmpcnt=1;
while ( $jmpcnt<=($pg-1)*$recperpage  && $row = mysql_fetch_array($rs_query) )
    {	
		$jmpcnt = $jmpcnt + 1;
	}

////////////////////////////////////////////////////////////////////////
?>

<link href="../styles/style.css" rel="stylesheet" type="text/css">

<?
//$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_members where id=".$_SESSION["userid"]));
?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td height="25"><font color="#000000"><strong>&nbsp;<a href="index.php"  class="barlink">HOME </font> 
      </a> &gt; RATING CODE</font></strong></font>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td> 
      <?
	
		$rst=mysql_fetch_array(mysql_query("Select * from sbwmd_config " ));
	$siteroot=$rst["site_addrs"];
		$rst=mysql_fetch_array(mysql_query("Select * from sbwmd_softwares where id=" . $_REQUEST["id"] ));

	?>
      <br> <table width="500" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td><strong>Rating 
            Code For </font></strong><font color="#000000" size="2" >- 
            <? echo $rst["s_name"];?></font></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><font color="#333333" size="2" >You 
            can add the following code to your website to let people rate your 
            software from your own website.</font></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><form name="form1" method="post" action="">
              <textarea name="textarea" cols="60" rows="15"><?php
echo "<form action=\"" . $siteroot . "\insert_rating.php\" method=\"get\" name=\"rating\" target=\"_blank\" onSubmit=\"return Validate(this);\">";

$rst=mysql_fetch_array(mysql_query("Select * from sbwmd_config " ));
$siteroot=$rst["site_addrs"];
$rst=mysql_fetch_array(mysql_query("Select * from sbwmd_softwares where id=" . $_REQUEST["id"] ));

echo "<table width=250 cellpadding=0 cellspacing=0><tr bgcolor=\"#000000\"> <td align=\"left\"><strong><font color=\"#FFFFFF\" size=\"2\" face=\"Arial, Helvetica, sans-serif\">Rate Software</font></strong></td></tr><tr><td align=\"left\"  bgcolor=\"FFFFFF\"><select name=\"rating\"><option value=\"1\">1</option><option value=\"2\">2</option><option value=\"3\">3</option><option value=\"4\">4</option><option value=\"5\">5</option><option value=\"6\">6</option><option value=\"7\">7</option><option value=\"8\">8</option><option value=\"9\">9</option><option value=\"10\">10</option></select><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><input type=\"hidden\" name=\"sid\" value=\"". $_REQUEST["id"] . ">\"><input type=submit value=Submit name=submit></font></td></tr><tr><td align=\"left\"  bgcolor=\"FFFFFF\"><font color=\"#333333\" size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>1</strong>-poor<strong>10</strong>-Great </font><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp; </font> </td></tr></table></form>";

	?>
	</textarea>
              <br>
              <br>
              <input type="button" name="Submit" value="Back" onclick="javascript:window.history.go(-1);">
              <br>
            </form></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>

<p>&nbsp; </p>
<p><br>
 <?
}// end main
include "template1.php";
?> 

