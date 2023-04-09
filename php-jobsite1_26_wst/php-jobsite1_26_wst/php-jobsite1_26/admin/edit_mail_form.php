<?php
if($HTTP_POST_VARS['folders']) {
    $folders=$HTTP_POST_VARS['folders'];
}
elseif ($HTTP_GET_VARS['folders']){
     $folders = $HTTP_GET_VARS['folders'];
}
else {
    $folders = '';
}
function write_email_config($filename, $cf)
{
    $fp = fopen($filename, "r");
    while (!feof($fp)) {
        $buffer = fgets($fp, 20000);
        for ($i=0;$i<sizeof($cf['h']);$i++) {
                if (eregi("\\\$".$cf['h'][$i]."(.*)",$buffer,$regs)) {
                    $buffer = eregi_replace("\\\$".$cf['h'][$i]."(.*)","\$".$cf['h'][$i]." = \"".$cf['v'][$i]."\";\n",$buffer);
                }
        }
        $to_write .= $buffer;
    }
    fclose($fp);
    $fp2 = fopen($filename, "w+");
    fwrite($fp2, $to_write);
    fclose($fp2);
} // end func

if ($HTTP_POST_VARS['todo'] == "savefile") {
    if(ADMIN_SAFE_MODE == "yes" && $HTTP_POST_VARS['lng']==DEFAULT_LANGUAGE) {
         $error_title = "editing language mail message";
         bx_admin_error(TEXT_SAFE_MODE_ALERT);
    }
    else {
        $fp=fopen(DIR_LANGUAGES.$HTTP_POST_VARS['filename'], "w+");
        fwrite($fp, eregi_replace("\\\\","\\\\",bx_stripslashes($HTTP_POST_VARS['mail_message'])));
        fclose($fp);
        $cf['h'][] = "file_mail_subject";
        $cf['v'][] = eregi_replace("\\\\\\\\","\\\\\\\\",bx_addslashes($HTTP_POST_VARS['mail_subject']));
        $cf['h'][] = "html_mail";
        $cf['v'][] = $HTTP_POST_VARS['html_mail'];
        $cf['h'][] = "add_mail_signature";
        $cf['v'][] = $HTTP_POST_VARS['add_mail_signature'];
        write_email_config(DIR_LANGUAGES.$HTTP_POST_VARS['filename'].".cfg.php" , $cf);
        ?>
         <table width="100%" cellspacing="0" cellpadding="2" border="0">
          <tr>
              <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit email message file</b></font></td>
          </tr>
          <tr>
             <td bgcolor="#000000">
             <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
                <tr>
                    <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b>Successfull update.</b></font></td>
                </tr>
                <tr>
                    <td align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><a href="<?php echo HTTP_SERVER_ADMIN.FILENAME_INDEX;?>">Home</a></font></td>
                </tr>
             </table>
             </td>
          </tr>
          </table>
          <script language="Javascript"><!--
                    document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_MAIL."?ref=".time();?>" name="redirect">');
                    document.write('<input type="hidden" name="todo" value="editmail">');
                    document.write('<input type="hidden" name="folders" value="<?php echo $HTTP_POST_VARS['lng'];?>">');
                    document.write('</form>');
                    document.redirect.submit();
                    //-->
          </script>
<?php
    }         
}
else if ($HTTP_POST_VARS['todo'] == "test_mail") {
include(DIR_LANGUAGES.$HTTP_POST_VARS['filename'].".cfg.php");
$admin_mail_message = eregi_replace("\\\\","\\\\",bx_stripslashes($HTTP_POST_VARS['test_mail_message']));
$admin_mail_subject = eregi_replace("\\\\","\\\\",bx_stripslashes($HTTP_POST_VARS['test_mail_subject']));
$admin_html_mail = $HTTP_POST_VARS['test_html_mail'];
$admin_add_mail_signature = $HTTP_POST_VARS['test_add_mail_signature'];
if ($repeat_code) {
    $ee = eregi("(.*)<BEGIN REPEAT>(.*)<END REPEAT>(.*)",$admin_mail_message, $regs);
    $admin_mail_header = $regs[1];
    $admin_mail_message = $regs[2];
    $admin_mail_footer = $regs[3];
}
    reset($fields);
    while (list($h, $v) = each($fields)) {
           $admin_mail_message = eregi_replace($v[0],$v[2],$admin_mail_message);
           $admin_mail_subject = eregi_replace($v[0],$v[2],$admin_mail_subject);
           $admin_mail_header = eregi_replace($v[0],$v[2],$admin_mail_header);
           $admin_mail_footer = eregi_replace($v[0],$v[2],$admin_mail_footer);
    }
if ($repeat_code) {
    $admin_mail_message .= "\n".$admin_mail_message;
    $admin_mail_message = $admin_mail_header.$admin_mail_message.$admin_mail_footer;
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
    alert('Mail was sent successfull to <?php echo SITE_MAIL;?>.\nPlease check your mailbox in a few moments.\nIf you are satisfied with the result, please then save the mail message file.');
    window.close();
    //-->
    </SCRIPT>
<?php
}
else if ($HTTP_POST_VARS['todo'] == "editfile") {
include(DIR_LANGUAGES.$HTTP_POST_VARS['editfile'].".cfg.php");
?>
<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_MAIL;?>" name="editfile">
<input type="hidden" name="todo" value="savefile">
<input type="hidden" name="filename" value="<?php echo $HTTP_POST_VARS['editfile'];?>">
<input type="hidden" name="lng" value="<?php echo $HTTP_POST_VARS['lng'];?>">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit language email message file: <?php echo $HTTP_POST_VARS['editfile'];?></b></font></td></tr>
<tr>
   <td bgcolor="#000000"><TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
   <tr>
       <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_MAIL_MESSAGE_NOTE;?></b></font></td>
   </tr>
   <?php
   if ($message_note) {
   ?>
   <tr>
       <td colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="red"><b><?php echo $message_note;?></b></font></td>
   </tr>
   <?php  
   }
   ?>
   <tr>
       <td colspan="2" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_MAIL_SUBJECT;?>:</b></font></td>
   </tr>
   <tr>
       <td colspan="2" align="center"><input type="text" name="mail_subject" size="60" value="<?php echo bx_js_stripslashes($file_mail_subject, true);?>"></td>
   </tr>
   <tr>
       <td colspan="2" align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_MAIL_TEXT;?>:</b></font></td>
   </tr>
   <tr>
       <td colspan="2" align="center"><textarea name="mail_message" rows="15" cols="60" class="mm"><?php echo stripslashes(fread(fopen(DIR_LANGUAGES.$HTTP_POST_VARS['editfile'],"r"),filesize(DIR_LANGUAGES.$HTTP_POST_VARS['editfile'])));?></textarea></td>
   </tr>
   <tr><td colspan="2" align="center" nowrap class="mm"><?php echo TEXT_AVAILABLE_MAIL_FIELDS;?><br>
        
        <select name="fields" class="mm" onChange="document.editfile.mail_message.value += this.options[this.selectedIndex].value; alert('Added '+this.options[this.selectedIndex].text+' to Mail message!'); this.selectedIndex=0;"><option>---- Select/Add field ----</option><?php
        reset($fields);
        $i=1;
        while (list($h, $v) = each($fields)) {
            echo "<option value=\"".$v[0]."\">".$i." - ".$v[1]."</option>";
            $i++;
        }
        ?></select>
        </td>
   </tr>
   <?php
    reset($fields);
    $i=1;
    while (list($h, $v) = each($fields)) {
        echo "<tr><td colspan=\"2\" class=\"mm\">&nbsp;&nbsp;&nbsp;<b>".$i.". - ".$v[0]."</b> - ".$v[1]."  - e.g. ".htmlspecialchars($v[2])."</td></tr>";
        $i++;
    }
   ?>
   <tr>
       <td colspan="2" align="center"><input type="checkbox" name="add_mail_signature" value="on" class="check"<?php echo ($add_mail_signature=="on")?" checked":"";?>><?php echo TEXT_ADD_MAIL_SIGNATURE;?></td>
   </tr>    
   <tr>
        <td align="right"><?php echo TEXT_EMAIL_TYPE?>:</font></td><td><input type="radio" class="radio" name="html_mail" value="no"<?php echo ($html_mail=="no")?" checked":"";?> onClick="document.testfile.test_html_mail.value=this.value;">Plain text <input type="radio" class="radio" name="html_mail" value="yes"<?php echo ($html_mail=="yes")?" checked":"";?> onClick="document.testfile.test_html_mail.value=this.value;">HTML</td>
   </tr>
   <tr>
       <td colspan="2" align="center" class="mm"><?php echo TEXT_SITE_MAIL_SIGNATURE;?></font></td>
   </tr>
   <tr>
        <td  width="35%" align="right"><input type="submit" name="save" value="Save"></form>
        </td><td width="65%"><form method="post" target="test_mail" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_MAIL;?>" name="testfile" onSubmit="this.test_mail_message.value=document.editfile.mail_message.value; this.test_mail_subject.value=document.editfile.mail_subject.value; if (document.editfile.add_mail_signature.checked == true) {this.test_add_mail_signature.value = document.editfile.add_mail_signature.value;} else {this.test_add_mail_signature.value='';} df=open('','test_mail','scrollbars=no,menubar=no,resizable=0,location=no,width=350,height=220,screenX=50,screenY=100');df.window.focus(); return true;"><input type="hidden" name="filename" value="<?php echo $HTTP_POST_VARS['editfile'];?>">
        <input type="hidden" name="todo" value="test_mail"><input type="hidden" name="test_mail_message" value=""><input type="hidden" name="test_mail_subject" value=""><input type="hidden" name="test_html_mail" value="<?php echo $html_mail;?>"><input type="hidden" name="test_add_mail_signature" value=""><input type="submit" name="sendtestmail" value="Send Admin a Test Mail" class=""></form></td>
   </tr>
</table>
</td></tr></table>
<?php
}
else if ($HTTP_POST_VARS['todo'] == "editmail" || $HTTP_GET_VARS['todo'] == "editmail") {
     if (empty($folders)) {
         bx_admin_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
       ?>
            <script language="Javascript">
       <!--
       function err_pop(title,content) {
            mywindow = open('','error_popup','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=600,height=300,left=0,top=0,screenX=0,screenY=0');
            mywindow.document.write('<html><style type="text/css" title=""><!--');
            mywindow.document.write('A:LINK, A:VISITED {	color : #0000FF; font-family : arial; text-decoration : none; font-weight : normal; font-size : 12px;}');
            mywindow.document.write('A:HOVER {	color : #FF0000; font-family : arial; text-decoration : underline; font-weight : normal;	font-size : 12px;}');
            mywindow.document.write('//-->');
            mywindow.document.write('</style><body bgcolor="#EFEFEF">');
            mywindow.document.write('<table width="100%" cellpadding="0" cellspacing="0" border="0">');
            mywindow.document.write('<tr><td><hr></td></tr>');
            mywindow.document.write('<tr><td>&nbsp;&nbsp;<b>'+title+'</b></td></tr>');
            mywindow.document.write('<tr><td><hr></td></tr>');
            mywindow.document.write('<tr><td>&nbsp;</td></tr>');
            mywindow.document.write('<tr><td><font style="font-size:12px;" nowrap>'+content+'</font></td></tr>');
            mywindow.document.write('<tr><td>&nbsp;</td></tr>');
            mywindow.document.write('<tr><td align="right" valign="middle"><a href="javascript: ;" onClick="window.close();" style="color: #FF0000; text-decoration:none; font-weight: bold; font-size:12px; background: #FFFFFF; border: 1px solid #000000;">&nbsp;x&nbsp;</a>&nbsp;<a href="javascript: window.close();">Close Window</a></td></tr>');
            mywindow.document.write('<tr><td>&nbsp;</td></tr>');
            mywindow.document.write('</table>');
            mywindow.document.write('</body></html>');
       }
       //-->
       </script>
            <table width="100%" cellspacing="0" cellpadding="2" border="0">
            <tr>
                 <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit "<?php echo $folders;?>" language email message files</b></font></td>
            </tr>
            <tr>
               <td bgcolor="#000000">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
               <tr>
                   <td colspan="2"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_EDIT_LANGUAGE_MAIL_NOTE;?></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_LANGUAGE_MAIL_FILE;?>:</b></font></td>
               </tr>
               <tr><td colspan="2">
                <table align="center" width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <th>#</th>
                    <th align="left">File</th>
                    <th align="center">Permission</th>
                    <th align="center">Action</th>
                </tr>
                <tr>
                    <td colspan="4"><hr size="1" color="#000000"></td>
                </tr>  
               <?php
                     $n=1;
                     $dirs = getFiles(DIR_LANGUAGES.$folders."/mail");
                     sort($dirs);
                     for ($i=0; $i<count($dirs); $i++) {
                               if (eregi(".cfg.php",$dirs[$i],$rrr) || $dirs[$i]=="index.html" || $dirs[$i]=="index.htm") {
                                   
                               }
                               else {
                               $perms_error=false;
                               ?>
                                <tr>
                                       <td><b><u><?php echo $n;?></u>.</b></td>
                                       <form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_MAIL;?>">
                                       <input type="hidden" name="todo" value="editfile">
                                       <input type="hidden" name="editfile" value="<?php echo $folders."/mail/".$dirs[$i];?>">
                                       <input type="hidden" name="lng" value="<?php echo $folders;?>">
                                       <td><b><?php echo eregi_replace(".txt$","",$dirs[$i]);?></b></td>
                                       <td align="center"><b><?php 
                                   $perms=substr(base_convert(@fileperms(DIR_LANGUAGES.$folders."/mail/".$dirs[$i]), 10, 8),3);
                                   echo $perms;
                                   if ($perms==666 || $perms==777) {
                                       echo " - OK";
                                       $perms_error=false;
                                   }
                                   else {
                                       $title="File Permission Error - ".$dirs[$i];
                                       $content="<font color=red><b>The permission for this file is invalid.<br>Valid permission for the file is: <b>777</b>.</font><br> The changes to the file will not be saved properly(will be lost)!<br>Please change the file permission for ".DIR_LANGUAGES.$folders."/mail/".$dirs[$i]." to 777.";
                                       $perms_error=true;
                                       ?>
                                                                     <font color="#FF0000" size="2"><b>ERROR</b>...<a href="javascript: ;" onClick="err_pop('<?php echo $title;?>','<?php echo eregi_replace("'","\'",$content);?>'); return false;" style="color: #FFFFFF; text-decoration:none; font-weight: bold; font-size:12px; background: #003399;">&nbsp;?&nbsp;</a></font>
                                                              <?php                  
                                   }
                                   ?></b></td>
                                       <td align="center"><input type="submit" name="edit" value="Edit File"<?php if($perms_error){ echo " onClick=\"return confirm('Invalid File Permission (".$perms.") for ".eregi_replace("'","\'",$dirs[$i])."\\nChanges will not be saved!\\nClick on Ok if you still want to continue, Cancel otherwise!');\"";}?>></td>
                                       </form>
                                </tr> 
                               <?php
                               $n++;
                               }
                    }
                 ?>
                 <tr>
                    <td colspan="4"><hr size="1" color="#000000"></td>
                 </tr>  
                 </table>
               </td>
               </tr>
                <tr>
                   <td colspan="2"><br></td>
               </tr>
              </table>
         </td></tr></table>
         <?php
     }//end else if (empty($folders))
}//end if ($todo == "editmail")
else {
?>
<form method="post" action="<?php echo HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_MAIL;?>" name="editlng" onSubmit="return check_form_editmail();">
<input type="hidden" name="todo" value="editmail">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit Email Messages - Select language</b></font></td>
</tr>
<tr>
   <td bgcolor="#000000">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
<tr>
    <td colspan="2"><br></td>
</tr>
<tr>
        <td valign="top" width="80%"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><b><?php echo TEXT_SELECT_EDIT_LANGUAGE_MAIL;?>:</b></font></td><td valign="top">
<?php
  $dirs = getFolders(DIR_LANGUAGES);
    if(count($dirs) == 1) {
          refresh(HTTP_SERVER_ADMIN.FILENAME_ADMIN_EDIT_MAIL."?todo=editmail&folders=".$dirs[0]);
  }
  for ($i=0; $i<count($dirs); $i++) {
       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
              echo "<input type=\"radio\" name=\"folders\" value=\"".$dirs[$i]."\" class=\"radio\">".$dirs[$i]."<br>";
       }
  }
?>
</td></tr>
<tr>
        <td colspan="2" align="center"><br><input type="submit" name="edit" value="<?php echo TEXT_EDIT_LANGUAGE_EMAIL;?>"></td>
</tr>
</table>
</td></tr></table>
</form>
<?php
}
?>