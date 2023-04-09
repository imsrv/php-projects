<?
include_once "config.php";
include_once "left_index.php";
include_once "right_index.php";
function main()
{
?>


</style>

<SCRIPT language=javascript>

	  
function validate() {
	if (isNaN (document.EnrollmentForm.amount.value) || document.EnrollmentForm.amount.value == ''){
		alert('Please enter numeric value for amount to be added.');
		document.EnrollmentForm.amount.select();
		document.EnrollmentForm.amount.focus();
		return false;
	}
	
	return true;

}
	  


</SCRIPT>
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td></td>
  </tr>
  <tr> 
    <td height="25"> <a href="index.php"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#000000">HOME</font></strong></font></a> 
      <strong><font color="#000000" size="2" >&gt; LOST PASSWORD</font></strong>
      <hr size="1"></td>
  </tr>
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
      <form name="frm1" method="post" action="sendpassword.php"  onSubmit="return Validator();">
        <table width="350" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Email 
              </font></strong></td>
            <td><input name="email" type="text" id="email6"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><input type="submit" name="Submit" value="Retrieve password" class="input"></td>
          </tr>
        </table>
        <strong><font color="#000000"> </font></strong> </form> </td>
  </tr>
</table>
<p>&nbsp; </p>
<p><br>
  
  <?
  }// end sub 
include "template.php";
?>