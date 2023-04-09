<?
include_once("logincheck.php");
include_once("../config.php");
function main()
{


$sql="select * from sbwmd_banners  ";

$rs0_query=mysql_query ($sql);

?>


<FORM name=register method=post action="link_insertad.php">
  <p><br>
    <font size="2" face="Arial, Helvetica, sans-serif"><B>Add A Link to Us Banner</B></font></p>
  <p><font size="2" face="Arial, Helvetica, sans-serif">Upload your banners to 
    the banner directory and enter the file name after banners/ below.<br>
    </font><br>
  </p>
  <TABLE class="onepxtable" cellSpacing=1 cellPadding=1 width=580 border=0>
    <TBODY>
      <TR> 
        <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif"><B>Banner 
          Url </B></font></TD>
        <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
        <TD><INPUT name=img_url style="FONT-FAMILY: courier, monospace" value="banners/" size=35 
                        maxLength=120>
        </TD>
      </TR>
      <TR> 
        <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></TD>
        <TD align=right>&nbsp;</TD>
        <TD><INPUT type=submit value=Continue name=submit> &nbsp; </TD>
      </TR>
    </TBODY>
  </TABLE>
</form>
<br>
<?
}//main()
include "template.php";
?>
