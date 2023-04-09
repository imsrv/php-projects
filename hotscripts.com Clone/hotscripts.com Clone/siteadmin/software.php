<?
include_once "logincheck.php"; 
include_once "../config.php";
function main()
{
/////////////getting null char
	$null_char=mysql_fetch_array(mysql_query("select null_char from sbwmd_config"));


$strpass="";
if (isset($_REQUEST["cid"]) && $_REQUEST["cid"]<>"")
{
$strpass="&cid=" .$_REQUEST["cid"];
} 
 
if (isset($_REQUEST["keyword"]) && $_REQUEST["keyword"]<>"")
{
$strpass="&keyword=" .$_REQUEST["keyword"];
} 
  
 
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

$sql0="select * from sbwmd_softwares where s_name<>''  ";

$keyword="";

if (isset($_REQUEST["keyword"]) && $_REQUEST["keyword"]<>"")
{		
$keyword=$_REQUEST["keyword"];

$sql0=$sql0." and ( s_name like '%".str_replace("'","''",$_REQUEST["keyword"])."%' or  admin_desc like '%".str_replace("'","''",$_REQUEST["keyword"]). "%')";


}//end if

if(isset($_REQUEST["cid"])&& $_REQUEST["cid"]<>"")
{
$sql0=$sql0." and cid=".$_REQUEST["cid"];
}
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

<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><div align="center"></div></td>
  </tr>
  <tr> 
    <td><div align="center"> 
        <table width="550" border="0" cellspacing="0" cellpadding="1">
          <tr> 
            <td><table width="100%" border="0" cellpadding="1" cellspacing="0" bordercolor="#3399CC">
                <form name="form1" method="post" action="software.php">
                  <tr> 
                    <td width="77%"> <div align="left"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong>Keyword</strong></font> 
                        <input name="keyword" type="text" value="<?  echo $keyword;?>" class="box1">
                        <input type="submit" name="Submit" value="Submit" >
                      </div></td>
                    <td width="23%">&nbsp;</td>
                  </tr>
                </form>
              </table></td>
          </tr>
          <tr> 
            <td bgcolor="#666666"> <font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              &nbsp; 
              <?
if (isset($_REQUEST["cid"]) && $_REQUEST["cid"]<>"")		
	{
	if ($rs_query)
	//echo " software for the category <b><font color='#FFCC00'> " .$rs_query["cat_name"]."</font></b>"
	;
	}
else
	echo " Software Search results for <b><font color='#FFCC00'>".$keyword."</font></b>";

?>
              </font></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr> 
    <td> <div align="center"> 
        <?
if (!$rs_query)
{
?>
        <br>
        <table align="center" bgcolor="#FEFCFC"   border="0" cellpadding="5" >
          <tr> 
            <td><font color="#666666"><b><font face="verdana, arial" size="1"> 
              No Software satisfy the criteria you specified. </font></b></font></td>
          </tr>
        </table>
        <br>
        <?
}//end if 
?>
      </div></td>
  </tr>
  <tr> 
    <td><div align="center"> 
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <?
  $cnt=1;
  while ( ($rs_query) && ($cnt<=$recperpage))
  {
?>
          <tr>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="2">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="38" valign="top"><strong><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $jmpcnt;?></font></strong></td>
            <td width="9"><strong></strong></td>
            <td colspan="2"><strong><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="editsoftware.php?id=<? echo $rs_query["id"]; ?>&pg=<? echo $pg; ?>"
	 title="Edit details for software <? echo $rs_query["s_name"]; ?>"> <? echo $rs_query["s_name"]; ?></a> 
              &nbsp;&nbsp;posted by 
              <? $name=mysql_fetch_array(mysql_query("select username from sbwmd_members where id=".$rs_query["uid"]));
			  echo $name[0];?>
              </font></strong></td>
            <td><font size="1"><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong>No. 
              of views</strong></font></font></font></font></td>
            <td><strong><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $rs_query["page_views"]; ?></font></strong></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign="top"><font size="1"><strong><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif">Price</font></strong></font></td>
            <td valign="top"><font size="1"><strong><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><font size="1" color="#0066ff"> 
              <?
					  if( ($rs_query["price"]==0) || ($rs_query["cur_id"]==0))
					  echo $null_char[0];
					  else
					  {
					  $cur=mysql_fetch_array(mysql_query("select * from sbwmd_currency where id=".$rs_query["cur_id"]));
					  echo $cur["cur_name"].$rs_query["price"];
					  }
					  ?>
              </font></font></strong></font></td>
            <td align="left" valign="top"><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong>Licence 
              Type</strong></font></font></font></td>
            <td valign="top"><font size="1"><font size="1"><strong><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
              <? 
			$lic=mysql_fetch_array(mysql_query("select * from sbwmd_licence_types where id=".$rs_query["lid"]));
			echo $lic["licence_name"]; ?>
              </font></strong></font></font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign="top"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"> 
              <strong> category</strong></font></font></td>
            <td align="left" valign="top"><strong><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
              <? 
			$lic=mysql_fetch_array(mysql_query("select * from sbwmd_categories where id=".$rs_query["cid"]));
			echo $lic["cat_name"]; ?>
              </font></strong><font size="1"><font size="1"><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"></font></font></font></font></font><font size="1"><font size="1"><a href="deletemember.php?id=<? echo $rs_query["id"];?>&pg=<? echo $pg; ?>"></a><strong><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></strong></font></font></td>
            <td align="left" valign="top"><font size="1"><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong>Popularity</strong></font></font></font></font></td>
            <td align="left" valign="top"><strong><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $rs_query["popularity"]; ?></font></strong></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign="top"><font size="1"><font size="1"><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong>Platforms</strong></font></font></font></font></font></td>
            <td colspan="3" align="left" valign="top"><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
              <? 
			$sq_l=mysql_query("select * from sbwmd_platforms where id in (".$rs_query["platforms"].")");
			$i=1;
			while($lic=mysql_fetch_array($sq_l))
			{if($i==1) {$i++; echo $lic["plat_name"]; }else echo " - ".$lic["plat_name"];}?>
              </font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td width="97" valign="top"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong>Software 
              URL</strong></font></font><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
              </strong></font></font></td>
            <td width="184" valign="top"><strong><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="<? echo $rs_query["soft_url"]; ?>"><? echo $rs_query["soft_url"]; ?></a></font></strong></td>
            <td width="80" align="left" valign="top"><font size="1"><font size="1"><font size="1"><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong>Downloads</strong></font></font></font></font></font></font></td>
            <td width="142" align="left" valign="top"><font size="1"><font size="1"><a href="deletemember.php?id=<? echo $rs_query["id"];?>&pg=<? echo $pg; ?>"></a><strong><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $rs_query["downloads"]; ?></font><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></strong></font></font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign="top"><font size="1"><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong>Home 
              URL</strong></font></font></font><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"></font></font></td>
            <td width="184" valign="top"><strong><font size="1"><font size="1"><strong><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="<? echo $rs_query["home_url"]; ?>"><? echo $rs_query["home_url"]; ?></a></font></strong></font></font><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></strong></td>
            <td width="80" align="left" valign="top"><font size="1"><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong>No. 
              of hits</strong></font></font></font></font></td>
            <td width="142" align="left" valign="top"><strong><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $rs_query["hits_dev_site"]; ?></font><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"></font></strong></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td valign="top"><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong>Screen 
              Shot URL</strong></font></font><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"></font></font></td>
            <td width="184"><strong><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="<? echo $rs_query["ss_url"]; ?>"><? echo $rs_query["ss_url"]; ?></a></font></strong></td>
            <td width="80" align="center" valign="bottom">&nbsp;</td>
            <td width="142" align="center" valign="bottom">&nbsp;</td>
          </tr>
          <tr> 
            <td height="30" colspan="6" align="left" valign="top"> <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
                <tr> 
                  <td height="18" valign="baseline"><font size="1"><font size="1"> 
                    <?
			if($rs_query["approved"]=='no')
			{ 
			?>
                    <a href="approve_soft.php?id=<? echo $rs_query["id"];?>&pg=<? echo $pg; ?>"><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">Approve</font></a></font></font> 
                    <?
			}
			else
			{
			?>
                    <a href="approve_soft.php?id=<? echo $rs_query["id"];?>&pg=<? echo $pg; ?>"><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif">Disapprove</font></a> 
                    <?
			}?>
                  </td>
                  <td> 
                    <?
			if($rs_query["featured"]=='no')
			{ 
			?>
                    <a href="featured.php?id=<? echo $rs_query["id"];?>&pg=<? echo $pg; ?>"><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">Make 
                    Featured</font></a> 
                    <?
			}
			else
			{
			?>
                    <a href="featured.php?id=<? echo $rs_query["id"];?>&pg=<? echo $pg; ?>"><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif">Make 
                    Not Featured</font></a> 
                    <?
			}?>
                  </td>
                  <td><font size="1"><font size="1"><a href="deletesoftware.php?id=<? echo $rs_query["id"];?>&pg=<? echo $pg; ?>"><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">Delete</font></a></font></font></td>
                </tr>
              </table></td>
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
            <td bgcolor="#666666"> <p> <font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <strong><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Pages: 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></font> 
                <?

if ($pg>1) 
{
?>
                
                <font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>
				<a href="software.php?tmp=1<? echo $strpass; ?>&pg=<? echo ($pg-1); ?>"> 
				<font color="#FFCC00" size="2">
                <?
}//end if
if ($pages<>1)
echo "Previous";
if ($pg>1)
{
?>
                </font></a></strong></font></a> &nbsp;&nbsp; 
                <?
}//end if
echo " ";
for ($i=1; $i<=$pages; $i++)
{
	if ($pg<>$i)
	{
	?>
                <a href="software.php?tmp=1<? echo $strpass; ?>&pg=<? echo $i;?>"> 
                <font color="#FFCC00" size="2"> 
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
                <a href="software.php?tmp=1<? echo $strpass; ?>&pg=<?   echo ($pg+1); ?>"><font color="#FFCC00"  size="2"> 
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
                </strong> </font></p></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td><div align="center"></div></td>
  </tr>
</table>
<p>&nbsp; </p>
<p><br>



<?
}//main()
include "template.php";
?>
