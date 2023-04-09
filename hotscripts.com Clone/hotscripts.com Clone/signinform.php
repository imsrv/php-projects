<?php
include_once "config.php";
include_once "left_index.php";
include_once "right_index.php";
function main()
{
?>
<style type="text/css">

</style>
  <SCRIPT language=javascript>
function submit_check() {
	  loginForm.submit();
}

</SCRIPT>
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td></td>
  </tr>
  <tr>
    <td height="25"> <a href="index.php"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#000000">HOME</font></strong></font></a> 
      <strong><font color="#000000" size="2" >&gt; MEMBER LOGIN</font></strong>
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
      <FORM name=loginForm  action="login.php"
      method=post>
        <div align="center"></div>
        <TABLE cellSpacing=0 cellPadding=5 align=center border=0>
          <TBODY>
            <TR vAlign=center> 
              <TD>&nbsp;</TD>
            </TR>
            <TR vAlign=center bgcolor="#003366"> 
              <TD colspan="2"><font color="#ffffff" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Member 
                Login</strong></font></TD>
            </TR>
            <TR vAlign=center> 
              <TD> <DIV align=right><strong><FONT color="#004080" 
            size=2 face="Verdana, Arial, Helvetica, sans-serif">Username</FONT></strong></DIV></TD>
              <TD><INPUT  class="box1"  name=UserName></TD>
            </TR>
            <TR vAlign=center> 
              <TD> <DIV align=right><strong><FONT color="#004080" 
            size=2 face="Verdana, Arial, Helvetica, sans-serif">Password</FONT></strong></DIV></TD>
              <TD><INPUT  class="box1"  type=password name=Password></TD>
            </TR>
            <TR align=right> 
              <TD 
        colSpan=2><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td width="67%"><p><a  class="insidelink"  href="signup.php">Signup 
                        Now</a><br>
                        <a class="insidelink" href="lostpassword.php">Lost Username/Password</a></p></td>
                    <td width="33%"> <div align="left"> 
                        <input type="submit" name="Submit" value="Sign In" class="input">
                      </div></td>
                  </tr>
                </table></TD>
            </TR>
            <TR align=right> 
              <TD colSpan=2>&nbsp; </TD>
            </TR>
          </TBODY>
        </TABLE>
        <div align="center"></div>
      </FORM></td>
  </tr>
</table>
<p>&nbsp; </p>
<p><br>
  
<? 
}// end of main()
include "template.php";?>
