<?
define('SITE_MAIL', $site_mail);

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

$error_title = "editing language mail message";
if ($HTTP_POST_VARS['todo'] == "savefile") {
    $fp=fopen(DIR_LANGUAGES.$HTTP_POST_VARS['filename'], "w+");
    fwrite($fp, stripslashes($HTTP_POST_VARS['mail_message']));
    fclose($fp);
    if($HTTP_POST_VARS['mail_type']=="1") {
        $fp=fopen(DIR_LANGUAGES.$HTTP_POST_VARS['filename'].".html", "w+");
        fwrite($fp, stripslashes($HTTP_POST_VARS['html_mail_message']));
        fclose($fp);
    }
    $cf['h'][] = "file_mail_subject";
    $cf['v'][] = $HTTP_POST_VARS['mail_subject'];
    $cf['h'][] = "html_mail";
    $cf['v'][] = $HTTP_POST_VARS['html_mail'];
    if($HTTP_POST_VARS['mail_type']=="1") {
        $cf['h'][] = "add_html_header";
        $cf['v'][] = $HTTP_POST_VARS['add_html_header'];
        $cf['h'][] = "add_html_footer";
        $cf['v'][] = $HTTP_POST_VARS['add_html_footer'];
    }
    $cf['h'][] = "add_mail_signature";
    $cf['v'][] = $HTTP_POST_VARS['add_mail_signature'];
    write_email_config(DIR_LANGUAGES.$HTTP_POST_VARS['filename'].".cfg.php" , $cf);
    ?>
     <table width="100%" cellspacing="0" cellpadding="1" border="0">
      <tr>
          <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit Email Message Files</b></font></td>
      </tr>
      <tr>
         <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
         <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
            <tr>
                <td align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Successfull update.</b></font></td>
            </tr>
            <tr>
                <td align="left" nowrap><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><a href="<?=HTTP_SERVER_ADMIN.FILENAME_INDEX?>" class="settings">&#171;Admin Home&#187;</a>&nbsp;&nbsp;<a href="<?=HTTP_SERVER_ADMIN."admin_edit_mail.php"."?todo=editmail&folders=".$HTTP_POST_VARS['lng']?>" class="settings">&#171;Edit Mail Messages Home&#187;</a></font></td>
            </tr>
         </table>
         </td>
      </tr>
      </table>
<?
}
else if ($HTTP_GET_VARS['todo'] == "preview") {
    ?>
    <script language="Javascript">
    <!--
          if(parent.opener.document.editfile.add_html_header.checked) {
              document.write("<?=eregi_replace('"',"&#034;",nl2br(fread(fopen(DIR_LANGUAGES.$HTTP_GET_VARS['lng']."/html/html_email_message_header.html","r"),filesize(DIR_LANGUAGES.$HTTP_GET_VARS['lng']."/html/html_email_message_footer.html"))))?>");
          }
          document.write(parent.opener.document.editfile.html_mail_message.value);
          if(parent.opener.document.editfile.add_html_footer.checked) {
              document.write("<br><?=eregi_replace('"',"&#034;",nl2br(fread(fopen(DIR_LANGUAGES.$HTTP_GET_VARS['lng']."/html/html_email_message_footer.html","r"),filesize(DIR_LANGUAGES.$HTTP_GET_VARS['lng']."/html/html_email_message_footer.html"))))?>");
          }
    //-->
    </script>
    <?
}
else if ($HTTP_POST_VARS['todo'] == "preview") {
      if($HTTP_POST_VARS['lng']) {
                include(DIR_LANGUAGES.$HTTP_POST_VARS['filename'].".cfg.php");
                $admin_mail_message = stripslashes($HTTP_POST_VARS['test_html_mail_message']);
                $admin_add_html_header = $HTTP_POST_VARS['test_add_html_header'];
                $admin_add_html_footer = $HTTP_POST_VARS['test_add_html_footer'];
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
                    $admin_mail_message .= "<br>".$admin_mail_message;
                    $admin_mail_message = $admin_mail_header.$admin_mail_message.$admin_mail_footer;
                }
                if ($admin_add_html_header == "on") {
                    $admin_mail_message = fread(fopen(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html/html_email_message_header.html","r"),filesize(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html/html_email_message_header.html")).$admin_mail_message;
                }
                if ($admin_add_html_footer == "on") {
                    $admin_mail_message .= fread(fopen(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html/html_email_message_footer.html","r"),filesize(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html/html_email_message_footer.html"));
                }
                echo $admin_mail_message;
      }
      else {
          bx_error("Please select a language to edit!");
      }
}
else if ($HTTP_POST_VARS['todo'] == "test_mail") {
include(DIR_LANGUAGES.$HTTP_POST_VARS['filename'].".cfg.php");
$admin_mail_message = $HTTP_POST_VARS['test_mail_message'];
$admin_mail_subject = stripslashes($HTTP_POST_VARS['test_mail_subject']);
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
bx_mail(SITE_NAME,SITE_MAIL,SITE_MAIL,$admin_mail_subject,nl2br(stripslashes($admin_mail_message)),$admin_html_mail); 
?>
    <table width="100%" cellspacing="0" cellpadding="1" border="0">
      <tr>
          <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Test mail message file</b></font></td>
      </tr>
      <tr>
         <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
         <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
            <tr>
                <td align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Mail sent successfully. Please check your mailbox.</b></font></td>
            </tr>
         </table>
         </td>
      </tr>
      </table>
    <SCRIPT LANGUAGE="JavaScript">
    <!--
    alert('Mail was sent successfull to <?=SITE_MAIL?>.\nPlease check your mailbox in a few moments.\nIf you are satisfied with the result, please then save the mail message file.');
    window.close();
    //-->
    </SCRIPT>
<?
}
else if ($HTTP_POST_VARS['todo'] == "test_mail_html") {
include(DIR_LANGUAGES.$HTTP_POST_VARS['filename'].".cfg.php");
if($HTTP_POST_VARS['mail_type']=="1") {
        $admin_mail_subject = stripslashes($HTTP_POST_VARS['test_mail_subject']);
        $admin_mail_message = $HTTP_POST_VARS['test_html_mail_message'];
        $admin_add_html_header = $HTTP_POST_VARS['test_add_html_header'];
        $admin_add_html_footer = $HTTP_POST_VARS['test_add_html_footer'];
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
            $admin_mail_message .= "<br>".$admin_mail_message;
            $admin_mail_message = $admin_mail_header.$admin_mail_message.$admin_mail_footer;
        }
        if ($admin_add_html_header == "on") {
            $admin_mail_message = fread(fopen(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html/html_email_message_header.html","r"),filesize(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html/html_email_message_header.html")).$admin_mail_message;
        }
        if ($admin_add_html_footer == "on") {
            $admin_mail_message .= fread(fopen(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html/html_email_message_footer.html","r"),filesize(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/html/html_email_message_footer.html"));
        }
        bx_mail(SITE_NAME,SITE_MAIL,SITE_MAIL,$admin_mail_subject,stripslashes($admin_mail_message),"yes"); 
}
?>
    <table width="100%" cellspacing="0" cellpadding="1" border="0">
      <tr>
          <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Test mail message file</b></font></td>
      </tr>
      <tr>
         <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
         <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
            <tr>
                <td align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Mail sent successfully. Please check your mailbox.</b></font></td>
            </tr>
         </table>
         </td>
      </tr>
      </table>
    <SCRIPT LANGUAGE="JavaScript">
    <!--
    alert('Mail was sent successfull to <?=SITE_MAIL?>.\nPlease check your mailbox in a few moments.\nIf you are satisfied with the result, please then save the mail message file.');
    window.close();
    //-->
    </SCRIPT>
<?
}
else if ($HTTP_POST_VARS['todo'] == "editfile") {
include(DIR_LANGUAGES.$HTTP_POST_VARS['editfile'].".cfg.php");
?>
<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_edit_mail.php"?>" name="editfile" style="margin-top: 0px; margin-bottom: 0px;">
<input type="hidden" name="todo" value="savefile">
<input type="hidden" name="lng" value="<?=$HTTP_POST_VARS['lng']?>">
<?if($mail_type=="1"){?>
    <input type="hidden" name="html_mail" value="<?=$html_mail?>">
<?}?>
<input type="hidden" name="filename" value="<?=$HTTP_POST_VARS['editfile']?>">
<input type="hidden" name="mail_type" value="<?=$mail_type?>">
<table width="550" cellspacing="0" cellpadding="1" border="0">
<tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit language email message file: <?=$HTTP_POST_VARS['editfile']?></b></font></td></tr>
<tr>
   <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>"><TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
   <tr>
       <td colspan="2"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_MAIL_MESSAGE_NOTE?></b></font></td>
   </tr>
   <?
   if ($message_note) {
   ?>
   <tr>
       <td colspan="2"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="red"><b><?=$message_note?></b></font></td>
   </tr>
   <?  
   }
   ?>
    <tr>
           <td colspan="2" align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_MAIL_SUBJECT?>:</b></font></td>
   </tr>
   <tr>
       <td colspan="2" align="center"><input type="text" name="mail_subject" size="60" value="<?=bx_js_stripslashes($file_mail_subject)?>"></td>
   </tr>
   <?if($mail_type=="1" && ALLOW_HTML_MAIL=="yes"){?>
       <tr>
           <td colspan="2" align="left"><hr color="#FF0000"></td>
       </tr>
       <tr>
           <td colspan="2" align="left"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="#FF0000"><b>Plain Text Mail Message:</b></font></td>
       </tr>
   <?}?>
   <tr>
       <td colspan="2" align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_MAIL_TEXT?>:</b></font></td>
   </tr>
   <tr>
       <td colspan="2" align="center"><textarea name="mail_message" rows="15" cols="80" class="mm"><?=fread(fopen(DIR_LANGUAGES.$HTTP_POST_VARS['editfile'],"r"),filesize(DIR_LANGUAGES.$HTTP_POST_VARS['editfile']))?></textarea></td>
   </tr>
   <tr><td colspan="2" align="center" nowrap class="mm"><?=TEXT_AVAILABLE_MAIL_FIELDS?><br>
        
        <select name="fields" class="mm" onChange="document.editfile.mail_message.value += this.options[this.selectedIndex].value; alert('Added '+this.options[this.selectedIndex].text+' to Mail message!'); this.selectedIndex=0;"><option>---- Select/Add field ----</option><?
        reset($fields);
        while (list($h, $v) = each($fields)) {
            echo "<option value=\"".$v[0]."\">".$v[1]."</option>";
        }
        ?></select>
        <br><?
        reset($fields);
        while (list($h, $v) = each($fields)) {
            echo "e.g. ".$v[1]." (<b>".$v[0]."</b>) - ".$v[2]."<br>";
        }
        ?>
        </td>
   </tr>
   <?if($mail_type=="0" || ALLOW_HTML_MAIL=="no"){?>
   <tr>
       <td colspan="2" align="center"><input type="checkbox" name="add_mail_signature" value="on" class="radio"<?=($add_mail_signature=="on")?" checked":""?>><?=TEXT_ADD_MAIL_SIGNATURE?></td>
   </tr>    
   <tr>
        <td align="right"><?=TEXT_EMAIL_TYPE?>:</font></td><td><input type="radio" class="radio" name="html_mail" value="no"<?=($html_mail=="no")?" checked":""?> onClick="document.testfile.test_html_mail.value=this.value;">Plain text <input type="radio" class="radio" name="html_mail" value="yes"<?=($html_mail=="yes")?" checked":""?> onClick="document.testfile.test_html_mail.value=this.value;">HTML</td>
   </tr>
   <tr>
       <td colspan="2" align="center" class="mm"><?=TEXT_SITE_MAIL_SIGNATURE?></font></td>
   </tr>
   <tr>
        <td  width="35%" align="right"><input type="submit" name="save" value="Save"></form>
        </td><td width="65%"><form method="post" target="test_mail" action="<?=HTTP_SERVER_ADMIN."admin_edit_mail.php"?>" name="testfile" onSubmit="this.test_mail_message.value=document.editfile.mail_message.value; this.test_mail_subject.value=document.editfile.mail_subject.value; if (document.editfile.add_mail_signature.checked == true) {this.test_add_mail_signature.value = document.editfile.add_mail_signature.value;} else {this.test_add_mail_signature.value='';} df=open('','test_mail','scrollbars=no,menubar=no,resizable=0,location=no,width=350,height=220,left=10,top=10,screenX=10,screenY=10');df.window.focus(); return true;"><input type="hidden" name="filename" value="<?=$HTTP_POST_VARS['editfile']?>">
        <input type="hidden" name="todo" value="test_mail"><input type="hidden" name="test_mail_message" value=""><input type="hidden" name="test_mail_subject" value=""><input type="hidden" name="test_html_mail" value="<?=$html_mail?>"><input type="hidden" name="mail_type" value="<?=$mail_type?>"><input type="hidden" name="test_add_mail_signature" value=""><input type="submit" name="sendtestmail" value="Send Admin a Test Mail" class=""></form></td>
   </tr>
   <?}?>
   <?if($mail_type=="1" && ALLOW_HTML_MAIL=="yes"){?>
       <tr>
           <td colspan="2" align="center"><input type="checkbox" name="add_mail_signature" value="on" class="radio"<?=($add_mail_signature=="on")?" checked":""?>><?=TEXT_ADD_MAIL_SIGNATURE?></td>
       </tr>    
       <tr>
           <td colspan="2" align="center" class="mm"><?=TEXT_SITE_MAIL_SIGNATURE?></font></td>
       </tr>
       <tr>
           <td colspan="2" align="left"><hr color="#FF0000"></td>
       </tr>
       <tr>
           <td colspan="2" align="left"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="#FF0000"><b>HTML Mail Message:</b></font></td>
       </tr>
      
       <tr>
           <td colspan="2" align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_MAIL_TEXT?>:</b></font></td>
       </tr>
       <tr>
           <td colspan="2" align="center"><textarea name="html_mail_message" rows="15" cols="80" class="mm"><?=htmlspecialchars(fread(fopen(DIR_LANGUAGES.$HTTP_POST_VARS['editfile'].".html","r"),filesize(DIR_LANGUAGES.$HTTP_POST_VARS['editfile'].".html")))?></textarea></td>
       </tr>
       <tr><td colspan="2" align="center" nowrap class="mm"><?=TEXT_AVAILABLE_MAIL_FIELDS?><br>
            
            <select name="fields" class="mm" onChange="document.editfile.html_mail_message.value += this.options[this.selectedIndex].value; alert('Added '+this.options[this.selectedIndex].text+' to Mail message!'); this.selectedIndex=0;"><option>---- Select/Add field ----</option><?
            reset($fields);
            while (list($h, $v) = each($fields)) {
                echo "<option value=\"".$v[0]."\">".$v[1]."</option>";
            }
            ?></select>
            <br><?
            reset($fields);
            while (list($h, $v) = each($fields)) {
                echo "e.g. ".$v[1]." (<b>".$v[0]."</b>) - ".$v[2]."<br>";
            }
            ?>
            </td>
       </tr>
       <tr>
           <td colspan="2" align="center"><input type="checkbox" name="add_html_header" value="on" class="radio"<?=($add_html_header=="on")?" checked":""?>><?=TEXT_ADD_HTML_HEADER?></td>
       </tr>    
       <tr>
           <td colspan="2" align="center"><input type="checkbox" name="add_html_footer" value="on" class="radio"<?=($add_html_footer=="on")?" checked":""?>><?=TEXT_ADD_HTML_FOOTER?></td>
       </tr>    
       <tr>
           <td colspan="2" align="center" class="mm"><?=TEXT_SITE_HTML_SIGNATURE?></font></td>
       </tr>
       <tr>
           <td colspan="2" align="center" nowrap><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>For a "Preview" <br>Click on the button on the right:&nbsp;&nbsp;<input type="button" class="button" style="width:200px" name="preview" value="Preview HTML Mail Message" onClick="document.preview.test_html_mail_message.value=document.editfile.html_mail_message.value; if (document.editfile.add_html_header.checked == true) {document.preview.test_add_html_header.value = document.editfile.add_html_header.value;} else {document.preview.test_add_html_header.value='';} if (document.editfile.add_html_footer.checked == true) {document.preview.test_add_html_footer.value = document.editfile.add_html_footer.value;} else {document.preview.test_add_html_footer.value='';} document.preview.test_mail_subject.value=document.editfile.mail_subject.value; df=open('','preview_html','scrollbars=no,menubar=no,resizable=yes,location=no,width=640,height=480,left=10,top=10,screenX=10,screenY=10');df.window.focus(); document.preview.submit();return true;"></b></font></td>
       </tr>
       <tr>
           <td colspan="2" align="left"><hr color="#FF0000"></td>
       </tr>
       <tr>
            <td  width="100%" align="center"><input type="submit" name="save" value="&nbsp;&nbsp;&nbsp;&nbsp;Save Mail Message&nbsp;&nbsp;&nbsp;&nbsp;"></form>
            </td><td width="1%"><form method="post" target="preview_html" style="margin-top: 0px; margin-bottom: 0px;" action="<?=HTTP_SERVER_ADMIN."admin_edit_mail.php"?>" name="preview" onSubmit="this.test_html_mail_message.value=document.editfile.html_mail_message.value; if (document.editfile.add_html_header.checked == true) {this.test_add_html_header.value = document.editfile.add_html_header.value;} else {this.test_add_html_header.value='';} if (document.editfile.add_html_footer.checked == true) {this.test_add_html_footer.value = document.editfile.add_html_footer.value;} else {this.test_add_html_footer.value='';} this.test_mail_subject.value=document.editfile.mail_subject.value; df=open('','preview_html','scrollbars=no,menubar=no,resizable=0,location=no,width=640,height=480,left=10,top=10,screenX=10,screenY=10');df.window.focus(); return true;"><input type="hidden" name="filename" value="<?=$HTTP_POST_VARS['editfile']?>"><input type="hidden" name="lng" value="<?=$HTTP_POST_VARS['lng']?>">
            <input type="hidden" name="todo" value="preview"><input type="hidden" name="test_html_mail_message" value=""><input type="hidden" name="test_add_html_header" value=""><input type="hidden" name="test_add_html_footer" value=""><input type="hidden" name="test_mail_subject" value=""><input type="hidden" name="test_html_mail" value="<?=$html_mail?>"><input type="hidden" name="mail_type" value="<?=$mail_type?>"></form></td>
       </tr>
	   <tr>
			<td colspan="2">&nbsp;</td>
	   </tr>
	   <tr>
           <form method="post" style="margin-top: 0px; margin-bottom: 0px;" target="test_mail" action="<?=HTTP_SERVER_ADMIN."admin_edit_mail.php"?>" name="testfile" onSubmit="this.test_mail_message.value=document.editfile.mail_message.value;this.test_mail_subject.value=document.editfile.mail_subject.value; if (document.editfile.add_mail_signature.checked == true) {this.test_add_mail_signature.value = document.editfile.add_mail_signature.value;} else {this.test_add_mail_signature.value='';} df=open('','test_mail','scrollbars=no,menubar=no,resizable=no,location=no,width=350,height=220,left=10,top=10,screenX=10,screenY=10');df.window.focus(); return true;"><td colspan="2" align="center" nowrap><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Send admin a Plaintext Test mail: &nbsp;&nbsp;<input type="hidden" name="filename" value="<?=$HTTP_POST_VARS['editfile']?>"><input type="hidden" name="lng" value="<?=$HTTP_POST_VARS['lng']?>">
            <input type="hidden" name="todo" value="test_mail"><input type="hidden" name="test_mail_message" value=""><input type="hidden" name="test_mail_subject" value=""><input type="hidden" name="test_html_mail" value="<?=$html_mail?>"><input type="hidden" name="test_add_mail_signature" value=""><input type="hidden" name="mail_type" value="<?=$mail_type?>"><input type="submit" style="width:230px" name="sendtestmail" value="Send Admin (Plaintext) Test Mail" class="button"></b></font></td></form>
       </tr>
	   <tr>
           <form method="post" target="test_mail_html" style="margin-top: 0px; margin-bottom: 0px;" action="<?=HTTP_SERVER_ADMIN."admin_edit_mail.php"?>" name="testhtmlfile" onSubmit="this.test_html_mail_message.value=document.editfile.html_mail_message.value; if (document.editfile.add_html_header.checked == true) {this.test_add_html_header.value = document.editfile.add_html_header.value;} else {this.test_add_html_header.value='';} if (document.editfile.add_html_footer.checked == true) {this.test_add_html_footer.value = document.editfile.add_html_footer.value;} else {this.test_add_html_footer.value='';} this.test_mail_subject.value=document.editfile.mail_subject.value; df=open('','test_mail_html','scrollbars=no,menubar=no,resizable=no,location=no,width=350,height=220,left=10,top=10,screenX=10,screenY=10');df.window.focus(); return true;"><td colspan="2" align="center" nowrap><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Send admin a HTML Test mail: &nbsp;&nbsp;<input type="hidden" name="filename" value="<?=$HTTP_POST_VARS['editfile']?>"><input type="hidden" name="lng" value="<?=$HTTP_POST_VARS['lng']?>">
            <input type="hidden" name="todo" value="test_mail_html"><input type="hidden" name="test_html_mail_message" value=""><input type="hidden" name="test_add_html_header" value=""><input type="hidden" name="test_add_html_footer" value=""><input type="hidden" name="test_mail_subject" value=""><input type="hidden" name="test_html_mail" value="<?=$html_mail?>"><input type="hidden" name="mail_type" value="<?=$mail_type?>"><input type="submit" style="width:230px" name="sendtestmail" value="Send Admin (HTML) Test Mail" class="button"></b></font></td></form>
       </tr>
   <?}?>
</table>
</td></tr></table>
<?
}
else if ($HTTP_POST_VARS['todo'] == "editmail" || $HTTP_GET_VARS['todo'] == "editmail") {
     if (empty($folders)) {
         bx_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="1" border="0">
            <tr>
                 <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit <?=$folders?> language email message files</b></font></td>
            </tr>
            <tr>
               <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
               <tr>
                   <td colspan="2"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_EDIT_LANGUAGE_MAIL_NOTE?></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_SELECT_EDIT_LANGUAGE_MAIL_FILE?>:</b></font></td>
               </tr>
               <?
                     $dirs = getFiles(DIR_LANGUAGES.$folders."/mail");
                     for ($i=0; $i<count($dirs); $i++) {
                               if (eregi("\.cfg\.php|\.txt\.html",$dirs[$i],$rrr)) {
                                   
                               }
                               else {
                                     echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_edit_mail.php"."\"><input type=\"hidden\" name=\"todo\" value=\"editfile\"><input type=\"hidden\" name=\"editfile\" value=\"".$folders."/mail/".$dirs[$i]."\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\"><b>".eregi_replace(".txt$","",$dirs[$i])."</b></td><td><input type=\"submit\" name=\"edit\" value=\"Edit\"></td></tr></form>";
                               }
                    }
                 ?>
                <tr>
                   <td valign="top" colspan="2">&nbsp;</td>
               </tr>
               </table>
         </td></tr></table>
         <?
     }//end else if (empty($folders))
}//end if ($todo == "editmail")
else {
?>
<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_edit_mail.php"?>" name="editlng" onSubmit="return check_form_editmail();">
<input type="hidden" name="todo" value="editmail">
<table width="100%" cellspacing="0" cellpadding="1" border="0">
<tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit email messages</b></font></td>
</tr>
<tr>
   <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
<TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
<tr>
    <td colspan="2"><br></td>
</tr>
<tr>
        <td valign="top" width="80%"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_SELECT_EDIT_LANGUAGE_MAIL?>:</b></font></td><td valign="top">
<?
  $dirs = getFolders(DIR_LANGUAGES);
    if(count($dirs) == 1) {
          refresh(HTTP_SERVER_ADMIN."admin_edit_mail.php"."?todo=editmail&folders=".$dirs[0]);
  }
  for ($i=0; $i<count($dirs); $i++) {
       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
              echo "<input type=\"radio\" name=\"folders\" value=\"".$dirs[$i]."\" class=\"radio\">".$dirs[$i]."<br>";
       }
  }
?>
</td></tr>
<tr>
        <td colspan="2" align="center"><br><input type="submit" name="edit" value="<?=TEXT_EDIT_LANGUAGE_EMAIL?>"></td>
</tr>
</table>

</td></tr></table>
</form>
<?
}
?>