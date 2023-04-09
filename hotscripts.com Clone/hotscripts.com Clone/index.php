<?
include_once "config.php";
include_once "left_index.php";
include_once "right_index.php";
function main()
{
?>
<table width="420" border="0" align="center" cellpadding="0" cellspacing="0" dwcopytype="CopyTableCell">
  <tr> 
    <td valign="top"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr> 
          <td> 
            <?
if ( isset($_REQUEST["msg"])&&$_REQUEST['msg']<>"")
{
?>
            <br> <table align="center" bgcolor="#FEFCFC"   border="0" cellpadding="5" >
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
?>
          </td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><form name="form2" method="post" action="showcategory.php">
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr> 
                  <td width="17%"><FONT color=#000000><strong><font color="#000000" size="2" >SEARCH</font></strong></FONT></td>
                  <td width="31%"><input type="text" name="keyword"></td>
                  <td width="24%"><select name="cid">
                      <?
			  $cats=mysql_query("select * from sbwmd_categories where pid=0");
			  while($rst=mysql_fetch_array($cats))
			  {
			  		  ?>
                      <option value="<? echo $rst["id"]; ?>"><? echo $rst["cat_name"]; ?></option>
                      <?
					}//end while
					 ?>
                    </select></td>
                  <td width="28%"><input type="submit" name="Submit2" value="Go" class="input"></td>
                </tr>
              </table>
            </form></td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0" bordercolor="#000000">
              <tr> 
                <td height="25" background="images/bargb.gif"> <div align="left"><FONT color=#000000><strong>&nbsp;<font color="#FFFFFF" face="Tahoma, Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;<font color="#000000">Software 
                    Categories </font></font></strong></FONT></div></td>
              </tr>
              <tr> 
                <td bgcolor="#F3F3F3"><table width="100%" border="0" cellspacing="2" cellpadding="1">
                    <?
			  $cats1=mysql_query("select * from sbwmd_categories where pid=0 ");
			  $cnt=1;
			  while($rst=mysql_fetch_array($cats1))
			  {
			  if(($cnt%2)==1)
			  {	
			  		  
			  ?>
                    <tr> 
                      <? } //end if?>
                      <td width="50%" bgcolor="#FFFFFF" > <table width="100%">
                          <tr> 
                            <td width="55"> <img src="images/folder.gif" width="50" height="45"></td>
                            <td> <div align="justify"><font color="#FF0000" size="3"> 
                                <strong> <a href="showcategory.php?cid=<? echo $rst["id"]?>"  class="biglink" ><? echo $rst["cat_name"]; ?></a> 
                                </strong> <font color="#666666" size="1"><br>
                                ( 
                                <?php
///////////////////////////////////////////////
///////////////////////////////////////////////
/// GENERATE CLIST ////////////////////////////////////////////			  
	$rst1_query=mysql_query("Select * from sbwmd_categories where pid=" . $rst["id"]);
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

//echo "[" .  $clist . "]";


$rst1_query=mysql_query("Select count(*)  from sbwmd_softwares where approved='yes' and cid in (" . $clist . ")"   );
$rst1=mysql_fetch_array($rst1_query);

$items=$rst1[0]  ;
echo  $items ;		  
////////////////////////////////////////////
////////////////////////////////////////////
////////////////////////////////////////////
?>
                                resources)</font></font> </div></td>
                          </tr>
                        </table></td>
                      <? if(($cnt%2)==0)
			  {			  
			  ?>
                    </tr>
                    <? } //end if?>
                    <?
				$cnt++;
				}//end while
				?>
                  </table> </td>
              </tr>
            </table></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
        <tr> 
          <td height="25" background="images/bargb.gif"> <div align="left"><FONT color=#000000><strong><font color="#000000" face="Tahoma, Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp; 
              &nbsp;Featured Resources</font></strong></FONT></div></td>
        </tr>
        <tr> 
          <td bgcolor="#f3f3f3" ><table width="100%" border="0" cellspacing="2" cellpadding="1">
              <?
			  $featured_sites=mysql_query("select * from sbwmd_featuredads ");
			  $cnt=0;$num=0;
			  while($rst=mysql_fetch_array($featured_sites))
			  {
			  if(($cnt%2)==1)
			  {	
			  $num++;		  
			  ?>
              <tr> 
                <? } //end if?>
                <td width="100%" bgcolor="#ffffff"> <div align="justify">
                    <a   class="insidelink" href="<? echo $rst["url"]; ?>" target="_blank"><? echo $rst["name_url"]; ?></a><br>
                    <font color="#666666"> <? echo str_replace("\n","<br>",$rst["fd_desc"]); ?></font></div><BR></td>
                <? if(($cnt%2)==0)
			  {			  
			  ?>
              </tr>
              <? } //end if?>
              <?
				$cnt++;
				}//end while
				?>
            </table></td>
        </tr>
      </table>
      <br>
    </td>
  </tr>
</table>
<?
}// end main
?>
<?

include_once "template.php";
?>