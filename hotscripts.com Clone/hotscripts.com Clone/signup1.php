<?
include_once "config.php";
include_once "left_index.php";
include_once "right_index.php";

function main()
{
/////////////getting length of user name and password
$len=mysql_fetch_array(mysql_query("select username_len,pwd_len from sbwmd_config"));
$username_len=$len["username_len"];
$pwd_len=$len["pwd_len"];
?>

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


  function formValidate(form) {
	if ( form.company_contact.value == "" ) {
       	   alert('Company contact is required!');
	   return false;
	   }
        if(!form.email_addr.value.match(/[a-zA-Z\.\@\d\_]/)) {
           alert('Invalid e-mail address.');
           return false;
           }

if (!emailCheck (form.email_addr.value) )
{
	return (false);
}

  
        if(form.stadd1.value == ""){
	   alert('Street address 1 is required.');
           return false; 
           }
        if(form.city.value == ""){
	   alert('City is required.');
           return false; 
           }
        if(form.zip_code.value == ""){
	   alert('Zip/postal code is required.');
           return false; 
           }
        if(form.country.selectedIndex == 0){
	   alert('Country is required.');
           return false; 
           }
        if(form.state_province_non.value == "" && form.state_province.selectedIndex == 0){
           alert('You must specify a state for U.S. or state/province for non U.S.');
           return false;
           }
        if(form.phone_number.value == ""){
	   alert('Phone number is required.');
           return false; 
           }
    
		if (form.username.value == "") {
	   alert('Username is required.');
	   return false;
	   }
	   if (form.username.value.length<'<? echo $username_len?>') {
	   alert('Username must be greater than <? echo $username_len;?> characters.');
	   return false;
	   }
  if (form.pwd.value == "") {
	   alert('Password is required.');
	   return false;
	   }
  if (form.pwd.value.length<'<? echo $pwd_len?>') {
	   alert('Password must be more than <? echo $pwd_len;?>  characters long.');
	   return false;
	   }		
	if (form.pwd.value != form.pwd2.value)
	{
		alert('Passwords do not match.');
		return false;
	}

	    if(form.agreement_conf[1].checked) { 
           alert(' You must agree to the Registration Agreement'); 
           return false; 
           }
	return true;
  }
// -->
</SCRIPT>
<table width="430" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td></td>
  </tr>
  <tr> 
    <td height="25"> <a href="index.php"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#000000">HOME</font></strong></font></a> 
      <strong><font color="#000000" size="2" >&gt; SIGN UP</font></strong>
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

$invalidaccess="No";
if( !isset($_REQUEST["rnum"]) || !isset($_REQUEST["email"] ) )
{
$invalidaccess="Yes";
}
else
{
$rs0_query=mysql_query ("select * from sbwmd_signups where email='" . $_REQUEST["email"]. "' and rnum='" . $_REQUEST["rnum"]. "' ");
if ($rs0=mysql_fetch_array($rs0_query))
{}else
{
$invalidaccess="Yes";
}
}
if ($invalidaccess=="Yes")
{
?>
      <table align="center" bgcolor="#FEFCFC"   border="0" cellpadding="5" >
        <tr> 
          <td><b><font face="verdana, arial" size="1" color="#666666"> 
     Invalid Access
            </font></b></td>
        </tr>
      </table> 
      <?
}
else
{
?>
      <FORM name=register onsubmit=return(formValidate(this)); 
                  method=post action="insertmember.php">
        <TABLE class="onepxtable" cellSpacing=1 cellPadding=1 width=400 border=0>
          <TBODY>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Company 
                name</B></font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=120 size=25 name=company_name></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Company 
                contact</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=120 size=25 name=company_contact></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Street 
                address 1</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=120 size=35 name=stadd1></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Street 
                address 2</B></font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=120 size=30 name=stadd2></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>City</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=120 size=30 name=city></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>State/Province</B></TD>
              <TD vAlign=center align=right><FONT color=red 
                        size=1>*&nbsp;</FONT> </TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        name=state_province_non></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Zip/Postal 
                code</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=11 size=15 name=zip_code></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Country</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=20 size=15 name=phone_number> </TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Phone 
                number</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=20 size=15 name=phone_number></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Fax 
                number</B></font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=20 size=15 name=fax_number></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>E-mail 
                address</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=99 size=25 name=email_addr readonly value="<?php echo $_REQUEST["email"] ?>"></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Home 
                page URL</B></font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><INPUT 
                        style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=255 size=30 value=http:// 
name=home_page></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Username</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=20 size=15 name=username> &nbsp;</font></TD>
            </TR>
            <TR> 
              <TD height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<b>Password</b></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT type=password style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=20 size=15 name=pwd> &nbsp;</font></TD>
            </TR>
            <TR> 
              <TD height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Confirm 
                Password </B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT type=password style="FONT-FAMILY: Tahoma, Arial, Verdana" 
                        maxLength=20 size=15 name=pwd2> &nbsp;</font></TD>
            </TR>
            <TR> 
              <td bgcolor="#f4f4f4"><b>&nbsp;Receive offers on other &nbsp;products 
                and services.</b> </font></td>
              <TD align=right><FONT color=red 
                        size=1>&nbsp;</FONT></TD>
              <td><input type=checkbox checked value=y 
                        name=offers> &nbsp; </TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Registration 
                Agreement</B></font></TD>
              <TD align=right>&nbsp;</TD>
              <TD> <TEXTAREA style="FONT-FAMILY: Tahoma, Arial, Verdana" name=agreement rows=10 cols=30>   
					  <?
					  $agreement=mysql_fetch_array(mysql_query("select agreement from sbwmd_config"));
					  echo str_replace("\n","<br>",$agreement["agreement"]);
					  ?>
   </TEXTAREA> </font></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Do 
                you agree to the Registration Agreement?</B></font></TD>
              <TD align=right>&nbsp;</TD>
              <TD> <INPUT type=radio value=y 
                        name=agreement_conf>
                Yes&nbsp; <INPUT type=radio CHECKED 
                        value=n name=agreement_conf>
                No&nbsp; </font></TD>
            </TR>
            <TR> 
              <TD width="200" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;</font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><INPUT type=submit value=Submit name=submit> &nbsp; <INPUT type=reset value=Reset name=reset></TD>
            </TR>
          </TBODY>
        </TABLE>
      </form>
	  <?
	  }
	  ?>
	   </td>
  </tr>
</table>
<?
}// end main
include "template.php";
?>
