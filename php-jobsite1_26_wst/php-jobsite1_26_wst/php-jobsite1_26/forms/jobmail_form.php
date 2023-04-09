<?php include(DIR_LANGUAGES.$language."/".FILENAME_JOBMAIL_FORM);?>
<?php
if ($done=="subscribe") {
    $success_message=TEXT_SUBSCRIBE_SUCCESS;
    $back_url=bx_make_url(HTTP_SERVER.FILENAME_JOBMAIL, "auth_sess", $bx_session);
    include(DIR_FORMS.FILENAME_MESSAGE_FORM);
}//end if ($done="subscribe")
elseif ($done=="unsubscribe") {
    $success_message=TEXT_UNSUBSCRIBE_SUCCESS;
    $back_url=bx_make_url(HTTP_SERVER.FILENAME_JOBMAIL, "auth_sess", $bx_session);
    include(DIR_FORMS.FILENAME_MESSAGE_FORM);
}//end elseif ($done=="unsubscribe")
elseif ($done=="subscribe_update") {
    $success_message=TEXT_UPDATE_SUCCESS;
    $back_url=bx_make_url(HTTP_SERVER.FILENAME_JOBMAIL, "auth_sess", $bx_session);
    include(DIR_FORMS.FILENAME_MESSAGE_FORM);
}//end elseif ($done=="subscribe_update")
else {
if ($jobmail_exist=="false") {
?>
<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOBMAIL, "auth_sess", $bx_session);?>" method="post" name="frm">
  <INPUT type="hidden" name="action" value="jobmail_subscribe">
  <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR bgcolor="#FFFFFF">
      <TD colspan="3" width="100%" align="center" class="headertdjob"><?php echo TEXT_SUBSCRIBE_NOW;?></TD>
    </TR>
    <TR><TD colspan="3"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
        </table></TD>
    </TR>
     <TR><TD>&nbsp;</TD></TR>
     <TR>
      <TD valign="top" align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOBMAIL_NOTE;?></B></FONT>
      </TD>
     </TR>
     <TR><TD>&nbsp;</TD></TR>
     <tr>
       <td align="center"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td width="30%">&nbsp;</td><td><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
          <?php
          $i=1;
           while (${TEXT_JOBMAIL_OPT.$i})
            {
             echo '<input type=radio class="radio" name="jobmail_type" value="'.$i.'"';
                    if ($i=='1')
                     {
                      if ($jobmail_exist=="false") {
                         echo " checked";
                       }// end if ($jobmail_exist=="false")
                     }//end if ($i==1)

                    if ($i==$jobmail_result['jobmail_type'])
                       {
                        echo " checked";
                        }
                        echo '>'.${TEXT_JOBMAIL_OPT.$i}.'<br>';
                        $i++;
                        }
                     ?>
           </font>
       </td>
       <td width="30%">&nbsp;</td>
       </tr>
        <?php if(MULTILANGUAGE_SUPPORT == "on") {?>
        <tr>
               <td colspan="3" valign="top" align="center">&nbsp;<font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOBMAIL_LANGUAGE;?></B></font></td>
        </tr>
        <tr>
               <td colspan="3" valign="top" align="center">&nbsp;</td>
        </tr>
        <tr>
               <td width="30%">&nbsp;</td><td valign="top"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>">
               <?php
                  $dirs = getFolders(DIR_LANGUAGES);
                  for ($i=0; $i<count($dirs); $i++) {
                       if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                              echo "<input type=\"radio\" name=\"jmail_lang\" value=\"".$dirs[$i]."\" class=\"radio\"";
                              if($language == $dirs[$i]) {
                                  echo " checked";
                              }
                              echo ">".$dirs[$i]."<br>";
                       }
                  }
               ?>
               </font>
               </td>
               <td width="30%">&nbsp;</td>
        </tr>   
        <?php }else{?> 
            <input type="hidden" name="jmail_lang" value="<?php echo DEFAULT_LANGUAGE;?>">
        <?php }?>
       </table></td>
     </tr>
     <TR><TD>&nbsp;</TD></TR>
     <tr>
      <TD align="center"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/subscribe.gif",0,TEXT_SUBSCRIBE);?></FONT></TD>
    </TR>
   </table>
 </form>

