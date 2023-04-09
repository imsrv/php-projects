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
if ($HTTP_POST_VARS['todo'] == "savefile") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
             $error_title = "editing language HTML files";
             bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
             $done = true;
             $HTTP_POST_VARS['html_file'] = bx_unhtmlspecialchars(bx_stripslashes($HTTP_POST_VARS['html_file']));
             $fp=fopen(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$HTTP_POST_VARS['filename'], "w+");
             fwrite($fp, $HTTP_POST_VARS['html_file']);
             fclose($fp);
             if ($HTTP_POST_VARS['type']=="template") {
                 $lng = $HTTP_POST_VARS['lng'];
                 $template_file = $HTTP_POST_VARS['lng']."/".$HTTP_POST_VARS['filename'];
                 include(DIR_LANGUAGES.$template_file.".cfg.php");
                 reset($fields);
                 while (list($h, $v) = each($fields)) {
                          $HTTP_POST_VARS['html_file'] = eregi_replace($v[0],$v[3],$HTTP_POST_VARS['html_file']);
                 }
                 if (file_exists(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".(eregi_replace("\.(html|htm)",".php",$HTTP_POST_VARS['filename'])))) {
                     $fp=fopen(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".(eregi_replace("\.(html|htm)",".php",$HTTP_POST_VARS['filename'])), "w+");
                     fwrite($fp, $HTTP_POST_VARS['html_file']);
                     fclose($fp);
                     $done = true;
                 }
                 else {
                     bx_admin_error("File Doesn't exist: ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".(eregi_replace("\.(html|htm)",".php",$HTTP_POST_VARS['filename'])));
                     $done=false;
                 }
             }
        if ($done) {
        ?>
        <script language="Javascript">
         <!--
            document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN."edit_file.php?ref=".time();?>" name="redirect">');
            document.write('<input type="hidden" name="todo" value="editinclude">');
            document.write('<input type="hidden" name="folders" value="<?php echo $HTTP_POST_VARS['lng'];?>">');
            document.write('</form>');
            document.redirect.submit();
          //-->
        </script>
        <?php
        } 
    }
}
elseif ($HTTP_POST_VARS['todo'] == "restore") {
     if(ADMIN_SAFE_MODE == "yes" && $lng==DEFAULT_LANGUAGE) {
             $error_title = "editing language HTML files";
             bx_admin_error(TEXT_SAFE_MODE_ALERT);
     }
     else {
            $done = true;
            if (file_exists(DIR_IMAGES."backups".$HTTP_POST_VARS['filename'])) {
                 if(!unlink(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$HTTP_POST_VARS['filename'])){
                     bx_admin_error("Unable to unlink the file: ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$HTTP_POST_VARS['filename'].".<br>Please try to chmod it to 777 and try again!");
                     $done = false;
                 }
                 if(!copy(DIR_IMAGES."backups".$HTTP_POST_VARS['filename'],DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$HTTP_POST_VARS['filename'])){
                     bx_admin_error("Unable to copy the file: ".DIR_IMAGES.$HTTP_POST_VARS['filename']." to ".DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$HTTP_POST_VARS['filename']."!");
                     $done = false;
                 }
                 else {
                      @chmod(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$HTTP_POST_VARS['filename'], 0777);
                 }
            }
            else {
                 $done = false;
                 bx_admin_error("Original file does not exists: -".DIR_IMAGES."backups".$HTTP_POST_VARS['filename']);
            }
            if ($done) {
            ?>
            <script language="Javascript">
             <!--
                document.write('<form method="post" action="<?php echo HTTP_SERVER_ADMIN."edit_file.php?ref=".time();?>" name="redirect">');
                document.write('<input type="hidden" name="todo" value="editfile">');
                document.write('<input type="hidden" name="editfile" value="<?php echo $HTTP_POST_VARS['filename'];?>">');
                document.write('<input type="hidden" name="lng" value="<?php echo $HTTP_POST_VARS['lng'];?>">');
                document.write('</form>');
                document.redirect.submit();
              //-->
            </script>
            <?php
            } 
    }
}
else if ($HTTP_POST_VARS['todo'] == "editfile") {
    $lng = $HTTP_POST_VARS['lng'];
?>
    <form method="post" action="<?php echo HTTP_SERVER_ADMIN."edit_file.php";?>" name="editfile">
    <input type="hidden" name="todo" value="savefile">
    <input type="hidden" name="filename" value="<?php echo $HTTP_POST_VARS['editfile'];?>">
    <input type="hidden" name="lng" value="<?php echo $HTTP_POST_VARS['lng'];?>">
    <table width="100%" cellspacing="0" cellpadding="2" border="0">
    <tr>
         <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit "<?php echo $HTTP_POST_VARS['lng'];?>" <?php echo basename($HTTP_POST_VARS['editfile']);?></b></font></td>
     </tr>
     <tr>
       <td bgcolor="#000000">
    <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
   <tr>
       <td colspan="2" align="center"><b><?php echo TEXT_HTML_FILE_NOTE;?>: <?php echo basename($HTTP_POST_VARS['editfile']);?></b></td>
   </tr>
   <tr>
       <td colspan="2" align="center"><textarea name="html_file" rows="20" cols="70" class="mm"><?php echo htmlspecialchars(fread(fopen(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$HTTP_POST_VARS['editfile'],"r"),filesize(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$HTTP_POST_VARS['editfile'])));?></textarea></td>
   </tr>
   <?php
   if (file_exists(DIR_LANGUAGES.$HTTP_POST_VARS['lng']."/".$HTTP_POST_VARS['editfile'].".cfg.php")) {
   $template  = true;
   ?>
     <input type="hidden" name="type" value="template">
    <tr><td colspan="2" align="center" nowrap class="mm"><?php echo TEXT_AVAILABLE_HTML_FIELDS;?><br>
        
        <select name="fields" class="mm" onChange="document.editfile.html_file.value += this.options[this.selectedIndex].value; alert('Added '+this.options[this.selectedIndex].text+' to Html file!'); this.selectedIndex=0;"><option>---- Select/Add field ----</option><?php
        $lng = $HTTP_POST_VARS['lng'];
        $template_file = $HTTP_POST_VARS['lng']."/".$HTTP_POST_VARS['editfile'];
        include(DIR_LANGUAGES.$template_file.".cfg.php");
        reset($fields);
        $i=1;
        while (list($h, $v) = each($fields)) {
            echo "<option value=\"".$v[0]."\">".$i." - ".$v[1]."</option>";
            $i++;
        }
        ?></select>
        </td>
   </tr>
   <?php }else{$template = false;}?>
   <tr>
       <td colspan="2">&nbsp;</td>
   </tr>
   <tr>
        <td  width="50%" align="right"><input type="submit" name="save" value="Save"></form>
        </td><td width="50%"><form method="post" target="preview" action="<?php echo HTTP_SERVER_ADMIN."edit_file.php";?>" name="testfile" onSubmit="this.test_html_file.value=document.editfile.html_file.value; df=open('','preview','scrollbars=no,menubar=no,resizable=0,location=no,width=400,height=400,screenX=10,screenY=10,top=10,left=10');df.window.focus(); return true;"><input type="hidden" name="filename" value="<?php echo $HTTP_POST_VARS['editfile'];?>">
        <input type="hidden" name="todo" value="preview"><?php if($template){?><input type="hidden" name="type" value="template"><input type="hidden" name="lng" value="<?php echo $HTTP_POST_VARS['lng'];?>"><?php };?><input type="hidden" name="test_html_file" value=""><input type="submit" name="sendpreview" value="Preview" class=""></form></td>
   </tr>
   <tr>
       <td colspan="2">&nbsp;</td>
   </tr>
   <tr>
       <td align="left" nowrap class="smalltext">
           <?php
              $dirs = getFolders(DIR_LANGUAGES);
              if(count($dirs) == 1) {
              }
              else {?>
           <b>Copy File From Language:</b> <select name="copyfrom">
           <option value="">--Select a language--</option>
            <?php
              for ($i=0; $i<count($dirs); $i++) {
                   if (file_exists(DIR_LANGUAGES.$dirs[$i].".php") && $dirs[$i]!=$HTTP_POST_VARS['lng']) {
                          ?>
                          <option value="" onClick="if(confirm('Are you sure you want to copy this file from <?php echo $dirs[$i];?> language?\nSelect Ok if oyu agree, Cancel otherwise!')) {window.location.href='<?php echo HTTP_SERVER_ADMIN."edit_file.php?todo=copy&filename=".urlencode($HTTP_POST_VARS['editfile'])."&lng=".$HTTP_POST_VARS['lng']."&new_lang=".$dirs[$i];?>';} else {return false;}"><?php echo $dirs[$i];?></option>
                          <?php
                   }
              }
              ?>
              </select>
              <?php
            }  
            ?>
            </td>
       <td align="right">
       <table width="50%" border="0" cellspacing="0" cellpadding="1">
       <tr>
           <td align="right"><form action="<?php echo HTTP_SERVER_ADMIN."edit_file.php";?>" method="post" ><input type="hidden" name="lng" value="<?php echo $HTTP_POST_VARS['lng'];?>"><input type="hidden" name="filename" value="<?php echo $HTTP_POST_VARS['editfile'];?>"><input type="hidden" name="todo" value="saveasfile"><input type="submit" name="savefile" value="Save As File - Download"></form></td>
           <td align="right"><form action="<?php echo HTTP_SERVER_ADMIN."edit_file.php";?>" method="post" ><input type="hidden" name="lng" value="<?php echo $HTTP_POST_VARS['lng'];?>"><input type="hidden" name="filename" value="<?php echo $HTTP_POST_VARS['editfile'];?>"><input type="hidden" name="todo" value="restore"><input type="submit" name="savefile" value="Restore the Original" onClick="return confirm('Are you sure you Want to Restore the Original File?\n By doing this you loose all the changes you have made to this file!\nClick Ok if this is what you want, Cancel otherwise...');"></form></td>
       </tr>
       </table>
       
       </td>
   </tr>
   <tr>
       <td colspan="2">&nbsp;</td>
   </tr>
   <?php
   if ($template) {
        $i=1;
        reset($fields);
        while (list($h, $v) = each($fields)) {
            ?>
            <tr>
                <td colspan="2" class="mm">
                <b><?php echo $i;?>. - <?php echo $v[0];?></b> - <?php echo $v[1];?> - e.g.  <?php echo htmlspecialchars($v[2]);?>
                </td>
            </tr>
            <?php
            $i++;
        }
   }     
   ?>
  <tr>
       <td colspan="2">&nbsp;</td>
   </tr>
</table>
</td></tr></table>
<?php
}
else if ($HTTP_POST_VARS['todo'] == "editinclude" || $HTTP_GET_VARS['todo'] == "editinclude") {
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
                 <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit "<?php echo $folders;?>" HTML Files</b></font></td>
             </tr>
             <tr>
               <td bgcolor="#000000">
               <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
               <tr>
                   <td colspan="2"><br></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><b><?php echo TEXT_EDIT_LANGUAGE_HTML_NOTE;?></b></td>
               </tr>
               <tr>
                   <td valign="top" colspan="2"><b><?php echo TEXT_SELECT_EDIT_LANGUAGE_HTML_FILE;?>:</b></td>
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
                     $dirs = getFiles(DIR_LANGUAGES.$folders."/html");
                     sort($dirs);
                     for ($i=0; $i<count($dirs); $i++) {
                               if (!eregi(".php",$dirs[$i],$rrr) && $dirs[$i]!="index.html" && $dirs[$i]!="index.htm") {
                               $perms_error=false;
                               ?>
                                   <tr>
                                   <td><b><u><?php echo $n;?></u>.</b></td>
                                   <form method="post" action="<?php echo HTTP_SERVER_ADMIN."edit_file.php";?>">
                                   <input type="hidden" name="todo" value="editfile">
                                   <input type="hidden" name="editfile" value="<?php echo "/html/".$dirs[$i];?>">
                                   <input type="hidden" name="lng" value="<?php echo $folders;?>">
                                   <td><b><?php echo $dirs[$i];?></b></td>
                                   <td align="center"><b><?php 
                                   $perms=substr(base_convert(@fileperms(DIR_LANGUAGES.$folders."/html/".$dirs[$i]), 10, 8),3);
                                   echo $perms;
                                   if ($perms==666 || $perms==777) {
                                       echo " - OK";
                                       $perms_error=false;
                                   }
                                   else {
                                       $title="File Permission Error - ".$dirs[$i];
                                       $content="<font color=red><b>The permission for this file is invalid.<br>Valid permission for the file is: <b>777</b>.</font><br> The changes to the file will not be saved properly(will be lost)!<br>Please change the file permission for ".DIR_LANGUAGES.$folders."/html/".$dirs[$i]." to 777.";
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
                   <td valign="top" colspan="2">&nbsp;</td>
               </tr>
               </table>
         </td></tr></table>
         <?php
     }//end else if (empty($folders))
}//end if ($todo == "editinclude")
else {
?>
<form method="post" action="<?php echo HTTP_SERVER_ADMIN."edit_file.php";?>" name="editlng" onSubmit="return check_form_editmail();">
<input type="hidden" name="todo" value="editinclude">
<table width="100%" cellspacing="0" cellpadding="2" border="0">
<tr>
     <td bgcolor="#000000" align="center"><font face="Verdana, Arial" size="2" color="white"><b>Edit HTML files - Select Language</b></font></td>
 </tr>
 <tr>
   <td bgcolor="#000000">
    <TABLE border="0" cellpadding="4" cellspacing="0" bgcolor="#00CCFF" width="100%">
    <tr>
        <td colspan="2"><br></td>
    </tr>
    <tr>
            <td valign="top" width="80%"><b><?php echo TEXT_SELECT_EDIT_LANGUAGE_HTML;?>:</b></td><td valign="top">
    <?php
      $dirs = getFolders(DIR_LANGUAGES);
      if(count($dirs) == 1) {
              refresh(HTTP_SERVER_ADMIN."edit_file.php?todo=editinclude&folders=".$dirs[0]);
      }
      for ($i=0; $i<count($dirs); $i++) {
           if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                  echo "<input type=\"radio\" name=\"folders\" value=\"".$dirs[$i]."\" class=\"radio\">".$dirs[$i]."<br>";
           }
      }
    ?>
    </td></tr>
    <tr>
            <td colspan="2" align="center"><br><input type="submit" name="edit" value="<?php echo TEXT_EDIT_LANGUAGE_HTML;?>"></td>
    </tr>
    </table>
</td></tr></table>
</form>
<?php
}
?>