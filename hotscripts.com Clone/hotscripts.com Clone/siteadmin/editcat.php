<?
include_once "../config.php";
include "logincheck.php";
function main()
{?>

<SCRIPT language=javascript>
function attachment(box)
{
str="fileupload.php?box="  + box;

window.open(str,"Attachment","top=5,left=30,toolbars=no,maximize=yes,resize=yes,width=550,height=450,location=no,directories=no,scrollbars=yes");
}

function removeattachment(box)
{
window.document.form123.list1.value=""
}

	  
function validate() {
	if (document.form123.catname.value == ''){
		alert('Please enter the category name.');
		return false;
	}
	
	return true;

}
</SCRIPT>
<table width="500" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td>&nbsp; </td>
  </tr>
  <tr bgcolor="#cccccc"> 
    <td colspan="6" bgcolor="#cccccc"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
	</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td> <FORM name=form123 onsubmit="return validate();" action=updatecategory.php 
      method=post>
        <div align="center"> 
          <TABLE width="465" border=0 align=center cellPadding=5 cellSpacing=0>
            <TBODY>
              <TR vAlign=center> 
                <TD width="91"><input type="hidden" name="pid" value="<? echo $_REQUEST["pid"];?>"> 
                  <input type="hidden" name="cid" value="<? echo $_REQUEST["cid"];?>"></TD>
              </TR>
              <TR vAlign=center> 
                <TD> <DIV align=right><strong><FONT color="#FF0000" 
            size=2 face="Verdana, Arial, Helvetica, sans-serif">*</FONT><FONT color="#004080" 
            size=2 face="Verdana, Arial, Helvetica, sans-serif">Category Name 
                    </FONT></strong></DIV></TD>
                <TD width="354"> 
                  <?
					$rs=mysql_fetch_array(mysql_query("Select * From sbwmd_categories where id=".$_REQUEST["cid"]));
				 ?>
                  <INPUT name=catname class="box1" value="<? echo $rs["cat_name"];?> "> 
                </TD>
              </TR>
              <TR vAlign=center>
                <TD><div align="right"><strong><FONT color="#004080" 
            size=2 face="Verdana, Arial, Helvetica, sans-serif">Image</FONT></strong></div></TD>
                <TD><font size="2" face="Arial, Helvetica, sans-serif" color="#666666">
                  <input name = "list1" type = "text" id="list1" value="<?php echo $rs["cat_img"]; ?>" size="20" readOnly >
                  <input type=BUTTON name=btn_name2 value="Attach" onClick=attachment('list1')>
                  <input type=BUTTON name=buttonname2 value="Remove" onClick=removeattachment()>
                  </font><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;</font></TD>
              </TR>
              <TR align=right> 
                <TD 
        colSpan=2> <div align="center"> 
                    <input type="submit" name="Submit" value="Update Category">
                  </div></TD>
              </TR>
              <TR align=right> 
                <TD colSpan=2>&nbsp; </TD>
              </TR>
            </TBODY>
          </TABLE>
        </div>
      </FORM></td>
  </tr>
</table>
 <?
}// end main
include "template.php";?>
