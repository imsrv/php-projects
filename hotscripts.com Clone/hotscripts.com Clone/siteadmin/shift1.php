
<script language="JavaScript">
<!--
function category(box)
{

str="choosecategory.php?box="  + box;

window.open(str,"Category","top=5,left=30,toolbars=no,maximize=yes,resize=yes,width=550,height=450,location=no,directories=no,scrollbars=yes");


}



//-->
</SCRIPT>
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