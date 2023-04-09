<? 
include "logincheck.php";
function main() 
{
?> 
<SCRIPT language=javascript>
  
function validate() 
{
  if (frm1.id.selectedIndex==0)
  {
	alert('Please Choose a Category to remove');
	document.frm1.id.focus();
	return (false);
  }
 
  return (true);
}

</SCRIPT>

<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td> </td>
  </tr>
  <tr> 
    <td> 
      <?

  if (isset($_REQUEST["msg"])&&$_REQUEST["msg"]<>"") 
  {
  ?>
      <table width="380" border="0" cellspacing="0" cellpadding="5">
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table>
      <?
		 }//end if 
		?>
    </td>
  </tr>
  <tr> 
    <td> <FORM name=frm1 onsubmit="return validate();" action=deletecategory.php 
      method=post>
        <TABLE width="347" border=0 align=center cellPadding=5 cellSpacing=0>
          <TBODY>
            <TR vAlign=center> 
              <TD width=30 rowSpan=10>&nbsp;</TD>
              <TD>&nbsp;</TD>
            </TR>
            <TR vAlign=center> 
              <TD colspan="2"><div align="center"><strong><font color="#993300" size="3" face="Verdana, Arial, Helvetica, sans-serif">REMOVE 
                  CATEGORY</font></strong></div></TD>
            </TR>
            <TR vAlign=center> 
              <TD valign="top"> <DIV align=right><strong><FONT color="#CC9933" 
            size=2 face="Verdana, Arial, Helvetica, sans-serif">*Category</FONT></strong></DIV></TD>
              <TD> <font color="#333333" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="id" class="box1">
                  <?
$sql=mysql_query("select * from sbppc_categories,sbppc_catbids where sbppc_categories.id = sbppc_catbids.cid and uid=".$_REQUEST["id"]);
			       ?>
                  <option value="">Select Category</option>
                  <?
				  while ($rs_t=mysql_fetch_array($sql))
				  {
				 ?>
                  <option value="<? echo $rs_t["id"];?>"><? echo $rs_t["cat_name"];?>(<? echo $rs_t["bid"];?>)</option>
                  <?
       			  }//				  wend			 
				 ?>
                </select>
                <br>
                (Please Choose the Category you want to remove)<br>
                </font></TD>
            </TR>
            <TR vAlign=center> 
              <TD colspan="2"> <div align="left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> 
                  <input type="submit" name="Submit" value="Remove Category">
                </div></TD>
            </TR>
            <TR align=right> 
              <TD 
        colSpan=2> </a> </TD>
            </TR>
            <TR align=right> 
              <TD colSpan=2>&nbsp; </TD>
            </TR>
          </TBODY>
        </TABLE>
      </FORM></td>
  </tr>
</table>
<p>&nbsp; </p>
<p><br>
<?
}// end main
include "template.php";
?>

  
