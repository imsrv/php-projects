<?
include "logincheck.php";
include_once "config.php";
include_once "left_mem.php";

function main()
{
?>

<link href="../styles/style.css" rel="stylesheet" type="text/css">
<SCRIPT language=javascript> 
<!--
 function emailCheck (emailStr) {
var emailPat=/^(.+)@(.+)$/
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
var validChars="\[^\\s" + specialChars + "\]"
var quotedUser="(\"[^\"]*\")"
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
var atom=validChars + '+'
var word="(" + atom + "|" + quotedUser + ")"
var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")
var matchArray=emailStr.match(emailPat)
if (matchArray==null) {
	alert("Email address seems incorrect (check @ and .'s)")
	return false
}
var user=matchArray[1]
var domain=matchArray[2]
if (user.match(userPat)==null) {
    alert("The username doesn't seem to be valid.")
    return false
}
var IPArray=domain.match(ipDomainPat)
if (IPArray!=null) {
    // this is an IP address
	  for (var i=1;i<=4;i++) {
	    if (IPArray[i]>255) {
	        alert("Destination IP address is invalid!")
		return false
	    }
    }
    return true
}
var domainArray=domain.match(domainPat)
if (domainArray==null) {
	alert("The domain name doesn't seem to be valid.")
    return false
}
var atomPat=new RegExp(atom,"g")
var domArr=domain.match(atomPat)
var len=domArr.length
if (domArr[domArr.length-1].length<2 || 
    domArr[domArr.length-1].length>3) {
   alert("The address must end in a three-letter domain, or two letter country.")
   return false
}
if (len<2) {
   var errStr="This address is missing a hostname!"
   alert(errStr)
   return false
}
return true;
}

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
		
		if (!emailCheck (form.email.value) )
{
	return (false);
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
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow">
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td height="25"><font color="#000000"><strong>&nbsp;<a href="index.php"  class="barlink">HOME </font> 
      </a> &gt; CONTACT US</font></strong></font></td>
  </tr>
  <tr> 
    <td valign="top"><form name="form" onSubmit="return Validate(this);" action="insertmem_fb.php" method="post">
        <input type="hidden" name="uid" value="<? echo $_SESSION["userid"];?>">
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
              <textarea name="comments" cols="33" rows="10" style="font-family: courier,monospace;"></textarea>
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
}// end main
include "template1.php";
?> 

