<?
if($HTTP_POST_VARS['folders']) {
    $folders=$HTTP_POST_VARS['folders'];
}
elseif ($HTTP_GET_VARS['folders']){
     $folders = $HTTP_GET_VARS['folders'];
}
else {
    $folders = '';
}
$error_title = "editing language HTML files";
if ($HTTP_POST_VARS['todo'] == "savefile") {
	if(file_exists(DIR_LANGUAGES.$HTTP_POST_VARS['filename']))
	{
		$fp=fopen(DIR_LANGUAGES.$HTTP_POST_VARS['filename'], "w+");
		fwrite($fp, stripslashes($HTTP_POST_VARS['html_file']));
		fclose($fp);
	}
	else
		bx_error('Path error');
    ?>
     <table width="100%" cellspacing="0" cellpadding="1" border="0">
      <tr>
          <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit HTML language file: <?=$HTTP_POST_VARS['filename']?></b></font></td>
      </tr>
      <tr>
         <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
         <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
            <tr>
                <td align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b>Successfull update.</b></font></td>
            </tr>
            <tr>
                   <td align="left" nowrap><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><a href="<?=HTTP_SERVER_ADMIN.FILENAME_INDEX?>" class="settings">&#171;Admin Home&#187;</a>&nbsp;&nbsp;<a href="<?=HTTP_SERVER_ADMIN."admin_edit_mail_include.php"."?todo=editinclude&folders=".$HTTP_POST_VARS['lng']?>" class="settings">&#171;Edit Language File Home&#187;</a></font></td>
            </tr>
         </table>
         </td>
      </tr>
      </table>
<?
}
else if ($HTTP_POST_VARS['todo'] == "editfile") {
?>
<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_edit_mail_include.php"?>" name="editfile">
<input type="hidden" name="todo" value="savefile">
<input type="hidden" name="filename" value="<?=$HTTP_POST_VARS['editfile']?>">
<input type="hidden" name="lng" value="<?=$HTTP_POST_VARS['lng']?>">
<table width="100%" cellspacing="0" cellpadding="1" border="0">
<tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit language email HTML Files: <?=$HTTP_POST_VARS['editfile']?></b></font></td></tr>
<tr>
   <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>"><TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
   <tr>
       <td colspan="2" align="center"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_HTML_FILE_NOTE?>: <?=basename($HTTP_POST_VARS['editfile']);?></b></font></td>
   </tr>
   <tr>
       <td colspan="2" align="center"><textarea name="html_file" rows="20" cols="70" class="mm"><?=fread(fopen(DIR_LANGUAGES.$HTTP_POST_VARS['editfile'],"r"),filesize(DIR_LANGUAGES.$HTTP_POST_VARS['editfile']))?></textarea></td>
   </tr>
   <tr>
       <td colspan="2">&nbsp;</td>
   </tr>
   <tr>
        <td  width="50%" align="right"><input type="submit" name="save" value="Save"></form>
        </td><td width="50%"><form method="post" target="preview" action="<?=HTTP_SERVER_ADMIN."admin_edit_mail_include.php"?>" name="testfile" onSubmit="this.test_html_file.value=document.editfile.html_file.value; df=open('','preview','scrollbars=no,menubar=no,resizable=0,location=no,width=400,height=400,screenX=10,screenY=10,top=10,left=10');df.window.focus(); return true;"><input type="hidden" name="filename" value="<?=$HTTP_POST_VARS['editfile']?>">
        <input type="hidden" name="todo" value="preview"><input type="hidden" name="test_html_file" value=""><input type="submit" name="sendpreview" value="Preview" class=""></form></td>
   </tr>
</table>
</td></tr></table>
<?
}
else if ($HTTP_POST_VARS['todo'] == "editinclude" || $HTTP_GET_VARS['todo'] == "editinclude") {
     if (empty($folders)) {
         bx_error("You must select a language to edit.");
     }//end if (empty($folders))
     else {
            ?>
            <table width="100%" cellspacing="0" cellpadding="1" border="0">
            <tr>
                 <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit <?=$folders?> language HTML Files</b></font></td>
            </tr>
            <tr>
               <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="<?=INSIDE_TABLE_BG_COLOR?>" width="100%">
               <tr>
                   <td colspan="2"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_EDIT_LANGUAGE_HTML_NOTE?></b></font></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><font face="<?=TEXT_FONT_FACE?>" size="<?=TEXT_FONT_SIZE?>" color="<?=TEXT_FONT_COLOR?>"><b><?=TEXT_SELECT_EDIT_LANGUAGE_HTML_FILE?>:</b></font></td>
               </tr>
               <?
                     $dirs = getFiles(DIR_LANGUAGES.$folders."/html");
                     for ($i=0; $i<count($dirs); $i++) {
                               if (eregi(".htm",$dirs[$i],$rrr)) {
                                   echo "<form method=\"post\" action=\"".HTTP_SERVER_ADMIN."admin_edit_mail_include.php"."\"><input type=\"hidden\" name=\"todo\" value=\"editfile\"><input type=\"hidden\" name=\"editfile\" value=\"".$folders."/html/".$dirs[$i]."\"><input type=\"hidden\" name=\"lng\" value=\"".$folders."\"><tr><td align=\"right\"><b>".$dirs[$i]."</b></td><td><input type=\"submit\" name=\"edit\" value=\"Edit\"></td></tr></form>";
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
}//end if ($todo == "editinclude")
else {
?>
<form method="post" action="<?=HTTP_SERVER_ADMIN."admin_edit_mail_include.php"?>" name="editlng" onSubmit="return check_form_editmail();">
<input type="hidden" name="todo" value="editinclude">
<table width="100%" cellspacing="0" cellpadding="1" border="0">
<tr>
     <td bgcolor="<?=TABLE_HEAD_BGCOLOR?>" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit HTML files</b></font></td>
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
          refresh(HTTP_SERVER_ADMIN."admin_edit_mail_include.php"."?todo=editinclude&folders=".$dirs[0]);
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