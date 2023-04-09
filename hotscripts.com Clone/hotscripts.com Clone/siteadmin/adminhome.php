<?
include "logincheck.php";

function main()
{
?> 
<?
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
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableCell">
  <tr>
    <td valign="top">&nbsp; </td>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp; </td>
  </tr>
</table>
<?
}// end main
?>
<?

include_once "template.php";
?>