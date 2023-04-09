<?
include "logincheck.php";
include_once("../config.php");
$rs0=mysql_fetch_array(mysql_query("select * from sbwmd_config"));

function main()
{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
<?

$errcnt=0;
$showform="";

$mailid="";
$fromid="";
$subject="";
$mail="";

if ( count($_POST)!=0 )
{
$mailid=$_REQUEST["mailid"];

if ($_REQUEST["mailid"]!="" )
{
$rs=mysql_query("select * from sbwmd_mails where mailid=" . $_REQUEST["mailid"] );
$rs=mysql_fetch_array($rs);
$fromid=$rs["fromid"];
$subject=$rs["subject"];
$mail=$rs["mail"];
}

if (  isset( $_REQUEST["update"])  )
{

if ( !isset( $_REQUEST["fromid"] ) || $_REQUEST["fromid"]=="" )
{
	$errs[$errcnt]="From Email id must be provided";
    $errcnt++;
}
if ( !isset( $_REQUEST["subject"] ) || $_REQUEST["subject"]=="" )
{
	$errs[$errcnt]="Email Subject must be provided";
    $errcnt++;
}
if ( !isset( $_REQUEST["mail"] ) || $_REQUEST["mail"]=="" )
{
	$errs[$errcnt]="Email Contents must be provided";
    $errcnt++;
}

}

}
?>


<p align="center">&nbsp;</p>
        <p align="center">
<?
if  (count($_POST)<>0)
{
if ( $errcnt==0 )
{
if (  isset( $_REQUEST["update"])  )
{
$update_str="update sbwmd_mails set fromid='" . $_REQUEST["fromid"] . "', subject='" . $_REQUEST["subject"] . "', mail='" . $_REQUEST["mail"] . "' where mailid =" . $_REQUEST["mailid"];
mysql_query($update_str);

$rs=mysql_query("select * from sbwmd_mails where mailid=" . $_REQUEST["mailid"] );
$rs=mysql_fetch_array($rs);
$fromid=$rs["fromid"];
$subject=$rs["subject"];
$mail=$rs["mail"];


?>
          <br>
          <br>
        <strong><font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif">Mail 
        has been updated</font></strong> 
        <?
$showform="No";
}

}
else
{
?>
      </p>
        <table width="558" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr> 
            
          <td colspan="2"><font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif"><strong>Your 
            Update Email Request cannot be processed due to following Reasons</strong></font></td>
          </tr>
          <?

for ($i=0;$i<$errcnt;$i++)
{
?>
          <tr> 
            <td width="6%"><strong><font color="#FF0000"><?php echo $i+1; ?></font></strong></td>
            <td width="94%"><font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif"><?php echo  $errs[$i]; ?> 
              </font></td>
          </tr>
          <?
}//end for
?>
        </table>
        
      <?

}

}


?>
      <br>
      <form name="form2" method="post" action="siteemails.php">
        <table width="576" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">From 
                here the admin can select/edit all automatic email messages that 
                are sent through the system.</font></div></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><div align="center"> 
                <select name="mailid">
                  <option  value="">Select a mail message</option>
                  <option  value="">--------------------------------</option>
                  <option value="1" 
				   <? 
				  if  (isset($_REQUEST["mailid"]) && $_REQUEST["mailid"]=="1")
				  {
				  echo " Selected ";
				  }
				  
				  ?>
				  >Welcome Email</option>
				  <option value="6" 
				   <? 
				  if  (isset($_REQUEST["mailid"]) && $_REQUEST["mailid"]=="6")
				  {
				  echo " Selected ";
				  }				  
				  ?>>Signup Confirmation Email</option>
				  
				  
				  
				  
                  <option value="3" 				   <? 
				  if  (isset($_REQUEST["mailid"]) && $_REQUEST["mailid"]=="3")
				  {
				  echo " Selected ";
				  }
				  
				  ?>
>Disapproval Email</option>
                  <option value="2"				   
				  <? 
				  if  (isset($_REQUEST["mailid"]) && $_REQUEST["mailid"]=="2")
				  {
				  echo " Selected ";
				  }
				  
				  ?>
>Approval Email</option>
<option value="4"				   
				  <? 
				  if  ( isset($_REQUEST["mailid"]) && $_REQUEST["mailid"]=="4")
				  {
				  echo " Selected ";
				  }
				  
				  ?>
>Forgot Password</option>

<option value="5"				   
				  <? 
				  if  ( isset($_REQUEST["mailid"]) && $_REQUEST["mailid"]=="5")
				  {
				  echo " Selected ";
				  }
				  
				  ?>
>Send Stats Email</option>

                </select>
                <input type="submit" name="Submit" value="Select email message">
              </div></td>
          </tr>
          <tr> 
            <td><div align="center"><font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif">.</font></div></td>
          </tr>
        </table>
      </form>
   <? 
				  if  ( isset($_REQUEST["mailid"]) && $_REQUEST["mailid"]!="")
				  {
	?>			  
				  
				     <form name="form1" method="post" action="siteemails.php">
        <table width="576" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">You can place 
              following custom shortcuts:</font></td>
          </tr>
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
          <tr> 
            <td><p><font size="2" face="Arial, Helvetica, sans-serif">1. &lt;email&gt; 
                will display the users email id.<br>
                2. &lt;username&gt; will display the users username.<br>
                3. &lt;password&gt; will display the user spassword.<br>
                4. &lt;name&gt; will display contact name.<br>
                5 . &lt;softwarename&gt; will display users last name.<br>
                <br>
                For Send Stats Email you can use:<br>
                1. &lt;credits&gt; will display the users email id.<br>
                2. &lt;displays&gt; will display the users username.<br>
                3. &lt;balance&gt; will display the user spassword.<br>
                4. &lt;date&gt; will display contact name.<br>
                <br>
                For Confirmation Email you can use:<br>
                1. &lt;link&gt; will display the url where users go to confirm 
                there email id.</font><font size="2" face="Arial, Helvetica, sans-serif"><br>
                </font></p>
              </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td height="25" bgcolor="#666666"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              &nbsp;&nbsp; 
              <?php
              switch ($mailid)
			  {
			  case "": echo "NONE" ; break;   			
			  case "1": echo "Auto Approval Email" ; break;   			
			  case "2": echo "Admin Approval Email" ; break;   			
			  case "3": echo "Admin Reject Email" ; break;   			
			  }
			  
			?>
              </font></strong></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="576" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="130"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td width="14"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td width="417"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <input name="update" type="hidden" value="Yes">
              <input name="mailid" type="hidden" value="<?php echo $mailid; ?>">
              </font></td>
            <td width="15"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
          <tr> 
            <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">From 
                / Reply address:</font></div></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
			
              <input name="fromid" type="text" value="<? echo $fromid ;?>" size="30">
              <br>
              This will show the emailaddress for this certain mail / message 
              </font></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font size="2"></font></font></div></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
          <tr> 
            <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">Subject:</font></div></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="subject" type="text" value="<?php echo $subject; ?>" size="30">
              <br>
              This is the custom subject for that certain mail / message </font></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
          <tr> 
            <td><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">Email 
                Message:</font></div></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="mail" cols="40" rows="10"><?php echo $mail; ?></textarea>
              <br>
              This will display the mail that will be sent upon certain actions 
              and will allow for editing. </font></td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><div align="center"> 
                <input type="submit" name="Submit2" value="Save message">
              </div></td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
          </tr>
        </table>
      </form>
<?
}

?>
</td>
  </tr>
</table>
<?
}// end of main()
include "template.php";
?>