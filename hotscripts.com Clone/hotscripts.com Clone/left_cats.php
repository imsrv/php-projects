<?
function left( $cid)
{
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));
$recperpage=$rs0["recinpanel"];

?> 
<table width="150" border="0" cellspacing="0" cellpadding="0">
  <?
if ( isset($_SESSION["userid"]) && $_SESSION["userid"]!="" )
{
?>
  <tr> 
    <td height="23"> <div align="right"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><img src="images/member.gif" width="164" height="25">&nbsp;</strong></font></div></td>
  </tr>
  <tr> 
    <td><table width="150" border="0" cellpadding="0" cellspacing="2" bordercolor="#000000">
        <tr> 
          <td > <table width="130" border="0" align="right" cellpadding="0" cellspacing="1">
              <tr> 
                <td>&nbsp;<font color="#000000" size="1" > 
                  Welcome <? echo $_SESSION["name"]; ?> </font></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="150" border="0" cellpadding="0" cellspacing="2" bordercolor="#000000">
        <tr> 
          <td > <table width="130" border="0" align="right" cellpadding="0" cellspacing="1">
              <tr> 
                <td>&nbsp;<a href="userhome.php" class="sidelink"><font size="1" > 
                  Members Area</font></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="150" border="0" cellpadding="0" cellspacing="2" bordercolor="#000000">
        <tr> 
          <td > <table width="130" border="0" align="right" cellpadding="0" cellspacing="1">
              <tr> 
                <td>&nbsp;<a href="logout.php" class="sidelink"><font size="1" > 
                  Logout</font></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <?
  }
  ?>
  <tr> 
    <td height="23"> <div align="right"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
        <img src="images/subcategories.gif" width="163" height="25"> </strong></font></div></td>
  </tr>
  <tr> 
    <td><table width="150" border="0" cellpadding="1" cellspacing="0" bordercolor="#000000">
        <?
			  $cats1=mysql_query("select * from sbwmd_categories where pid=$cid ");
			  $cnt=1;
			  while($rst=mysql_fetch_array($cats1))
			  {			  
			  ?>
        <tr> 
          <td > <table width="130" border="0" align="right" cellpadding="0" cellspacing="1">
              <tr> 
                <td>&nbsp;<a   class="sidelink" href="showcategory.php?cid=<? echo $rst["id"]?>"><? echo $rst["cat_name"]; ?></a><font color="#FF0000" size="3" face="Times New Roman, Times, serif"><font color="#FFFFFF" size="1" >( 
                  <?php
///////////////////////////////////////////////
///////////////////////////////////////////////
///////////////////////////////////////////////			  

/// GENERATE CLIST ////////////////////////////////////////////			  
	$rst1_query=mysql_query("Select * from sbwmd_categories where pid=" . $rst["id"] );
	$clist=$rst["id"];
	while ( $rst1=mysql_fetch_array($rst1_query) )
	{
 	$clist.="," . $rst1["id"];
	while ( $rst1=mysql_fetch_array($rst1_query) )
	{ 
	$clist.="," . $rst1["id"];
	}
    
	$rst1_query=mysql_query("Select * from sbwmd_categories where pid IN (" . $clist . ") and id not in ( ". $clist . ")") ;
}
/// CLIST GENERATED /////////////////////////////////////////



$rst1_query=mysql_query("Select count(*)  from sbwmd_softwares where approved='yes' and cid in (" . $clist . ")"   );
$rst1=mysql_fetch_array($rst1_query);

$items=$rst1[0]  ;
echo  $items ;		  


////////////////////////////////////////////
////////////////////////////////////////////
////////////////////////////////////////////
?>
                  )</font></font></td>
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
    <td height="23"><div align="right"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/latest.gif" width="163" height="25"></font></div></td>
  </tr>
  <tr> 
    <td><table width="150" border="0" cellpadding="1" cellspacing="0" bordercolor="#000000">
        <?
			  
$sql="select id,s_name from sbwmd_softwares where approved='yes' ";		  
			  
			  if ($cid<>0)
{
///////////////////////////////////////////////			  
/// GENERATE CLIST ////////////////////////////////////////////			  
	$rst1_query=mysql_query("Select * from sbwmd_categories where pid=" . $cid );
	$clist=$cid;
	while ( $rst1=mysql_fetch_array($rst1_query) )
	{
 	$clist.="," . $rst1["id"];
	while ( $rst1=mysql_fetch_array($rst1_query) )
	{ 
	$clist.="," . $rst1["id"];
	}
    
	$rst1_query=mysql_query("Select * from sbwmd_categories where pid IN (" . $clist . ") and id not in ( ". $clist . ")") ;
}
/// CLIST GENERATED /////////////////////////////////////////

//echo "[" .  $clist . "]";
$sql.=" and cid in (" . $clist . ") "  ;
////////////////////////////////////////////
}

$sql.=" order by date_approved desc";
$latest=mysql_query($sql);
			  $cnt=1;
			  while( ( $rst=mysql_fetch_array($latest)  )  && ($cnt<=$recperpage) )  
			  {			  
			  ?>
        <tr> 
          <td > <table width="130" border="0" align="right" cellpadding="0" cellspacing="1">
              <tr> 
                <td>&nbsp;<a  class="sidelink"  href="software-description.php?id=<? echo $rst["id"];?>"><? echo $rst["s_name"];?></a></td>
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
    <td height="23"><div align="right"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><img src="images/popular.gif" width="164" height="25"></font></div></td>
  </tr>
  <tr> 
    <td><table width="150" border="0" cellpadding="1" cellspacing="0" bordercolor="#000000">
        <?

$sql="select id,s_name from sbwmd_softwares where approved='yes' ";		  
			  
			  if ($cid<>0)
{
///////////////////////////////////////////////			  
/// GENERATE CLIST ////////////////////////////////////////////			  
	$rst1_query=mysql_query("Select * from sbwmd_categories where pid=" . $cid );
	$clist=$cid;
	while ( $rst1=mysql_fetch_array($rst1_query) )
	{
 	$clist.="," . $rst1["id"];
	while ( $rst1=mysql_fetch_array($rst1_query) )
	{ 
	$clist.="," . $rst1["id"];
	}
    
	$rst1_query=mysql_query("Select * from sbwmd_categories where pid IN (" . $clist . ") and id not in ( ". $clist . ")") ;
}
/// CLIST GENERATED /////////////////////////////////////////
//echo "[" .  $clist . "]";
$sql.=" and cid in (" . $clist . ") "  ;
////////////////////////////////////////////
}

$sql.=" order by popularity desc";
$mostpop=mysql_query($sql);


			  $cnt=1;
			  while( ( $rst=mysql_fetch_array($mostpop) )  && ($cnt<=$recperpage)  )
			  {			  
			  ?>
        <tr> 
          <td > <table width="130" border="0" align="right" cellpadding="0" cellspacing="1">
              <tr> 
                <td>&nbsp;<a  class="sidelink"  href="software-description.php?id=<? echo $rst["id"];?>"><? echo $rst["s_name"];?></a></td>
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
</table>
<?
}// end left
?>
