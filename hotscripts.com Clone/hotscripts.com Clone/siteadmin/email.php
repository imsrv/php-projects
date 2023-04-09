<?
include_once "logincheck.php"; 
include_once "../config.php";
function main()
{
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));

?>
<script language="JavaScript">
<!--
function Validate()
{
if (form123.email.value=='')
{
	alert("To Email cannot be left blank");
	document.form123.email.focus();
	return (false);
}

if (form123.from.value=='')
{
	alert("From email cannot be left blank");
	document.form123.from.focus();
	return (false);
}

if (form123.subject.value=='')
{
	alert("Subject cannot be left blank");
	document.form123.subject.focus();
	return (false);
}

if (form123.message.value=='')
{
	alert("Message cannot be left blank");
	document.form123.message.focus();
	return (false);
}


return(true);
}

//-->
</script>

<table width="700" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td colspan="2"><div align="center"></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Send 
      Mail </strong></font></td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr> 
    <td width="615" bgcolor="#FFFFFF"><font color="#666666" size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font>
      <form action="sendmessageone.php" method="post" name="form123" id="form123" onsubmit="return Validate();">
        <div align="center"> <font color="#FF0000" size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
          </font><br>
          <table width="425" border="0" cellspacing="10" cellpadding="0">
            <tr bgcolor="#666666"> 
              <td height="25" colspan="2"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp;SEND 
                Mail </font></strong></td>
            </tr>
            <tr> 
              <td width="130" bgcolor="#f5f5f5"><b><font size="2" face="Arial, Helvetica, sans-serif">To:</font></b></td>
              <td> <input name="email" type="text" value="<? 
			  if ( isset($_REQUEST["id"]))
			  {echo $_REQUEST["id"]; }
			  
			  ?>" size="24" border="0"> 
              </td>
            </tr>
            <tr> 
              <td bgcolor="#f5f5f5"><b><font size="2" face="Arial, Helvetica, sans-serif">From:</font></b></td>
              <td><input name="from" type="text" value="<? echo $rs0["admin_email"];?>" size="24" border="0"></td>
            </tr>
            <tr> 
              <td bgcolor="#f5f5f5"><b><font size="2" face="Arial, Helvetica, sans-serif">Subject 
                :</font></b></td>
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td colspan="2"><input name="subject" type="text" size="50" border="0"></td>
            </tr>
            <tr> 
              <td width="130" bgcolor="#f5f5f5"><b><font size="2" face="Arial, Helvetica, sans-serif">Message:</font></b></td>
              <td>&nbsp; </td>
            </tr>
            <tr> 
              <td colspan="2"><textarea name="message" cols="45" rows="12" id="textarea" border="0"></textarea></td>
            </tr>
            <tr> 
              <td colspan="2" background="images/dots.gif"></td>
            </tr>
            <tr> 
              <td colspan="2"> <div align="center"> 
                  <input type="submit" name="submitButtonName" value="Send" border="0">
                  <br>
                </div></td>
            </tr>
          </table>
        </div>
      </form></td>
    <td width="65" bgcolor="#FFFFFF"><font size="1"><font color="#FF0000" face="Verdana, Arial, Helvetica, sans-serif"></font></font></td>
  </tr>
</table>
<p>&nbsp; </p>
<p><br>



<?
}//main()
include "template.php";
?>
