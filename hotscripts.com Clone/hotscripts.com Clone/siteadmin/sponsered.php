<?
include_once "logincheck.php"; 
include_once "../config.php";
function main()
{

 
if (isset($_REQUEST["msg"]) && $_REQUEST["msg"]<>"")
{
?>
        <table align="center" bgcolor="#FEFCFC"   border="0" cellpadding="5" >
        <tr> 
          <td><b><font face="verdana, arial" size="1" color="#666666"> 
            <?
echo $_REQUEST["msg"] ; 

?>
            </font></b></td>
        </tr>
      </table>
        <?
}//end if 

$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));
$recperpage=$rs0["recperpage"];

$sql0="select * from sbwmd_sideads ";



$sql0=$sql0." order by id desc";

$query=mysql_query($sql0);
$rs_query=mysql_fetch_array($query);

///////////////////////////////////PAGINATION /////////
	if(!isset($_REQUEST["pg"]))
	{
			$pg=1;
	}
	else 
	{
	$pg=$_REQUEST["pg"];
	}

$rcount=mysql_num_rows($query);

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
while ( $jmpcnt<=($pg-1)*$recperpage  && $rs_query = mysql_fetch_array($query) )
    {	
		$jmpcnt = $jmpcnt + 1;
	}

////////////////////////////////////////////////////////////////////////
?>

<table width="700" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td colspan="2"><div align="center"></div></td>
  </tr>
  <tr> 
    <td width="615" bgcolor="#FFFFFF"><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Sponsered 
      Ads</strong></font></td>
    <td width="65" bgcolor="#FFFFFF"><font size="1"><font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif"><a href="add_sponsered.php">Add</a></font></font></td>
  </tr>
  <tr> 
    <td colspan="2" bgcolor="#666666"> <div align="center"></div></td>
  </tr>
  <tr> 
    <td colspan="2"><div align="center"> 
        <table width="100%" border="0" align="center" cellpadding="1" cellspacing="0">
          <?
  $cnt=1;
  while ( ($rs_query) && ($cnt<=$recperpage))
  {
?>
          <tr bgcolor='<? if ($cnt%2==0) echo "#FFFFFF"; else echo "#EEEEEE"?>'> 
            <td width="4%"><strong><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $jmpcnt;?></font></strong></td>
            <td width="28%"><strong><font color="#004080" size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $rs_query["linktext"];?>(<? echo $rs_query["url"];?>)</font></strong></td>
            <td width="10%"><font size="1"><font size="1"><a  href="edit_sponsered.php?id=<? echo $rs_query["id"];?>&pg=<? echo $pg; ?>"><font color="#0066ff" face="Verdana, Arial, Helvetica, sans-serif">Edit</font></a></font></font></td>
            <td width="14%"><font size="1"><font size="1"><a href="delete_sponsered.php?id=<? echo $rs_query["id"];?>&pg=<? echo $pg; ?>"><font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif">Delete</font></a></font></font></td>
          </tr>
          <?
	  $cnt=$cnt+1;
	  $jmpcnt=$jmpcnt+1;
	  $rs_query=mysql_fetch_array($query);
	  }//  wend
	?>
        </table>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td bgcolor="#666666" height=1></td>
          </tr>
          <tr> 
            <td bgcolor="#ffffff"> <p> <font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <strong><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#666666">Pages: 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></strong></font> <font color="#666666"> 
                <?

if ($pg>1) 
{
?>
                <a href="sponsered.php?pg=<? echo ($pg-1); ?>"> <font size="2"> 
                <?
}//end if
if ($pages<>1)
echo "Previous";
if ($pg>1)
{
?>
                </font></a> &nbsp;&nbsp; 
                <?
}//end if
echo " ";
for ($i=1; $i<=$pages; $i++)
{
	if ($pg<>$i)
	{
	?>
                <a href="sponsered.php?pg=<? echo $i;?>"> <font size="2"> 
                <?
 }//end if
?>
                <? echo $i; ?> 
                <?
if ($pg<>$i)
{
?>
                </font></a> &nbsp;&nbsp; 
                <? 
				}
}//for

if ($pg<$pages )
{
?>
                <a href="sponsered.php?pg=<?   echo ($pg+1); ?>"><font  size="2"> 
                <?
}//end if
if ($pages<>1)
{
?>
                Next 
                <?
}//end if
if ($pg<>($pages))
{
?>
                </font></a> &nbsp;&nbsp; 
                <?
}//end if
?>
                </font> </strong> </font></p></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr> 
    <td colspan="2"><div align="center"></div></td>
  </tr>
</table>
<p>&nbsp; </p>
<p><br>



<?
}//main()
include "template.php";
?>
