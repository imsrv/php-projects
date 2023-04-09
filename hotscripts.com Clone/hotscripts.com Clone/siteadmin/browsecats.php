<?

include "logincheck.php";
include_once "../config.php";


function main()
{

if ( isset( $_REQUEST["cid"] ) && $_REQUEST["cid"]!="" )
{
$cid=$_REQUEST["cid"];
}
else
{
$cid=0;
}
if ( isset( $_REQUEST["pid"] ) && $_REQUEST["id"]!="" )
{
$pid=$_REQUEST["cid"];
}
else
{
$pid=0;
}

$rs_query=mysql_query("Select * from sbwmd_categories where id=" . $cid );
	if ($rs=mysql_fetch_array($rs_query))
	{
	$catname=$rs["cat_name"];
	$category=$rs["id"];
	$cid=$rs["id"];
	}
    else
	{
	$catname="";
	$category=0;
	$cid=0;
	}
    $catpath="";
  	$rs_query=mysql_query("Select * from sbwmd_categories where id=" . $category );

	while ($rs=mysql_fetch_array($rs_query))
    {
    $catpath ="<font size='2' color='darkred'>>&nbsp;</font><a href=\"browsecats.php?cid=" . $rs["id"] . "\"><font size='2' color='darkred' face='Verdana, Arial, Helvetica, sans-serif'>" .$rs["cat_name"]."</a>" . $catpath; 
  	$rs_query=mysql_query("Select * from sbwmd_categories where id=" . $rs["pid"] );
    }
    



?><?
if ( isset($_REQUEST["msg"])&&$_REQUEST['msg']<>"")
{
?>
<br>
<table align="center" bgcolor="#FEFCFC"   border="0" cellpadding="5" >
  <tr> 
    <td><b><font face="verdana, arial" size="1" color="#666666"> 
      <?
print($_REQUEST['msg']); 

?>
      </font></b></td>
  </tr>
</table>
<?
}//end if
?><br>
<table width="90%" border="0" cellspacing="2" cellpadding="2">
  <tr> 
    <td bgcolor="#cccccc"> <table cellpadding="3">
        <tr> 
          <td><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
            &nbsp; <a href="browsecats.php"><font size="2" color="darkred" face="Verdana, Arial, Helvetica, sans-serif">All 
            Categories</font></a> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><? echo  $catpath; ?></font></font></td>
        </tr>
      </table></td>
  </tr>
</table>
  
  

<table width="90%" border="0" align="left" cellpadding="4" cellspacing="0">
  <?
					   $cnt=1;
					   $rs_query_t=mysql_query("Select * from sbwmd_categories where pid=" . $cid	);
                        while($rs_t=mysql_fetch_array($rs_query_t))
						{
	  ?>
  <tr> 
    <td width="6%"><img src="images/space.gif" height="8" width="35"></td>
    <td width="19%" align="left" valign="top"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><a href="browsecats.php?cid=<? echo $rs_t["id"] ;?>"><? echo $rs_t["cat_name"] ;?></a> 
        </font></div></td>
    <td width="27%" align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
      <?
	$rs_t1=mysql_fetch_array(mysql_query("select * from sbwmd_softwares where cid=".$rs_t["id"]));
	if($rs_t1)
	{
	?>
      <font size="1"><a target=_blank href="shift1.php?cid=<? echo $rs_t["id"];?>&pid=<? echo $cid;?>">Shift</a> 
      (<? echo mysql_num_rows(mysql_query("select * from sbwmd_softwares where cid=".$rs_t["id"]));?>)<font color="darkred"> 
      Listings to any other Category</font> 
      <?
  }// end if
  ?>
      </font> </td>
	<td width="13%" align="center"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><a href="deletecat.php?cid=<? echo $rs_t["id"];?>&pid=<? echo $cid;?>">Remove</a></font></font></div></td>
    <td width="10%" align="center"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><a href="editcat.php?cid=<? echo $rs_t["id"];?>&pid=<? echo $cid;?>">Edit</a></font></font><font size="1"></font></font></div></td>
    <?
	if($rs_t["pid"]==0)
	{
	?>
    <td width="25%" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><font size="1"><a target=_blank href="platform.php?cid=<? echo $rs_t["id"];?>&pid=<? echo $cid;?>">Platforms</a></font></font></font> 
    </td>
    <?
  }// end if
  ?>
  </tr>
  <?
$cnt++;
  }
 ?>
  <tr > 
    <td>&nbsp;</td>
    <td colspan="5"> 
      <? 
	  if ( isset( $_REQUEST["cid"] ) && $_REQUEST["cid"]!="" )
{
	  $sql=mysql_query("Select * from sbwmd_categories where pid=" . $_REQUEST["cid"]	);
if(!($rs=mysql_fetch_array($sql)))
{ 
$rs=mysql_fetch_array(mysql_query("Select * from sbwmd_categories where id=" . $_REQUEST["cid"]));
?>
      <div align="center"><font color="#FF0000" size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>There 
        is no Sub category To Display.<br>
        <a href="software.php?cid=<? echo $_REQUEST["cid"];?>">View Softwares 
        in this category</a></strong> </font> 
        <? } }?>
      </div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
    <td colspan="5"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><a  href="addcategorydb.php?pid=<? echo $cid;?>"><strong>Add 
        New Category</strong></a></font> </div></td>
  </tr>
</table>

  <?
}// end main
include "template.php";?>
</p>