<?php
  }//end if ($jobmail_exist=="false")
if ($jobmail_exist=="true") {
?>
<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOBMAIL, "auth_sess", $bx_session);?>" method="post" name="frm">
  <INPUT type="hidden" name="action" value="jobmail_subscribe">
  <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR bgcolor="#FFFFFF">
      <TD colspan="3" width="100%" align="center" class="headertdjob"><?php echo TEXT_JOBMAIL_UPDATE;?></TD>
    </TR>
    <TR><TD colspan="3"><table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td bgcolor="<?php echo TABLE_HEADING_BGCOLOR;?>" height="1"><?php echo bx_image_width(HTTP_IMAGES.$language."/pix-t.gif",1,1,0,"");?></td>
                </tr>
        </table></TD>
    </TR>
	<TR>
      <TD valign="top" align="center" colspan="3">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOBMAIL_CURRENT_OPTION;?></B></FONT>
      </TD>
     </TR>
    <tr>
       <td colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><ul>
          <?php
          $i=1;
           while (${TEXT_JOBMAIL_OPT.$i})
            {
             echo '<li><input type="radio" class="radio" name="jobmail_type" value="'.$i.'"';
                    if ($i=='1')
                     {
                      if ($jobmail_exist=="false") {
                         echo " checked";
                       }// end if ($jobmail_exist=="false")
                     }//end if ($i==1)

                    if ($i==$jobmail_result['jobmail_type'])
                       {
                        echo " checked";
                        }
                        echo '>'.${TEXT_JOBMAIL_OPT.$i}.'</li><br>';
                        $i++;
                        }
                     ?>
           </font>
       </td>
     </tr>
     <?php if(MULTILANGUAGE_SUPPORT == "on") {?>
       <tr>
           <td colspan="3" valign="top" align="center">&nbsp;<font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOBMAIL_LANGUAGE;?></B></font></td>
       </tr>
       <tr>
           <td valign="top" colspan="3"><font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><ul>
           <?php
              $dirs = getFolders(DIR_LANGUAGES);
              for ($i=0; $i<count($dirs); $i++) {
                   if (file_exists(DIR_LANGUAGES.$dirs[$i].".php")) {
                          echo "<li><input type=\"radio\" name=\"jmail_lang\" value=\"".$dirs[$i]."\" class=\"radio\"";
                          if($jobmail_result['jmail_lang'] != "") {
                                  if($jobmail_result['jmail_lang'] == $dirs[$i]) {
                                      echo " checked";
                                  }
                          }
                          else {
                                  if($language == $dirs[$i]) {
                                      echo " checked";
                                  }
                          }        
                          echo ">".$dirs[$i]."</li><br>";
                   }
              }
           ?>
           </font></ul>
           </td>
     </tr>   
     <?php }else{?> 
         <input type="hidden" name="jmail_lang" value="<?php echo DEFAULT_LANGUAGE;?>">
     <?php }?>
     <tr>
      <TD width="75%" align="center" colspan="3">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/subscribe.gif",0,TEXT_SUBSCRIBE);?>
     </FONT>
      </TD>
    </TR>
   </table>
 </form>
 <br><br>
<FORM action="<?php echo bx_make_url(HTTP_SERVER.FILENAME_JOBMAIL, "auth_sess", $bx_session);?>" method="post" name="frm">
  <INPUT type="hidden" name="action" value="jobmail_unsubscribe">
  <table bgcolor="<?php echo TABLE_BGCOLOR;?>" width="100%" border="0" cellspacing="0" cellpadding="2">
    <TR>
      <TD valign="top" width="25%" align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><B><?php echo TEXT_JOBMAIL_UNSUBSCRIBE;?></B></FONT>
      </TD>
     </TR>
     <tr>
      <TD width="75%" align="center">
        <font face="<?php echo TEXT_FONT_FACE;?>" size="<?php echo TEXT_FONT_SIZE;?>" color="<?php echo TEXT_FONT_COLOR;?>"><?php echo bx_image_submit_nowidth(HTTP_IMAGES.$language."/unsubscribe.gif",0,TEXT_UNSUBSCRIBE);?>
     </FONT>
      </TD>
    </TR>
   </table>
 </form>
<?php
  }//end if ($jobmail_exist=="true")
}
?>