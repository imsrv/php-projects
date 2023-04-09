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
	if ( form.url.value == "" ) {
       	   alert('Website Url is required!');
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


  
        if(form.bannerurl.value == ""){
	   alert('Banner url is required.');
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
      <strong><font color="#000000" size="2" >&gt; ADVERTISE</font></strong>
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
      <FORM name=register onsubmit=return(formValidate(this)); 
                  method=post action="advertise1.php">
        <TABLE width=95% border=0 align="center" cellPadding=1 cellSpacing=1 class="onepxtable">
          <TBODY>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Website 
                Url </B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT name=url style="FONT-FAMILY: courier, monospace" value="http://" size=25 
                        maxLength=120></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Your 
                Email </B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=120 size=25 name=email></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Banner 
                Url </B></font></TD>
              <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
              <TD><INPUT name=bannerurl style="FONT-FAMILY: courier, monospace" value="http://" size=35 
                        maxLength=120>
                <font color="#333333" >Url of your banner. It must be of 468X60 
                size</font></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;<B>Choose 
                Plan </B></font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr bgcolor="#f5f5f5"> 
                    <td width="30"><strong></strong></td>
                    <td width="250"><strong>Plan</strong></td>
                  </tr>
                  <?
$sql="select * from sbwmd_plans  ";

$rs0_query=mysql_query ($sql);
$cnt=0;
while ($rs0=mysql_fetch_array($rs0_query))
{
$cnt++;
?>
                  <tr> 
                    <td> <input name="plan" type="radio" value="<?php echo $rs0["id"]; ?>" <?php
	if ($cnt==1)
	{
	 echo " checked ";
	}
	?>
	></td>
                    <td><? echo  $rs0["credits"]; ?> Credits For $<? echo $rs0["price"]; ?></td>
                  </tr>
                  <?
 }
 ?>
                  <tr> 
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table></TD>
            </TR>
            <TR> 
              <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4">&nbsp;</font></TD>
              <TD align=right>&nbsp;</TD>
              <TD><INPUT type=submit value=Continue name=submit> &nbsp; </TD>
            </TR>
          </TBODY>
        </TABLE>
      </form></td>
  </tr>
</table>
<?
}// end main
include "template.php";
?>
