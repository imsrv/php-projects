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

$sql0="select * from sbwmd_members where username<>''  ";

$keyword="";

if (isset($_REQUEST["keyword"]) && $_REQUEST["keyword"]<>"")
{		
$keyword=$_REQUEST["keyword"];

$sql0=$sql0." and ( username like '%".str_replace("'","''",$_REQUEST["keyword"])."%' or  c_name like '%".str_replace("'","''",$_REQUEST["keyword"]). "%' or  c_contact like '%".str_replace("'","''",$_REQUEST["keyword"])."%' or  email like '%".str_replace("'","''",$_REQUEST["keyword"])."%')";

//$sql0=$sql0. " and ( username like '%".$_REQUEST["keyword"]."%' or  company like '%".$_REQUEST["keyword"]."%' or  name like '%".$_REQUEST["keyword"]."%')";

}//end if

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
                <form name="form1" method="post" action="members.php">
                  <tr> 
                    <td> 
                      <div align="left"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><strong>Keyword</strong></font> 
                        <input name="keyword" type="text" value="<?  echo $keyword;?>" class="box1">
                        <input type="submit" name="Submit" value="Submit" >
                      </div></td>
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
	//echo " Members for the category <b><font color='#FFCC00'> " .$rs_query["cat_name"]."</font></b>"
	;
	}
else
	echo " Member Search results for <b><font color='#FFCC00'>".$keyword."</font></b>";

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
              No Members satisfy the criteria you specified. </font></b></font></td>
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
        <table width="90%" border="0" align="center" cellpadding="1" cellspacing="0">
          <?
  $cnt=1;
  while ( ($rs_query) && ($cnt<=$recperpage))
  {
?>
          <tr> 
            <td width="7%"><strong><font color="#000000" size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $jmpcnt;?><? echo "      ".$rs_query["id"]; ?></font></strong></td>
            <td colspan="4"><strong><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"><a href="editmember.php?id=<? echo $rs_query["id"]; ?>&pg=<? echo $pg; ?>"
	 title="Edit details for member <? echo $rs_query["username"]; ?>"> <? echo $rs_query["username"]; ?></a> 
              &nbsp;&nbsp;</font><font size="1"><font size="1"><a href="email.php?id=<? echo $rs_query["email"];?>"><font color="#0066ff" face="Verdana, Arial, Helvetica, sans-serif">Email</font></a></font></font><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
              </font><font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"><? echo $rs_query["email"]; ?> 
              &nbsp;&nbsp;</font></strong></td>
          </tr>
          <tr> 
            <td><font color="#003399" size="1">&nbsp;</font></td>
            <td colspan="4"><font size="1"><strong></strong><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><? echo $rs_query["c_contact"];?> 
              (<? echo $rs_query["phone"]; ?>) </font></font></td>
          </tr>
          <tr> 
            <td><font color="#003399" size="1">&nbsp;</font></td>
            <td><font size="1"><strong><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif">Company<font size="1"> 
              </font></font></strong><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"> 
              &nbsp;</font></font></td>
            <td><font size="1"><strong><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><? echo $rs_query["c_name"];?></font></font></strong></font></td>
            <td colspan="2"><div align="left"><font color="#003399" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Number 
                of softwares</strong></font></div></td>
          </tr>
          <tr> 
            <td rowspan="3">&nbsp;</td>
            <td width="17%" rowspan="3" valign="top"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"> 
              <strong> Address </strong> </font><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></font></font></td>
            <td width="45%" rowspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><? echo $rs_query["stadd1"];?></font></font></td>
                </tr>
                <tr> 
                  <td><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><? echo $rs_query["stadd2"];?></font></font></font></td>
                </tr>
                <tr> 
                  <td><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"> 
                    </font><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"><? echo $rs_query["city"]." - ".$rs_query["zip"];?></font></font></font></td>
                </tr>
                <tr> 
                  <td><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"> 
                    <? if($rs_query["state_us"]<>0)
				  { 
				  $state=mysql_fetch_array(mysql_query("select * from sbwmd_states where id=".$rs_query["state_us"]));
				  echo $state["state"];}else echo $rs_query["state_non_us"];?>
                    </font><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"> 
                    </font><font size="1"><font size="1"><font size="1"><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif">
                    <? if($rs_query["country"]<>0)
				  { 
				  $country=mysql_fetch_array(mysql_query("select * from sbwmd_country where id=".$rs_query["country"]));
				  echo " , ".$country["country"];}else echo " ";?>
                    </font></font></font></font><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"> 
                    </font></font></font><font color="#003399" face="Verdana, Arial, Helvetica, sans-serif"> 
                    </font></font></td>
                </tr>
              </table></td>
            <td width="22%" align="center" valign="bottom"><div align="left"><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Approved:</strong></font></div></td>
            <td width="9%" align="center" valign="bottom"><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
              <?
			$num=mysql_fetch_array(mysql_query("select count(*) from sbwmd_softwares where approved='yes' and uid=".$rs_query["id"]));
			echo $num[0];
			?>
              </font></td>
          </tr>
          <tr> 
            <td align="center" valign="bottom"><div align="left"><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>To 
                be Approved:</strong></font></div></td>
            <td width="9%" align="center" valign="bottom"><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
              <?
			$num=mysql_fetch_array(mysql_query("select count(*) from sbwmd_softwares where approved='no' and uid=".$rs_query["id"]));
			echo $num[0];
			?>
              </font></td>
          </tr>
          <tr> 
            <td width="22%" align="center" valign="bottom"><div align="left"><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font><font size="1"><font size="1"><a href="deletemember.php?id=<? echo $rs_query["id"];?>&pg=<? echo $pg; ?>"><font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif">Delete</font></a></font></font><font color="#0066ff" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font></div></td>
            <td width="9%" align="center" valign="bottom"><font size="1"><font size="1"><a href="deletemember.php?id=<? echo $rs_query["id"];?>&pg=<? echo $pg; ?>"></a></font></font></td>
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
            <td bgcolor="#666666"> 
              <p> <font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <strong><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Pages: 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></font> 
                <?

if ($pg>1) 
{
?>
                <a href="members.php?cid=&keyword=<? echo $_REQUEST["keyword"]?>&pg=<? echo ($pg-1); ?>"> 
                <font color="#FFCC00" size="2"> 
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
                <a href="members.php?cid=<? //echo $_REQUEST["cid"];?>&keyword=<? echo $keyword;?>&pg=<? echo $i;?>"> 
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
                <a href="members.php?cid=&keyword=<? $_REQUEST["keyword"]; ?>&pg=<?   echo ($pg+1); ?>"><font color="#FFCC00"  size="2"> 
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
