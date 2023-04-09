<?
include_once "config.php";
include_once "left_index.php";
include_once "right_index.php";

function main()
{


////////////////////////////INSERTS MEMBER INFORMATION  INTO DB and sets session so as to automatically login the member . ALSO sends a welcome mail ////////////////

function perform_insert()
{

mysql_query ("delete from sbwmd_signups where email='" . $_REQUEST["email"]. "'");



$rnum =  mt_rand(1,1000000000);
$insert_str="Insert into `sbwmd_signups` ( email ,rnum,onstamp) VALUES ( " ."'".str_replace("'","''",$_REQUEST["email"])."'" ."," ."'". $rnum ."'," . date("Ymdhis",time()) . ")";
mysql_query($insert_str);

///////////////////////////////////////////////////////////////////////
///////////////////////////// SEND EMAIL //////////////////////////////
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));
$link= $rs0["site_addrs"] . "/signup1.php?email=" . $_REQUEST["email"] . "&rnum=" . $rnum ; 

$sql = "SELECT * FROM sbwmd_mails where id=6" ;
$rs_query=mysql_query($sql);

if ( $rs=mysql_fetch_array($rs_query)  )
  {
			 $from =$rs["fromid"];

			 $to = $_REQUEST["email"];

			 $subject =$rs["subject"];

		     $header="From:" . $from . "\r\n" ."Reply-To:". $from  ;

		 	 $body=str_replace("<link>", $link,str_replace("<email>", $_REQUEST["email"],$rs["mail"]) ); 
			 
			 mail($to,$subject,$body,$header);

}
//////////////////////////////// CONFIRMATION SENT//////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////


}
//////////////Function perform_insert ends here/////////

$errcnt=0;
$showform="";

$email="";

//IF SOME FORM WAS POSTED DO VALIDATION
if ( count($_POST)<>0 )
{
$email=$_REQUEST["email"];

if ( !isset( $_REQUEST["email"] ) || $_REQUEST["email"]=="" )
{
	$errs[$errcnt]="Email must be provided";
    $errcnt++;
}


if ( isset( $_REQUEST["email"] ) )
{
$rs0_query=mysql_query ("select * from sbwmd_members where email='" . $_REQUEST["email"]. "'");
if ($rs0=mysql_fetch_array($rs0_query))
{
	$errs[$errcnt]="Some member has already registered with this email id. <br>So, you cannot register with this email id";
    $errcnt++;

}
}


}
//Array of errors have been generated



?>
<html>
<head>
<title>Member Signup</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?
if  (count($_POST)<>0)
{

if ( $errcnt==0 )
{
perform_insert();
?>
<br>
<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="justify"><strong><font color="#FF0000" size="2" >Please 
        verify your email address from the email that has been sent to the email 
        account you provided.. You need to click on the link provided in the email 
        to continue registration.</font></strong></div></td>
  </tr>
</table>
<strong></strong> 
<?
$showform="No";
}
else
{
?>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2"><font color="#FF0000" size="2" ><strong>Your 
      signup Request cannot be processed due to following Reasons</strong></font></td>
  </tr>
  <?

for ($i=0;$i<$errcnt;$i++)
{
?>
  <tr valign="top"> 
    <td width="6%"><strong><font color="#FF0000"><?php echo $i+1; ?></font></strong></td>
    <td width="94%"><font color="#FF0000" size="2" ><?php echo  $errs[$i]; ?> 
      </font></td>
  </tr>
  <?
}
?>
</table>

<?

}

}

if ($showform<>"No")
{
?>
<form name="form1" method="post" action="signup.php">
  <br>
  <table width="95%" border="0" align="center" cellpadding="4" cellspacing="0">
    <tr> 
      <td><font color="#FFFFFF" size="2" ><a href="index.php"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font color="#000000">HOME</font></strong></font></a> 
        <strong><font color="#000000" size="2" >&gt; SIGN UP</font></strong></font>
        <hr size="1"></td>
    </tr>
    <tr> 
      <td bgcolor="#FFFFFF"><div align="center"> 
          <table width="71%" border="0" align="center" cellpadding="4" cellspacing="0" background="images/greypixel.gif">
            <tr> 
              <td colspan="3" valign="top" bgcolor="#FFFFFF"><font color="#FFFFFF" size="2" ><strong><font color="#000000">Please 
                provide your email address to continue</font>ue...</strong></font></td>
            </tr>
            <tr> 
              <td valign="top">&nbsp;</td>
              <td valign="top">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td valign="top"><div align="right"><strong><font color="#FF0000">*</font> 
                  Email address:</strong></font></div></td>
              <td valign="top">&nbsp;</td>
              <td>&nbsp; 
                <input name="email" type="text" class=select size="30" maxlength="40">
                </font></td>
            </tr>
            <tr> 
              <td valign="top">&nbsp;</td>
              <td valign="top">&nbsp;</td>
              <td><font color="#666666" size="1" >Your 
                older varification code will be disabled once you request for 
                newer verification code.</font></td>
            </tr>
          </table>
          <input type="submit" name="Submit" value="Continue" class="input">
          <br>
        </div></td>
    </tr>
  </table>
  <br>
</form>
<?
} //If showform = No? ends here
}
include "template.php";
?>