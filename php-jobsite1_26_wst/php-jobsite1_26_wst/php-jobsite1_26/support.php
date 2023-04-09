<?php
include ('application_config_file.php');
include(DIR_SERVER_ROOT."header.php");
if ($HTTP_POST_VARS['todo']=="support") {
$error = "no";
        if(empty($HTTP_POST_VARS['email']) || (!eregi("(@)(.*)",$HTTP_POST_VARS['email'],$regs)) || (!eregi("([.])(.*)",$HTTP_POST_VARS['email'],$regs))) {
                $email_error="yes";
                $error="yes";
        }
        else {
                $email_error="no";
        }
        if(empty($HTTP_POST_VARS['subject'])) {
                $subject_error="yes";
                $error="yes";
        }
        else {
                $subject_error="no";
        }
        if(empty($HTTP_POST_VARS['sname'])) {
                $name_error="yes";
                $error="yes";
        }
        else {
                $name_error="no";
        }
        if(empty($HTTP_POST_VARS['message'])) {
                $message_error="yes";
                $error="yes";
        }
        else {
                $message_error="no";
        }
        if ($error=="no") {
                $mmessage="Support need by ".$HTTP_POST_VARS['sname'].".\n";
				if (!$HTTP_POST_VARS['support_need']) {
				    $HTTP_POST_VARS['support_need'] = "not logged";
				}
				$mmessage= $HTTP_POST_VARS['sname']." was logged in as: ".$HTTP_POST_VARS['support_need'].".\n";
                $mmessage.="Support subject \"".bx_stripslashes($HTTP_POST_VARS['subject'])."\".\n";
                $mmessage.="Reply email address ".$HTTP_POST_VARS['email'].".\n";
                $mmessage.="Message:\n";
                $mmessage.="\n".bx_stripslashes($HTTP_POST_VARS['message']);
                bx_mail(bx_stripslashes($HTTP_POST_VARS['sname']),$HTTP_POST_VARS['email'],SITE_MAIL, "Support: ".bx_stripslashes($HTTP_POST_VARS['subject']) , $mmessage,"no");
                ?>
            <table border="0" cellpadding="0" cellspacing="0" align="center" width="100%">
            <tr>
                  <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                  <td colspan="3" align="center"><font face="Arial" color="#00009C" size="2"><b><i>Dear <?php echo $HTTP_POST_VARS['sname'];?></i></b></font></td>
            </tr>
            <tr>
                  <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                  <td colspan="3"><font face="Arial" color="#000000" size="2"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Your support message was sent to <a href="mailto:<?php echo SITE_MAIL;?>"><font color="red" size="2"><b><?php echo SITE_MAIL;?></b></font></a>.</b></font></td>
            </tr>
            <tr>
                  <td colspan="3"><font face="Arial" color="#000000" size="2">&nbsp;&nbsp;<b>The subject was: <font color="#000000" size="2">"<?php echo $HTTP_POST_VARS['subject'];?>"</font>.</b></font></td>
            </tr>
            <tr>
                  <td colspan="3"><font face="Arial" color="#000000" size="2">&nbsp;&nbsp;<b>Your email address is <font color="#000000" size="2">"<?php echo $HTTP_POST_VARS['email'];?>"</font>.</b></font></td>
            </tr>
            <tr>
                  <td colspan="3"><font face="Arial" color="#000000" size="2">&nbsp;&nbsp;<b>Sent message was:</b></font></td>
            </tr>
            <tr>
                  <td width="20%"><font face="Arial" color="#000000" size="2"><b>&nbsp;</b></font></td>
                  <td class="td4textarea" nowrap><font face="Arial" color="#000000" size="1"><b><?php echo bx_textarea($HTTP_POST_VARS['message']);?></b></font></td>
				  <td width="20%">&nbsp;</td>
            </tr>
            <tr>
                  <td colspan="3">&nbsp;</td>
            </tr>
            <tr>
                  <td colspan="3" align="right"><font face="Arial" color="#00009C" size="2"><b><i>Thank you!!!</i></b></font></td>
            </tr>
            <tr>
                  <td colspan="3">&nbsp;</td>
            </tr>
            </table>
<?php
}
else {				 
	include(DIR_FORMS.FILENAME_SUPPORT_FORM);
}
}
else {
	include(DIR_FORMS.FILENAME_SUPPORT_FORM);
}
include(DIR_SERVER_ROOT."footer.php");
?>