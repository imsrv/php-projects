<?
include_once("logincheck.php");
include_once("../config.php");
function main()
{


$sql="select * from sbwmd_ads  ";

$rs0_query=mysql_query ($sql);

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
		   
		   
		   if (form.credits.value==''  || isNaN(form.credits.value) || form.credits.value<=0  )
{
	alert("Please provide some non-negative numeric value  for credits");
	return (false);
}
if (form.displays.value==''  || isNaN(form.displays.value) || form.displays.value<=0  )
{
	alert("Please provide some non-negative numeric value  for displays");
	return (false);
}

		   
		   
		   
		   
		   
		   
		   
		   
		   
		   
	return true;
  }
// -->
</SCRIPT>



<FORM name=register onsubmit=return(formValidate(this)); 
                  method=post action="insertad.php">
  <br>
  <font size="2" face="Arial, Helvetica, sans-serif"><B>Add A Banner<br>
  </B></font><br>
  <TABLE class="onepxtable" cellSpacing=1 cellPadding=1 width=580 border=0>
    <TBODY>
      <TR> 
        <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<B>Website 
          Url </B></font></TD>
        <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
        <TD><INPUT name=url style="FONT-FAMILY: courier, monospace" value="http://" size=25 
                        maxLength=120></TD>
      </TR>
      <TR> 
        <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<B>Your 
          Email </B></font></TD>
        <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
        <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=120 size=25 name=email></TD>
      </TR>
      <TR> 
        <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<B>Banner 
          Url </B></font></TD>
        <TD align=right><FONT color=red 
                        size=1>*&nbsp;</FONT></TD>
        <TD><INPUT name=bannerurl style="FONT-FAMILY: courier, monospace" value="http://" size=35 
                        maxLength=120> <font color="#333333" size="2" face="Arial, Helvetica, sans-serif">Url 
          of your banner. It must be of 468X60 size</font></TD>
      </TR>
      <TR>
        <TD height="25" align=left valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif"><B>Credits</B></font></TD>
        <TD align=right>&nbsp;</TD>
        <TD><INPUT style="FONT-FAMILY: courier, monospace" 
                        maxLength=120 size=5 name=credits>
        </TD>
      </TR>
      <TR> 
        <TD width="50%" height="25" align=left valign="top" bgcolor="#f4f4f4"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Ad 
          Displays</strong></font></TD>
        <TD align=right>&nbsp;</TD>
        <TD><input name=displays style="FONT-FAMILY: courier, monospace" value="1" size=5 
                        maxlength=120>
          <br>
          <font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">This 
          is how many times the add will show in a row. If you set it to 20, then 
          the add will show 20 times before other ads in the rotation will show. 
          If you want the ad to be random and appear only once at a time then 
          set the ad display to 1. Having multiple displays is uesful if you have 
          a banner you want to display more often than others.</font></TD>
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
