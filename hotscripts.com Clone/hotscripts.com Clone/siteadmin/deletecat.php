<?

include "logincheck.php";
include_once "../config.php";
function main()
{
$sql=mysql_query("Select * from sbwmd_softwares where cid=".$_REQUEST["cid"]);
$cnt=mysql_num_rows($sql);
if(mysql_fetch_array(mysql_query("select id from sbwmd_categories where pid=".$_REQUEST["cid"])))
{
?>
<font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif">This category cannot be deleted 
  as it contains Subcategories. To delete this category you need to delete all 
  its subcategories.</font><br>
  <br>
  <input type="button" name="no2" value="Go Back" onClick="javascript:window.history.go(-1);" >
 <?
return; }// end if
else 
{
if($cnt==0)
{?>

<font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif">This 
category doesn't contains any Listings. Do you really want to delete this Catgory ? </font></p> 
<form name="form2" method="post" action="deletecategory_ad.php">
                <input name="cid" type="hidden" id="id" value="<? echo $_REQUEST["cid"];?>">
  <input type="hidden" name="pid" value="<? echo $_REQUEST["pid"];?>">

  <input type="button" name="no" value="No" onClick="javascript:window.history.go(-1);" >

  &nbsp;&nbsp;&nbsp; 
  <input type="submit" name="yes" value="Yes" >
              </form>
<?
return;
}
} 
?>
<script language="JavaScript">
<!--
function category(box)
{

str="choosecategory.php?box="  + box;

window.open(str,"Category","top=5,left=30,toolbars=no,maximize=yes,resize=yes,width=550,height=450,location=no,directories=no,scrollbars=yes");


}



//-->
</SCRIPT>
<?
if($_REQUEST["pid"]==0)
{
?>
<font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif">This 
category contains <? echo $cnt;?> Listings. You have to shift all these listings to any other category before deleting. </font></p>  
<form name="frm1" method="post" action="shiftlistings.php">
                <input name="cat1" type="hidden" id="id" >
   <input name="cid" type="hidden" id="id" value="<? echo $_REQUEST["cid"];?>">
  &nbsp;&nbsp;&nbsp; 
  <table width="80%" border="0">
    <TR vAlign=center> 
      <TD valign="top"> <DIV align=right><font color="#003399"><strong><FONT 
            size=2 face="Verdana, Arial, Helvetica, sans-serif">*Category</FONT></strong></font></DIV></TD>
      <TD valign="top"> 
          <input name = "cat_name1" type = "text" id="cat_name1"  size="45" readOnly >
          <input type="button" name=btn_name22 value="Select Category" onClick=category('1')>
          <input type="button" name="no3" value="Back" onClick="javascript:window.history.go(-1);" >
		  <input type="Submit" name="no3" value="Go" >
          <br>
          </font></div></TD>
    </TR>
  </table>
  </form>
<?
return;}// end if root
$cnt_siblings=mysql_num_rows(mysql_query("select * from sbwmd_categories where pid=".$_REQUEST["pid"]." and id<>".$_REQUEST["cid"]));

if($cnt_siblings==0)
{
?>
<font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif">This 
category contains <? echo $cnt;?> Listings. All the listings are shifted to its parent category  </font></p> 
<form name="form2" method="post" action="shiftlistings.php">
                <input name="cid" type="hidden" id="id" value="<? echo $_REQUEST["cid"];?>">
  <input type="hidden" name="pid" value="<? echo $_REQUEST["pid"];?>">

  <input type="button" name="no" value="No" onClick="javascript:window.history.go(-1);" >

  &nbsp;&nbsp;&nbsp; 
  <input type="submit" name="yes" value="Yes" >
              </form>

<?
return;}// end if not sibling
else
{
?>
<font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif">This 
category contains <? echo $cnt;?> Listings. You have to shift all these listings to any other category before deleting. </font></p>  
<form name="frm1" method="post" action="shiftlistings.php">
                <input name="cat1" type="hidden" id="id" >
   <input name="cid" type="hidden" id="id" value="<? echo $_REQUEST["cid"];?>">
  &nbsp;&nbsp;&nbsp; 
  <table width="80%" border="0">
    <TR vAlign=center> 
      <TD valign="top"> <DIV align=right><font color="#003399"><strong><FONT 
            size=2 face="Verdana, Arial, Helvetica, sans-serif">*Category</FONT></strong></font></DIV></TD>
      <TD valign="top"> 
          <input name = "cat_name1" type = "text" id="cat_name1"  size="45" readOnly >
          <input type="button" name=btn_name22 value="Select Category" onClick=category('1')>
          <input type="button" name="no3" value="Back" onClick="javascript:window.history.go(-1);" >
		  <input type="Submit" name="go" value="Go" >
          <br>
          </font></div></TD>
    </TR>
  </table>
  </form>

<?
return;}
?>
<?
}// end of main
include_once "template.php";
?>