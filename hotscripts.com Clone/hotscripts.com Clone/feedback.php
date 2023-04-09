<?php
include_once "config.php";
include_once "left_index.php";
include_once "right_index.php";
function main()
{
?>
<SCRIPT language=javascript> 
<!--
  function Validate(form) {
	if ( form.fname.value == "" ) {
       	   alert('First Name is required!');
	   return false;
	   }
	if ( form.lname.value == "" ) {
       	   alert('Last Name is required!');
	   return false;
	   }
        if(!form.email.value.match(/[a-zA-Z\.\@\d\_]/)) {
           alert('Invalid e-mail address.');
           return false;
           }
		   if (form.title.value == "") {
	   alert('Enter the title.');
	   return false;
	   }
	if (form.comments.value == "") {
	   alert('Give Your Suggestions.');
	   return false;
	   }
	   return true;
  }
// -->
</SCRIPT>
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td></td>
  </tr>
  <tr> 
    <td height="25"> <a href="index.php"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#000000">HOME</font></strong></font></a> 
      <strong><font color="#000000" size="2" >&gt; FEEDBACK</font></strong>
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
      <form name="form" onSubmit="return Validate(this);" action="insert_fb.php" method="post">
        <table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr> 
            <td colspan="3">&nbsp;</td>
          </tr>
          <tr> 
            <td width="50%" height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>First 
              Name </b></font></td>
            <TD align=right valign="top"><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
            <td>  
              <input type="text" name="fname" style="font-family: courier,monospace;" MAXLENGTH="120" SIZE="35" value="">
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Last 
              Name</b></font></td>
            <TD align=right valign="top"><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
            <td>  
              <input type="text" name="lname" style="font-family: courier,monospace;" MAXLENGTH="120" SIZE="35" value="">
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Email</b></font></td>
            <TD align=right valign="top"><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
            <td>  
              <input type="text" name="email" style="font-family: courier,monospace;" MAXLENGTH="120" SIZE="35" value="">
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Url</b></font></td>
            <TD align=right valign="top"><FONT color=red 
                        size=2 >&nbsp;</FONT></TD>
            <td>  
              <input type="text" name="url" style="font-family: courier,monospace;" MAXLENGTH="120" SIZE="35" value="">
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Title</b></font></td>
            <TD align=right valign="top"><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
            <td>  
              <input type="text" name="title" style="font-family: courier,monospace;" MAXLENGTH="120" SIZE="35" value="">
              </font></td>
          </tr>
          <tr> 
            <td height="25" align="left" valign="top" bgcolor="#f4f4f4">&nbsp;<b>Comment 
              / Feedback</b></font></td>
            <TD align=right valign="top"><FONT color=red 
                        size=2 >*&nbsp;</FONT></TD>
            <td>  
              <textarea name="comments" cols="35" rows="10" style="font-family: courier,monospace;"></textarea>
              </font></td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#f4f4f4">&nbsp;</font></td>
            <td>&nbsp;</font></td>
            <td> 
              <INPUT type=submit value=Submit name=submit>
              </font></td>
          </tr>
        </table>
      </form></td>
  </tr>
</table>
<p>&nbsp; </p>
<p><br>
  
<? 
}// end of main()
include "template.php";?>
