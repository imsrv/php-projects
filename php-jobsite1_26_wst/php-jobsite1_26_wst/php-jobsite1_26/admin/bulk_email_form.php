<?php
if (($HTTP_POST_VARS['todo']=="bulkmail") && ($HTTP_POST_VARS['mail']=="companies")) {
      include(DIR_ADMIN."employer_bulkmail.cfg.php");
      $company_query=bx_db_query("select * from ".$bx_table_prefix."_companies");
      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
      while ($company_result=bx_db_fetch_array($company_query)) {
          if(ADMIN_SAFE_MODE == "yes") {
              echo 'Mail was not sent to '.$company_result['email'].".".TEXT_SAFE_MODE_ALERT."<br>";
          }
          else {
               $mail_message = eregi_replace("\\\\","\\\\",bx_stripslashes($HTTP_POST_VARS['bulk_message']);
               $mail_subject = eregi_replace("\\\\","\\\\",bx_stripslashes($HTTP_POST_VARS['bulk_subject']));
               $add_mail_signature = $HTTP_POST_VARS['add_mail_signature'];
               reset($fields);
               while (list($h, $v) = each($fields)) {
                   $mail_message = eregi_replace($v[0],$company_result[$h],$mail_message);
                   $mail_subject = eregi_replace($v[0],$company_result[$h],$mail_subject);
               }
               if ($add_mail_signature == "on") {
                    $mail_message .= "\n".SITE_SIGNATURE;
               }
               bx_mail(SITE_NAME,SITE_MAIL,$company_result['email'],stripslashes($mail_subject),stripslashes($mail_message),$HTTP_POST_VARS['bulk_type']);
               echo 'Mail was sent to '.$company_result['email']."<br>";
          }
      }
}
else if (($HTTP_POST_VARS['todo']=="bulkmail") && ($HTTP_POST_VARS['mail']=="jobseekers")) {
      include(DIR_ADMIN."jobseeker_bulkmail.cfg.php");
      $person_query=bx_db_query("select * from ".$bx_table_prefix."_persons");
      SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
      while ($person_result=bx_db_fetch_array($person_query)) {
          if(ADMIN_SAFE_MODE == "yes") {
              echo 'Mail was not sent to '.$person_result['email'].". <font color=\"red\">".TEXT_SAFE_MODE_ALERT."</font><br>";
          }
          else {
               $mail_message = eregi_replace("\\\\","\\\\",bx_stripslashes($HTTP_POST_VARS['bulk_message']));
               $mail_subject = eregi_replace("\\\\","\\\\",bx_stripslashes($HTTP_POST_VARS['bulk_subject']));
               $add_mail_signature = $HTTP_POST_VARS['add_mail_signature'];
               reset($fields);
               while (list($h, $v) = each($fields)) {
                   $mail_message = eregi_replace($v[0],$person_result[$h],$mail_message);
                   $mail_subject = eregi_replace($v[0],$person_result[$h],$mail_subject);
               }
               if ($add_mail_signature == "on") {
                    $mail_message .= "\n".SITE_SIGNATURE;
               }
               bx_mail(SITE_NAME,SITE_MAIL,$person_result['email'],stripslashes($mail_subject),stripslashes($mail_message),$HTTP_POST_VARS['bulk_type']);
               echo 'Mail was sent to '.$person_result['email']."<br>";
          }    
      }
}
else if ($HTTP_POST_VARS['todo']=="test_mail") {
    if($HTTP_POST_VARS['t_mail'] == "companies") {
        include(DIR_ADMIN."employer_bulkmail.cfg.php");
    }
    if($HTTP_POST_VARS['t_mail'] == "jobseekers") {
        include(DIR_ADMIN."jobseeker_bulkmail.cfg.php");
    }
    $admin_mail_message = eregi_replace("\\\\","\\\\",bx_stripslashes($HTTP_POST_VARS['test_mail_message']));
    $admin_mail_subject = eregi_replace("\\\\","\\\\",bx_stripslashes($HTTP_POST_VARS['test_mail_subject']));
    $admin_html_mail = $HTTP_POST_VARS['test_html_mail'];
    $admin_add_mail_signature = $HTTP_POST_VARS['test_add_mail_signature'];
    reset($fields);
    while (list($h, $v) = each($fields)) {
           $admin_mail_message = eregi_replace($v[0],$v[2],$admin_mail_message);
           $admin_mail_subject = eregi_replace($v[0],$v[2],$admin_mail_subject);
    }
    if ($admin_add_mail_signature == "on") {
        $admin_mail_message .= "\n".SITE_SIGNATURE;
    }
    bx_mail(SITE_NAME,SITE_MAIL,SITE_MAIL,stripslashes($admin_mail_subject),stripslashes($admin_mail_message),$admin_html_mail); 
    ?>
        <table width="100%" cellspacing="0" cellpadding="2" border="0">
          <tr>
              <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Test mail message file</b></font></td>
          </tr>
          <tr>
             <td bgcolor="#000000">
             <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
                <tr>
                    <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Mail sent successfully. Please check your mailbox.</b></font></td>
                </tr>
             </table>
             </td>
          </tr>
          </table>
        <SCRIPT LANGUAGE="JavaScript">
        <!--
        alert('Mail was sent successfull to <?php echo SITE_MAIL;?>.\nPlease check your mailbox in a few moments.\nIf you are satisfied with the result, please then send the bulk mail message file.');
        window.close();
        //-->
        </SCRIPT>
    <?php
}
else {
if($HTTP_GET_VARS['mail'] == "companies") {
    include(DIR_ADMIN."employer_bulkmail.cfg.php");
}
if($HTTP_GET_VARS['mail'] == "jobseekers") {
    include(DIR_ADMIN."jobseeker_bulkmail.cfg.php");
}
?>
<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_BULK_EMAIL;?>" name="bulkmail" onSubmit="return check_form();">
<input type="hidden" name="todo" value="bulkmail">
<input type="hidden" name="mail" value="<?php echo $HTTP_GET_VARS['mail'];?>">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
 <tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Send email</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
<tr>
        <td align="right" width="30%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_EMAIL_TYPE;?>:</b></font></td><td><input type="radio" class="radio" name="bulk_type" value="no" checked onClick="document.testbulk.test_html_mail.value=this.value;">Plain text <input type="radio" class="radio" name="bulk_type" value="yes" onClick="document.testbulk.test_html_mail.value=this.value;">HTML</td>
</tr>
<tr>
       <td colspan="2" align="center"><input type="checkbox" name="add_mail_signature" value="on" class="check"<?php echo ($add_mail_signature=="on")?" checked":"";?>><?php echo TEXT_ADD_MAIL_SIGNATURE;?></td>
</tr>    
<tr>
        <td align="right"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SUBJECT;?>:</b></font></td><td><input type="text" name="bulk_subject" size="40"></td>
</tr>
<tr>
        <td align="right" valign="top"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_MESSAGE;?>:</b></font></td><td><textarea name="bulk_message" rows="10" cols="40"></textarea></td>
</tr>
<tr><td colspan="2" align="center" nowrap class="mm"><?php echo TEXT_AVAILABLE_MAIL_FIELDS;?><br>
        
        <select name="fields" class="mm" onChange="document.bulkmail.bulk_message.value += this.options[this.selectedIndex].value; alert('Added '+this.options[this.selectedIndex].text+' to Mail message!'); this.selectedIndex=0;"><option>---- Select/Add field ----</option><?php
        reset($fields);
        while (list($h, $v) = each($fields)) {
            echo "<option value=\"".$v[0]."\">".$v[1]."</option>";
        }
        ?></select>
        <br><?php
        reset($fields);
        while (list($h, $v) = each($fields)) {
            echo "e.g. ".$v[1]." (<b>".$v[0]."</b>) - ".$v[2]."<br>";
        }
        ?>
        </td>
   </tr>
<tr>
       <td colspan="2" align="center" class="mm"><?php echo TEXT_SITE_MAIL_SIGNATURE;?></td>
</tr>
<tr>
        <td align="right" width="100%" colspan="2"><table width="100%" cellpadding="2" cellspacing="0" border="0"><tr><td width="10%">&nbsp;</td><td width="30%" align="right">
            <input type="submit" name="save" value="Send Message"></form></td>
        <td align="left" width="60%"><form method="post" target="test_mail" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_BULK_EMAIL;?>" name="testbulk" onSubmit="this.t_mail.value=document.bulkmail.mail.value; this.test_mail_message.value=document.bulkmail.bulk_message.value; this.test_mail_subject.value=document.bulkmail.bulk_subject.value; if (document.bulkmail.add_mail_signature.checked == true) {this.test_add_mail_signature.value = document.bulkmail.add_mail_signature.value;} else {this.test_add_mail_signature.value='';} df=open('','test_mail','scrollbars=no,menubar=no,resizable=0,location=no,width=350,height=220,screenX=50,screenY=100');df.window.focus(); return true;">
        <input type="hidden" name="todo" value="test_mail"><input type="hidden" name="t_mail" value=""><input type="hidden" name="test_mail_message" value=""><input type="hidden" name="test_mail_subject" value=""><input type="hidden" name="test_html_mail" value=""><input type="hidden" name="test_add_mail_signature" value=""><input type="submit" name="sendtestmail" value="Send Admin a Test Mail" class=""></form></td>
        </tr></table></td>
</tr>
</table>
</td></tr></table>
<?php
}
?>
