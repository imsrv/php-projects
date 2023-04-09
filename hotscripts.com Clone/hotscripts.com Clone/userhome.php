<?
include "logincheck.php";
include_once "config.php";
include_once "left_mem.php";

function main()
{
?>

                  <SCRIPT language=javascript> 
<!--
  function formValidate(form) {
	if ( form.company_contact.value == "" ) {
       	   alert('Company contact is required!');
	   return false;
	   }
        if(!form.email_addr.value.match(/[a-zA-Z\.\@\d\_]/)) {
           alert('Invalid e-mail address.');
           return false;
           }
	if (form.username.value == "") {
	   alert('Username is required.');
	   return false;
	   }
        if(form.street_addr_1.value == ""){
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
        if(form.agreement_conf[1].checked) { 
           alert(' You must agree to the Registration Agreement before Tucows can create an account for you. This agreement simply gives us permission to host your application on our site. You are in no way giving us exclusive rights to your software, your soul, or your first-born child. '); 
           return false; 
           }
	return true;
  }
// -->
</SCRIPT>
</head>

<body>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td height="25"><strong>&nbsp;<a href="index.php"  class="barlink"><font color="#000000">HOME 
      </font></font></a> <font color="#000000">&gt; MEMBER HOME </font></strong><font color="#000000">&nbsp;</font></font>
      <hr size="1"></td>
  </tr>
  <tr> 
    <td valign="top">&nbsp;</td>
  </tr>
  <tr> 
    <td width="80%" valign="top">
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
    </td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
<?
}// end main
include "template1.php";
?>