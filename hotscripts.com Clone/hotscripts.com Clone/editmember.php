<?
include "logincheck.php";
include_once "config.php";
include_once "left_mem.php";

function main()
{
?>

<link href="../styles/style.css" rel="stylesheet" type="text/css">

<?
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_members where id=".$_SESSION["userid"]));

$len=mysql_fetch_array(mysql_query("select username_len,pwd_len from sbwmd_config"));
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


	if ( form.company_contact.value == "" )
	 {
       alert('Company contact is required!');
	   return false;
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
         if(form.state_province_non.value == "" && form.state_province.selectedIndex == 0){
           alert('You must specify a state for U.S. or state/province for non U.S.');
           return false;
           }
        if(form.phone_number.value == ""){
	   alert('Phone number is required.');
           return false; 
           }
       
   

	   if(!form.email_addr.value.match(/[a-zA-Z\.\@\d\_]/)) 
	   {
          alert('Invalid e-mail address.');
          return false;
       }
if (!emailCheck (form.email_addr.value) )
{
	return (false);
}
	
  
  if (form.pwd.value == "") {
	   alert('Password is required.');
	   return false;
	   }
 
	
  		
	if (form.pwd.value != form.pwd2.value)
	{
		alert('Passwords do not match.');
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
      </a> &gt; UPDATE PROFILE</font></strong></font>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td height="25" bgcolor="#003366"> <div align="center"><font color="#FFFFFF" size="2" ><strong>Update 
        Your Profile</strong></font></div></td>
  </tr>
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td width="80%" valign="top"><FORM name=register onsubmit=return(formValidate(this)); 
                  method=post action="updatemember.php">
        <TABLE cellSpacing=1 cellPadding=1 width=580 border=0>
          <TBODY>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Company 
                name</B></font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=120 size=25 name=company_name value="<? echo $rs0["c_name"];?>"></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Company 
                contact</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=120 size=25 name=company_contact value="<? echo $rs0["c_contact"];?>"></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Street 
                address 1</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=120 size=35 name=stadd1 value="<? echo $rs0["stadd1"];?>"></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Street 
                address 2</B></font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=120 size=35 name=stadd2 value="<? echo $rs0["stadd2"];?>"></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>City</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=120 size=35 name=city value="<? echo $rs0["city"];?>"></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>State/Province 
                </B></TD>
              <TD vAlign=center align=right><FONT color=red 
                        size=1>*&nbsp;</FONT> </TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        name=state_province_non value="<? echo $rs0["state_non_us"];?>"></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Zip/Postal 
                code</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=11 size=15 name=zip_code value="<? echo $rs0["zip"];?>"></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Country</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=20 size=15 name=phone_number value="<? echo $rs0["country"];?>"> 
              </TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Phone 
                number</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=20 size=15 name=phone_number value="<? echo $rs0["phone"];?>"></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Fax 
                number</B></font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=20 size=15 name=fax_number value="<? echo $rs0["fax"];?>"></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>E-mail 
                address</B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=99 size=25 name=email_addr value="<? echo $rs0["email"];?>"></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Home 
                page URL</B></font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><INPUT style="WIDTH: 330px; FONT-FAMILY: courier, monospace" 
                        maxLength=255 size=35  name=home_page value="<? echo $rs0["homepage"];?>"></TD>
            </TR>
            <TR> 
              <TD height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<b>Password</b></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT type=password style="FONT-FAMILY: courier, monospace" 
                        maxLength=20 size=15 name=pwd value="<? echo $rs0["pwd"];?>"> 
                &nbsp;</font></TD>
            </TR>
            <TR> 
              <TD height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Confirm 
                Password </B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT type=password style="FONT-FAMILY: courier, monospace" 
                        maxLength=20 size=15 name=pwd2 value="<? echo $rs0["pwd"];?>"> 
                &nbsp;</font></TD>
            </TR>
            <TR> 
              <td bgcolor="#f4f4f4"><b>Receive offers for other Your products 
                and services.</font></b> </td>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <td><input type=checkbox value="<? echo $rs0["recieve_offer"];?>" 
                        <? if($rs0["recieve_offer"]=='y') echo " checked ";?> name=offers> 
                &nbsp; </TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;</font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><INPUT type=submit value=Update Profile name=submit> &nbsp; 
              </TD>
            </TR>
          </TBODY>
        </TABLE>
      </form></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>

<p>&nbsp; </p>
<p><br>
 <?
}// end main
include "template1.php";
?> 

